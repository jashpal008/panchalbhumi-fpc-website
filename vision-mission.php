<?php
/**
 * Vision & Mission Page
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

?>

<!-- Breadcrumb -->
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
            <li class="breadcrumb-item active">Vision & Mission</li>
        </ol>
    </nav>
</div>

<!-- Hero -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Vision & Mission</h1>
    </div>
</section>

<!-- Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header" style="background-color: var(--primary-color);">
                        <h3 style="color: white; margin: 0;">Our Vision</h3>
                    </div>
                    <div class="card-body">
                        <p><?php echo getSetting('vision_statement', 'To be updated'); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header" style="background-color: var(--secondary-color);">
                        <h3 style="color: white; margin: 0;">Our Mission</h3>
                    </div>
                    <div class="card-body">
                        <p><?php echo getSetting('mission_statement', 'To be updated'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-12">
                <h2 class="section-title text-center">Core Values</h2>
                <div class="row mt-4">
                    <?php
                    $core_values = [
                        ['icon' => 'fas fa-users', 'title' => 'Farmer First', 'description' => 'Farmer interests are our priority'],
                        ['icon' => 'fas fa-eye', 'title' => 'Transparency', 'description' => 'Transparent operations and decision-making'],
                        ['icon' => 'fas fa-handshake', 'title' => 'Collective Growth', 'description' => 'Shared benefits for all members'],
                        ['icon' => 'fas fa-leaf', 'title' => 'Sustainability', 'description' => 'Sustainable agriculture practices'],
                        ['icon' => 'fas fa-briefcase', 'title' => 'Professional Management', 'description' => 'Professional team and systems'],
                        ['icon' => 'fas fa-star', 'title' => 'Quality', 'description' => 'Quality in all products and services']
                    ];
                    ?>
                    
                    <?php foreach ($core_values as $value): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="stat-icon">
                                        <i class="<?php echo $value['icon']; ?>"></i>
                                    </div>
                                    <h5 class="card-title"><?php echo $value['title']; ?></h5>
                                    <p class="card-text"><?php echo $value['description']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
