<?php

include "db.php";

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $area = $_POST['area'];
    $account = $_POST['account'];
    

    $update = "UPDATE users SET

    name='$name',
    email='$email',
    area='$area',
    account_number='$account'
   

    WHERE id='$id'
    ";

    if(mysqli_query($conn, $update)){

        echo "
        <script>

        alert('User Updated Successfully');

        window.location.href='users.php';

        </script>
        ";
    }
}

?>

<html>

<head>

    <title>Edit User</title>

    <style>

        body{
            background:#173845;
            font-family:Arial;
        }

        .box{
            width:350px;
            background:white;
            padding:30px;
            margin:50px auto;
            border-radius:10px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:10px;
            margin-top:10px;
        }

        button{
            width:100%;
            padding:12px;
            background:green;
            color:white;
            border:none;
            margin-top:15px;
            cursor:pointer;
        }

    </style>

</head>

<body>

<div class="box">

<h2>Edit User</h2>

<form method="POST">

<input type="text" name="name"
value="<?php echo $row['name']; ?>">

<input type="email" name="email"
value="<?php echo $row['email']; ?>">

<input type="text" name="area"
value="<?php echo $row['area']; ?>">

<input type="text" name="account"
value="<?php echo $row['account_number']; ?>">



<button name="update">
    Update User
</button>

</form>

</div>

</body>
</html>