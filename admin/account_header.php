<?php
// Make sure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../db.php";  // Adjust the path as necessary

// Account and logout functionality
if (isset($_SESSION["uid"])) {
    $sql = "SELECT FullName FROM CustomerInfo WHERE UserId='$_SESSION[uid]'";
    $query = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_array($query)) {
        echo '
            <div class="dropdownn">
                <a href="#" class="dropdownn" data-toggle="modal" data-target="#myModal"><i class="fa fa-user-o"></i> Hi ' . $row["FullName"] . '</a>
                <div class="dropdownn-content">
                    <a href="../customer/logout.php"><i class="fa fa-sign-in" aria-hidden="true"></i>Log out</a>
                </div>
            </div>';
    }
} else {
    echo '
        <div class="dropdownn">
            <a href="#" class="dropdownn" data-toggle="modal" data-target="#myModal"><i class="fa fa-user-o"></i> NOT LOGGED IN</a>
        </div>';
}
?>
