<nav id="sidebar">
    <ul class="list-unstyled">
        <li>
            <a href="admindashboard.php" class="lilita <?= $page == "dashboard" ? "active" : "" ?>">Dashboard</a>
        </li>
        <li>
            <a href="adminuser.php" class="lilita  <?= $page == "user" ? "active" : "" ?>">User</a>
        </li>
        <li>
            <a href="adminanimal.php" class="lilita  <?= $page == "animal" ? "active" : "" ?>">Animal</a>
        </li>
    </ul>

    <ul class="list-unstyled mt-3">
        <li>
            <a href="adminadoption.php" class="lilita  <?= $page == "adoption" ? "active" : "" ?>">Adoption</a>
        </li>
        <li>
            <a href="adminshelter.php" class="lilita  <?= $page == "visit" ? "active" : "" ?>">Shelter Visit</a>
        </li>
        <li>
            <a href="adminrescue.php" class="lilita  <?= $page == "rescue" ? "active" : "" ?>">Rescue Report</a>
        </li>
     
    </ul>

</nav>