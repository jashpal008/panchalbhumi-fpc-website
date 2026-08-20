-- Panchalbhumi Farmers Producer Company Limited - Database Schema
-- MySQL 8.0+

SET FOREIGN_KEY_CHECKS=0;
DROP DATABASE IF EXISTS panchalbhumi_fpc;
CREATE DATABASE panchalbhumi_fpc DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE panchalbhumi_fpc;
SET FOREIGN_KEY_CHECKS=1;

-- =====================
-- USERS AND ROLES
-- =====================

CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO roles (name, description) VALUES
('Super Admin', 'Full system access'),
('Admin', 'Administrative access'),
('Editor', 'Content and media editing'),
('Viewer', 'Read-only access');

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    active TINYINT DEFAULT 1,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id),
    INDEX idx_email (email),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- WEBSITE SETTINGS
-- =====================

CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    `key` VARCHAR(100) UNIQUE NOT NULL,
    `value` LONGTEXT,
    `type` VARCHAR(50) DEFAULT 'text',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO settings (`key`, `value`, `type`) VALUES
('site_name', 'Panchalbhumi Farmers Producer Company Limited', 'text'),
('site_short_name', 'Panchalbhumi FPC', 'text'),
('site_tagline', 'Empowering Farmers Through Collective Action', 'text'),
('primary_color', '#1b5e20', 'color'),
('secondary_color', '#4caf50', 'color'),
('accent_color', '#ffa500', 'color'),
('logo', '', 'media'),
('favicon', '', 'media'),
('office_address', 'To be updated', 'text'),
('office_city', 'To be updated', 'text'),
('office_state', 'To be updated', 'text'),
('office_pin', 'To be updated', 'text'),
('office_phone', 'To be updated', 'text'),
('office_email', 'To be updated', 'text'),
('office_whatsapp', '', 'text'),
('office_timings', 'To be updated', 'text'),
('google_maps_url', '', 'text'),
('google_analytics_id', '', 'text'),
('google_search_console', '', 'text'),
('facebook_url', '', 'text'),
('instagram_url', '', 'text'),
('linkedin_url', '', 'text'),
('youtube_url', '', 'text'),
('whatsapp_enabled', '1', 'boolean'),
('terms_content', 'To be updated', 'textarea'),
('privacy_content', 'To be updated', 'textarea'),
('disclaimer_content', 'To be updated', 'textarea');

-- =====================
-- PAGES AND MENU
-- =====================

