<?php

include "db.php";

$id = $_GET['id'];

$sql = "SELECT * FROM admins WHERE id='$id'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

}else{

    die("No Record Found");

}

?>

<html>
<head>
<title>Edit Admin</title>

<style>

body{
    font-family: Arial;
    background: #173845;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.form-box{
    background:white;
    padding:50px;
    width:350px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0, 0, 0, 0.3);
    transition:0.3s;
}

.form-box:hover{
    transform: scale(1.02);
}

h2{
    text-align:center;
    margin-bottom:20px;
    color:#173845;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:5px;
    transition:0.3s;
}

input:focus{
    border-color:#0f6c81;
    box-shadow:0 0 5px rgba(15,108,129,0.5);
    outline:none;
}

button{
    width:100%;
    padding:10px;
    background:#0f6c81;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#0b4f5e;
    transform: scale(1.05);
}

/* Responsive */
@media(max-width:500px){
    .form-box{
        width:90%;
    }
}

</style>

</head>

<body>

<div class="form-box">

    <h2>Edit Your Details Here</h2>

    <form method="POST">

        <input type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="Name">

        <input type="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Email">

        <input type="text" name="id_number" value="<?php echo $row['id_number']; ?>" placeholder="ID Number">

        <button type="submit" name="update">Update</button>

    </form>

</div>

</body>
</html>

<?php

if(isset($_POST['update'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);

    $update = "UPDATE admins 
    SET 
        name='$name',
        email='$email',
        id_number='$id_number'
    WHERE id='$id'";

    $run = mysqli_query($conn, $update);

    if($run){

        echo "<script>
            alert('Successfully Updated');
            window.location.href='staff.php';
        </script>";

    }else{

        echo mysqli_error($conn);

    }

}

?>