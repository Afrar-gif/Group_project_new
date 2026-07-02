<?php
// Clear any accidental previous outputs or spaces
ob_clean();
header('Content-Type: application/json');

// Error reporting-ai temporary-ah off panni, clean JSON response thara
error_reporting(0); 

include "db.php";

// Database connection code validation
if (!$conn) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . mysqli_connect_error()
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['area']) && isset($_POST['date']) && isset($_POST['time'])) {
    
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    
    // User table-il irunthu name matrum email-ai mattum fetch seigirom
    $sql = "SELECT name, email FROM users WHERE area = '$area'";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        echo json_encode([
            'status' => 'error',
            'message' => 'SQL Error: ' . mysqli_error($conn)
        ]);
        exit;
    }
    
    $alerts_count = 0;
    
    // Construct Email Message Template
    $subject = "⚡ Smart Power Cut Alert - $area";
    $message_text = "Dear User,\n\nThis is an automated alert to inform you that a power cut has been scheduled for your area ($area) on $date from $time. Please plan accordingly.\n\nThank you,\nCEB Smart Alert Team";
    
    while ($user = mysqli_fetch_assoc($result)) {
        $user_email = $user['email'];
        $user_name = $user['name'];
        
        // -------------------------------------------------------------
        // EMAIL INTEGRATION (Real-ah mail anuppa):
        // -------------------------------------------------------------
        // PHP built-in mail function (Localhost-il direct-ah vela seiyathu, live server-il vela seiyum)
        // $headers = "From: alerts@smartpower.com";
        // mail($user_email, $subject, "Hi $user_name,\n\n" . $message_text, $headers);
        
        // Neenga testing seiyum pothu server background loop check panna ithu track aahum
        $alerts_count++;
    }
    
    // Success response return to Frontend JS
    echo json_encode([
        'status' => 'success',
        'count' => $alerts_count
    ]);
    exit;
    
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request parameters structural error.'
    ]);
    exit;
}
?>