CREATE TABLE menus (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    url VARCHAR(255),
    parent_id INT,
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES menus(id),
    INDEX idx_display_order (display_order),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO menus (title, url, parent_id, display_order, active) VALUES
('Home', '/', NULL, 1, 1),
('About Us', NULL, NULL, 2, 1),
('About Us', '/about.php', 2, 1, 1),
('Vision & Mission', '/vision-mission.php', 2, 2, 1),
('Board of Directors', '/board.php', 2, 3, 1),
('Management Team', '/management.php', 2, 4, 1),
('Our Farmers', '/farmers.php', 2, 5, 1),
('Products & Services', NULL, NULL, 3, 1),
('Our Products', '/products.php', 8, 1, 1),
('Our Services', '/services.php', 8, 2, 1),
('Activities', '/activities.php', NULL, 4, 1),
('Membership', '/membership.php', NULL, 5, 1),
('Success Stories', '/success-stories.php', NULL, 6, 1),
('News & Events', '/news.php', NULL, 7, 1),
('Gallery', '/gallery.php', NULL, 8, 1),
('Resources', NULL, NULL, 9, 1),
('Reports & Transparency', '/reports.php', 15, 1, 1),
('Government Schemes', '/schemes.php', 15, 2, 1),
('Careers', '/careers.php', 15, 3, 1),
('Contact Us', '/contact.php', NULL, 10, 1);

CREATE TABLE pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT,
    featured_image VARCHAR(255),
    seo_title VARCHAR(255),
    seo_description VARCHAR(500),
    seo_keywords VARCHAR(255),
    og_title VARCHAR(255),
    og_description VARCHAR(500),
    og_image VARCHAR(255),
    active TINYINT DEFAULT 1,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (slug) REFERENCES menus(url),
    UNIQUE INDEX idx_slug (slug),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- HERO SLIDERS
-- =====================

CREATE TABLE hero_sliders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    image VARCHAR(255),
    button_1_text VARCHAR(100),
    button_1_url VARCHAR(255),
    button_2_text VARCHAR(100),
    button_2_url VARCHAR(255),
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_display_order (display_order),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO hero_sliders (title, subtitle, button_1_text, button_1_url, button_2_text, button_2_url, display_order, active) VALUES
('Empowering Farmers Through Collective Action', 'Panchalbhumi Farmers Producer Company Limited', 'Know About Us', '/about.php', 'Explore Products', '/products.php', 1, 1);

-- =====================
-- STATISTICS
-- =====================

CREATE TABLE statistics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    number INT DEFAULT 0,
    unit VARCHAR(50),
    icon VARCHAR(100),
    description TEXT,
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_display_order (display_order),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO statistics (title, number, unit, icon, description, display_order, active) VALUES
('Farmer Members', 0, '', 'fas fa-users', 'Active farmer members', 1, 1),
('Villages Covered', 0, '', 'fas fa-map-marker-alt', 'Villages under operation', 2, 1),
('Products', 0, '', 'fas fa-box', 'Active products', 3, 1),
('Activities', 0, '', 'fas fa-tasks', 'Training and activities', 4, 1);

-- =====================
-- DIRECTORS
-- =====================

CREATE TABLE directors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    designation VARCHAR(100) NOT NULL,
    photo VARCHAR(255),
    village VARCHAR(100),
    biography TEXT,
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_display_order (display_order),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- MANAGEMENT TEAM
-- =====================

CREATE TABLE management (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    designation VARCHAR(100) NOT NULL,
    photo VARCHAR(255),
    qualification VARCHAR(255),
    experience TEXT,
    email VARCHAR(100),
    biography TEXT,
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_display_order (display_order),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- MEMBERS / FARMERS
-- =====================

CREATE TABLE members (
    id INT PRIMARY KEY AUTO_INCREMENT,
    member_code VARCHAR(50) UNIQUE,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female', 'Other'),
    village VARCHAR(100),
    taluka VARCHAR(100),
    district VARCHAR(100),
    crop_category VARCHAR(100),
    shareholding DECIMAL(10,2) DEFAULT 0,
    membership_date DATE,
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_village (village),
    INDEX idx_district (district)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- MEMBERSHIP APPLICATIONS
-- =====================

CREATE TABLE membership_applications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    village VARCHAR(100),
    taluka VARCHAR(100),
    district VARCHAR(100),
    farmer_status VARCHAR(50),
    main_crop VARCHAR(100),
    message TEXT,
    status ENUM('New', 'Contacted', 'Processed', 'Rejected') DEFAULT 'New',
    contacted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- PRODUCT CATEGORIES
-- =====================

CREATE TABLE product_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) UNIQUE,
    description TEXT,
    image VARCHAR(255),
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_display_order (display_order),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO product_categories (name, slug, description, display_order, active) VALUES
('Vegetables', 'vegetables', 'Fresh vegetables from our farmers', 1, 1),
('Cereals & Pulses', 'cereals-pulses', 'Grains and pulses', 2, 1),
('Spices', 'spices', 'Traditional spices', 3, 1),
('Fruits', 'fruits', 'Fresh fruits', 4, 1),
('Value Added', 'value-added', 'Processed and value-added products', 5, 1);

-- =====================
-- PRODUCTS
-- =====================

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    category_id INT NOT NULL,
    description TEXT,
    detailed_description LONGTEXT,
    image VARCHAR(255),
    unit VARCHAR(50),
    availability VARCHAR(100),
    production_season VARCHAR(100),
    natural_farming TINYINT DEFAULT 0,
    organic_certified TINYINT DEFAULT 0,
    packaging_info TEXT,
    minimum_order_quantity VARCHAR(100),
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES product_categories(id),
    INDEX idx_category_id (category_id),
    INDEX idx_active (active),
    INDEX idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- SERVICES
-- =====================

CREATE TABLE services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    category VARCHAR(100),
    description TEXT,
    detailed_description LONGTEXT,
    image VARCHAR(255),
    icon VARCHAR(100),
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active (active),
    INDEX idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- ACTIVITIES
-- =====================

CREATE TABLE activities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    activity_date DATE NOT NULL,
    location VARCHAR(255),
    category VARCHAR(100),
    description TEXT,
    detailed_description LONGTEXT,
    participants_count INT DEFAULT 0,
    organizer VARCHAR(255),
    featured_image VARCHAR(255),
    status ENUM('Planned', 'Ongoing', 'Completed', 'Cancelled') DEFAULT 'Completed',
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_activity_date (activity_date),
    INDEX idx_category (category),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- ACTIVITY GALLERY
-- =====================

CREATE TABLE activity_gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    activity_id INT NOT NULL,
    image VARCHAR(255),
    caption VARCHAR(255),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE,
    INDEX idx_activity_id (activity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- ACTIVITY DOCUMENTS
-- =====================

CREATE TABLE activity_documents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    activity_id INT NOT NULL,
    title VARCHAR(255),
    file VARCHAR(255),
    file_type VARCHAR(50),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE,
    INDEX idx_activity_id (activity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- SUCCESS STORIES
-- =====================

CREATE TABLE success_stories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    farmer_name VARCHAR(100) NOT NULL,
    village VARCHAR(100),
    crop_activity VARCHAR(100),
    title VARCHAR(255) NOT NULL,
    story TEXT NOT NULL,
    result_impact TEXT,
    photo VARCHAR(255),
    story_date DATE,
    approved TINYINT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_approved (approved),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- NEWS / ARTICLES
-- =====================

CREATE TABLE news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    excerpt VARCHAR(500),
    content LONGTEXT NOT NULL,
    featured_image VARCHAR(255),
    category VARCHAR(100),
    author_id INT,
    publication_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    seo_title VARCHAR(255),
    seo_description VARCHAR(500),
    seo_keywords VARCHAR(255),
    og_title VARCHAR(255),
    og_description VARCHAR(500),
    og_image VARCHAR(255),
    views INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id),
    INDEX idx_publication_date (publication_date),
    INDEX idx_active (active),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- GALLERY ALBUMS
-- =====================

CREATE TABLE gallery_albums (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    cover_image VARCHAR(255),
    category VARCHAR(100),
    event_date DATE,
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_display_order (display_order),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- GALLERY IMAGES
-- =====================

CREATE TABLE gallery_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    album_id INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    alt_text VARCHAR(255),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (album_id) REFERENCES gallery_albums(id) ON DELETE CASCADE,
    INDEX idx_album_id (album_id),
    INDEX idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- VIDEOS
-- =====================

CREATE TABLE videos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    video_url VARCHAR(500),
    thumbnail VARCHAR(255),
    category VARCHAR(100),
    video_date DATE,
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active (active),
    INDEX idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- DOCUMENTS / REPORTS
-- =====================

CREATE TABLE documents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    financial_year VARCHAR(10),
    description TEXT,
    file VARCHAR(255),
    file_size INT,
    file_type VARCHAR(50),
    public_access TINYINT DEFAULT 1,
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_public_access (public_access),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- GOVERNMENT SCHEMES
-- =====================

CREATE TABLE schemes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    scheme_name VARCHAR(255) NOT NULL,
    department_agency VARCHAR(255),
    description TEXT,
    panchalbhumi_role TEXT,
    farmer_benefit TEXT,
    eligibility TEXT,
    scheme_url VARCHAR(500),
    display_order INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active (active),
    INDEX idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- JOBS / CAREERS
-- =====================

CREATE TABLE jobs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    location VARCHAR(255),
    qualification VARCHAR(255),
    experience VARCHAR(255),
    salary_info VARCHAR(255),
    job_description TEXT,
    responsibilities TEXT,
    last_date DATE,
    application_email VARCHAR(100),
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- JOB APPLICATIONS
-- =====================

CREATE TABLE job_applications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    job_id INT NOT NULL,
    applicant_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    mobile VARCHAR(20),
    qualification VARCHAR(255),
    experience VARCHAR(255),
    resume VARCHAR(255),
    cover_letter TEXT,
    status ENUM('New', 'Reviewed', 'Shortlisted', 'Rejected') DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    INDEX idx_job_id (job_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- CONTACT ENQUIRIES
-- =====================

CREATE TABLE contact_enquiries (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    mobile VARCHAR(20),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('New', 'In Progress', 'Contacted', 'Resolved', 'Spam') DEFAULT 'New',
    notes TEXT,
    contacted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- PRODUCT ENQUIRIES
-- =====================

CREATE TABLE product_enquiries (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    buyer_name VARCHAR(100) NOT NULL,
    company_name VARCHAR(255),
    email VARCHAR(100),
    mobile VARCHAR(20),
    quantity_required VARCHAR(100),
    location VARCHAR(255),
    message TEXT,
    status ENUM('New', 'In Progress', 'Contacted', 'Resolved') DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_id (product_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- MEDIA / UPLOADS
-- =====================

CREATE TABLE media (
    id INT PRIMARY KEY AUTO_INCREMENT,
    filename VARCHAR(255) NOT NULL,
    original_filename VARCHAR(255),
    file_path VARCHAR(255),
    file_type VARCHAR(50),
    file_size INT,
    mime_type VARCHAR(100),
    uploaded_by INT,
    alt_text VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id),
    INDEX idx_file_type (file_type),
    INDEX idx_uploaded_by (uploaded_by)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- SEO METADATA
-- =====================

CREATE TABLE seo_meta (
    id INT PRIMARY KEY AUTO_INCREMENT,
    page_url VARCHAR(255) UNIQUE NOT NULL,
    meta_title VARCHAR(255),
    meta_description VARCHAR(500),
    meta_keywords VARCHAR(255),
    og_title VARCHAR(255),
    og_description VARCHAR(500),
    og_image VARCHAR(255),
    canonical_url VARCHAR(255),
    robots VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_page_url (page_url)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- ACTIVITY LOGS
-- =====================

CREATE TABLE activity_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(100),
    module VARCHAR(100),
    description TEXT,
    ip_address VARCHAR(45),
    user_agent VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at),
    INDEX idx_action (action)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- LANGUAGE / TRANSLATION SUPPORT
-- =====================

CREATE TABLE languages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(50),
    native_name VARCHAR(50),
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO languages (code, name, native_name, active) VALUES
('en', 'English', 'English', 1),
('gu', 'Gujarati', 'ગુજરાતી', 0),
('hi', 'Hindi', 'हिन्दी', 0);

CREATE TABLE translations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    language_id INT NOT NULL,
    translation_key VARCHAR(255) NOT NULL,
    translation_value LONGTEXT,
    module VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (language_id) REFERENCES languages(id),
    UNIQUE KEY unique_translation (language_id, translation_key),
    INDEX idx_language_id (language_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create default indexes
CREATE INDEX idx_created_at ON users(created_at);
CREATE INDEX idx_created_at ON members(created_at);
CREATE INDEX idx_created_at ON products(created_at);
CREATE INDEX idx_created_at ON news(created_at);
CREATE INDEX idx_created_at ON activities(created_at);

COMMIT;