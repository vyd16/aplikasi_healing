-- ============================================
-- HealPoint Database
-- Generated for MySQL 5.7+ / MariaDB 10.3+
-- Import: mysql -u root -p < db/healing.sql
-- Or via phpMyAdmin: Import this file
-- ============================================

CREATE DATABASE IF NOT EXISTS `healing_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `healing_db`;

-- ============================================
-- Table: users
-- ============================================
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `itinerary_items`;
DROP TABLE IF EXISTS `itineraries`;
DROP TABLE IF EXISTS `media`;
DROP TABLE IF EXISTS `favorites`;
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `locations`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
    `remember_token` VARCHAR(100) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: password_reset_tokens
-- ============================================
CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL PRIMARY KEY,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: sessions
-- ============================================
CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `ip_address` VARCHAR(45) NULL DEFAULT NULL,
    `user_agent` TEXT NULL DEFAULT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: cache
-- ============================================
CREATE TABLE `cache` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: jobs (Laravel queue)
-- ============================================
CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL DEFAULT NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `uuid` VARCHAR(255) NOT NULL,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL,
    `cancelled_at` INT NULL DEFAULT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: locations
-- ============================================
CREATE TABLE `locations` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `category` VARCHAR(255) NOT NULL,
    `latitude` DECIMAL(10, 7) NOT NULL,
    `longitude` DECIMAL(10, 7) NOT NULL,
    `address` VARCHAR(255) NULL DEFAULT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `rating` FLOAT NOT NULL DEFAULT 0,
    `status` ENUM('pending', 'approved') NOT NULL DEFAULT 'pending',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: reviews
-- ============================================
CREATE TABLE `reviews` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `location_id` BIGINT UNSIGNED NOT NULL,
    `rating` TINYINT UNSIGNED NOT NULL COMMENT '1-5 star rating',
    `comment` TEXT NULL DEFAULT NULL,
    `photo_path` VARCHAR(255) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `reviews_user_id_foreign` (`user_id`),
    KEY `reviews_location_id_foreign` (`location_id`),
    CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `reviews_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: favorites
-- ============================================
CREATE TABLE `favorites` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `location_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `favorites_user_id_foreign` (`user_id`),
    KEY `favorites_location_id_foreign` (`location_id`),
    CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `favorites_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: itineraries
-- ============================================
CREATE TABLE `itineraries` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `itineraries_user_id_foreign` (`user_id`),
    CONSTRAINT `itineraries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: itinerary_items
-- ============================================
CREATE TABLE `itinerary_items` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `itinerary_id` BIGINT UNSIGNED NOT NULL,
    `location_id` BIGINT UNSIGNED NOT NULL,
    `day_number` INT UNSIGNED NOT NULL,
    `order` INT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `itinerary_items_itinerary_id_foreign` (`itinerary_id`),
    KEY `itinerary_items_location_id_foreign` (`location_id`),
    CONSTRAINT `itinerary_items_itinerary_id_foreign` FOREIGN KEY (`itinerary_id`) REFERENCES `itineraries` (`id`) ON DELETE CASCADE,
    CONSTRAINT `itinerary_items_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: media (polymorphic)
-- ============================================
CREATE TABLE `media` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `mediable_type` VARCHAR(255) NOT NULL,
    `mediable_id` BIGINT UNSIGNED NOT NULL,
    `type` ENUM('photo', 'video') NOT NULL,
    `path` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `media_mediable_type_mediable_id_index` (`mediable_type`, `mediable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: notifications
-- ============================================
CREATE TABLE `notifications` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `data` JSON NOT NULL,
    `read_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `notifications_user_id_foreign` (`user_id`),
    CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: migrations (Laravel internal)
-- ============================================
CREATE TABLE `migrations` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2024_01_01_000001_create_locations_table', 1),
('2024_01_01_000002_create_reviews_table', 1),
('2024_01_01_000003_create_favorites_table', 1),
('2024_01_01_000004_create_itineraries_table', 1),
('2024_01_01_000005_create_itinerary_items_table', 1),
('2024_01_01_000006_create_media_table', 1),
('2024_01_01_000007_create_notifications_table', 1);


-- ============================================
-- SEED DATA
-- ============================================

-- Password: password123 (bcrypt hash)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'Admin HealPoint', 'admin@healpoint.id', '$2y$12$LJ3a5FhYh7UVXbGx5.AO9u1fE6tMVTxGpYGqcN8kVqJZ9HXWG/XuC', 1, NOW(), NOW()),
(2, 'Pengguna Demo', 'demo@healpoint.id', '$2y$12$LJ3a5FhYh7UVXbGx5.AO9u1fE6tMVTxGpYGqcN8kVqJZ9HXWG/XuC', 0, NOW(), NOW());

