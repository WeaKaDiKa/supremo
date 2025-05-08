<?php
require 'db/server.php'; // your database connection


if (isset($_GET['petid'])) {
    $petid = intval($_GET['petid']);
    $stmt = $conn->prepare("SELECT picurl FROM petpics WHERE petid = ?");
    $stmt->bind_param("i", $petid);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 masonry-item">
                <img src="assets/img/uploads/pets/' . htmlspecialchars($row['picurl']) . '" 
                     class="img-fluid rounded shadow-sm" alt="Pet Image">
              </div>';
    }
    $stmt->close();
}