<?php
/**
 * Home Page
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

// Get hero sliders
$db->query('SELECT * FROM hero_sliders WHERE active = 1 ORDER BY display_order LIMIT 1');
$hero = $db->getSingle();

// Get statistics
$db->query('SELECT * FROM statistics WHERE active = 1 ORDER BY display_order');
$stats = $db->getResult();

?>

<!-- Hero Section -->
<?php if ($hero): ?>
    <section class="hero-section" style="background-image: url('<?php echo SITE_URL . 'uploads/' . $hero['image']; ?>')">
        <div class="container text-center">
            <h1 class="hero-title"><?php echo sanitize($hero['title']); ?></h1>
            <p class="hero-subtitle"><?php echo sanitize($hero['subtitle']); ?></p>
            <div class="hero-buttons">
                <?php if ($hero['button_1_text']): ?>
                    <a href="<?php echo $hero['button_1_url']; ?>" class="btn btn-primary-hero">
                        <?php echo sanitize($hero['button_1_text']); ?>
                    </a>
                <?php endif; ?>
                <?php if ($hero['button_2_text']): ?>
                    <a href="<?php echo $hero['button_2_url']; ?>" class="btn btn-secondary-hero">
                        <?php echo sanitize($hero['button_2_text']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Statistics Section -->
<?php if ($stats): ?>
    <section class="statistics-section">
        <div class="container">
            <div class="row">
                <?php foreach ($stats as $stat): ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="<?php echo $stat['icon']; ?>"></i>
                            </div>
                            <div class="stat-number"><?php echo $stat['number']; ?></div>
                            <div class="stat-title"><?php echo sanitize($stat['title']); ?></div>
                            <?php if ($stat['unit']): ?>
                                <small class="text-muted"><?php echo sanitize($stat['unit']); ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- About Preview -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h2 class="section-title">About Panchalbhumi FPC</h2>
                <p class="section-subtitle">Empowering Farmers Through Collective Action</p>
                <p><?php echo truncate(getSetting('site_tagline'), 300); ?></p>
                <p>Panchalbhumi Farmers Producer Company Limited is dedicated to professional management, market linkage, and sustainable agriculture for farmer members.</p>
                <a href="<?php echo SITE_URL; ?>about.php" class="btn btn-primary">Learn More</a>
            </div>
            <div class="col-md-6">
                <img src="<?php echo SITE_URL; ?>assets/images/placeholder-about.jpg" alt="About Panchalbhumi" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Products Preview -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">Our Products</h2>
        <p class="section-subtitle text-center">Quality produce from our farmer members</p>
        
        <?php
        $db->query('SELECT * FROM products WHERE active = 1 ORDER BY display_order LIMIT 6');
        $products = $db->getResult();
        ?>
        
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo SITE_URL . 'uploads/' . $product['image']; ?>" alt="<?php echo sanitize($product['name']); ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo sanitize($product['name']); ?></h5>
                            <p class="card-text"><?php echo truncate($product['description'], 100); ?></p>
                            <a href="<?php echo SITE_URL; ?>product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?php echo SITE_URL; ?>products.php" class="btn btn-primary btn-lg">View All Products</a>
        </div>
    </div>
</section>

<!-- Recent Activities -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Recent Activities</h2>
        
        <?php
        $db->query('SELECT * FROM activities WHERE active = 1 ORDER BY activity_date DESC LIMIT 3');
        $activities = $db->getResult();
        ?>
        
        <div class="row">
            <?php foreach ($activities as $activity): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo SITE_URL . 'uploads/' . $activity['featured_image']; ?>" alt="<?php echo sanitize($activity['title']); ?>" class="card-img-top">
                        <div class="card-body">
                            <small class="text-muted"><i class="fas fa-calendar"></i> <?php echo humanDate($activity['activity_date']); ?></small>
                            <h5 class="card-title mt-2"><?php echo sanitize($activity['title']); ?></h5>
                            <p class="card-text"><?php echo truncate($activity['description'], 100); ?></p>
                            <a href="<?php echo SITE_URL; ?>activity.php?id=<?php echo $activity['id']; ?>" class="btn btn-sm btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background-color: var(--primary-color); color: white;">
    <div class="container text-center">
        <h2>Join Our Farmer Network</h2>
        <p class="mt-3">Become part of Panchalbhumi and benefit from collective marketing, training, and support.</p>
        <a href="<?php echo SITE_URL; ?>membership.php" class="btn btn-warning mt-4">Become a Member</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
