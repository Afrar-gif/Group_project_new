<?php
include ('db.php');
$user_email = "rukaimyahamed01@gmail.com"; 

$msg = "";
if(isset($_POST['update_profile'])) {
    $new_name = mysqli_real_escape_string($conn, $_POST['name']);
    $new_area = mysqli_real_escape_string($conn, $_POST['area']);
    
    $up_sql = "UPDATE complaints SET name='$new_name', area='$new_area' WHERE email='$user_email'";
    if(mysqli_query($conn, $up_sql)) {
        $msg = "<p style='color:#10b981; font-weight:bold; margin-bottom:15px;'><i class='fa fa-circle-check'></i> Account Node credentials successfully updated!</p>";
    }
}
$info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM complaints WHERE email='$user_email' LIMIT 1"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EDL - Consumer Settings</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', sans-serif; }
    body { background:#0b132b; color:#e0e1dd; display:flex; min-height:100vh; }
    .main-content { margin-left:260px; width:calc(100% - 260px); padding:30px; }
    .profile-box { background:#1c2541; padding:25px; border-radius:15px; margin-top:25px; max-width:600px; }
    .form-control { width:100%; background:#0b132b; border:1px solid #3a506b; padding:12px; border-radius:8px; color:#fff; margin-top:6px; margin-bottom:15px; }
    .btn-save { background:#4cc9f0; color:#0b132b; font-weight:700; border:none; width:100%; padding:12px; border-radius:8px; cursor:pointer; }
  </style>
</head>
<body>
  <?php include "user_sidebar.php"; ?> <!-- எர்ரர் சரி செய்யப்பட்டது -->
  <div class="main-content">
    <h2><i class="fa fa-user-gear" style="color:#4cc9f0;"></i> Consumer Profile Node Configurator</h2>
    <div class="profile-box">
      <?php echo $msg; ?>
      <form action="" method="POST">
        <label>Consumer Terminal Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($info['name'] ?? 'Rukaimy Ahamed'); ?>" required>
        <label>Account Main Email</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_email); ?>" readonly style="opacity:0.6;">
        <label>Assigned Registered Outage Sector Area</label>
        <select name="area" class="form-control">
          <?php
          $aq = mysqli_query($conn, "SELECT area FROM areas");
          while($ar = mysqli_fetch_assoc($aq)) {
              $sel = ($ar['area'] == $info['area']) ? "selected" : "";
              echo "<option value='".htmlspecialchars($ar['area'])."' $sel>".htmlspecialchars($ar['area'])."</option>";
          }
          ?>
        </select>
        <button type="submit" name="update_profile" class="btn-save">Save Profile Settings</button>
      </form>
    </div>
  </div>
  <script>document.getElementById('nav-profile').classList.add('active');</script>
</body>
</html>