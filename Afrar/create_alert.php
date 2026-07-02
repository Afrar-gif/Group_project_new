<?php
include "db.php";

// Initialize form variables
$area_name = '';
$date_val = '';
$time_val = '';
$status_val = 'Pending';
$is_edit = false;
$edit_id = '';

// 1. EDIT MODE CHECKING (Dashboard-ilirunthu edit click panni vanthaal)
if (isset($_GET['edit_id'])) {
    $is_edit = true;
    $edit_id = mysqli_real_escape_string($conn, $_GET['edit_id']);
    
    // Database-il irunthu antha particular row-vin palaiya details-ai fetch seigirom
    $fetch_sql = "SELECT * FROM power_alerts WHERE id = '$edit_id'";
    $fetch_res = mysqli_query($conn, $fetch_sql);
    
    if (mysqli_num_rows($fetch_res) > 0) {
        $alert_data = mysqli_fetch_assoc($fetch_res);
        
        // Palaiya details-ai variables-il store seigirom (Form-il kaatta)
        $area_name = $alert_data['area'];
        $date_val = $alert_data['date'];  // format: YYYY-MM-DD
        $time_val = $alert_data['time'];
        $status_val = $alert_data['status'];
    }
} 
// 2. FRESH INSERT MODE CHECKING (Area Details page-ilirunthu fresh-ah vanthaal)
else if (isset($_GET['area'])) {
    $area_name = mysqli_real_escape_string($conn, $_GET['area']);
}

// 3. FORM SUBMIT HANDLE LOGIC
if (isset($_POST['submit_alert'])) {
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if ($is_edit) {
        // Palaiya record-ai UPDATE seiyum query
        $update_query = "UPDATE power_alerts SET date='$date', time='$time', status='$status' WHERE id='$edit_id'";
        $run_query = mysqli_query($conn, $update_query);
        $msg = "✅ Alert updated successfully!";
    } else {
        // Puthiya record-ai INSERT seiyum query
        $insert_query = "INSERT INTO power_alerts (area, date, time, status) VALUES ('$area', '$date', '$time', '$status')";
        $run_query = mysqli_query($conn, $insert_query);
        $msg = "✅ Power cut alert scheduled successfully!";
    }

    if ($run_query) {
        echo "<script>alert('$msg'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('❌ Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $is_edit ? "Edit Alert" : "Schedule New Alert"; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #173845;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            text-align: center;
            margin-top: 0;
            color: #173845;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            outline: none;
        }
        input:focus, select:focus {
            border-color: #0077b6;
        }
        .btn-submit {
            background-color: #0077b6;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-submit:hover {
            background: #005683;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #0077b6;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>⚡ <?php echo $is_edit ? "Edit Power Cut Alert" : "New Power Cut Alert"; ?></h2>
    
    <form action="" method="POST">
        
        <div class="form-group">
            <label>Selected Area:</label>
            <input type="text" name="area" value="<?php echo htmlspecialchars($area_name); ?>" readonly style="background: #e9ecef; font-weight: bold; color: #495057;">
        </div>

        <div class="form-group">
            <label>Select Date:</label>
            <input type="date" name="date" value="<?php echo $date_val; ?>" required>
        </div>

        <div class="form-group">
            <label>Set Time Slot:</label>
            <input type="text" name="time" value="<?php echo htmlspecialchars($time_val); ?>" placeholder="e.g., 8AM - 12PM or 1PM - 4PM" required>
        </div>

        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="Pending" <?php if($status_val == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="In Progress" <?php if($status_val == 'In Progress') echo 'selected'; ?>>In Progress</option>
                <option value="Finished" <?php if($status_val == 'Finished') echo 'selected'; ?>>Finished</option>
            </select>
        </div>

        <button type="submit" name="submit_alert" class="btn-submit">
            <?php echo $is_edit ? "Update Alert Details" : "Confirm & Schedule"; ?>
        </button>
        
        <a href="dashboard.php" class="back-link">⬅ Cancel & Go Back</a>
    </form>
</div>

</body>
</html>