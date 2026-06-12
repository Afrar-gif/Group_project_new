<?php
include "db.php";

$area_name = '';
$date_val = '';
$start_time_val = '';
$end_time_val = '';
$status_val = 'Pending';
$is_edit = false;
$edit_id = '';

/* EDIT MODE */
if (isset($_GET['edit_id'])) {
    $is_edit = true;
    $edit_id = mysqli_real_escape_string($conn, $_GET['edit_id']);

    $sql = "SELECT * FROM power_alerts WHERE id='$edit_id'";
    $res = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($res)) {
        $area_name = $row['area'];
        $date_val = $row['date'];
        $start_time_val = $row['start_time'];
        $end_time_val = $row['end_time'];
        $status_val = $row['status'];
    }
}

/* NEW INSERT MODE */
else if (isset($_GET['area'])) {
    $area_name = mysqli_real_escape_string($conn, $_GET['area']);
}

/* SUBMIT */
if (isset($_POST['submit_alert'])) {

    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if ($is_edit) {

        $sql = "UPDATE power_alerts SET 
                date='$date',
                start_time='$start_time',
                end_time='$end_time',
                status='$status'
                WHERE id='$edit_id'";

        mysqli_query($conn, $sql);
        echo "<script>alert('✅ Updated Successfully'); window.location.href='dashboard.php';</script>";

    } else {

        $sql = "INSERT INTO power_alerts 
        (area, date, start_time, end_time, status)
        VALUES
        ('$area', '$date', '$start_time', '$end_time', '$status')";

        mysqli_query($conn, $sql);
        echo "<script>alert('✅ Alert Created Successfully'); window.location.href='dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $is_edit ? "Edit Alert" : "Create Alert"; ?></title>

<style>
body{
    font-family: Arial;
    background:#173845;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.form-box{
    background:white;
    padding:25px;
    width:400px;
    border-radius:12px;
}

h2{
    text-align:center;
    margin-bottom:15px;
}

input, select{
    width:100%;
    padding:10px;
    margin-bottom:12px;
    border:1px solid #ccc;
    border-radius:6px;
}

button{
    width:100%;
    padding:10px;
    background:#0077b6;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

button:hover{
    background:#005a8c;
}
</style>
</head>

<body>

<div class="form-box">

<h2>⚡ <?php echo $is_edit ? "Edit Alert" : "Create Alert"; ?></h2>

<form method="POST">

    <input type="text" name="area"
    value="<?php echo htmlspecialchars($area_name); ?>"
    readonly>

    <input type="date" name="date"
    value="<?php echo $date_val; ?>" required>

    <label>Start Time</label>
    <input type="time" name="start_time"
    value="<?php echo $start_time_val; ?>" required>

    <label>End Time</label>
    <input type="time" name="end_time"
    value="<?php echo $end_time_val; ?>" required>

    <select name="status" required>
        <option value="Pending" <?php if($status_val=='Pending') echo 'selected'; ?>>Pending</option>
        <option value="In Progress" <?php if($status_val=='In Progress') echo 'selected'; ?>>In Progress</option>
        <option value="Finished" <?php if($status_val=='Finished') echo 'selected'; ?>>Finished</option>
    </select>

    <button type="submit" name="submit_alert">
        <?php echo $is_edit ? "Update Alert" : "Create Alert"; ?>
    </button>

</form>

</div>

</body>
</html>