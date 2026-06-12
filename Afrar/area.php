<?php
include "db.php";

if(isset($_POST['submit'])){

    $district = $_POST['district'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $transformer = $_POST['transformer'];

    $sql = "INSERT INTO areas (district, city, area, transformer)
            VALUES ('$district', '$city', '$area', '$transformer')";

    if(mysqli_query($conn, $sql)){
        echo "<script>
            window.location.href='areaDV.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to Add Area');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang>
<title>Add Area</title>

<style>

body{
    font-family: Arial;
    background: linear-gradient(135deg,#0d1b2a,#1b263b);
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
}

/* CARD */
.form-box{
    background:white;
    width:100%;
    max-width:520px;
    padding:35px;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
    transition:0.3s;
}

.form-box:hover{
    transform:scale(1.02);
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:25px;
    color:#0d1b2a;
    letter-spacing:1px;
}

/* INPUT GROUP */
.form-group{
    margin-bottom:15px;
}

label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
    color:#333;
}

input{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:10px;
    outline:none;
    transition:0.3s;
}

input:focus{
    border-color:#0077b6;
    box-shadow:0 0 8px rgba(0,119,182,0.4);
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    background:linear-gradient(135deg,#0077b6,#023e8a);
    color:white;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-size:16px;
    transition:0.3s;
    margin-top:10px;
}

button:hover{
    transform:scale(1.05);
    background:linear-gradient(135deg,#023e8a,#0077b6);
}

/* RESPONSIVE */
@media(max-width:600px){
    .form-box{
        padding:20px;
    }
}

</style>

</head>

<body>

<div class="form-box">

    <h2>Add Area Details</h2>

    <form method="POST">

        <div class="form-group">
            <label>District Name</label>
            <input type="text" name="district" placeholder="Enter District Name" required>
        </div>

        <div class="form-group">
            <label>City Name</label>
            <input type="text" name="city" placeholder="Enter City Name" required>
        </div>

        <div class="form-group">
            <label>Area Name</label>
            <input type="text" name="area" placeholder="Enter Area Name" required>
        </div>

        <div class="form-group">
            <label>Area Transformer Name</label>
            <input type="text" name="transformer" placeholder="Enter Transformer Name" required>
        </div>

        <button type="submit" name="submit">Add Area</button>

    </form>

</div>

</body>
</html>