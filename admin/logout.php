<?php
/**
 * Admin Logout
 */

require_once dirname(__FILE__) . '/../includes/auth.php';

$auth->logout();
header('Location: ' . ADMIN_URL . 'login.php');
exit;
