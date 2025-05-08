<?php
require_once('db/server.php');
$sql = "SELECT petid, name, gender, age, spayed, description, color, status, pet_condition, rescue_date FROM pet";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['newPet'])) {

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


        $_SESSION['errorMessage'] = "Pet and images uploaded successfully";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorHead'] = "Success!";

    } else {
        $_SESSION['errorMessage'] = "Error saving pet";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorHead'] = "Warning!";
    }

    $stmt->close();
    header("Location: adminanimal.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletePet'])) {
    $petid = $_POST['delete_petid'];

    // First, delete pet images from the server
    $query = $conn->prepare("SELECT picurl FROM petpics WHERE petid = ?");
    $query->bind_param("i", $petid);
    $query->execute();
    $result = $query->get_result();
    while ($row = $result->fetch_assoc()) {
        $file_path = "assets/img/uploads/pets/" . $row['picurl'];
        if (file_exists($file_path)) {
            unlink($file_path); // Delete image file
        }
    }

    // Delete image records
    $stmt=$conn->prepare("DELETE FROM petpics WHERE petid = ?");
    $stmt->bind_param("i", $petid);
    $stmt->execute();

    // Delete the pet record
    $stmt2 = $conn->prepare("DELETE FROM pet WHERE petid = ?");
    $stmt2->bind_param("i", $petid);
    $stmt2->execute();

    $_SESSION['errorMessage'] = "Pet deleted successfully";
    $_SESSION['errorType'] = "success";
    $_SESSION['errorHead'] = "Deleted!";

    header("Location: adminanimal.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editPet'])) {
    $petid = $_POST['petid'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $color = $_POST['color'];
    $status = $_POST['status'];
    $pet_condition = $_POST['pet_condition'];
    $spayed = $_POST['spayed'];

    // Update pet info
    $stmt = $conn->prepare("UPDATE pet SET name=?, gender=?, age=?, description=?, color=?, status=?, pet_condition=?, spayed=? WHERE petid=?");
    $stmt->bind_param("ssssssssi", $name, $gender, $age, $description, $color, $status, $pet_condition, $spayed, $petid);

    if ($stmt->execute()) {
        $upload_dir = "assets/img/uploads/pets/";

        // If new images are uploaded, remove old ones and save new ones
        if (!empty($_FILES["petpics"]["name"][0])) {

            // Step 1: Remove old images from folder and DB
            $query = $conn->prepare("SELECT picurl FROM petpics WHERE petid = ?");
            $query->bind_param("i", $petid);
            $query->execute();
            $result = $query->get_result();

            while ($row = $result->fetch_assoc()) {
                $filePath = $upload_dir . $row['picurl'];
                if (file_exists($filePath)) {
                    unlink($filePath); // delete file from folder
                }
            }

            // Delete image records from DB
            $deleteStmt = $conn->prepare("DELETE FROM petpics WHERE petid = ?");
            $deleteStmt->bind_param("i", $petid);
            $deleteStmt->execute();

            // Step 2: Upload new images
            foreach ($_FILES["petpics"]["name"] as $key => $value) {
                if ($_FILES["petpics"]["error"][$key] === UPLOAD_ERR_OK) {
                    $file_name = time() . "_" . basename($_FILES["petpics"]["name"][$key]);
                    $target_file = $upload_dir . $file_name;

                    // Ensure upload folder exists
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    if (move_uploaded_file($_FILES["petpics"]["tmp_name"][$key], $target_file)) {
                        $stmt2 = $conn->prepare("INSERT INTO petpics (petid, picurl) VALUES (?, ?)");
                        $stmt2->bind_param("is", $petid, $file_name);
                        $stmt2->execute();
                    }
                }
            }
        }

        $_SESSION['errorMessage'] = "Pet details updated successfully.";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorHead'] = "Updated!";
    } else {
        $_SESSION['errorMessage'] = "Failed to update pet.";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorHead'] = "Error!";
    }

    $stmt->close();
    header("Location: adminanimal.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php
    $page = "animal";
    require_once 'db/head.php'; ?>
    <title>Pets | Supremo Fur Babies</title>


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
                        <div class="d-flex justify-content-between">

                        <h1 class="lilita dark-accent-fg">MANAGE PETS</h1>
                        <button type="button" class="btn mid-accent-bg text-white btn-sm lilita" data-bs-toggle="modal" data-bs-target="#newModal">NEW</button>
</div>
                        <hr>
                        <div style="overflow-x: scroll;">
                            <table id="dataTable" class="table table-striped table-bordered ">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Age (months)</th>
                                      
                                        <th>Color</th>

                                     
                                        <th>Rescue Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['petid']; ?></td>
                                                <td><?= ucfirst($row['name']); ?></td>
                                                <td><?= ucfirst($row['gender']); ?></td>
                                                <td><?= $row['age']; ?></td>
                                           
                                                <td><?= ucfirst($row['color']); ?></td>
                                      
                                                <td><?= date("F j, Y", strtotime($row['rescue_date'])); ?></td>
                                                <td><?= ucfirst($row['status']); ?></td>
                                                <td class="text-center">
                                                    <!-- Add data-src attribute -->
                                                  <!-- View Button -->
<button type="button" class="btn dark-accent-bg text-white btn-sm openModal"
    data-bs-toggle="modal" data-bs-target="#imageModal"
    data-petid="<?= htmlspecialchars($row['petid']) ?>">
    <i class="bi bi-eye"></i>   
</button>

<!-- Edit Button -->
<button type="button" class="btn mid-accent-bg text-white btn-sm editModal"
    data-bs-toggle="modal" data-bs-target="#editModal"
    data-petid="<?= htmlspecialchars($row['petid']) ?>"
    data-name="<?= htmlspecialchars($row['name']) ?>"
    data-gender="<?= htmlspecialchars($row['gender']) ?>"
    data-age="<?= htmlspecialchars($row['age']) ?>"
    data-description="<?= htmlspecialchars($row['description']) ?>"
    data-color="<?= htmlspecialchars($row['color']) ?>"
    data-condition="<?= htmlspecialchars($row['pet_condition']) ?>"
    data-date="<?= htmlspecialchars(date("Y-m-d", strtotime($row['rescue_date']))) ?>"
    data-status="<?= htmlspecialchars($row['status']) ?>">
    <i class="bi bi-pencil-square"></i>
</button>

<!-- Delete Button -->
<button type="button" class="btn btn-danger btn-sm" 
    data-bs-toggle="modal" 
    data-bs-target="#deletePetModal" 
    onclick="setDeletePetId(<?= htmlspecialchars($row['petid']) ?>)">
    <i class="bi bi-trash"></i>
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
                            <h5 class="modal-title lilita" id="imageModalLabel">Pet Images</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div id="petimagesdiv" class="row" data-masonry='{"percentPosition": true }'>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title lilita" id="newModalLabel">Pet Form</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <h4 class="lilita">New Pet Form</h4>

                            <hr>

                            <form method="post" enctype="multipart/form-data">
                                <!-- Name -->

           
                                <div class="form-group mb-3">
                                    <label for="name">Pet Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>

                                <!-- Gender -->
                                <div class="form-group mb-3">
                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                    <select class="form-control"  name="gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <!-- Age -->
                                <div class="form-group mb-3">
                                    <label for="age">Age in Months <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="age" required>
                                </div>

                                <!-- Description -->
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description"
                                        rows="3"></textarea>
                                </div>

                                <!-- Color -->
                                <div class="form-group mb-3">
                                    <label for="color">Color <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="color" required>
                                </div>

                                <!-- Status -->
                                <div class="form-group mb-3">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" name="status" required>
                                        <option value="available">Available</option>
                                        <option value="adopted">Adopted</option>
                                        <option value="rescued">Rescued</option>
                                    </select>
                                </div>

                                <!-- Pet Condition -->
                                <div class="form-group mb-3">
                                    <label for="pet_condition">Pet Condition</label>
                                    <input type="text" class="form-control" name="pet_condition">
                                </div>

                                <!-- Spayed -->
                                <div class="form-group mb-3">
                                    <label for="spayed">Spayed? <span class="text-danger">*</span></label>
                                    <select class="form-control" name="spayed" required>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>

                                <!-- Type -->
                                <div class="form-group mb-3">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="type" required>
                                        <option value="Dog">Dog</option>
                                        <option value="Cat">Cat</option>
                                    </select>
                                </div>

                                <!-- Multiple Pet Images -->
                                <div class="form-group mb-3">
                                    <label for="petpics">Upload Pet Images (Multiple Allowed) <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file" name="petpics[]"
                                        accept="image/*" multiple required>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="submit" name="newPet" class="btn btn-primary p-2 lilita">Submit</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title lilita" id="editModalLabel">Pet Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <h4 class="lilita">Edit Pet Form</h4>

                            <hr>

                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" class="form-control" id="petid" name="petid">
                                <!-- Pet Name -->
                                <div class="form-group mb-3">
                                    <label for="name">Pet Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>

                                <!-- Gender -->
                                <div class="form-group mb-3">
                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <!-- Age -->
                                <div class="form-group mb-3">
                                    <label for="age">Age in Months <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="age" name="age">
                                </div>

                                <!-- Description -->
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>

                                <!-- Color -->
                                <div class="form-group mb-3">
                                    <label for="color">Color <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="color" name="color">
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

               
                              
                                <!-- Status -->
                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="available">Available</option>

                                        <option value="unavailable">Unavailable</option>
                                    </select>
                                </div>
  <!-- Multiple Pet Images -->
  <div class="form-group mb-3">
                                    <label for="petpics">Upload Pet Images (Multiple Allowed) <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file" id="petpics" name="petpics[]"
                                        accept="image/*" multiple><br>
                                        <small class="text-muted">Uploading new pictures removes old pictures</small>
                                </div>

                                <!-- Submit and Adopt Buttons -->
                                <div class="d-flex align-items-center justify-content-center my-3">
                                    <button type="submit" name="editPet"
                                        class="btn dark-accent-bg text-white p-2 mx-2 lilita">Edit</button>

                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
<!-- Delete Pet Modal -->
<div class="modal fade" id="deletePetModal" tabindex="-1" role="dialog" aria-labelledby="deletePetLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="post">
      <input type="hidden" name="delete_petid" id="delete_petid">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deletePetLabel">Confirm Deletion</h5>
      
        </div>
        <div class="modal-body">
          Are you sure you want to delete this pet and all associated images?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary lilita" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="deletePet" class="btn btn-danger lilita">Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>

            <script>
                function setDeletePetId(id) {
    document.getElementById("delete_petid").value = id;
}
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
                            const petid = this.getAttribute("data-petid");

                            // Clear previous content
                            document.getElementById("petimagesdiv").innerHTML = "Loading...";

                            // Fetch pet images via AJAX
                            fetch("fetch_pet_images.php?petid=" + petid)
                                .then(response => response.text())
                                .then(data => {
                                    document.getElementById("petimagesdiv").innerHTML = `
                        <div class="row g-2" id="masonry-container">${data}</div>
                    `;

                                    // Optional: Trigger Masonry (if using a library like Masonry.js)
                                    // new Masonry('#masonry-container', { itemSelector: '.masonry-item' });
                                })
                                .catch(error => {
                                    document.getElementById("petimagesdiv").innerHTML = `<p class="text-danger">Error loading images.</p>`;
                                    console.error("Fetch error:", error);
                                });
                        });
                    });
                    document.querySelectorAll(".editModal").forEach(button => {
                        button.addEventListener("click", function () {
                            document.getElementById("petid").value = this.getAttribute("data-petid");
                            document.getElementById("name").value = this.getAttribute("data-name");
                            document.getElementById("gender").value = this.getAttribute("data-gender");
                            document.getElementById("age").value = this.getAttribute("data-age");
                            document.getElementById("description").value = this.getAttribute("data-description");
                            document.getElementById("color").value = this.getAttribute("data-color");
                            document.getElementById("pet_condition").value = this.getAttribute("data-condition");

                            let status = this.getAttribute("data-status");
                            let statusField = document.getElementById("status");
                            statusField.value = status;

                            // Disable status field if status is 'adopted'
                            if (status.toLowerCase() === 'adopted') {
                                statusField.setAttribute("disabled", true);
                            } else {
                                statusField.removeAttribute("disabled");
                            }
                        });
                    });

                });
            </script>
        </div>
    </div>
</body>

</html>