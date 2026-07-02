<?php
/* ==========================================================================
   🔌 1. DATABASE CONNECTION CONFIGURATION
   ========================================================================== */
mysqli_report(MYSQLI_REPORT_OFF);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edl"; // உங்க உண்மையான டேட்டாபேஸ் பெயர் 'edl' தான்!

$conn = @new mysqli($servername, $username, $password, $dbname);

$db_connected = false;
if ($conn && !$conn->connect_error) {
    $db_connected = true;
}

/* ==========================================================================
   📊 2. FETCHING REAL-TIME COUNTS (With Correct Database Table Names)
   ========================================================================== */

// 1️⃣ Total Users Count (டேபிள் பெயர்: users)
$real_users_count = 1500; 
if ($db_connected) {
    $user_count_result = @$conn->query("SELECT COUNT(*) as total FROM users");
    if ($user_count_result) {
        $real_users_count = $user_count_result->fetch_assoc()['total'];
    }
}

// 2️⃣ Alerts Sent Count (உங்க உண்மையான டேபிள் பெயர்: power_alerts)
$real_alerts_count = 520;
if ($db_connected) {
    $alerts_count_result = @$conn->query("SELECT COUNT(*) as total FROM power_alerts");
    if ($alerts_count_result) {
        $real_alerts_count = $alerts_count_result->fetch_assoc()['total'];
    }
}

// 3️⃣ Reports Filed Count (உங்க உண்மையான டேபிள் பெயர்: complaints)
$real_reports_count = 210;
if ($db_connected) {
    $reports_count_result = @$conn->query("SELECT COUNT(*) as total FROM complaints");
    if ($reports_count_result) {
        $real_reports_count = $reports_count_result->fetch_assoc()['total'];
    }
}

// 4️⃣ Tracked Regions Count (உங்க உண்மையான டேபிள் பெயர்: areas)
$real_regions_count = 8;
if ($db_connected) {
    $regions_count_result = @$conn->query("SELECT COUNT(*) as total FROM areas");
    if ($regions_count_result) {
        $real_regions_count = $regions_count_result->fetch_assoc()['total'];
    }
}

