<?php
require_once('db/server.php');
require_once('db/adminloginverify.php');
require_once('db/sendmail.php');
$sql = "
        SELECT 
            v.visitid, 
            u.fname AS user_fname, u.lname AS user_lname, 
            v.schedule_date, v.schedule_time, v.visittype, v.number_people, 
            v.comment, v.liability, v.status
        FROM visit v
        JOIN user u ON v.userid = u.userid
    ";
$result = $conn->query($sql);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submiteditvisit'])) {
    // Get form data
    $visitid = $_POST['visitid'];
    $status = $_POST['status'];

    // Validate data
    if (!empty($visitid) && !empty($status)) {
        // Update query
        $sql = "UPDATE visit SET status = ? WHERE visitid = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("si", $status, $visitid);
            if ($stmt->execute()) {

                // Fetch user email and name
                $sqlUser = "
                    SELECT u.email, u.fname 
                    FROM visit v
                    JOIN user u ON v.userid = u.userid
                    WHERE v.visitid = ?
                ";
                if ($stmtUser = $conn->prepare($sqlUser)) {
                    $stmtUser->bind_param("i", $visitid);
                    $stmtUser->execute();
                    $resultUser = $stmtUser->get_result();
                    if ($user = $resultUser->fetch_assoc()) {
                        $email = $user['email'];
                        $name = $user['fname'];

                        $subject = "";
                        $message = "";
                        // Initialize visit date and time
                        $visit_date = '';
                        $visit_time = '';

                        // Fetch schedule date and time if approved
                        if ($status === 'approved') {
                            $sql = "SELECT schedule_date, schedule_time FROM visit WHERE visitid = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $visitid);
                            $stmt->execute();
                            $stmt->bind_result($visit_date, $visit_time);
                            $stmt->fetch();
                            $stmt->close();
                        }
                        if ($status === 'approved') {
                            $subject = "Shelter Visit Booking Confirmation";
                            $message = "
Hi $name,

Great news! Your shelter visit request has been approved.

Your visit is scheduled for **$visit_date, at $visit_time**. We look forward to seeing you then!

**Here's where to find us:**
11 Pacencia St., Tugatog, Malabon City, Philippines

**Our visiting hours are:**
Monday to Saturday, 9:00 AM – 5:00 PM

**A few reminders before your visit:**
• Please review and keep in mind the reminders and Liability Waiver you agreed to during booking. By coming to the shelter, you're kindly confirming that you understand and accept its terms and conditions.  
• Bring a valid ID for check-in.  
• Arrive on time so you can spend enough quality time with the rescues.

We look forward to seeing you soon!

Best regards,  
**The Supremo Fur Babies Team**
";
                        } elseif ($status === 'declined') {
                            $subject = "Shelter Visit Status Update";
                            $message = "
Hi $name,

Thank you for your interest in visiting **Supremo Fur Babies Malabon Shelter**.

After reviewing your request, we’re sorry to inform you that your shelter visit scheduled for **$visit_date, at $visit_time** has been declined.

**Reason:** $decline_reason

If you still wish to visit, you're very welcome to select a new date and time that works best for you.

👉 [Click here to book another visit](https://supremofurbabies.great-site.net/visit.php)

If you have any questions, feel free to reach out—we’re always happy to assist.

Warm regards,  
**Supremo Fur Babies Team**
";
                        } elseif ($status === 'scheduled') {
                            $subject = "Shelter Visit Scheduled";
                            $message = "
Hi $name,

Your shelter visit has been successfully scheduled for **$visit_date, at $visit_time**.

We look forward to seeing you soon!

Best,  
**Supremo Fur Babies Team**
";
                        } else {
                            $subject = "Shelter Visit Status Update";
                            $message = "Hi $name,\n\nYour visit status has been updated to: $status.";
                        }

                        // Send email
                        sendmail($email, $name, $subject, nl2br($message));

                    }
                    $stmtUser->close();
                }

                $_SESSION['errorMessage'] = "Visit status updated successfully";
                $_SESSION['errorType'] = "success";
                $_SESSION['errorHead'] = "Success!";
            } else {
                $_SESSION['errorMessage'] = "Error updating status: " . $stmt->error;
                $_SESSION['errorType'] = "danger";
                $_SESSION['errorHead'] = "Warning!";
            }
            $stmt->close();
        } else {
            $_SESSION['errorMessage'] = "Error preparing statement.";
            $_SESSION['errorType'] = "danger";
            $_SESSION['errorHead'] = "Warning!";
        }
    } else {
        $_SESSION['errorMessage'] = "All fields are required!";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorHead'] = "Warning!";
    }

    header("Location: adminshelter.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php
    $page = "visit";
    require_once 'db/head.php'; ?>
    <title>Admin | Supremo Fur Babies</title>
</head>

<body>
    <?php require_once 'db/nav.php'; ?>
    <div class="d-flex w-100 align-items-stretch flex-grow-1 flex-column flex-md-row">
        <?php require_once 'db/sidebar.php'; ?>
        <div class="flex-grow-1 gradient-bg" style="overflow-x: hidden!important;">
            <?php require_once 'db/alert.php'; ?>
            <div class="py-5 container-fluid main-content">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="lilita dark-accent-fg">MANAGE VISITORS</h1>
                        <hr>
                        <div style="overflow-x: scroll;">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Visit ID</th>
                                        <th>User Name</th>
                                        <th>Date</th>
                                        <th>Timeslot</th>
                                        <th>Visit Type</th>
                                        <th>People</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['visitid']; ?></td>
                                                <td><?= $row['user_fname'] . ' ' . $row['user_lname']; ?></td>
                                                <td><?= date("F j, Y", strtotime($row['schedule_date'])); ?></td>
                                                <td><?= $row['schedule_time']; ?></td>
                                                <td><?= ucfirst($row['visittype']); ?></td>
                                                <td><?= $row['number_people']; ?></td>
                                                <td><?= $row['comment']; ?></td>
                                                <td><?= ucfirst($row['status']); ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn mid-accent-bg text-white btn-sm editModal"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        data-visitid="<?= htmlspecialchars($row['visitid']) ?>"
                                                        data-userid="<?= htmlspecialchars($row['user_fname'] . ' ' . $row['user_lname']) ?>"
                                                        data-schedule_date="<?= htmlspecialchars(date("F j, Y", strtotime($row['schedule_date']))) ?>"
                                                        data-schedule_time="<?= $row['schedule_time'] ?>"
                                                        data-visittype="<?= htmlspecialchars(ucfirst($row['visittype'])) ?>"
                                                        data-number_people="<?= htmlspecialchars($row['number_people']) ?>"
                                                        data-comment="<?= htmlspecialchars($row['comment']) ?>"
                                                        data-status="<?= htmlspecialchars($row['status']) ?>">
                                                        Edit
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            require_once 'db/script.php';
            ?>
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title lilita" id="editModalLabel">Visit Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p id="modalDetails"></p>
                            <hr>
                            <h4 class="lilita">Edit Visit Form</h4>
                            <form method="post">
                                <!-- Hidden Visit ID -->
                                <input type="hidden" id="visitid" name="visitid">
                                <!-- Status -->
                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="scheduled">Scheduled</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                                <!-- Submit Button -->
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="submit" name="submiteditvisit"
                                        class="btn mid-accent-bg text-white p-2">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('#dataTable').DataTable({
                        "paging": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "lengthChange": true
                    });
                });
                document.addEventListener("DOMContentLoaded", function () {
                    document.querySelectorAll(".editModal").forEach(button => {
                        button.addEventListener("click", function () {
                            document.getElementById("visitid").value = this.getAttribute("data-visitid");
                            document.getElementById("status").value = this.getAttribute("data-status");
                            // Update modal details
                            document.getElementById("modalDetails").innerHTML = `
                    <strong>Visit ID:</strong> ${this.getAttribute("data-visitid")}<br>
                    <strong>User ID:</strong> ${this.getAttribute("data-userid")}<br>
                    <strong>Date:</strong> ${this.getAttribute("data-schedule_date")}<br>
                      <strong>Timeslot:</strong> ${this.getAttribute("data-schedule_time")}<br>
                    <strong>Visit Type:</strong> ${this.getAttribute("data-visittype")}<br>
                    <strong>People Count:</strong> ${this.getAttribute("data-number_people")}<br>
                    <strong>Comment:</strong><br> ${this.getAttribute("data-comment")}
                `;
                        });
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>