<?php
/**
 * Product Detail Page
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: ' . SITE_URL . 'products.php');
    exit;
}

$product_id = (int)$_GET['id'];

$db->query('SELECT p.*, c.name as category_name FROM products p 
           LEFT JOIN product_categories c ON p.category_id = c.id 
           WHERE p.id = :id AND p.active = 1 LIMIT 1');
$db->bind(':id', $product_id);
$product = $db->getSingle();

if (!$product) {
    header('Location: ' . SITE_URL . 'products.php');
    exit;
}

?>

<!-- Breadcrumb -->
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>products.php">Products</a></li>
            <li class="breadcrumb-item active"><?php echo sanitize($product['name']); ?></li>
        </ol>
    </nav>
</div>

<!-- Product Detail -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <img src="<?php echo SITE_URL . 'uploads/' . $product['image']; ?>" alt="<?php echo sanitize($product['name']); ?>" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h1><?php echo sanitize($product['name']); ?></h1>
                <p class="text-muted mb-3">
                    <a href="<?php echo SITE_URL; ?>products.php?category=<?php echo $product['category_id']; ?>" class="text-primary">
                        <?php echo sanitize($product['category_name']); ?>
                    </a>
                </p>
                
                <div class="mb-4">
                    <?php if ($product['natural_farming']): ?>
                        <span class="badge bg-success me-2"><i class="fas fa-leaf"></i> Natural Farming</span>
                    <?php endif; ?>
                    <?php if ($product['organic_certified']): ?>
                        <span class="badge bg-success"><i class="fas fa-certificate"></i> Organic Certified</span>
                    <?php endif; ?>
                </div>
                
                <h3>Description</h3>
                <p><?php echo $product['description']; ?></p>
                
                <?php if ($product['detailed_description']): ?>
                    <h4>Details</h4>
                    <p><?php echo $product['detailed_description']; ?></p>
                <?php endif; ?>
                
                <table class="table table-sm">
                    <tr>
                        <th>Unit</th>
                        <td><?php echo sanitize($product['unit']); ?></td>
                    </tr>
                    <tr>
                        <th>Availability</th>
                        <td><?php echo sanitize($product['availability']); ?></td>
                    </tr>
                    <tr>
                        <th>Production Season</th>
                        <td><?php echo sanitize($product['production_season']); ?></td>
                    </tr>
                    <tr>
                        <th>Minimum Order</th>
                        <td><?php echo sanitize($product['minimum_order_quantity']); ?></td>
                    </tr>
                    <?php if ($product['packaging_info']): ?>
                        <tr>
                            <th>Packaging</th>
                            <td><?php echo sanitize($product['packaging_info']); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
                
                <h4 class="mt-4">Interested in Buying?</h4>
                <p>Send us an enquiry and we'll get back to you with pricing and availability.</p>
                <a href="<?php echo SITE_URL; ?>contact.php?product=<?php echo $product_id; ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-envelope"></i> Send Enquiry
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php
$db->query('SELECT * FROM products WHERE active = 1 AND id != :id AND category_id = :category_id ORDER BY display_order LIMIT 3');
$db->bind(':id', $product_id);
$db->bind(':category_id', $product['category_id']);
$related = $db->getResult();

if ($related):
?>
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Related Products</h2>
            <div class="row">
                <?php foreach ($related as $rel_product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo SITE_URL . 'uploads/' . $rel_product['image']; ?>" alt="<?php echo sanitize($rel_product['name']); ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo sanitize($rel_product['name']); ?></h5>
                                <p class="card-text"><?php echo truncate($rel_product['description'], 100); ?></p>
                                <a href="<?php echo SITE_URL; ?>product.php?id=<?php echo $rel_product['id']; ?>" class="btn btn-primary btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
