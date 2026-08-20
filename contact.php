<?php
/**
 * Contact Us Page
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Security token validation failed';
    } else {
        $name = sanitize($_POST['name'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $mobile = sanitize($_POST['mobile'] ?? '');
        $subject = sanitize($_POST['subject'] ?? '');
        $message_text = sanitize($_POST['message'] ?? '');
        
        if (!$name || !$email || !$subject || !$message_text) {
            $error = 'Please fill all required fields';
        } elseif (!validateEmail($email)) {
            $error = 'Invalid email address';
        } else {
            $db->query('INSERT INTO contact_enquiries (name, email, mobile, subject, message) 
                       VALUES (:name, :email, :mobile, :subject, :message)');
            $db->bind(':name', $name);
            $db->bind(':email', $email);
            $db->bind(':mobile', $mobile);
            $db->bind(':subject', $subject);
            $db->bind(':message', $message_text);
            
            if ($db->execute()) {
                $message = 'Thank you! Your message has been received. We will get back to you soon.';
                logActivity('Create', 'Contact Enquiry', 'New enquiry from ' . $name);
            } else {
                $error = 'Failed to submit message. Please try again.';
            }
        }
    }
}

?>

<!-- Breadcrumb -->
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
            <li class="breadcrumb-item active">Contact Us</li>
        </ol>
    </nav>
</div>

<!-- Hero -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Contact Us</h1>
        <p class="section-subtitle">Get in touch with Panchalbhumi FPC</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Information -->
            <div class="col-md-4 mb-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-map-marker-alt" style="font-size: 2rem; color: var(--primary-color);"></i>
                        <h5 class="card-title mt-3">Office Address</h5>
                        <p class="card-text">
                            <?php echo getSetting('office_address', 'To be updated'); ?><br>
                            <?php echo getSetting('office_city', ''); ?>, <?php echo getSetting('office_state', ''); ?> <?php echo getSetting('office_pin', ''); ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-phone" style="font-size: 2rem; color: var(--primary-color);"></i>
                        <h5 class="card-title mt-3">Phone & WhatsApp</h5>
                        <p class="card-text">
                            <a href="tel:<?php echo getSetting('office_phone'); ?>" class="text-decoration-none">
                                <?php echo getSetting('office_phone', 'To be updated'); ?>
                            </a><br>
                            <?php if (getSetting('office_whatsapp')): ?>
                                <a href="https://wa.me/<?php echo str_replace([' ', '-', '+'], '', getSetting('office_whatsapp')); ?>" class="text-decoration-none" target="_blank">
                                    WhatsApp
                                </a>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope" style="font-size: 2rem; color: var(--primary-color);"></i>
                        <h5 class="card-title mt-3">Email</h5>
                        <p class="card-text">
                            <a href="mailto:<?php echo getSetting('office_email'); ?>" class="text-decoration-none">
                                <?php echo getSetting('office_email', 'To be updated'); ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <!-- Google Maps -->
            <div class="col-md-6 mb-4">
                <?php if (getSetting('google_maps_url')): ?>
                    <div class="ratio ratio-4x3">
                        <iframe src="<?php echo getSetting('google_maps_url'); ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">Location map will be updated soon.</div>
                <?php endif; ?>
            </div>
            
            <!-- Contact Form -->
            <div class="col-md-6">
                <?php if ($message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 style="margin: 0;">Send us a Message</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="needs-validation">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="10-digit number">
                            </div>
                            
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
