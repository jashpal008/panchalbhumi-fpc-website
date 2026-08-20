<?php
/**
 * Admin Settings Page
 */

require_once dirname(__FILE__) . '/../config/config.php';
require_once dirname(__FILE__) . '/../config/database.php';
require_once dirname(__FILE__) . '/../includes/auth.php';
require_once dirname(__FILE__) . '/../includes/functions.php';

requireLogin();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $site_name = sanitize($_POST['site_name'] ?? '');
    $site_short_name = sanitize($_POST['site_short_name'] ?? '');
    $site_tagline = sanitize($_POST['site_tagline'] ?? '');
    $office_address = sanitize($_POST['office_address'] ?? '');
    $office_city = sanitize($_POST['office_city'] ?? '');
    $office_state = sanitize($_POST['office_state'] ?? '');
    $office_pin = sanitize($_POST['office_pin'] ?? '');
    $office_phone = sanitize($_POST['office_phone'] ?? '');
    $office_email = sanitize($_POST['office_email'] ?? '');
    $office_whatsapp = sanitize($_POST['office_whatsapp'] ?? '');
    $office_timings = sanitize($_POST['office_timings'] ?? '');
    
    if ($site_name) {
        updateSetting('site_name', $site_name);
        updateSetting('site_short_name', $site_short_name);
        updateSetting('site_tagline', $site_tagline);
        updateSetting('office_address', $office_address);
        updateSetting('office_city', $office_city);
        updateSetting('office_state', $office_state);
        updateSetting('office_pin', $office_pin);
        updateSetting('office_phone', $office_phone);
        updateSetting('office_email', $office_email);
        updateSetting('office_whatsapp', $office_whatsapp);
        updateSetting('office_timings', $office_timings);
        
        $message = 'Settings updated successfully!';
        logActivity('Update', 'Settings', 'Website settings updated');
    } else {
        $error = 'Please fill all required fields';
    }
}

// Get current settings
$site_name = getSetting('site_name');
$site_short_name = getSetting('site_short_name');
$site_tagline = getSetting('site_tagline');
$office_address = getSetting('office_address');
$office_city = getSetting('office_city');
$office_state = getSetting('office_state');
$office_pin = getSetting('office_pin');
$office_phone = getSetting('office_phone');
$office_email = getSetting('office_email');
$office_whatsapp = getSetting('office_whatsapp');
$office_timings = getSetting('office_timings');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1b5e20;
        }
        body {
            background-color: #f5f5f5;
        }
        .sidebar {
            background-color: var(--primary-color);
            color: white;
            min-height: 100vh;
            padding: 20px 0;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-3 border-bottom">
            <h5 style="margin: 0;"><i class="fas fa-cog"></i> Settings</h5>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>dashboard.php">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a class="nav-link active" href="<?php echo ADMIN_URL; ?>settings.php">
                <i class="fas fa-cog"></i> Website Settings
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <h2 class="mb-4">Website Settings</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 style="margin: 0;">Basic Settings</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="site_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="site_name" name="site_name" value="<?php echo htmlspecialchars($site_name); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="site_short_name" class="form-label">Short Name</label>
                                <input type="text" class="form-control" id="site_short_name" name="site_short_name" value="<?php echo htmlspecialchars($site_short_name); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="site_tagline" class="form-label">Tagline</label>
                                <input type="text" class="form-control" id="site_tagline" name="site_tagline" value="<?php echo htmlspecialchars($site_tagline); ?>">
                            </div>
                            
                            <h5 class="mt-4 mb-3">Office Contact Information</h5>
                            
                            <div class="mb-3">
                                <label for="office_address" class="form-label">Office Address</label>
                                <textarea class="form-control" id="office_address" name="office_address" rows="2"><?php echo htmlspecialchars($office_address); ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="office_city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="office_city" name="office_city" value="<?php echo htmlspecialchars($office_city); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="office_state" class="form-label">State</label>
                                    <input type="text" class="form-control" id="office_state" name="office_state" value="<?php echo htmlspecialchars($office_state); ?>">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="office_pin" class="form-label">PIN Code</label>
                                <input type="text" class="form-control" id="office_pin" name="office_pin" value="<?php echo htmlspecialchars($office_pin); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="office_phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="office_phone" name="office_phone" value="<?php echo htmlspecialchars($office_phone); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="office_email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="office_email" name="office_email" value="<?php echo htmlspecialchars($office_email); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="office_whatsapp" class="form-label">WhatsApp Number</label>
                                <input type="tel" class="form-control" id="office_whatsapp" name="office_whatsapp" value="<?php echo htmlspecialchars($office_whatsapp); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="office_timings" class="form-label">Office Timings</label>
                                <input type="text" class="form-control" id="office_timings" name="office_timings" value="<?php echo htmlspecialchars($office_timings); ?>" placeholder="e.g., Monday to Friday, 9 AM to 5 PM">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 style="margin: 0;">Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Last Updated:</strong> Today</p>
                        <p><strong>Admin:</strong> <?php echo $_SESSION['user_name']; ?></p>
                        <hr>
                        <p class="small text-muted">Update your company information that will be displayed on the website.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
