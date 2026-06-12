<?php

include "db.php";

// CHECK FORM SUBMIT

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // GET FORM DATA

    $secretkey = trim($_POST['secretkey']);
    $password = trim($_POST['password']);

    // EMPTY CHECK

    if(empty($secretkey) || empty($password)){

        echo "
        <script>
            alert('All Fields Are Required');
            window.location.href='adminL.html';
        </script>
        ";

        exit();

    }

    // LOGIN QUERY

    $sql = "SELECT * FROM admins
            WHERE secret_key='$secretkey'
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    // CHECK LOGIN

    if(mysqli_num_rows($result) > 0){

        echo "
        <script>
            alert('Admin Login Successful');
            window.location.href='dashboard.php';
        </script>
        ";

    }
    else{

        echo "
        <script>
            alert('Invalid Secret Key or Password');
            window.location.href='adminL.html';
        </script>
        ";

    }

}
else{

    header("Location: adminL.html");
    exit();

}

?>