-- === CIREBON ===
INSERT INTO `locations` (`id`, `name`, `category`, `latitude`, `longitude`, `address`, `description`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Taman Sari Gua Sunyaragi', 'Alam', -6.7362000, 108.5513000, 'Sunyaragi, Kesambi, Kota Cirebon', 'Taman bersejarah dengan gua-gua buatan dan taman yang asri, cocok untuk meditasi dan menenangkan pikiran. Dibangun pada abad ke-14 sebagai tempat peristirahatan sultan.', 4.3, 'approved', NOW(), NOW()),
(2, 'Pantai Kejawanan', 'Pantai', -6.6977000, 108.5584000, 'Pegambiran, Lemahwungkuk, Kota Cirebon', 'Pantai yang tenang dengan pemandangan laut Jawa, sempurna untuk menikmati sunset sambil melepas penat. Terdapat area duduk dan warung seafood segar.', 4.0, 'approved', NOW(), NOW()),
(3, 'Situ Sedong', 'Alam', -6.8120000, 108.4830000, 'Sedong, Kabupaten Cirebon', 'Danau buatan yang dikelilingi pepohonan hijau, ideal untuk memancing, piknik, atau sekadar duduk menikmati ketenangan alam.', 4.1, 'approved', NOW(), NOW()),
(4, 'Taman Wisata Gronggong', 'Alam', -6.7890000, 108.5120000, 'Gronggong, Kapetakan, Kabupaten Cirebon', 'Kawasan wisata alam dengan view kota Cirebon dari ketinggian. Udara sejuk dan banyak warung makan khas Cirebon. Ideal untuk healing sore hari.', 4.4, 'approved', NOW(), NOW()),

-- === MAJALENGKA ===
(5, 'Tebing Gunung Hawu', 'Gunung', -6.8530000, 108.2720000, 'Argamukti, Argapura, Majalengka', 'Tebing batu dengan pemandangan alam spektakuler dan udara pegunungan yang segar. Cocok untuk pendaki pemula yang ingin menikmati ketenangan di ketinggian.', 4.6, 'approved', NOW(), NOW()),
(6, 'Curug Muara Jaya', 'Air Terjun', -6.8910000, 108.2350000, 'Argamukti, Argapura, Majalengka', 'Air terjun setinggi 75 meter yang tersembunyi di tengah hutan. Suara gemuruh air dan udara sejuk menciptakan suasana healing yang sempurna.', 4.7, 'approved', NOW(), NOW()),
(7, 'Situ Sangiang', 'Alam', -6.8350000, 108.3460000, 'Sangiang, Banjaran, Majalengka', 'Danau alami yang tenang dikelilingi perbukitan hijau. Tempat ini cocok untuk camping, piknik keluarga, atau sekadar menikmati udara segar.', 4.2, 'approved', NOW(), NOW()),
(8, 'Puncak Batu Tilu', 'Gunung', -6.8780000, 108.2580000, 'Leuwimunding, Majalengka', 'Puncak dengan tiga batu besar yang menawarkan panorama alam luas. Spot favorit untuk sunrise sekaligus tempat meditasi alam terbuka.', 4.5, 'approved', NOW(), NOW()),

-- === KUNINGAN ===
(9, 'Telaga Remis', 'Alam', -6.9495000, 108.3845000, 'Kaduela, Pasawahan, Kuningan', 'Danau alami di kaki Gunung Ciremai dengan air jernih kebiruan. Dikelilingi hutan pinus yang sejuk, sempurna untuk healing dan foto estetik.', 4.8, 'approved', NOW(), NOW()),
(10, 'Curug Landung', 'Air Terjun', -6.9670000, 108.3590000, 'Pasawahan, Kuningan', 'Air terjun bertingkat dengan kolam alami yang cocok untuk berendam. Suasananya sangat tenang karena tersembunyi di dalam hutan lindung Gunung Ciremai.', 4.5, 'approved', NOW(), NOW()),
(11, 'Taman Nasional Gunung Ciremai', 'Gunung', -6.8920000, 108.3050000, 'Linggarjati, Cilimus, Kuningan', 'Taman nasional yang melindungi gunung tertinggi di Jawa Barat. Terdapat jalur trekking, camping ground, dan mata air alami yang menyejukkan.', 4.9, 'approved', NOW(), NOW()),
(12, 'Waduk Darma', 'Alam', -6.8700000, 108.4690000, 'Darma, Kuningan', 'Waduk besar dengan pemandangan Gunung Ciremai sebagai latar belakang. Tersedia perahu, area memancing, dan gazebo untuk bersantai.', 4.3, 'approved', NOW(), NOW()),
(13, 'Buper Palutungan', 'Alam', -6.9150000, 108.3500000, 'Cisantana, Cigugur, Kuningan', 'Bumi perkemahan di lereng Gunung Ciremai dengan udara sangat sejuk. Dilengkapi fasilitas camping, toilet, dan musholla. Ideal untuk healing bersama keluarga.', 4.6, 'approved', NOW(), NOW()),
(14, 'Kolam Renang Sangkanurip', 'Alam', -6.8580000, 108.4280000, 'Sangkanurip, Kuningan', 'Kolam renang alami dengan air dari mata air pegunungan yang segar dan jernih. Tempat ini populer untuk relaksasi dan berenang santai.', 4.1, 'approved', NOW(), NOW()),
(15, 'Curug Putri', 'Air Terjun', -6.9430000, 108.3680000, 'Pasawahan, Kuningan', 'Air terjun cantik yang konon menjadi tempat mandi putri kerajaan. Air terjun ini relatif mudah dijangkau dan sangat fotogenik.', 4.4, 'approved', NOW(), NOW());

-- ============================================
-- Done! Database ready.
-- ============================================
