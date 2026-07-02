<?php

include "db.php";

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id='$id'";

if(mysqli_query($conn, $sql)){

    echo "

    <script>

    alert('User Deleted Successfully');

    window.location.href='users.php';

    </script>

    ";

}

?>