<?php

include "../Thanseer/db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $secretkey = trim($_POST['secretkey']);
    $password = trim($_POST['password']);

    if(empty($secretkey) || empty($password)){

        echo "
        <script>
            alert('All Fields Are Required');
            window.location.href='../Hamyan GP/adminL.html';
        </script>
        ";

        exit();

    }

    $sql = "SELECT * FROM admins
            WHERE secret_key='$secretkey'
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        echo "
        <script>
            alert('Admin Login Successful');
            window.location.href='../Thanseer/dashboard.php';
        </script>
        ";

    }
    else{

        echo "
        <script>
            alert('Invalid Secret Key or Password');
            window.location.href='../Hamyan GP/adminL.html';
        </script>
        ";

    }

}
else{

    header("Location: ../Hamyan GP/adminL.html");
    exit();

}

?>