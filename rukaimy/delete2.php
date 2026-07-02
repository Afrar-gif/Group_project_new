<?php

include "db.php";

$id = $_GET['id'];

$sql = "DELETE FROM admins WHERE id=$id";

if(mysqli_query($conn, $sql)){
    header("Location: staff.php");
} else {
    echo "Delete Failed";
}

?>