<?php
/**
 * Activities Page
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

// Get selected category
$category = isset($_GET['category']) ? sanitize($_GET['category']) : '';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Get activities count
if ($category) {
    $db->query('SELECT COUNT(*) as count FROM activities WHERE active = 1 AND category = :category');
    $db->bind(':category', $category);
} else {
    $db->query('SELECT COUNT(*) as count FROM activities WHERE active = 1');
}
$count_result = $db->getSingle();
$total_items = $count_result['count'];

$pagination = getPagination($total_items, ITEMS_PER_PAGE, $page);

// Get activities
if ($category) {
    $db->query('SELECT * FROM activities WHERE active = 1 AND category = :category ORDER BY activity_date DESC LIMIT :limit OFFSET :offset');
    $db->bind(':category', $category);
} else {
    $db->query('SELECT * FROM activities WHERE active = 1 ORDER BY activity_date DESC LIMIT :limit OFFSET :offset');
}
$db->bind(':limit', ITEMS_PER_PAGE, PDO::PARAM_INT);
$db->bind(':offset', $pagination['offset'], PDO::PARAM_INT);
$activities = $db->getResult();

?>

<!-- Breadcrumb -->
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
            <li class="breadcrumb-item active">Activities</li>
        </ol>
    </nav>
</div>

<!-- Hero -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Our Activities</h1>
        <p class="section-subtitle">Training, meetings, and farmer development programs</p>
    </div>
</section>

<!-- Activities -->
<section class="py-5">
    <div class="container">
        <?php if ($activities): ?>
            <div class="row">
                <?php foreach ($activities as $activity): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo SITE_URL . 'uploads/' . $activity['featured_image']; ?>" alt="<?php echo sanitize($activity['title']); ?>" class="card-img-top">
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <small class="text-muted"><i class="fas fa-calendar"></i> <?php echo humanDate($activity['activity_date']); ?></small>
                                    <br>
                                    <small class="text-muted"><i class="fas fa-map-marker-alt"></i> <?php echo sanitize($activity['location']); ?></small>
                                    <br>
                                    <small class="badge bg-primary"><?php echo sanitize($activity['category']); ?></small>
                                </div>
                                <h5 class="card-title"><?php echo sanitize($activity['title']); ?></h5>
                                <p class="card-text"><?php echo truncate($activity['description'], 150); ?></p>
                                <div class="mt-auto">
                                    <a href="<?php echo SITE_URL; ?>activity.php?id=<?php echo $activity['id']; ?>" class="btn btn-primary btn-sm">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($pagination['total_pages'] > 1): ?>
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                            <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?><?php echo $category ? '&category=' . urlencode($category) : ''; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info">No activities available at this time.</div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
