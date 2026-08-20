<?php
/**
 * Gallery Page
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Get albums count
$db->query('SELECT COUNT(*) as count FROM gallery_albums WHERE active = 1');
$count_result = $db->getSingle();
$total_items = $count_result['count'];

$pagination = getPagination($total_items, ITEMS_PER_PAGE, $page);

// Get albums
$db->query('SELECT * FROM gallery_albums WHERE active = 1 ORDER BY display_order LIMIT :limit OFFSET :offset');
$db->bind(':limit', ITEMS_PER_PAGE, PDO::PARAM_INT);
$db->bind(':offset', $pagination['offset'], PDO::PARAM_INT);
$albums = $db->getResult();

?>

<!-- Breadcrumb -->
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
            <li class="breadcrumb-item active">Gallery</li>
        </ol>
    </nav>
</div>

<!-- Hero -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Photo Gallery</h1>
        <p class="section-subtitle">Events, activities, and farmer success stories</p>
    </div>
</section>

<!-- Gallery Albums -->
<section class="py-5">
    <div class="container">
        <?php if ($albums): ?>
            <div class="row">
                <?php foreach ($albums as $album): ?>
                    <?php
                    // Get first image from album
                    $db->query('SELECT image FROM gallery_images WHERE album_id = :album_id ORDER BY display_order LIMIT 1');
                    $db->bind(':album_id', $album['id']);
                    $first_image = $db->getSingle();
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 cursor-pointer">
                            <div style="height: 250px; overflow: hidden;">
                                <img src="<?php echo SITE_URL . 'uploads/' . ($first_image['image'] ?? $album['cover_image']); ?>" alt="<?php echo sanitize($album['title']); ?>" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo sanitize($album['title']); ?></h5>
                                <?php if ($album['event_date']): ?>
                                    <small class="text-muted"><i class="fas fa-calendar"></i> <?php echo humanDate($album['event_date']); ?></small>
                                <?php endif; ?>
                                <?php if ($album['category']): ?>
                                    <small class="badge bg-primary mt-2" style="width: fit-content;"><?php echo sanitize($album['category']); ?></small>
                                <?php endif; ?>
                                <p class="card-text mt-3"><?php echo truncate($album['description'], 100); ?></p>
                                <div class="mt-auto">
                                    <a href="<?php echo SITE_URL; ?>gallery.php?album=<?php echo $album['id']; ?>" class="btn btn-primary btn-sm">View Album</a>
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
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info">No gallery albums available at this time.</div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
