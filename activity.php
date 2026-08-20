<?php
/**
 * Activity Detail Page
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: ' . SITE_URL . 'activities.php');
    exit;
}

$activity_id = (int)$_GET['id'];

$db->query('SELECT * FROM activities WHERE id = :id AND active = 1 LIMIT 1');
$db->bind(':id', $activity_id);
$activity = $db->getSingle();

if (!$activity) {
    header('Location: ' . SITE_URL . 'activities.php');
    exit;
}

// Get gallery images
$db->query('SELECT * FROM activity_gallery WHERE activity_id = :activity_id ORDER BY display_order');
$db->bind(':activity_id', $activity_id);
$gallery = $db->getResult();

// Get documents
$db->query('SELECT * FROM activity_documents WHERE activity_id = :activity_id');
$db->bind(':activity_id', $activity_id);
$documents = $db->getResult();

?>

<!-- Breadcrumb -->
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>activities.php">Activities</a></li>
            <li class="breadcrumb-item active"><?php echo sanitize($activity['title']); ?></li>
        </ol>
    </nav>
</div>

<!-- Activity Detail -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <img src="<?php echo SITE_URL . 'uploads/' . $activity['featured_image']; ?>" alt="<?php echo sanitize($activity['title']); ?>" class="img-fluid rounded mb-4">
                
                <h1><?php echo sanitize($activity['title']); ?></h1>
                
                <div class="mb-4">
                    <span class="badge bg-primary"><i class="fas fa-calendar"></i> <?php echo humanDate($activity['activity_date']); ?></span>
                    <span class="badge bg-success"><i class="fas fa-map-marker-alt"></i> <?php echo sanitize($activity['location']); ?></span>
                    <span class="badge bg-info"><?php echo sanitize($activity['category']); ?></span>
                </div>
                
                <h3>Activity Details</h3>
                <p><?php echo $activity['detailed_description'] ?: $activity['description']; ?></p>
                
                <dl class="row">
                    <dt class="col-sm-4">Organizer:</dt>
                    <dd class="col-sm-8"><?php echo sanitize($activity['organizer']); ?></dd>
                    
                    <dt class="col-sm-4">Participants:</dt>
                    <dd class="col-sm-8"><?php echo $activity['participants_count']; ?></dd>
                    
                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8"><span class="badge bg-secondary"><?php echo sanitize($activity['status']); ?></span></dd>
                </dl>
                
                <!-- Gallery -->
                <?php if ($gallery): ?>
                    <h3 class="mt-5">Activity Gallery</h3>
                    <div class="row">
                        <?php foreach ($gallery as $image): ?>
                            <div class="col-md-4 mb-3">
                                <a href="<?php echo SITE_URL . 'uploads/' . $image['image']; ?>" data-bs-toggle="lightbox" class="d-block">
                                    <img src="<?php echo SITE_URL . 'uploads/' . $image['image']; ?>" alt="<?php echo sanitize($image['caption']); ?>" class="img-fluid rounded">
                                    <?php if ($image['caption']): ?>
                                        <small class="d-block mt-2"><?php echo sanitize($image['caption']); ?></small>
                                    <?php endif; ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Documents -->
                <?php if ($documents): ?>
                    <h3 class="mt-5">Related Documents</h3>
                    <ul class="list-group">
                        <?php foreach ($documents as $doc): ?>
                            <li class="list-group-item">
                                <a href="<?php echo SITE_URL . 'uploads/' . $doc['file']; ?>" target="_blank">
                                    <i class="fas fa-file-pdf"></i> <?php echo sanitize($doc['title']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        Activity Summary
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>Date:</strong> <?php echo humanDate($activity['activity_date']); ?><br>
                            <strong>Location:</strong> <?php echo sanitize($activity['location']); ?><br>
                            <strong>Category:</strong> <?php echo sanitize($activity['category']); ?><br>
                            <strong>Participants:</strong> <?php echo $activity['participants_count']; ?><br>
                            <strong>Status:</strong> <?php echo sanitize($activity['status']); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
