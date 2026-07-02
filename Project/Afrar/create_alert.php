<?php
include "db.php";

$edit_mode = false;
$alert_id = '';
$area = '';
$date = '';
$time = '';
$status = 'Pending';

/* ===========================
   EDIT MODE - Fetch existing data to auto fill
=========================== */
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $edit_mode = true;
    $alert_id = intval($_GET['id']);

    $fetch_sql = "SELECT * FROM power_alerts WHERE id = $alert_id";
    $fetch_result = mysqli_query($conn, $fetch_sql);

    if ($fetch_result && mysqli_num_rows($fetch_result) > 0) {
        $row = mysqli_fetch_assoc($fetch_result);
        $area   = $row['area'];
        $date   = $row['date'];
        $time   = $row['time'];
        $status = $row['status'];
    } else {
        // Invalid ID - redirect back
        header("Location: dashboard.php");
        exit;
    }
}

/* ===========================
   FORM SUBMIT - Insert or Update
=========================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $area   = mysqli_real_escape_string($conn, $_POST['area']);
    $date   = mysqli_real_escape_string($conn, $_POST['date']);
    $time   = mysqli_real_escape_string($conn, $_POST['time']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (isset($_POST['alert_id']) && !empty($_POST['alert_id'])) {
        // UPDATE existing record
        $id = intval($_POST['alert_id']);
        $update_sql = "UPDATE power_alerts 
                       SET area = '$area', date = '$date', time = '$time', status = '$status' 
                       WHERE id = $id";

        if (mysqli_query($conn, $update_sql)) {
            header("Location: dashboard.php?msg=updated");
            exit;
        } else {
            $error = "Update failed: " . mysqli_error($conn);
        }
    } else {
        // INSERT new record
        $insert_sql = "INSERT INTO power_alerts (area, date, time, status) 
                       VALUES ('$area', '$date', '$time', '$status')";

        if (mysqli_query($conn, $insert_sql)) {
            header("Location: dashboard.php?msg=added");
            exit;
        } else {
            $error = "Insert failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $edit_mode ? "Edit Power Cut Alert" : "Add New Power Cut Alert"; ?></title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
    }

    body {
      background: #f4f7fc;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .form-container {
      background: white;
      width: 100%;
      max-width: 500px;
      padding: 35px;
      border-radius: 15px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }

    .form-container h2 {
      margin-bottom: 25px;
      color: #0077b6;
      text-align: center;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #333;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
    }

    .btn-submit {
      width: 100%;
      padding: 12px;
      background: #0077b6;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }

    .btn-submit:hover {
      background: #023e8a;
    }

    .btn-back {
      display: inline-block;
      margin-top: 15px;
      text-decoration: none;
      color: #555;
      text-align: center;
      width: 100%;
    }

    .error-msg {
      background: #fee2e2;
      color: #b91c1c;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 15px;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2><?php echo $edit_mode ? "Edit Power Cut Alert" : "Add New Power Cut Alert"; ?></h2>

    <?php if (isset($error)): ?>
      <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="create_alert.php">

      <?php if ($edit_mode): ?>
        <input type="hidden" name="alert_id" value="<?php echo htmlspecialchars($alert_id); ?>">
      <?php endif; ?>

      <div class="form-group">
        <label>Area</label>
        <input type="text" name="area" value="<?php echo htmlspecialchars($area); ?>" required>
      </div>

      <div class="form-group">
        <label>Date</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($date); ?>" required>
      </div>

      <div class="form-group">
        <label>Time</label>
        <input type="time" name="time" value="<?php echo htmlspecialchars($time); ?>" required>
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status" required>
          <option value="Pending" <?php echo ($status === 'Pending') ? 'selected' : ''; ?>>Pending</option>
          <option value="In Progress" <?php echo ($status === 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
          <option value="Completed" <?php echo ($status === 'Completed') ? 'selected' : ''; ?>>Completed</option>
        </select>
      </div>

      <button type="submit" class="btn-submit">
        <?php echo $edit_mode ? "Update Alert" : "Add Alert"; ?>
      </button>

      <a href="../Thanseer/dashboard.php" class="btn-back">← Back to Dashboard</a>

    </form>
  </div>

</body>
</html>
