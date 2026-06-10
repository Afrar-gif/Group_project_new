<?php
include ('db.php');
$msg = "";
if(isset($_POST['report_hazard'])) {
    $h_area = mysqli_real_escape_string($conn, $_POST['area']);
    $h_type = mysqli_real_escape_string($conn, $_POST['hazard_type']);
    $h_desc = mysqli_real_escape_string($conn, $_POST['desc']);
    
    $subj = "[EMERGENCY EXTREME] - " . $h_type;
    $sql = "INSERT INTO complaints (name, email, area, subject, message, status) 
            VALUES ('Critical Hazard Client', 'emergency_system@edl.lk', '$h_area', '$subj', '$h_desc', 'Pending')";
    if(mysqli_query($conn, $sql)) {
        $msg = "<div style='background:rgba(230,57,70,0.2); border:1px solid #e63946; color:#e63946; padding:15px; border-radius:8px; margin-bottom:20px;'>🚨 CRITICAL HAZARD DISPATCHED! Control room intercepting tracking pipeline immediately!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EDL - Emergency Hazard Dispatch</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', sans-serif; }
    body { background:#0b132b; color:#e0e1dd; display:flex; min-height:100vh; }
    .main-content { margin-left:260px; width:calc(100% - 260px); padding:30px; }
    .hazard-box { background:#1c2541; padding:30px; border-radius:15px; margin-top:25px; border-top: 5px solid #e63946; max-width: 700px; }
    .form-control { width:100%; background:#0b132b; border:1px solid #3a506b; padding:12px; border-radius:8px; color:#fff; margin-top:6px; margin-bottom:15px; }
    .btn-alert { background:#e63946; color:#fff; font-weight:800; border:none; width:100%; padding:14px; border-radius:8px; cursor:pointer; font-size:16px; }
  </style>
</head>
<body>
  <?php include "user_sidebar.php"; ?> <!-- எர்ரர் சரி செய்யப்பட்டது (AdobeExpressPhotos_98f4675bad1a4949a40c8a9edd243e18_CopyEdited.png இல் காட்டிய எர்ரர் முழுமையாக நீக்கப்பட்டது) -->
  <div class="main-content">
    <h2><i class="fa fa-triangle-exclamation" style="color:#e63946;"></i> Instant Live Infrastructure Hazard Reporting</h2>
    <div class="hazard-box">
      <?php echo $msg; ?>
      <form action="" method="POST">
        <label>Select Affected Grid Station Area</label>
        <select name="area" class="form-control" required>
          <?php
          $aq = mysqli_query($conn, "SELECT area FROM areas");
          while($ar = mysqli_fetch_assoc($aq)) { echo "<option value='".htmlspecialchars($ar['area'])."'>".htmlspecialchars($ar['area'])."</option>"; }
          ?>
        </select>
        <label>Critical Hazard Threat Level Type</label>
        <select name="hazard_type" class="form-control" required>
          <option value="Live Wire Snapped on Road">Live Wire Snapped on Road (மின்கம்பி அறுந்து விழுந்துள்ளது)</option>
          <option value="Transformer Sparking / Fire Explosion">Transformer Sparking / Fire Explosion (டிரான்ஸ்ஃபார்மர் தீ விபத்து)</option>
          <option value="Electric Pole Tilted / Collapsed">Electric Pole Tilted / Collapsed (மின் கம்பம் சாய்ந்துள்ளது)</option>
        </select>
        <label>Dynamic Condition Breakdown / Landmarks</label>
        <textarea name="desc" class="form-control" rows="4" required></textarea>
        <button type="submit" name="report_hazard" class="btn-alert">BROADCAST EMERGENCY SENSOR DATA</button>
      </form>
    </div>
  </div>
  <script>document.getElementById('nav-hazard').classList.add('active');</script>
</body>
</html>