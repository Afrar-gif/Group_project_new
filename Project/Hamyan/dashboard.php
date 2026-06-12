<?php
include "db.php";

/* TOTAL USERS */
$user_sql = "SELECT COUNT(*) as total_users FROM users";
$user_result = mysqli_query($conn, $user_sql);
$user_data = mysqli_fetch_assoc($user_result);
$total_users = $user_data['total_users'];

/* TOTAL STAFF */
$staff_sql = "SELECT COUNT(*) as total_staff FROM admins";
$staff_result = mysqli_query($conn, $staff_sql);
$staff_data = mysqli_fetch_assoc($staff_result);
$total_staff = $staff_data['total_staff'];

/* DYNAMIC AREAS COVERED COUNT */
$area_count_sql = "SELECT COUNT(*) as total_areas FROM areas";
$area_count_result = mysqli_query($conn, $area_count_sql);
$area_count_data = mysqli_fetch_assoc($area_count_result);
$total_areas = $area_count_data['total_areas'];

/* DYNAMIC ACTIVE ALERTS COUNT */
$active_alerts_sql = "SELECT COUNT(*) as total_active FROM power_alerts WHERE status = 'Pending' OR status = 'In Progress'";
$active_alerts_result = mysqli_query($conn, $active_alerts_sql);
$active_alerts_data = mysqli_fetch_assoc($active_alerts_result);
$total_active_alerts = $active_alerts_data['total_active'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Smart Power Cut Alert System</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

  <style>
    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family:Arial, Helvetica, sans-serif;
    }

    body{
      background:#f4f7fc;
      display:flex;
    }

    .sidebar{
      width:250px;
      height:100vh;
      background:#0d1b2a;
      color:white;
      padding:20px;
      position:fixed;
    }

    .sidebar h2{
      text-align:center;
      margin-bottom:30px;
      color:#4cc9f0;
    }

    .sidebar ul{
      list-style:none;
    }

    .sidebar ul li{
      margin:20px 0;
    }

    .sidebar ul li a{
      text-decoration:none;
      color:white;
      font-size:17px;
      display:block;
      padding:10px;
      border-radius:8px;
      transition:0.3s;
    }

    .sidebar ul li a:hover{
      background:#1b263b;
      color:#4cc9f0;
    }

    .main{
      margin-left:250px;
      width:100%;
      padding:20px;
    }

    .topbar{
      background:white;
      padding:15px 20px;
      border-radius:10px;
      display:flex;
      justify-content:space-between;
      align-items:center;
      box-shadow:0 2px 10px rgba(0,0,0,0.1);
    }

    .cards{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
      gap:20px;
      margin-top:30px;
    }

    .card{
      background:white;
      padding:25px;
      border-radius:15px;
      box-shadow:0 2px 10px rgba(0,0,0,0.1);
      transition:0.3s;
    }

    .card:hover{
      transform:translateY(-5px);
    }

    .card i{
      font-size:35px;
      margin-bottom:10px;
      color:#0077b6;
    }

    .card h3{
      margin-bottom:10px;
      color:#333;
    }

    .table-section{
      margin-top:40px;
      background:white;
      padding:20px;
      border-radius:15px;
      box-shadow:0 2px 10px rgba(0,0,0,0.1);
    }

    table{
      width:100%;
      border-collapse:collapse;
      margin-top:15px;
    }

    table th, table td{
      padding:12px;
      border-bottom:1px solid #ddd;
      text-align:center;
    }

    table th{
      background:#0077b6;
      color:white;
    }

    .btn{
      padding:8px 14px;
      border:none;
      border-radius:5px;
      cursor:pointer;
      color:white;
    }

    .edit{ background:orange; text-decoration: none; color: white; display: inline-block; }
    .delete{ background:red; }
    
    /* SMS/Email Alert CSS */
    .alert-trigger { background:#dc2626; margin-left:5px; font-weight:bold; }
    .alert-trigger:hover { background:#b91c1c; }
    .alert-trigger:disabled { background:#94a3b8; cursor:not-allowed; }

    .add-btn{
      background:#0077b6;
      padding:10px 18px;
      border:none;
      color:white;
      border-radius:6px;
      margin-top:20px;
      cursor:pointer;
    }

    @media(max-width:768px){
      .sidebar{
        width:200px;
      }

      .main{
        margin-left:200px;
      }
    }
  </style>
</head>

<body>

<div class="sidebar">
  <marquee behavior="" direction="right"><h2>Power Alert</h2></marquee>

  <ul>
    <li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
    <li><a href="users.php"><i class="fa fa-users"></i> Users</a></li>
    <li><a href="staff.php"><i class="fa fa-users"></i> Staff</a></li>
    <li><a href="area.php"><i class="fa fa-location-dot"></i> Add Areas</a></li>
    <li><a href="areaDV.php"><i class="fa fa-eye"></i> Area Details</a></li>
    <li><a href="#"><i class="fa fa-bolt"></i> Alerts</a></li>
    <li><a href="#"><i class="fa fa-comment"></i> Complaints</a></li>
    <li><a href="#"><i class="fa fa-bell"></i> Notifications</a></li>
    <li><a href="adminL.html"><i class="fa fa-right-from-bracket"></i> Logout</a></li>
  </ul>
</div>

<div class="main">

  <div class="topbar">
    <h2>Smart Power Cut Alert Dashboard</h2>
    <p><i class="fa fa-user-circle"></i> Welcome Admin</p>
  </div>

  <div class="cards">

    <div class="card">
      <i class="fa fa-users"></i>
      <h3>Total Users</h3>
      <h1><?php echo $total_users; ?></h1>
    </div>

    <div class="card">
      <i class="fa fa-users"></i>
      <h3>Total Staff</h3>
      <h1><?php echo $total_staff; ?></h1>
    </div>

    <div class="card">
      <i class="fa fa-location-dot"></i>
      <h3>Areas Covered</h3>
      <h1><?php echo $total_areas; ?></h1> 
    </div>

    <div class="card">
      <i class="fa fa-bolt"></i>
      <h3>Active Alerts</h3>
      <h1><?php echo $total_active_alerts; ?></h1> 
    </div>

    <div class="card">
      <i class="fa fa-comment"></i>
      <h3>Complaints</h3>
      <h1>18</h1>
    </div>

  </div>

  <div class="table-section">
    <h2>Power Cut Alerts</h2>

    <a href="areaDV.php" style="text-decoration: none;">
        <button class="add-btn">Add New Alert</button>
    </a>

    <table>
      <tr>
        <th>ID</th>
        <th>Area</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
        <th>Alert Action</th> 
      </tr>

      <?php
      // Database-il irundhu alerts-ai thalaikeelaaga fetch seigirom
      $alert_sql = "SELECT * FROM power_alerts ORDER BY id DESC";
      $alert_result = mysqli_query($conn, $alert_sql);

      if(mysqli_num_rows($alert_result) > 0) {
          while($row = mysqli_fetch_assoc($alert_result)) {
              // Date format-ai Y-m-d thakuthiyil irundhu d-m-Y ku maatrukirom
              $formatted_date = date("d-m-Y", strtotime($row['date']));
              ?>
              <tr id="row_<?php echo $row['id']; ?>">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['area']); ?></td>
                <td><?php echo $formatted_date; ?></td>
                <td><?php echo htmlspecialchars($row['time']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                  <a href="create_alert.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                  
                  <button class="btn delete" onclick="deleteSystemAlert(<?php echo $row['id']; ?>)">Delete</button>
                </td>
                <td>
                  <button class="btn alert-trigger" onclick="sendSystemAlert(this, '<?php echo mysqli_real_escape_string($conn, $row['area']); ?>', '<?php echo $formatted_date; ?>', '<?php echo mysqli_real_escape_string($conn, $row['time']); ?>')">
                    <i class="fa fa-paper-plane" style="font-size:14px; color:white; margin:0;"></i> Alert Now
                  </button>
                </td>
              </tr>
              <?php
          }
      } else {
          echo "<tr><td colspan='7' style='text-align:center; padding:20px;'>No Scheduled Alerts Found.</td></tr>";
      }
      ?>

    </table>
  </div>

</div>

<script>
// ✉️ BROADCAST ALERTS DISPATCH ENGINE
function sendSystemAlert(buttonElement, areaName, cutDate, cutTime) {
    if (!confirm(`Are you sure you want to send immediate Email alerts to all users in ${areaName}?`)) {
        return;
    }

    buttonElement.disabled = true;
    buttonElement.innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:14px; color:white; margin:0;"></i> Sending...';

    fetch('send_alerts_process.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `area=${encodeURIComponent(areaName)}&date=${encodeURIComponent(cutDate)}&time=${encodeURIComponent(cutTime)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(`✅ Success: Alerts successfully sent to ${data.count} users in ${areaName}!`);
            buttonElement.innerHTML = '✅ Sent';
            buttonElement.style.background = '#10b981'; 
        } else {
            alert('❌ Error: ' + data.message);
            buttonElement.disabled = false;
            buttonElement.innerHTML = '<i class="fa fa-paper-plane" style="font-size:14px; color:white; margin:0;"></i> Alert Now';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Server connection failure!');
        buttonElement.disabled = false;
        buttonElement.innerHTML = '<i class="fa fa-paper-plane" style="font-size:14px; color:white; margin:0;"></i> Alert Now';
    });
}

// 🗑️ AJAX LIVE DELETE ENGINE (உங்க ஒரிஜினல் ஃபீடில் இணைக்கப்பட்டது தலா)
function deleteSystemAlert(alertId) {
    if (!confirm("Are you sure you want to permanently delete this power cut alert?")) {
        return;
    }

    fetch('delete_alert.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${alertId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert("✅ Alert deleted successfully!");
            // பேஜ் ரீஃப்ரெஷ் ஆகாமல் அந்த ரோவை மட்டும் அப்படியே மறைக்கிறோம் தலா
            document.getElementById(`row_${alertId}`).remove(); 
        } else {
            alert("❌ Error: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Server connection failure!');
    });
}
</script>

</body>
</html>