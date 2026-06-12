<?php

include "db.php";

$sql = "SELECT * FROM admins";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Details</title>

    <style>

        body{
            font-family: Arial;
            background:#173845;
            padding-right:40px;
            padding-left:40px;
        }

        h1{
            color:white;
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse: collapse;
            background:white;
        }

        table th{
            background:#0f6c81;
            color:white;
            padding:12px;
        }

        table td{
            padding:10px;
            text-align:center;
            border:1px solid #ccc;
        }


        a{
            padding:5px 10px;
            text-decoration:none;
            color:white;
            border-radius:5px;
            margin:2px;
            display:inline-block;
        }

        .edit{
            background:green;
        }

        .delete{
            background:red;
        }

    </style>

</head>

<body>
    <h1>Staff Details</h1>
    <table>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>ID Number</th>
            <th>Action</th>
        </tr>

        <?php

        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_assoc($result)){

        ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['id_number']; ?></td>

            <td>
                <a class="edit" href="edit2.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a class="delete" href="delete2.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure want to delete?')">Delete</a>
            </td>
        </tr>

        <?php
            }

        } else {
            echo "<tr><td colspan='5'>No Data Found</td></tr>";
        }

        ?>

    </table>

</body>

</html>