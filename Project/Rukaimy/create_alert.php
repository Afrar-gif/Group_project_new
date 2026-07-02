<?php
include "db.php";

$area_name = '';
$date_val = '';
$start_time_val = '';
$end_time_val = '';
$status_val = 'Pending';
$is_edit = false;
$edit_id = '';

/* 1️⃣ EDIT MODE: டேஷ்போர்டில் இருந்து Edit கிளிக் செய்து வரும்போது மட்டும் */
if (isset($_GET['edit_id']) || (isset($_GET['id']) && !isset($_GET['area_id']))) {
    $is_edit = true;
    
    $edit_id = isset($_GET['edit_id']) ? mysqli_real_escape_string($conn, $_GET['edit_id']) : mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM power_alerts WHERE id='$edit_id'";
    $res = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($res)) {
        $area_name = $row['area'];
        $date_val = $row['date'];
        
        /* 🌟 BUG FIX: டைம் ஃபீல்டை உடைத்துப் போடுதல் */
        if (!empty($row['time']) && strpos($row['time'], '-') !== false) {
            $parts = explode('-', $row['time']);
            $start_time_val = date("H:i", strtotime(trim($parts[0])));
            $end_time_val = date("H:i", strtotime(trim($parts[1])));
        } else if (!empty($row['time'])) {
            $start_time_val = date("H:i", strtotime($row['time']));
            $end_time_val = '';
        }
        
        $status_val = $row['status'];
    }
}
/* 2️⃣ NEW INSERT MODE: Area Details பக்கத்தில் இருந்து "+ Schedule Alert" கிளிக் செய்து வந்தால் */
else if (isset($_GET['area'])) {
    $is_edit = false; 
    $area_name = mysqli_real_escape_string($conn, $_GET['area']);
}

/* 📥 FORM SUBMIT TRIGGER (SAVE / UPDATE) */
if (isset($_POST['submit_alert'])) {

    if (!empty($_POST['hidden_edit_id'])) {
        $is_edit = true;
        $edit_id = mysqli_real_escape_string($conn, $_POST['hidden_edit_id']);
    }

    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $combined_time = $start_time . " - " . $end_time;

    if ($is_edit) {
        /* 🛠️ UPDATE QUERY */
        $sql = "UPDATE power_alerts SET 
                date='$date',
                time='$combined_time',
                status='$status'
                WHERE id='$edit_id'";

        mysqli_query($conn, $sql);
        echo "<script>alert('✅ Updated Successfully'); window.location.href='dashboard.php';</script>";

    } else {
        /* 🛠️ INSERT QUERY */
        $sql = "INSERT INTO power_alerts 
                (area, date, time, status)
                VALUES
                ('$area', '$date', '$combined_time', '$status')";

        mysqli_query($conn, $sql);
        echo "<script>alert('✅ Alert Created Successfully'); window.location.href='dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $is_edit ? "Edit Alert" : "Create Alert"; ?></title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
body{
    font-family: Arial, sans-serif;
    background:#173845;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin: 0;
    padding: 10px;
    box-sizing: border-box;
}

.form-box{
    background:white;
    padding:30px;
    width:100%;
    max-width:420px;
    border-radius:12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

h2{
    text-align:center;
    margin-top: 0;
    margin-bottom:20px;
    color: #173845;
}

.form-group {
    margin-bottom: 14px;
}

label{
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #444;
    font-size: 14px;
}

input, select{
    width:100%;
    padding:11px;
    border:1px solid #ccc;
    border-radius:6px;
    box-sizing: border-box;
    outline: none;
    font-size: 15px;
    transition: 0.3s;
}

input:focus, select:focus {
    border-color: #0077b6;
    box-shadow: 0 0 5px rgba(0, 119, 182, 0.3);
}

.button-group {
    display: flex;
    gap: 10px;
    margin-top: 22px;
}

button{
    background:#0077b6;
    color:white;
    border:none;
    padding:12px;
    flex: 2;
    border-radius:6px;
    cursor:pointer;
    font-size: 16px;
    font-weight: bold;
    transition: 0.3s;
}

button:hover{
    background:#005a8c;
}

.btn-cancel {
    background: #6c757d;
    color: white;
    text-decoration: none;
    padding: 12px;
    flex: 1;
    border-radius:6px;
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    transition: 0.3s;
}

.btn-cancel:hover {
    background: #495057;
}
</style>
</head>

<body>

<div class="form-box">

<h2><i class="fa-solid fa-bolt-lightning"></i> <?php echo $is_edit ? "Edit Power Alert" : "Create Power Alert"; ?></h2>

<form method="POST">

    <input type="hidden" name="hidden_edit_id" value="<?php echo $edit_id; ?>">

    <div class="form-group">
        <label>Selected Area Name</label>
        <input type="text" name="area" value="<?php echo htmlspecialchars($area_name); ?>" readonly style="background: #e9ecef; color: #495057; font-weight: bold;">
    </div>

    <div class="form-group">
        <label>Select Date</label>
        <input type="date" name="date" value="<?php echo $date_val; ?>" required>
    </div>

    <div class="form-group">
        <label><i class="fa-regular fa-clock"></i> Start Time</label>
        <input type="time" name="start_time" value="<?php echo $start_time_val; ?>" required>
    </div>

    <div class="form-group">
        <label><i class="fa-regular fa-clock"></i> End Time</label>
        <input type="time" name="end_time" value="<?php echo $end_time_val; ?>" required>
    </div>

    <div class="form-group">
        <label>Current Status</label>
        <select name="status" required>
            <option value="Pending" <?php if($status_val=='Pending') echo 'selected'; ?>>Pending</option>
            <option value="In Progress" <?php if($status_val=='In Progress') echo 'selected'; ?>>In Progress</option>
            <option value="Finished" <?php if($status_val=='Finished' || $status_val=='Completed') echo 'selected'; ?>>Finished</option>
        </select>
    </div>

    <div class="button-group">
        <button type="submit" name="submit_alert">
            <?php echo $is_edit ? "Update Alert" : "Create Alert"; ?>
        </button>
        <a href="areaDV.php" class="btn-cancel">Cancel</a>
    </div>

</form>

</div>

</body>
</html>