<?php
/**
 * Membership Page
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
        $mobile = sanitize($_POST['mobile'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $village = sanitize($_POST['village'] ?? '');
        $taluka = sanitize($_POST['taluka'] ?? '');
        $district = sanitize($_POST['district'] ?? '');
        $farmer_status = sanitize($_POST['farmer_status'] ?? '');
        $main_crop = sanitize($_POST['main_crop'] ?? '');
        $message_text = sanitize($_POST['message'] ?? '');
        
        if (!$name || !$mobile || !$email) {
            $error = 'Please fill all required fields';
        } elseif (!validateEmail($email)) {
            $error = 'Invalid email address';
        } elseif (!validatePhone($mobile)) {
            $error = 'Invalid mobile number';
        } else {
            $db->query('INSERT INTO membership_applications (name, mobile, email, village, taluka, district, farmer_status, main_crop, message) 
                       VALUES (:name, :mobile, :email, :village, :taluka, :district, :farmer_status, :main_crop, :message)');
            $db->bind(':name', $name);
            $db->bind(':mobile', $mobile);
            $db->bind(':email', $email);
            $db->bind(':village', $village);
            $db->bind(':taluka', $taluka);
            $db->bind(':district', $district);
            $db->bind(':farmer_status', $farmer_status);
            $db->bind(':main_crop', $main_crop);
            $db->bind(':message', $message_text);
            
            if ($db->execute()) {
                $message = 'Thank you! Your membership application has been received. We will contact you shortly.';
                logActivity('Create', 'Membership Application', 'New membership application from ' . $name);
            } else {
                $error = 'Failed to submit application. Please try again.';
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
            <li class="breadcrumb-item active">Membership</li>
        </ol>
    </nav>
</div>

<!-- Hero -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Become a Member</h1>
        <p class="section-subtitle">Join Panchalbhumi FPC and benefit from collective action</p>
    </div>
</section>

<!-- Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h2>Membership Benefits</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Collective marketing of agricultural produce</li>
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Access to quality inputs and services</li>
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Farmer training and capacity building</li>
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Market price linkage and information</li>
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Support for value addition</li>
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Access to government schemes</li>
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Professional advisory services</li>
                    <li class="list-group-item"><i class="fas fa-check text-success"></i> Community and network</li>
                </ul>
                
                <h3 class="mt-4">Who Can Join?</h3>
                <p><?php echo getSetting('membership_eligibility', 'Active farmers or farmer groups interested in collective marketing and agricultural development'); ?></p>
                
                <h3>Required Documents</h3>
                <ul>
                    <li>Government ID (Aadhaar/Pan)</li>
                    <li>Land ownership proof or lease agreement</li>
                    <li>Bank account details</li>
                    <li>Recent photograph</li>
                </ul>
            </div>
            
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
                        <h5 style="margin: 0;">Membership Application Form</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="needs-validation">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="10-digit number" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="village" class="form-label">Village</label>
                                <input type="text" class="form-control" id="village" name="village">
                            </div>
                            
                            <div class="mb-3">
                                <label for="taluka" class="form-label">Taluka</label>
                                <input type="text" class="form-control" id="taluka" name="taluka">
                            </div>
                            
                            <div class="mb-3">
                                <label for="district" class="form-label">District</label>
                                <input type="text" class="form-control" id="district" name="district">
                            </div>
                            
                            <div class="mb-3">
                                <label for="farmer_status" class="form-label">Farmer Status</label>
                                <select class="form-select" id="farmer_status" name="farmer_status">
                                    <option value="">-- Select --</option>
                                    <option value="Individual Farmer">Individual Farmer</option>
                                    <option value="Farmer Group Member">Farmer Group Member</option>
                                    <option value="FPO Member">FPO Member</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="main_crop" class="form-label">Main Crop</label>
                                <input type="text" class="form-control" id="main_crop" name="main_crop">
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Additional Message</label>
                                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Submit Application</button>
                        </form>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <small>We will review your application and contact you within 2-3 business days.</small>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
