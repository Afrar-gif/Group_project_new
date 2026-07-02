<?php
// 1. செஷன் ஸ்டார்ட் பண்ணுதல் (அட்மின் விபரங்களை டேஷ்போர்டுக்கு கொண்டு போக)
session_start();

// 2. டேட்டாபேஸ் கனெக்ஷன் ஃபைலை இணைத்தல்
include "db.php"; 

// 3. அட்மின் 'Login' பட்டனை கிளிக் பண்ணா மட்டும் இந்த கோடு ரன் ஆகும்
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $secretkey = mysqli_real_escape_with_sec($conn, $_POST['secretkey']); // SQL Injection பாதுகாப்பு
    $password = mysqli_real_escape_with_sec($conn, $_POST['password']);

    // காலி ஃபீல்டுகள் இருக்கான்னு செக் பண்றோம்
    if (empty($secretkey) || empty($password)) {
        echo "
        <script>
            alert('All Fields Are Required');
            window.location.href='adminL.php';
        </script>
        ";
        exit();
    }

    // அட்மின் டேபிளில் தரவைச் சரிபார்த்தல்
    $sql = "SELECT * FROM admins WHERE secret_key='$secretkey' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $admin_data = mysqli_fetch_assoc($result);
        
        // அட்மின் விபரங்களை செஷனில் சேமித்தல்
        $_SESSION['admin_id'] = $admin_data['id'];
        $_SESSION['admin_key'] = $admin_data['secret_key'];

        echo "
        <script>
            alert('Admin Login Successful');
            window.location.href='dashboard.php';
        </script>
        ";
        exit();
    } else {
        echo "
        <script>
            alert('Invalid Secret Key or Password');
            window.location.href='adminL.php';
        </script>
        ";
        exit();
    }
}

// பாதுகாப்புக்கான ஹெல்ப்பர் ஃபங்க்ஷன்
function mysqli_real_escape_with_sec($conn, $data) {
    return mysqli_real_escape_string($conn, trim($data));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - EDL Grid Pro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #173845;
            height: 100vh;
        }

        .navbar {
            width: 100%;
            height: 70px;
            background: #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            color: red;
            font-size: 28px;
            font-weight: bold;
        }

        .main {
            height: calc(100vh - 70px);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 340px;
            background: #ddd;
            border-radius: 30px;
            padding: 40px 35px;
            animation: fadeIn 0.6s ease-in-out;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #000;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: none;
            border-bottom: 1px solid #777;
            background: transparent;
            outline: none;
            font-size: 14px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 20px;
            background: #22d8ff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #12c3e8;
            transform: scale(1.02);
            color: #173845;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #173845;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">EDL</div>
    </div>

    <div class="main">
        <div class="login-box">
            <h2>Admin Login</h2>

            <form action="adminL.php" method="POST" onsubmit="return validateAdminLogin()">

                <div class="input-group">
                    <input type="text" id="secretkey" name="secretkey" placeholder="Security Key">
                </div>

                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password">
                </div>

                <button type="submit" class="btn">Login</button>

            </form>

            <div class="register-link">
                <a href="adminR.html">Don't have an account? Register</a>
            </div>
        </div>
    </div>

    <script>
        function validateAdminLogin(){
            let secretkey = document.getElementById("secretkey").value.trim();
            let password = document.getElementById("password").value.trim();

            if(secretkey === "" || password === ""){
                alert("All Fields Must Be Filled");
                return false;
            }

            if(password.length < 6){
                alert("Password Must Be Minimum 6 Characters");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>