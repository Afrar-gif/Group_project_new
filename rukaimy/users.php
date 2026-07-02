<?php

include "db.php";

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

?>

<html>
    
<head>
    <title>Users Details</title>

    <style>

        body{
            font-family:Arial;
            background:#173845;
            padding:30px;
        }

        h1{
            color:white;
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            background:white;
            border-collapse:collapse;
        }

        table th{
            background:black;
            color:white;
            padding:12px;
        }

        table td{
            padding:12px;
            text-align:center;
            border-bottom:1px solid #ccc;
        }

        .edit{
            background:orange;
            color:white;
            padding:8px 12px;
            text-decoration:none;
            border-radius:5px;
            margin-right:5px;
        }

        .delete{
            background:red;
            color:white;
            padding:8px 12px;
            text-decoration:none;
            border-radius:5px;
        }

    </style>

</head>

<body>

<h1>User Details</h1>

<table>

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Area</th>
        <th>Account Number</th>        
        <th>Action</th>
    </tr>

<?php

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['area']; ?></td>
    <td><?php echo $row['account_number']; ?></td>

    <td>
        <a class="edit" href="edit.php?id=<?php echo $row['id']; ?>">
            Edit
        </a>

        <a class="delete" href="delete.php?id=<?php echo $row['id']; ?>">
            Delete
        </a>
    </td>

</tr>

<?php

}

?>

</table>

</body>
</html>