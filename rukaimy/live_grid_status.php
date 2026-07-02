<?php
include ('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EDL - Live Grid Node Health</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', sans-serif; }
    body { background:#0b132b; color:#e0e1dd; display:flex; min-height:100vh; }
    .main-content { margin-left:260px; width:calc(100% - 260px); padding:30px; }
    .grid-layout { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top:25px; }
    .status-card { background:#1c2541; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.2); position:relative; }
    .status-dot { width:12px; height:12px; border-radius:50%; position:absolute; top:20px; right:20px; animation: blink 1.5s infinite; }
    .online { background:#10b981; box-shadow:0 0 10px #10b981; }
    .offline { background:#e63946; box-shadow:0 0 10px #e63946; }
    @keyframes blink { 0% { opacity:0.4; } 50% { opacity:1; } 100% { opacity:0.4; } }
  </style>
</head>
<body>
  <?php include "user_sidebar.php"; ?> <!-- எர்ரர் சரி செய்யப்பட்டது -->
  <div class="main-content">
    <h2><i class="fa fa-tower-broadcast" style="color:#4cc9f0;"></i> Real-time Substation & Transformer Nodes Status</h2>
    <div class="grid-layout">
      <?php
      $sql = "SELECT DISTINCT area, transformer FROM areas";
      $res = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_assoc($res)) {
          $chk_alert = mysqli_query($conn, "SELECT id FROM power_alerts WHERE area='{$row['area']}' AND status='Pending'");
          $is_offline = (mysqli_num_rows($chk_alert) > 0);
          ?>
          <div class="status-card">
            <div class="status-dot <?php echo $is_offline ? 'offline' : 'online'; ?>"></div>
            <h3 style="color:#fff;"><?php echo htmlspecialchars($row['area']); ?></h3>
            <p style="color:#adb5bd; font-size:13px; margin-top:4px;">Transformer Serial: <span style="color:#4cc9f0;"><?php echo htmlspecialchars($row['transformer'] ?? 'N/A'); ?></span></p>
            <p style="font-size:14px; margin-top:15px;">
              Current Load State: <b><?php echo $is_offline ? '<span style="color:#e63946;">⚠️ Offline / Maintenance</span>' : '<span style="color:#10b981;">⚡ Stable / Operational</span>'; ?></b>
            </p>
          </div>
      <?php } ?>
    </div>
  </div>
  <script>document.getElementById('nav-grid').classList.add('active');</script>
</body>
</html>