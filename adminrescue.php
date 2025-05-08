<?php
require_once('db/server.php');
require_once('db/adminloginverify.php');

// Fetch rescue records
$sql = "SELECT rescueid, pet_type, pet_condition, location, picurl, fname, lname, additional, status FROM rescue LEFT JOIN user ON rescue.userid = user.userid";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitPet'])) {
    $rescueid = $_POST['rescueid'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $color = $_POST['color'];
    $status = $_POST['status'];
    $pet_condition = $_POST['pet_condition'];
    $spayed = $_POST['spayed'];
    $type = $_POST['type'];

    // Insert into pet table
    $stmt = $conn->prepare("INSERT INTO pet (name, gender, age, description, color, status, pet_condition, spayed, type) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $gender, $age, $description, $color, $status, $pet_condition, $spayed, $type);

    if ($stmt->execute()) {
        // Get the inserted pet ID
        $petid = $stmt->insert_id;
        $stmt3 = $conn->prepare("UPDATE rescue SET status = 'rescued' WHERE rescueid = ?");
        $stmt3->bind_param("i", $rescueid);
        $stmt3->execute();

        // Handle Multiple Image Uploads
        if (!empty($_FILES["petpics"]["name"][0])) {
            $target_dir = "assets/img/uploads/pets/"; // Folder to store images

            foreach ($_FILES["petpics"]["name"] as $key => $value) {
                $file_name = time() . "_" . basename($_FILES["petpics"]["name"][$key]);
                $target_file = $target_dir . $file_name;

                if (move_uploaded_file($_FILES["petpics"]["tmp_name"][$key], $target_file)) {
                    // Save filename to petpics table
                    $stmt2 = $conn->prepare("INSERT INTO petpics (petid, picurl) VALUES (?, ?)");
                    $stmt2->bind_param("is", $petid, $file_name);
                    $stmt2->execute();
                }
            }
        }


        $_SESSION['errorMessage'] = "Pet and images saved successfully";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorHead'] = "Success!";

    } else {
        $_SESSION['errorMessage'] = "Error saving pet";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorHead'] = "Warning!";
    }

    $stmt->close();
    header("Location: adminrescue.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php
    $page = "rescue";
    require_once 'db/head.php'; ?>
    <title>Rescues | Supremo Fur Babies</title>


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
                        <h1 class="lilita dark-accent-fg">MANAGE RESCUES</h1>
                        <hr>
                        <div style="overflow-x: scroll;">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Pet Type</th>
                                        <th>Condition</th>
                                        <th>Location</th>

                                        <th>User</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result && $result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['rescueid']); ?></td>
                                                <td><?= ucfirst(htmlspecialchars($row['pet_type'])); ?></td>
                                                <td><?= htmlspecialchars($row['pet_condition']); ?></td>
                                                <td><?= htmlspecialchars($row['location']); ?></td>
                                                <td><?= htmlspecialchars($row['fname']); ?>
                                                    <?= htmlspecialchars($row['lname']); ?>
                                                </td>
                                                <td><?= ucfirst(htmlspecialchars($row['status'])); ?></td>
                                                <td class="text-center">
                                                    <!-- Add data-src attribute -->
                                                    <button type="button" class="btn dark-accent-bg text-white btn-sm openModal"
                                                        data-bs-toggle="modal" data-bs-target="#imageModal"
                                                        data-src="assets/img/uploads/rescue/<?= htmlspecialchars($row['picurl']); ?>">
                                                        View
                                                    </button>
                                                    <button type="button" class="btn mid-accent-bg text-white btn-sm editModal"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        data-rescueid="<?= htmlspecialchars($row['rescueid']) ?>"
                                                        data-additional="<?= htmlspecialchars($row['additional']) ?>"
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

            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title lilita" id="imageModalLabel">Rescue Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalImage" src="" alt="Pet Image" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title lilita" id="editModalLabel">Rescue Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <h4 class="lilita">Additional Details</h4>
                            <p id="modalDetails"></p>
                            <hr>
                            <h4 class="lilita">Rescue Pet Form</h4>
                            <form method="post" enctype="multipart/form-data">
                                <!-- Name -->

                                <input type="hidden" name="rescueid" id="rescueid" required>
                                <div class="form-group mb-3">
                                    <label for="name">Pet Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <!-- Gender -->
                                <div class="form-group mb-3">
                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <!-- Age -->
                                <div class="form-group mb-3">
                                    <label for="age">Age in Months <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="age" name="age" required>
                                </div>

                                <!-- Description -->
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description"
                                        rows="3"></textarea>
                                </div>

                                <!-- Color -->
                                <div class="form-group mb-3">
                                    <label for="color">Color <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="color" name="color" required>
                                </div>

                                <!-- Status -->
                                <div class="form-group mb-3">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="available">Available</option>
                                        <option value="adopted">Adopted</option>
                                        <option value="rescued">Rescued</option>
                                    </select>
                                </div>

                                <!-- Pet Condition -->
                                <div class="form-group mb-3">
                                    <label for="pet_condition">Pet Condition</label>
                                    <input type="text" class="form-control" id="pet_condition" name="pet_condition">
                                </div>

                                <!-- Spayed -->
                                <div class="form-group mb-3">
                                    <label for="spayed">Spayed? <span class="text-danger">*</span></label>
                                    <select class="form-control" id="spayed" name="spayed" required>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>

                                <!-- Type -->
                                <div class="form-group mb-3">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="Dog">Dog</option>
                                        <option value="Cat">Cat</option>
                                    </select>
                                </div>

                                <!-- Multiple Pet Images -->
                                <div class="form-group mb-3">
                                    <label for="petpics">Upload Pet Images (Multiple Allowed) <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file" id="petpics" name="petpics[]"
                                        accept="image/*" multiple required>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="submit" name="submitPet" class="btn btn-primary p-2">Submit</button>
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
                    // Get all buttons that open the modal
                    document.querySelectorAll(".openModal").forEach(button => {
                        button.addEventListener("click", function () {

                            let imageUrl = this.getAttribute("data-src");

                            // Update modal image source
                            document.getElementById("modalImage").src = imageUrl;
                        });
                    });

                    document.querySelectorAll(".editModal").forEach(button => {
                        button.addEventListener("click", function () {

                            let additional = this.getAttribute("data-additional");
                            let rescueid = this.getAttribute("data-rescueid");
                            // Update modal image source
                            document.getElementById("modalDetails").innerHTML = additional;
                            document.getElementById("rescueid").value = rescueid;
                        });
                    });
                });
            </script>

        </div>
    </div>
</body>

</html>