<?php
include("db.php");

$user_email = "rukaimyahamed01@gmail.com"; 

$user_info_sql = "SELECT * FROM complaints WHERE email = '$user_email' LIMIT 1";
$user_info_res = mysqli_query($conn, $user_info_sql);
$user_data = mysqli_fetch_assoc($user_info_res);
$user_area = $user_data['area'] ?? 'Sammanthurai 01'; 
$user_name = $user_data['name'] ?? 'Registered Customer';

$msg = "";
if (isset($_POST['submit_complaint'])) {
    $c_name = mysqli_real_escape_string($conn, $_POST['name']);
    $c_email = mysqli_real_escape_string($conn, $_POST['email']);
    $c_area = mysqli_real_escape_string($conn, $_POST['area']);
    $c_subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $c_message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $insert_sql = "INSERT INTO complaints (name, email, area, subject, message, status) 
                   VALUES ('$c_name', '$c_email', '$c_area', '$c_subject', '$c_message', 'Pending')";
    
    if (mysqli_query($conn, $insert_sql)) {
        $msg = "<p style='color: #10b981; font-weight: bold; margin-bottom: 15px;'><i class='fa fa-circle-check'></i> Complaint registered successfully!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EDL Portal - Consumer Dashboard</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', sans-serif; }
    body { background:#0b132b; color:#e0e1dd; display:flex; min-height:100vh; }
    .main-content { margin-left:260px; width:calc(100% - 260px); padding:30px; }
    .header-panel { background:#1c2541; padding:25px; border-radius:15px; display:flex; justify-content:space-between; align-items:center; border-left: 5px solid #4cc9f0; }
    .portal-grid { display:grid; grid-template-columns: 1fr 1.3fr; gap:25px; margin-top:30px; }
    .panel-box { background:#1c2541; padding:25px; border-radius:15px; }
    .panel-box h2 { font-size:18px; margin-bottom:20px; color:#4cc9f0; border-bottom: 1px solid #3a506b; padding-bottom:10px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display:block; margin-bottom: 6px; font-size: 13px; color:#adb5bd; }
    .form-control { width:100%; background:#0b132b; border:1px solid #3a506b; padding:10px; border-radius:8px; color:#fff; }
    .btn-submit { background:#4cc9f0; color:#0b132b; width:100%; padding:12px; border:none; border-radius:8px; font-weight:700; cursor:pointer; }
    .alert-card { background:#0b132b; border-radius:10px; padding:15px; margin-bottom:15px; border-left:4px solid #e63946; }
  </style>
</head>
<body>

  <?php include "user_sidebar.php"; ?> <!-- எர்ரர் சரி செய்யப்பட்டது (../ நீக்கப்பட்டது) -->

  <div class="main-content">
    <div class="header-panel">
      <div>
        <h1>Welcome Back, <?php echo htmlspecialchars($user_name); ?></h1>
        <p><i class="fa fa-location-dot"></i> Grid Sector Node: <strong><?php echo htmlspecialchars($user_area); ?></strong></p>
      </div>
      <span style="color:#10b981;"><i class="fa fa-circle-check"></i> Connected Live</span>
    </div>

    <div class="portal-grid">
      <div class="panel-box">
        <h2><i class="fa fa-pen-to-square"></i> File Smart Grid Complaint</h2>
        <?php echo $msg; ?>
        <form action="" method="POST">
          <div class="form-group"><label>Full Name</label><input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user_name); ?>" required></div>
          <div class="form-group"><label>Email Address</label><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user_email); ?>" readonly></div>
          <div class="form-group">
            <label>Target Outage Area</label>
            <select name="area" class="form-control">
              <option value="<?php echo htmlspecialchars($user_area); ?>"><?php echo htmlspecialchars($user_area); ?></option>
            </select>
          </div>
          <div class="form-group"><label>Subject</label><input type="text" name="subject" class="form-control" placeholder="e.g. Transformer Issue" required></div>
          <div class="form-group"><label>Detailed Message</label><textarea name="message" class="form-control" rows="4" required></textarea></div>
          <button type="submit" name="submit_complaint" class="btn-submit">File Emergency Ticket</button>
        </form>
      </div>

      <div>
        <div class="panel-box" style="margin-bottom: 25px;">
          <h2><i class="fa fa-bolt" style="color:#e63946;"></i> Active Area Alerts</h2>
          <?php
          $outage_res = mysqli_query($conn, "SELECT * FROM power_alerts WHERE area = '$user_area' AND status != 'Completed' LIMIT 2");
          if(mysqli_num_rows($outage_res) > 0) {
              while($out_row = mysqli_fetch_assoc($outage_res)) {
                  echo "<div class='alert-card'><h4>⚠️ Power Break Scheduled ({$out_row['status']})</h4><p style='font-size:13px; color:#adb5bd; margin-top:5px;'><b>Time Slot:</b> {$out_row['time']}</p></div>";
              }
          } else { echo "<p style='color:#6c757d; font-size:14px; text-align:center;'>No active power cuts logged for your region currently.</p>"; }
          ?>
        </div>
      </div>
    </div>
  </div>

  <script>document.getElementById('nav-dash').classList.add('active');</script>
</body>
</html>