<?php
/**
 * Admin Login Page
 */

session_start();
require_once dirname(__FILE__) . '/../config/config.php';
require_once dirname(__FILE__) . '/../config/database.php';
require_once dirname(__FILE__) . '/../includes/auth.php';
require_once dirname(__FILE__) . '/../includes/functions.php';

// Redirect if already logged in
redirectIfLoggedIn();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($email && $password) {
        $result = $auth->login($email, $password);
        if ($result['success']) {
            header('Location: ' . ADMIN_URL . 'dashboard.php');
            exit;
        } else {
            $error = $result['message'];
        }
    } else {
        $error = 'Please enter email and password';
    }
}

$site_name = getSetting('site_name', 'Panchalbhumi FPC');
$logo = getSetting('logo');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo $site_name; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
        }
        .login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .login-header {
            background-color: #1b5e20;
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .login-header h3 {
            margin: 0;
            font-weight: 700;
        }
        .login-logo {
            width: 80px;
            height: 80px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        .login-logo i {
            font-size: 40px;
            color: white;
        }
        .form-control:focus {
            border-color: #1b5e20;
            box-shadow: 0 0 0 0.2rem rgba(27, 94, 32, 0.25);
        }
        .btn-login {
            background-color: #1b5e20;
            border: none;
            padding: 10px;
            font-weight: 600;
        }
        .btn-login:hover {
            background-color: #0d3817;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card login-card">
            <div class="login-header">
                <?php if ($logo): ?>
                    <img src="<?php echo SITE_URL . 'uploads/' . $logo; ?>" alt="<?php echo $site_name; ?>" style="width: 80px; margin-bottom: 15px;">
                <?php else: ?>
                    <div class="login-logo">
                        <i class="fas fa-seedling"></i>
                    </div>
                <?php endif; ?>
                <h3>Admin Panel</h3>
                <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;"><?php echo $site_name; ?></p>
            </div>
            
            <div class="card-body p-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-login btn-primary w-100">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
                
                <hr>
                
                <p class="text-center text-muted small mb-0">
                    <i class="fas fa-info-circle"></i> For security, please use HTTPS and never share your credentials.
                </p>
            </div>
        </div>
        
        <p class="text-white text-center mt-4">
            <small>© <?php echo date('Y'); ?> <?php echo $site_name; ?></small>
        </p>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
