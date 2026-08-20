<?php
/**
 * About Us Page
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

?>

<!-- Breadcrumb -->
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
            <li class="breadcrumb-item active">About Us</li>
        </ol>
    </nav>
</div>

<!-- Hero -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">About Panchalbhumi Farmers Producer Company Limited</h1>
    </div>
</section>

<!-- Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Our Organization</h2>
                <p><?php echo getSetting('about_content', 'Information will be updated shortly'); ?></p>
                
                <h3 class="mt-4">Our Approach</h3>
                <ul>
                    <li>Farmer-centric decision making</li>
                    <li>Professional management</li>
                    <li>Market-linked operations</li>
                    <li>Transparency and accountability</li>
                    <li>Sustainable agriculture practices</li>
                </ul>
                
                <h3 class="mt-4">Area of Operation</h3>
                <p><?php echo getSetting('area_of_operation', 'To be updated'); ?></p>
                
                <h3 class="mt-4">Key Objectives</h3>
                <ul>
                    <li>Increase farmer income through collective action</li>
                    <li>Provide quality inputs and market linkage</li>
                    <li>Support sustainable agriculture</li>
                    <li>Facilitate farmer training and capacity building</li>
                    <li>Promote value addition</li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quick Facts</h5>
                        <dl class="row">
                            <dt class="col-sm-6">Company Name:</dt>
                            <dd class="col-sm-6"><?php echo getSetting('site_name'); ?></dd>
                            
                            <dt class="col-sm-6">Short Name:</dt>
                            <dd class="col-sm-6"><?php echo getSetting('site_short_name'); ?></dd>
                            
                            <dt class="col-sm-6">Type:</dt>
                            <dd class="col-sm-6">Farmer Producer Organization</dd>
                            
                            <dt class="col-sm-6">Status:</dt>
                            <dd class="col-sm-6">Active</dd>
                        </dl>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Contact Details</h5>
                        <p>
                            <strong>Office Address:</strong><br>
                            <?php echo getSetting('office_address'); ?><br>
                            <?php echo getSetting('office_city'); ?>, <?php echo getSetting('office_state'); ?> <?php echo getSetting('office_pin'); ?>
                        </p>
                        <p>
                            <strong>Phone:</strong> <?php echo getSetting('office_phone'); ?><br>
                            <strong>Email:</strong> <?php echo getSetting('office_email'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
