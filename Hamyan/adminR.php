<?php

include "db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$idnumber = $_POST['idnumber'];
$secretkey = $_POST['secretkey'];
$password = $_POST['password'];

$sql = "INSERT INTO admins
(name,email,id_number,secret_key,password)

VALUES
('$name','$email','$idnumber','$secretkey','$password')";

if(mysqli_query($conn,$sql)){

    echo "
    <script>
        alert('Admin Registration Successful');
        window.location.href='adminL.html';
    </script>
    ";

}
else{

    echo mysqli_error($conn);

}

?>