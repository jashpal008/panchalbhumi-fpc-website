<?php
/**
 * News & Articles Page
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

// Get selected category
$category = isset($_GET['category']) ? sanitize($_GET['category']) : '';
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Get news count
if ($search) {
    $db->query('SELECT COUNT(*) as count FROM news WHERE active = 1 AND (title LIKE :search OR excerpt LIKE :search OR content LIKE :search)');
    $db->bind(':search', '%' . $search . '%');
} elseif ($category) {
    $db->query('SELECT COUNT(*) as count FROM news WHERE active = 1 AND category = :category');
    $db->bind(':category', $category);
} else {
    $db->query('SELECT COUNT(*) as count FROM news WHERE active = 1');
}
$count_result = $db->getSingle();
$total_items = $count_result['count'];

$pagination = getPagination($total_items, ITEMS_PER_PAGE, $page);

// Get news
if ($search) {
    $db->query('SELECT * FROM news WHERE active = 1 AND (title LIKE :search OR excerpt LIKE :search OR content LIKE :search) 
               ORDER BY publication_date DESC LIMIT :limit OFFSET :offset');
    $db->bind(':search', '%' . $search . '%');
} elseif ($category) {
    $db->query('SELECT * FROM news WHERE active = 1 AND category = :category ORDER BY publication_date DESC LIMIT :limit OFFSET :offset');
    $db->bind(':category', $category);
} else {
    $db->query('SELECT * FROM news WHERE active = 1 ORDER BY publication_date DESC LIMIT :limit OFFSET :offset');
}
$db->bind(':limit', ITEMS_PER_PAGE, PDO::PARAM_INT);
$db->bind(':offset', $pagination['offset'], PDO::PARAM_INT);
$news_items = $db->getResult();

?>

<!-- Breadcrumb -->
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
            <li class="breadcrumb-item active">News & Articles</li>
        </ol>
    </nav>
</div>

<!-- Hero -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">News & Articles</h1>
        <p class="section-subtitle">Latest updates from Panchalbhumi FPC</p>
    </div>
</section>

<!-- Search & Filter -->
<section class="py-3 border-bottom">
    <div class="container">
        <form method="GET" class="form-inline d-flex gap-2">
            <input type="text" class="form-control flex-grow-1" name="search" placeholder="Search news..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </form>
    </div>
</section>

<!-- News -->
<section class="py-5">
    <div class="container">
        <?php if ($news_items): ?>
            <div class="row">
                <?php foreach ($news_items as $item): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <?php if ($item['featured_image']): ?>
                                <img src="<?php echo SITE_URL . 'uploads/' . $item['featured_image']; ?>" alt="<?php echo sanitize($item['title']); ?>" class="card-img-top">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <small class="text-muted"><i class="fas fa-calendar"></i> <?php echo humanDate($item['publication_date']); ?></small>
                                <?php if ($item['category']): ?>
                                    <small class="badge bg-primary mt-2" style="width: fit-content;"><?php echo sanitize($item['category']); ?></small>
                                <?php endif; ?>
                                <h5 class="card-title mt-3"><?php echo sanitize($item['title']); ?></h5>
                                <p class="card-text"><?php echo truncate($item['excerpt'] ?: $item['content'], 200); ?></p>
                                <div class="mt-auto">
                                    <a href="<?php echo SITE_URL; ?>news.php?id=<?php echo $item['id']; ?>" class="btn btn-primary btn-sm">Read More</a>
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
                                <a class="page-link" href="?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $category ? '&category=' . urlencode($category) : ''; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info">No news articles available at this time.</div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
