<?php
/**
 * Products Page
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

// Get categories
$db->query('SELECT * FROM product_categories WHERE active = 1 ORDER BY display_order');
$categories = $db->getResult();

// Get selected category
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Get products count
if ($category_id) {
    $db->query('SELECT COUNT(*) as count FROM products WHERE active = 1 AND category_id = :category_id');
    $db->bind(':category_id', $category_id);
} else {
    $db->query('SELECT COUNT(*) as count FROM products WHERE active = 1');
}
$count_result = $db->getSingle();
$total_items = $count_result['count'];

$pagination = getPagination($total_items, ITEMS_PER_PAGE, $page);

// Get products
if ($category_id) {
    $db->query('SELECT * FROM products WHERE active = 1 AND category_id = :category_id ORDER BY display_order LIMIT :limit OFFSET :offset');
    $db->bind(':category_id', $category_id);
} else {
    $db->query('SELECT * FROM products WHERE active = 1 ORDER BY display_order LIMIT :limit OFFSET :offset');
}
$db->bind(':limit', ITEMS_PER_PAGE, PDO::PARAM_INT);
$db->bind(':offset', $pagination['offset'], PDO::PARAM_INT);
$products = $db->getResult();

?>

<!-- Breadcrumb -->
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </nav>
</div>

<!-- Hero -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Our Products</h1>
        <p class="section-subtitle">Quality produce from our farmer members</p>
    </div>
</section>

<!-- Products -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                <h5>Categories</h5>
                <div class="list-group">
                    <a href="<?php echo SITE_URL; ?>products.php" class="list-group-item list-group-item-action <?php echo $category_id == 0 ? 'active' : ''; ?>">
                        All Products
                    </a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="<?php echo SITE_URL; ?>products.php?category=<?php echo $cat['id']; ?>" class="list-group-item list-group-item-action <?php echo $category_id == $cat['id'] ? 'active' : ''; ?>">
                            <?php echo sanitize($cat['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="col-md-9">
                <?php if ($products): ?>
                    <div class="row">
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <img src="<?php echo SITE_URL . 'uploads/' . $product['image']; ?>" alt="<?php echo sanitize($product['name']); ?>" class="card-img-top">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?php echo sanitize($product['name']); ?></h5>
                                        <p class="card-text"><?php echo truncate($product['description'], 150); ?></p>
                                        
                                        <?php if ($product['natural_farming']): ?>
                                            <small class="text-success"><i class="fas fa-check-circle"></i> Natural Farming Produce</small>
                                        <?php endif; ?>
                                        
                                        <div class="mt-auto">
                                            <a href="<?php echo SITE_URL; ?>product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm">View Details</a>
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
                                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo $category_id ? '&category=' . $category_id : ''; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">No products available at this time.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
