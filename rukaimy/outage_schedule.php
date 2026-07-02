<?php
// ✅ Session-ai start panrom
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('db.php'); 

// --- 👤 FETCH LOGGED-IN USER DETAILS FOR AUTO-FILL ---
$logged_in_name = "";
$logged_in_location = "";

/* 🔎 Ungaloda project structure-padi session variable check panrom.
  Oru vaela neenga session-la 'account_number', 'email' or 'id' ethu vachirundhalum 
  katchithamaana user detail-ai db-la irunthu fetch pannidum.
*/
$search_user_val = "";
$search_column = "";

if (isset($_SESSION['account_number'])) {
    $search_user_val = mysqli_real_escape_string($conn, $_SESSION['account_number']);
    $search_column = "account_number";
} elseif (isset($_SESSION['email'])) {
    $search_user_val = mysqli_real_escape_string($conn, $_SESSION['email']);
    $search_column = "email";
} elseif (isset($_SESSION['user_id'])) {
    $search_user_val = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    $search_column = "id";
} elseif (isset($_SESSION['username'])) {
    $search_user_val = mysqli_real_escape_string($conn, $_SESSION['username']);
    $search_column = "name";
}

// Oru vaela unga system-la automatic user session ippo active-ah iruntha details fetch aagum
if (!empty($search_user_val)) {
    $user_sql = "SELECT name, area FROM users WHERE $search_column = '$search_user_val'";
    $user_res = mysqli_query($conn, $user_sql);
    
    if ($user_res && mysqli_num_rows($user_res) > 0) {
        $user_row = mysqli_fetch_assoc($user_res);
        $logged_in_name = $user_row['name'];
        $logged_in_location = $user_row['area'];
    }
}

// Fallback: Oru vaela session unga local machine-la set aahama iruntha, unga testing easy-kaaha database-la irukura latest user details-ai load panrom!
if (empty($logged_in_name)) {
    $backup_sql = "SELECT name, area FROM users ORDER BY id DESC LIMIT 1";
    $backup_res = mysqli_query($conn, $backup_sql);
    if ($backup_res && mysqli_num_rows($backup_res) > 0) {
        $backup_row = mysqli_fetch_assoc($backup_res);
        $logged_in_name = $backup_row['name'];
        $logged_in_location = $backup_row['area'];
    }
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
    .main-content { margin-left:260px; width:calc(100% - 260px); padding:30px; position: relative; }
    
    /* Top Header Section */
    .header-section { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .btn-feedback-top { background:#ffb703; color:#0b132b; text-decoration:none; padding:10px 20px; border-radius:8px; font-weight:700; display:flex; align-items:center; gap:8px; border:none; cursor:pointer; transition:0.3s; }
    .btn-feedback-top:hover { background:#fb8500; transform: translateY(-2px); }

    .panel-box { background:#1c2541; padding:25px; border-radius:15px; }
    .search-box { display:flex; gap:10px; margin-bottom:20px; }
    .search-input { flex:1; background:#0b132b; border:1px solid #3a506b; padding:12px; border-radius:8px; color:#fff; }
    .btn-search { background:#4cc9f0; border:none; padding:12px 25px; border-radius:8px; font-weight:700; cursor:pointer; color:#0b132b; }
    table { width:100%; border-collapse:collapse; margin-top:15px; text-align:left; border-radius:10px; overflow:hidden; }
    table th, table td { padding:14px; border-bottom:1px solid #3a506b; }
    table th { background:#3a506b; color:#4cc9f0; }

    /* === POP-UP MODAL STYLES === */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: none; justify-content: center; align-items: center; z-index: 1000; }
    .modal-box { background: #1c2541; width: 450px; padding: 30px; border-radius: 15px; border: 1px solid #3a506b; box-shadow: 0 5px 15px rgba(0,0,0,0.5); position: relative; }
    .modal-box h3 { color: #4cc9f0; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .close-modal { position: absolute; top: 15px; right: 20px; color: #6c757d; font-size: 22px; cursor: pointer; transition: 0.3s; }
    .close-modal:hover { color: #fff; }
    .modal-input-group { margin-bottom: 15px; }
    .modal-input-group input, .modal-input-group textarea { width: 100%; padding: 12px; background: #0b132b; border: 1px solid #3a506b; border-radius: 8px; color: #fff; outline: none; font-size: 14px; }
    .modal-input-group textarea { height: 100px; resize: none; }
    
    /* Locked state design matching screenshot */
    .modal-input-group input[readonly] { background: #141c33; border-color: #2a3a5c; color: #a4b3d6; cursor: not-allowed; opacity: 0.8; }

    .btn-modal-submit { width: 100%; padding: 12px; background: #22d8ff; border: none; border-radius: 8px; color: #0b132b; font-weight: bold; font-size: 16px; cursor: pointer; transition: 0.3s; }
    .btn-modal-submit:hover { background: #11a8cc; }
  </style>
</head>
<body>

  <?php include "user_sidebar.php"; ?>

  <div class="main-content">
    
    <div class="header-section">
        <h2><i class="fa fa-calendar-days" style="color:#4cc9f0;"></i> National Grid Planned Outage Master Schedules</h2>
        <button class="btn-feedback-top" onclick="openFeedbackModal()"><i class="fa fa-comment-dots"></i> Give Feedback</button>
    </div>

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
          $search_query = "";
          if (isset($_POST['search_btn']) && !empty($_POST['search_area'])) {
              $search_area = mysqli_real_escape_string($conn, $_POST['search_area']);
              $search_query = "WHERE area LIKE '%$search_area%'";
          }
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

  <div class="modal-overlay" id="feedbackModal">
      <div class="modal-box">
          <span class="close-modal" onclick="closeFeedbackModal()">&times;</span>
          <h3><i class="fa fa-comments"></i> Submit Your Feedback</h3>
          
          <form action="" method="POST" onsubmit="return validateModalFeedback()">
              
              <div class="modal-input-group">
                  <input type="text" name="user_name" value="<?php echo htmlspecialchars($logged_in_name); ?>" readonly>
              </div>
              <div class="modal-input-group">
                  <input type="text" name="location" value="<?php echo htmlspecialchars($logged_in_location); ?>" readonly>
              </div>
              
              <div class="modal-input-group">
                  <textarea id="fb_text" name="review_text" placeholder="Write your feedback message here..."></textarea>
              </div>
              
              <button type="submit" name="submit_feedback" class="btn-modal-submit">Submit Feedback</button>
          </form>
      </div>
  </div>

  <?php
  // --- SUBMISSION LOGIC ---
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_feedback'])) {
      $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
      $location = mysqli_real_escape_string($conn, $_POST['location']);
      $review_text = trim($_POST['review_text']);

      if (!empty($review_text)) {
          $sql_fb = "INSERT INTO user_reviews (user_name, location, review_text) 
                     VALUES ('$user_name', '$location', '$review_text')";
          if (mysqli_query($conn, $sql_fb)) {
              echo "<script>alert('Thank you! Your feedback submitted successfully.'); window.location.href='outage_schedule.php';</script>";
              exit();
          }
      }
  }
  ?>

  <script>
    document.getElementById('nav-sched').classList.add('active');

    function openFeedbackModal() {
        document.getElementById("feedbackModal").style.display = "flex";
    }

    function closeFeedbackModal() {
        document.getElementById("feedbackModal").style.display = "none";
    }

    function validateModalFeedback() {
        let text = document.getElementById("fb_text").value.trim();
        if (text == "") {
            alert("Please enter your feedback message before submitting!");
            return false;
        }
        return true;
    }
  </script>
</body>
</html>