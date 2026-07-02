<?php
// 1. துல்லியமான கோப்புப் பாதையைக் கண்டறிந்து db.php ஐ இணைத்தல்
include __DIR__ . "/db.php";

header('Content-Type: application/json');

/* ===========================
   VALIDATE INPUT
=========================== */
if (
    $_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['area']) || trim($_POST['area']) === '' ||
    !isset($_POST['date']) || trim($_POST['date']) === '' ||
    !isset($_POST['time']) || trim($_POST['time']) === ''
) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields (area, date, time).']);
    exit;
}

// $conn மாறிலியைச் சரிபார்த்தல்
if (!isset($conn)) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection variable ($conn) not found.']);
    exit;
}

$area = mysqli_real_escape_string($conn, $_POST['area']);
$date = mysqli_real_escape_string($conn, $_POST['date']);
$time = mysqli_real_escape_string($conn, $_POST['time']);

/* ===========================
   FETCH USERS BELONGING TO THIS AREA
=========================== */
$user_sql = "SELECT name, email FROM users WHERE area = '$area'";
$user_result = mysqli_query($conn, $user_sql);

if (!$user_result) {
    echo json_encode(['status' => 'error', 'message' => 'DB error: ' . mysqli_error($conn)]);
    exit;
}

if (mysqli_num_rows($user_result) === 0) {
    echo json_encode(['status' => 'error', 'message' => "No registered users found in area: $area"]);
    exit;
}

/* ===========================
   SEND EMAIL TO EACH USER
=========================== */
$sent_count = 0;
$failed_count = 0;

$from_email = "no-reply@yourdomain.com";
$from_name  = "Smart Power Cut Alert System";
$subject = "⚡ Power Cut Alert - $area";

while ($user = mysqli_fetch_assoc($user_result)) {

    $to = $user['email'];
    $user_name = htmlspecialchars($user['name']);

    if (empty($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $failed_count++;
        continue;
    }

    $message = "
    <html>
    <head><title>Power Cut Alert</title></head>
    <body style='font-family: Arial, sans-serif; background:#f4f7fc; padding:20px;'>
        <div style='max-width:500px;margin:auto;background:white;padding:25px;border-radius:10px;border:1px solid #ddd;'>
            <h2 style='color:#0077b6;'>⚡ Power Cut Alert</h2>
            <p>Dear <b>$user_name</b>,</p>
            <p>This is to inform you about a scheduled power cut in your area.</p>
            <table style='width:100%; margin-top:15px;'>
                <tr><td style='padding:6px;font-weight:bold;'>Area:</td><td style='padding:6px;'>$area</td></tr>
                <tr><td style='padding:6px;font-weight:bold;'>Date:</td><td style='padding:6px;'>$date</td></tr>
                <tr><td style='padding:6px;font-weight:bold;'>Time:</td><td style='padding:6px;'>$time</td></tr>
            </table>
            <p style='margin-top:15px;'>Please plan accordingly. We apologize for any inconvenience caused.</p>
            <hr style='margin:20px 0;border:none;border-top:1px solid #eee;'>
            <p style='font-size:12px;color:#888;'>This is an automated message from Smart Power Cut Alert System.</p>
        </div>
    </body>
    </html>
    ";

    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $from_name <$from_email>" . "\r\n";

    // LOCALHOST சோதனைக்காக தற்காலிகமாக மாற்றம் (உண்மையான சர்வரில் பதிவேற்றும்போது 'true' ஐ மாற்றி 'mail(...)' ஐப் பயன்படுத்தவும்)
    if (true) {
        $sent_count++;
    } else {
        $failed_count++;
    }
}

/* ===========================
   RESPONSE
=========================== */
if ($sent_count > 0) {
    echo json_encode([
        'status'  => 'success',
        'count'   => $sent_count,
        'failed'  => $failed_count,
        'message' => "Alerts sent to $sent_count user(s) in $area."
    ]);
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => "Failed to send any emails. Check mail server configuration."
    ]);
}
?>