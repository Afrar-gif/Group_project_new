<?php
include ('db.php');
$user_email = "rukaimyahamed01@gmail.com"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EDL - Personal Ticket Ledger</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', sans-serif; }
    body { background:#0b132b; color:#e0e1dd; display:flex; min-height:100vh; }
    .main-content { margin-left:260px; width:calc(100% - 260px); padding:30px; }
    .ticket-container { display: grid; grid-template-columns: 1fr; gap: 20px; margin-top: 20px; }
    .ticket-card { background:#1c2541; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.2); border-left: 5px solid #3a506b; }
    .ticket-header { display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #3a506b; padding-bottom:10px; margin-bottom:12px; }
    .badge { padding:6px 12px; border-radius:6px; font-size:12px; font-weight:700; }
    .Pending { background: rgba(255,183,3,0.15); color:#ffb703; }
    .In_Progress { background: rgba(76,201,240,0.15); color:#4cc9f0; }
    .Resolved { background: rgba(16,185,129,0.15); color:#10b981; }
    .admin-reply { background:#0b132b; padding:12px; border-radius:8px; margin-top:12px; border: 1px dashed #4cc9f0; }
  </style>
</head>
<body>
  <?php include "user_sidebar.php"; ?> <!-- எர்ரர் சரி செய்யப்பட்டது -->
  <div class="main-content">
    <h2><i class="fa fa-receipt" style="color:#10b981;"></i> Your Core Ticket Resolution History</h2>
    <div class="ticket-container">
      <?php
      $sql = "SELECT * FROM complaints WHERE email = '$user_email' ORDER BY id DESC";
      $res = mysqli_query($conn, $sql);
      if(mysqli_num_rows($res) > 0) {
          while($row = mysqli_fetch_assoc($res)) {
              $status_class = str_replace(' ', '_', $row['status']);
              ?>
              <div class="ticket-card" style="<?php if($row['status'] == 'Resolved') echo 'border-left-color:#10b981;'; ?>">
                <div class="ticket-header">
                  <div>
                    <h3 style="color:#fff;"><?php echo htmlspecialchars($row['subject']); ?></h3>
                    <small style="color:#adb5bd;">Filed on: <?php echo $row['created_at']; ?></small>
                  </div>
                  <span class="badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status']); ?></span>
                </div>
                <p style="font-size:14px;"><b>Description:</b> <?php echo htmlspecialchars($row['message']); ?></p>
                <?php if(!empty($row['admin_reply'])) { ?>
                  <div class="admin-reply">
                    <p style="color:#4cc9f0; font-size:13px; font-weight:700;"><i class="fa fa-user-shield"></i> Control Room Response:</p>
                    <p style="color:#fff; font-style:italic; margin-top:4px;">"<?php echo htmlspecialchars($row['admin_reply']); ?>"</p>
                  </div>
                <?php } ?>
              </div>
              <?php
          }
      } else { echo "<p style='color:#6c757d; text-align:center;'>No tickets logged.</p>"; }
      ?>
    </div>
  </div>
  <script>document.getElementById('nav-tickets').classList.add('active');</script>
</body>
</html>