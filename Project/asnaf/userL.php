<?php

include "db.php";

$account = $_POST['account'];
$password = $_POST['password'];

$sql = "SELECT * FROM users 
WHERE account_number='$account'
AND password='$password'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    echo "
    <script>
        alert('Login Successful');
        window.location.href='outage_schedule.php';
    </script>
    ";

}
else{

    echo "
    <script>
        alert('Invalid Account Number or Password');
        window.location.href='userL.html';
    </script>
    ";

}

?>