// 💬 User Reviews (டேபிள் பெயர்: user_reviews)
$reviews_result = false;
if ($db_connected) {
    $reviews_result = @$conn->query("SELECT user_name, review_text, location FROM user_reviews ORDER BY id DESC LIMIT 3");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EDL Grid Pro - Smart Power Cut Alert System</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  
  <style>
    /* Global Reset & Colors */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Arial, sans-serif;
      scroll-behavior: smooth;
    }

    body {
      background: #0b192c;
      color: #cbd5e1;
    }

    /* NAVIGATION MENU BAR */
    header {
      background: #1e3e62;
      position: fixed;
      width: 100%;
      top: 0;
      left: 0;
      z-index: 1000;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
    }

    .logo {
      font-size: 22px;
      font-weight: bold;
      color: #ffffff;
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .logo i {
      color: #38bdf8;
    }

    .navbar {
      display: flex;
      list-style: none;
      gap: 25px;
      align-items: center;
    }

    .navbar a {
      text-decoration: none;
      color: #cbd5e1;
      font-size: 16px;
      font-weight: 500;
      transition: all 0.3s ease;
      position: relative;
      padding: 5px 0;
    }

    .navbar a:hover {
      color: #38bdf8;
    }

    .navbar a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 3px;
      background: #38bdf8;
      border-radius: 2px;
      transition: width 0.3s ease;
    }

    .navbar a.active {
      color: #38bdf8 !important;
      font-weight: 600;
    }

    .navbar a.active::after {
      width: 100%;
    }

    .cta-btn {
      background: #38bdf8;
      color: #0b192c !important;
      padding: 8px 18px;
      border-radius: 20px;
      font-weight: bold !important;
      cursor: pointer;
      border: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 15px;
      transition: background 0.3s;
    }

    .cta-btn:hover {
      background: #0ea5e9;
    }

    .login-nav-btn {
      background: transparent;
      color: #38bdf8 !important;
      border: 2px solid #38bdf8;
    }

    .login-nav-btn:hover {
      background: #38bdf8;
      color: #0b192c !important;
    }

    section {
      padding: 100px 20px 60px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .section-title {
      text-align: center;
      font-size: 32px;
      color: #ffffff;
      margin-bottom: 40px;
      position: relative;
    }

    .section-title::after {
      content: '';
      display: block;
      width: 60px;
      height: 4px;
      background: #38bdf8;
      margin: 10px auto 0;
      border-radius: 2px;
    }

    /* HERO SECTION */
    .hero-section {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 40px;
      margin-top: 40px;
      min-height: calc(100vh - 80px);
    }

    .hero-content {
      flex: 1;
    }

    .hero-content h1 {
      font-size: 45px;
      color: #ffffff;
      line-height: 1.2;
      margin-bottom: 20px;
    }

    .hero-content h1 span {
      color: #38bdf8;
    }

    .hero-content p {
      font-size: 18px;
      line-height: 1.6;
      margin-bottom: 30px;
      color: #94a3b8;
    }

    .hero-image {
      flex: 1;
      text-align: center;
    }

    .banner-graphic {
      width: 100%;
      max-width: 450px;
      height: 300px;
      background: linear-gradient(135deg, #1e3e62, #0b192c);
      border: 2px solid #38bdf8;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 30px rgba(56, 189, 248, 0.2);
    }

    .banner-graphic i {
      font-size: 100px;
      color: #38bdf8;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { transform: scale(1); opacity: 0.8; }
      50% { transform: scale(1.1); opacity: 1; }
      100% { transform: scale(1); opacity: 0.8; }
    }

    /* STATISTICS SECTION */
    .stats-container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      background: #1e3e62;
      padding: 40px;
      border-radius: 15px;
      text-align: center;
      margin-bottom: 40px;
    }

    .stat-item i {
      font-size: 35px;
      color: #38bdf8;
      margin-bottom: 10px;
    }

    .stat-item h2 {
      font-size: 36px;
      color: #ffffff;
      margin-bottom: 5px;
    }

    .stat-item p {
      color: #94a3b8;
      font-size: 14px;
      text-transform: uppercase;
    }

    /* SERVICES / FEATURES SECTION */
    .grid-3 {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 25px;
    }

    .feature-card {
      background: #1e3e62;
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      transition: transform 0.3s;
      border: 1px solid #ffffff10;
    }

    .feature-card:hover {
      transform: translateY(-5px);
      border-color: #38bdf8;
    }

    .feature-card i {
      font-size: 40px;
      color: #38bdf8;
      margin-bottom: 15px;
    }

    .feature-card h3 {
      color: #ffffff;
      margin-bottom: 12px;
    }

    .feature-card p {
      font-size: 15px;
      line-height: 1.5;
      color: #cbd5e1;
    }

    /* BENEFITS SECTION */
    .benefits-section {
      background: #0d1e36;
      border-radius: 20px;
      padding: 50px;
    }

    .benefit-item {
      display: flex;
      align-items: flex-start;
      gap: 20px;
      margin-bottom: 25px;
    }

    .benefit-item i {
      font-size: 24px;
      color: #10b981;
      background: rgba(16, 185, 129, 0.1);
      padding: 10px;
      border-radius: 50%;
    }

    .benefit-item h4 {
      color: #ffffff;
      font-size: 18px;
      margin-bottom: 5px;
    }

    /* TESTIMONIALS / USER REVIEWS */
    .testimonial-card {
      background: #1e3e62;
      padding: 25px;
      border-radius: 12px;
      position: relative;
    }

    .testimonial-card p {
      font-style: italic;
      line-height: 1.6;
      margin-bottom: 15px;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .user-info i {
      font-size: 35px;
      color: #94a3b8;
    }

    .user-info h5 {
      color: #ffffff;
      font-size: 16px;
    }

    /* FAQ SECTION */
    .faq-container {
      max-width: 800px;
      margin: 0 auto;
    }

    .faq-item {
      background: #1e3e62;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .faq-item h4 {
      color: #38bdf8;
      margin-bottom: 8px;
      font-size: 17px;
    }

    /* LOGIN MODAL POPUP */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(7, 16, 30, 0.85);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 2000;
      opacity: 0;
      pointer-events: none;
      transition: all 0.3s ease;
    }

    .modal-overlay.open {
      opacity: 1;
      pointer-events: auto;
    }

    .modal-box {
      background: #1e3e62;
      padding: 35px;
      border-radius: 15px;
      width: 90%;
      max-width: 420px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
      border: 1px solid #38bdf830;
      transform: scale(0.7);
      transition: all 0.3s ease;
      position: relative;
    }

    .modal-overlay.open .modal-box {
      transform: scale(1);
    }

    .modal-box h3 {
      color: #ffffff;
      font-size: 22px;
      margin-bottom: 10px;
    }

    .modal-box p {
      color: #94a3b8;
      font-size: 14px;
      margin-bottom: 25px;
    }

    .modal-options {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .modal-link {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      text-decoration: none;
      background: #0b192c;
      color: #ffffff;
      padding: 14px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      border: 1px solid #3a506b;
      transition: all 0.2s ease;
    }

    .modal-link:hover {
      background: #38bdf8;
      color: #0b192c;
      border-color: #38bdf8;
      transform: translateY(-2px);
    }

    .close-modal {
      position: absolute;
      top: 15px;
      right: 15px;
      background: transparent;
      border: none;
      color: #94a3b8;
      font-size: 20px;
      cursor: pointer;
    }

    .close-modal:hover {
      color: #ef4444;
    }

    /* CONTACT INFORMATION & FOOTER */
    footer {
      background: #07101e;
      padding: 40px 20px 20px;
      border-top: 1px solid #1e3e62;
    }

    .footer-container {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      gap: 40px;
      padding-bottom: 30px;
    }

    .footer-about h3 { color: #ffffff; margin-bottom: 15px; }
    .footer-links h4, .footer-contact h4 { color: #38bdf8; margin-bottom: 15px; }
    
    .footer-links ul { list-style: none; }
    .footer-links ul li { margin-bottom: 10px; }
    .footer-links ul li a { color: #94a3b8; text-decoration: none; transition: color 0.3s; }
    .footer-links ul li a:hover { color: #ffffff; }

    .footer-contact p { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; color: #94a3b8; }
    .footer-contact i { color: #38bdf8; }

    .footer-bottom {
      border-top: 1px solid #1e3e62;
      padding-top: 20px;
      text-align: center;
      font-size: 14px;
      color: #64748b;
    }

    .footer-bottom a { color: #94a3b8; text-decoration: none; margin: 0 10px; }
    .footer-bottom a:hover { color: #ffffff; }

    @media (max-width: 768px) {
      .navbar { display: none; }
      .hero-section { flex-direction: column; text-align: center; }
      .grid-3, .stats-container, .footer-container { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <header>
    <div class="nav-container">
      <a href="#" class="logo"><i class="fa fa-bolt"></i> EDL Grid Pro</a>
      
      <ul class="navbar">
        <li><a href="#home" class="nav-item active">Home</a></li>
        <li><a href="#about" class="nav-item">About Us</a></li>
        <li><a href="#features" class="nav-item">Services / Features</a></li>
        <li><a href="#contact" class="nav-item">Contact Us</a></li>
        <li><a href="#faq" class="nav-item">FAQ</a></li>
        <li>
          <button class="cta-btn login-nav-btn" onclick="openLoginModal()">
            <i class="fa fa-sign-in-alt"></i> Login
          </button>
        </li>
      </ul>
    </div>
  </header>

  <div class="modal-overlay" id="loginModal">
    <div class="modal-box">
      <button class="close-modal" onclick="closeLoginModal()"><i class="fa fa-times"></i></button>
      <i class="fa fa-user-shield" style="font-size: 45px; color: #38bdf8; margin-bottom: 15px;"></i>
      <h3>Account Login</h3>
      <p>Please select your account type to proceed.</p>
      
      <div class="modal-options">
      <a href="Hamyan GP/adminL.php" class="modal-link">
          <i class="fa fa-user-gear"></i> Admin Login
        </a>
        
        <a href="asnaf/userL.php" class="modal-link">
          <i class="fa fa-users"></i> User Login
        </a>
      </div>
    </div>
  </div>

  <section id="home" class="hero-section">
    <div class="hero-content">
      <h1>Smart Load Shedding & <span>Power Cut Alert</span> System</h1>
      <p>Get instant scheduled power cut alerts directly tailored to your area. Plan your daily schedules, secure your valuable appliances, and manage energy consumption smoothly with our system.</p>
      <button class="cta-btn" onclick="openLoginModal()" style="padding: 12px 25px;">Get Started Now</button>
    </div>
    <div class="hero-image">
      <div class="banner-graphic">
        <i class="fa fa-satellite-dish"></i>
      </div>
    </div>
  </section>

  <section style="padding-top: 0; padding-bottom: 0;">
    <div class="stats-container">
      
      <div class="stat-item">
        <i class="fa fa-users"></i>
        <h2><?php echo number_format($real_users_count); ?>+</h2>
        <p>Total Users</p>
      </div>
      
      <div class="stat-item">
        <i class="fa fa-bullhorn"></i>
        <h2><?php echo number_format($real_alerts_count); ?>+</h2>
        <p>Alerts Sent</p>
      </div>

      <div class="stat-item">
        <i class="fa fa-file-invoice"></i>
        <h2><?php echo number_format($real_reports_count); ?>+</h2>
        <p>Reports Filed</p>
      </div>

      <div class="stat-item">
        <i class="fa fa-shield-cat"></i>
        <h2><?php echo number_format($real_regions_count); ?>+</h2>
        <p>Tracked Regions</p>
      </div>

    </div>
  </section>

  <section id="about">
    <h2 class="section-title">About Us</h2>
    <div style="text-align: center; max-width: 800px; margin: 0 auto; line-height: 1.8; color: #94a3b8;">
      <p><strong>EDL Grid Pro</strong> is an advanced digital platform developed to deliver real-time, highly accurate power grid updates to the public. Our ultimate goal is to minimize the hassle of manually checking schedules by creating a seamless, automated link between local consumers and distribution centers.</p>
    </div>
  </section>

  <section id="features">
    <h2 class="section-title">Services & Features</h2>
    <div class="grid-3">
      <div class="feature-card">
        <i class="fa fa-bell"></i>
        <h3>Instant Notifications</h3>
        <p>Receive immediate email alerts containing breakdown schedules customized specifically for your residential grid zone.</p>
      </div>
      <div class="feature-card">
        <i class="fa fa-map-location-dot"></i>
        <h3>Geo-Targeted Data</h3>
        <p>No more unwanted clutter. Get localized data and targeted tracking maps configured to your specific region.</p>
      </div>
      <div class="feature-card">
        <i class="fa fa-triangle-exclamation"></i>
        <h3>Hazard Reporting</h3>
        <p>Empowering citizens to report down cables, grid issues, or electrical emergencies directly to the control room admin panel.</p>
      </div>
    </div>
  </section>

  <section style="padding-top: 20px;">
    <div class="benefits-section">
      <h2 class="section-title" style="margin-bottom: 30px;">Why Use Our System?</h2>
      <div class="benefit-item">
        <i class="fa fa-check"></i>
        <div>
          <h4>Advance Planning</h4>
          <p style="color: #94a3b8;">Knowing when the power drops lets you efficiently organize office tasks, household workflows, or academic milestones ahead of time.</p>
        </div>
      </div>
      <div class="benefit-item">
        <i class="fa fa-check"></i>
        <div>
          <h4>Appliance Protection</h4>
          <p style="color: #94a3b8;">Prevent massive hardware degradation or component breakdowns on computers, servers, and sensitive electronics caused by sudden blackouts.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <h2 class="section-title">User Reviews</h2>
    <div class="grid-3">
      <?php 
      if ($reviews_result && $reviews_result->num_rows > 0) {
          while($review = $reviews_result->fetch_assoc()) { 
      ?>
          <div class="testimonial-card">
            <p>"<?php echo htmlspecialchars($review['review_text']); ?>"</p>
            <div class="user-info">
              <i class="fa fa-user-circle"></i>
              <div>
                <h5><?php echo htmlspecialchars($review['user_name']); ?></h5>
                <small style="color:#64748b;">Consumer - <?php echo htmlspecialchars($review['location']); ?></small>
              </div>
            </div>
          </div>
      <?php 
          }
      } else {
      ?>
          <div class="testimonial-card">
            <p>"Ever since I started using this site, I no longer worry about unannounced power outages."</p>
            <div class="user-info"><i class="fa fa-user-circle"></i><div><h5>Ahmed R.</h5><small style="color:#64748b;">Consumer - Ampara</small></div></div>
          </div>
          <div class="testimonial-card">
            <p>"The ability to instantly report emergency breakdowns directly to the dashboard is helpful."</p>
            <div class="user-info"><i class="fa fa-user-circle"></i><div><h5>Mohamed S.</h5><small style="color:#64748b;">Consumer - Batticaloa</small></div></div>
          </div>
          <div class="testimonial-card">
            <p>"The UI layout looks very responsive, neat, and tracking analytics is fast."</p>
            <div class="user-info"><i class="fa fa-user-circle"></i><div><h5>Fathima A.</h5><small style="color:#64748b;">Consumer - Colombo</small></div></div>
          </div>
      <?php } ?>
    </div>
  </section>

  <section id="faq">
    <h2 class="section-title">Frequently Asked Questions</h2>
    <div class="faq-container">
      <div class="faq-item">
        <h4>Q1: Is this alerting service completely free to use?</h4>
        <p style="color: #cbd5e1;">Yes! Every consumer can seamlessly create an account and receive power cut alert logs absolutely free.</p>
      </div>
      <div class="faq-item">
        <h4>Q2: How do I change my monitored grid area?</h4>
        <p style="color: #cbd5e1;">Simply navigate to your profile management dashboard anytime to modify your tracking grid preferences.</p>
      </div>
    </div>
  </section>

  <footer id="contact">
    <div class="footer-container">
      <div class="footer-about">
        <h3>EDL Grid Pro</h3>
        <p style="color: #94a3b8; line-height: 1.6;">Digitizing national electricity grid monitoring to provide top-tier breakdown notifications and community safety tools.</p>
      </div>
      <div class="footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#features">Services / Features</a></li>
          <li><a href="#faq">FAQ</a></li>
        </ul>
      </div>
      <div class="footer-contact">
        <h4>Contact Info</h4>
        <p><i class="fa fa-map-marker-alt"></i> Ampara / Colombo, Sri Lanka</p>
        <p><i class="fa fa-envelope"></i> support@edlgridpro.com</p>
        <p><i class="fa fa-phone"></i> +94 77 123 4567</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2026 EDL Grid Pro System. All Rights Reserved.</p>
    </div>
  </footer>

  <script>
    const modal = document.getElementById('loginModal');
    function openLoginModal() { modal.classList.add('open'); }
    function closeLoginModal() { modal.classList.remove('open'); }
    window.onclick = function(event) { if (event.target === modal) { closeLoginModal(); } }

    const sections = document.querySelectorAll('section, footer');
    const navItems = document.querySelectorAll('.navbar .nav-item');

    const observerOptions = {
      root: null,
      rootMargin: '-50% 0px -50% 0px',
      threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = entry.target.getAttribute('id');
          
          if (id) {
            navItems.forEach(item => {
              item.classList.remove('active');
              if (item.getAttribute('href') === `#${id}`) {
                item.classList.add('active');
              }
            });
          }
        }
      });
    }, observerOptions);

    sections.forEach(section => observer.observe(section));
  </script>

</body>
</html>
<?php 
if (isset($conn) && $conn) {
    @$conn->close(); 
}
?>