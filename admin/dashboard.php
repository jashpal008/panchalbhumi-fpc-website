<?php
/**
 * Admin Dashboard
 */

require_once dirname(__FILE__) . '/../config/config.php';
require_once dirname(__FILE__) . '/../config/database.php';
require_once dirname(__FILE__) . '/../includes/auth.php';
require_once dirname(__FILE__) . '/../includes/functions.php';

requireLogin();

// Get dashboard statistics
$db->query('SELECT COUNT(*) as count FROM members WHERE status = "Active"');
$active_members = $db->getSingle()['count'];

$db->query('SELECT COUNT(*) as count FROM products WHERE active = 1');
$total_products = $db->getSingle()['count'];

$db->query('SELECT COUNT(*) as count FROM activities WHERE active = 1');
$total_activities = $db->getSingle()['count'];

$db->query('SELECT COUNT(*) as count FROM news WHERE active = 1');
$total_news = $db->getSingle()['count'];

$db->query('SELECT COUNT(*) as count FROM gallery_images');
$total_gallery_images = $db->getSingle()['count'];

$db->query('SELECT COUNT(*) as count FROM membership_applications WHERE status = "New"');
$pending_applications = $db->getSingle()['count'];

$db->query('SELECT COUNT(*) as count FROM contact_enquiries WHERE status = "New"');
$new_enquiries = $db->getSingle()['count'];

$db->query('SELECT COUNT(*) as count FROM product_enquiries WHERE status = "New"');
$new_product_enquiries = $db->getSingle()['count'];

$db->query('SELECT COUNT(*) as count FROM documents');
$total_documents = $db->getSingle()['count'];

// Get recent activities
$db->query('SELECT name, action, module, created_at FROM activity_logs ORDER BY created_at DESC LIMIT 5');
$recent_activities = $db->getResult();

$site_name = getSetting('site_name');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1b5e20;
            --secondary-color: #4caf50;
            --accent-color: #ffa500;
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
            overflow-y: auto;
        }
        .sidebar .brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left-color: var(--accent-color);
        }
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left-color: var(--accent-color);
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .topbar {
            background-color: white;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            border-left: 5px solid var(--primary-color);
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }
        .stat-card.success { border-left-color: #28a745; }
        .stat-card.info { border-left-color: #17a2b8; }
        .stat-card.warning { border-left-color: #ffc107; }
        .stat-card.danger { border-left-color: #dc3545; }
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        .stat-title {
            color: #666;
            font-size: 0.9rem;
        }
        .card {
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
        }
        .btn-primary:hover {
            background-color: #0d3817;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <h4 style="margin: 0; font-weight: 700;"><i class="fas fa-tractor"></i> Admin Panel</h4>
            <small style="opacity: 0.8;">Panchalbhumi FPC</small>
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link active" href="<?php echo ADMIN_URL; ?>dashboard.php">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>settings.php">
                <i class="fas fa-cog"></i> Settings
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>products/index.php">
                <i class="fas fa-box"></i> Products
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>activities/index.php">
                <i class="fas fa-tasks"></i> Activities
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>news/index.php">
                <i class="fas fa-newspaper"></i> News
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>gallery/index.php">
                <i class="fas fa-images"></i> Gallery
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>members/index.php">
                <i class="fas fa-users"></i> Members
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>enquiries/index.php">
                <i class="fas fa-envelope"></i> Enquiries
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>documents/index.php">
                <i class="fas fa-file-pdf"></i> Documents
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h5 style="margin: 0;">Welcome, <?php echo $_SESSION['user_name']; ?></h5>
            <div>
                <a href="<?php echo SITE_URL; ?>" class="btn btn-sm btn-secondary" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Website
                </a>
                <a href="<?php echo ADMIN_URL; ?>profile.php" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-user"></i> Profile
                </a>
            </div>
        </div>
        
        <div class="container-fluid">
            <h2 class="mb-4">Dashboard</h2>
            
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card success">
                        <div class="stat-number"><?php echo $active_members; ?></div>
                        <div class="stat-title">Active Members</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card info">
                        <div class="stat-number"><?php echo $total_products; ?></div>
                        <div class="stat-title">Products</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card warning">
                        <div class="stat-number"><?php echo $total_activities; ?></div>
                        <div class="stat-title">Activities</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card danger">
                        <div class="stat-number"><?php echo $new_enquiries; ?></div>
                        <div class="stat-title">New Enquiries</div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $total_news; ?></div>
                        <div class="stat-title">News Articles</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $total_gallery_images; ?></div>
                        <div class="stat-title">Gallery Images</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $pending_applications; ?></div>
                        <div class="stat-title">Membership Applications</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $total_documents; ?></div>
                        <div class="stat-title">Documents</div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: var(--primary-color); color: white;">
                            <h6 style="margin: 0;">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <a href="<?php echo ADMIN_URL; ?>products/create.php" class="btn btn-sm btn-primary me-2 mb-2">
                                <i class="fas fa-plus"></i> Add Product
                            </a>
                            <a href="<?php echo ADMIN_URL; ?>activities/create.php" class="btn btn-sm btn-primary me-2 mb-2">
                                <i class="fas fa-plus"></i> Add Activity
                            </a>
                            <a href="<?php echo ADMIN_URL; ?>news/create.php" class="btn btn-sm btn-primary me-2 mb-2">
                                <i class="fas fa-plus"></i> Add News
                            </a>
                            <a href="<?php echo ADMIN_URL; ?>gallery/create.php" class="btn btn-sm btn-primary me-2 mb-2">
                                <i class="fas fa-plus"></i> Add Gallery
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activities -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: var(--primary-color); color: white;">
                            <h6 style="margin: 0;">Recent Admin Activities</h6>
                        </div>
                        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                            <?php if ($recent_activities): ?>
                                <ul class="list-unstyled">
                                    <?php foreach ($recent_activities as $activity): ?>
                                        <li class="mb-2 pb-2 border-bottom">
                                            <small>
                                                <strong><?php echo sanitize($activity['name']); ?></strong> - 
                                                <?php echo sanitize($activity['action']); ?> 
                                                <span class="badge bg-secondary"><?php echo sanitize($activity['module']); ?></span>
                                                <br>
                                                <span class="text-muted"><?php echo timeAgo($activity['created_at']); ?></span>
                                            </small>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted small mb-0">No activities yet</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
