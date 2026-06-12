<?php
include('db.php'); 

$search_query = "";
if (isset($_POST['search_btn']) && !empty($_POST['search_area'])) {
    $search_area = mysqli_real_escape_string($conn, $_POST['search_area']);
    $search_query = "WHERE area LIKE '%$search_area%'";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EDL - Outage Schedule Calendar</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', sans-serif; }
    body { background:#0b132b; color:#e0e1dd; display:flex; min-height:100vh; }
    .main-content { margin-left:260px; width:calc(100% - 260px); padding:30px; }
    .panel-box { background:#1c2541; padding:25px; border-radius:15px; margin-top:20px; }
    .search-box { display:flex; gap:10px; margin-bottom:20px; }
    .search-input { flex:1; background:#0b132b; border:1px solid #3a506b; padding:12px; border-radius:8px; color:#fff; }
    .btn-search { background:#4cc9f0; border:none; padding:12px 25px; border-radius:8px; font-weight:700; cursor:pointer; color:#0b132b; }
    table { width:100%; border-collapse:collapse; margin-top:15px; text-align:left; border-radius:10px; overflow:hidden; }
    table th, table td { padding:14px; border-bottom:1px solid #3a506b; }
    table th { background:#3a506b; color:#4cc9f0; }
  </style>
</head>
<body>

  <?php include "user_sidebar.php"; ?> <!-- எர்ரர் சரி செய்யப்பட்டது -->

  <div class="main-content">
    <h2><i class="fa fa-calendar-days" style="color:#4cc9f0;"></i> National Grid Planned Outage Master Schedules</h2>
    <div class="panel-box">
      <form action="" method="POST" class="search-box">
        <input type="text" name="search_area" class="search-input" placeholder="Search by Grid Area Name...">
        <button type="submit" name="search_btn" class="btn-search"><i class="fa fa-magnifying-glass"></i> Filter Schedule</button>
      </form>
      <table>
        <thead>
          <tr><th>Grid Area Station</th><th>Planned Outage Date</th><th>Allocated Time Frame</th><th>Status Pipeline</th></tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM power_alerts $search_query ORDER BY date ASC, time ASC";
          $res = mysqli_query($conn, $sql);
          if(mysqli_num_rows($res) > 0) {
              while($row = mysqli_fetch_assoc($res)) {
                  echo "<tr>
                          <td><strong>" . htmlspecialchars($row['area']) . "</strong></td>
                          <td>" . date('d-M-Y', strtotime($row['date'])) . "</td>
                          <td style='color:#ffb703; font-weight:600;'>" . htmlspecialchars($row['time']) . "</td>
                          <td><span style='color:#4cc9f0;'>" . htmlspecialchars($row['status']) . "</span></td>
                        </tr>";
              }
          } else { echo "<tr><td colspan='4' style='text-align:center; color:#6c757d;'>No matching plans found.</td></tr>"; }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>document.getElementById('nav-sched').classList.add('active');</script>
</body>
</html>