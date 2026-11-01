-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 01, 2026 at 05:18 PM
-- Server version: 13.0.2-MariaDB
-- PHP Version: 8.3.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `softpolli`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'created', 'App\\Models\\Category', 'created', 1, NULL, NULL, '{\"attributes\":{\"id\":1,\"name\":\"Enterprise Architecture\",\"slug\":\"enterprise-architecture\",\"type\":\"service\",\"icon\":\"fa-solid fa-sitemap\",\"description\":null,\"sort_order\":1,\"is_active\":true,\"created_at\":\"2026-10-23T17:11:44.000000Z\",\"updated_at\":\"2026-10-23T17:11:44.000000Z\"}}', NULL, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(2, 'default', 'created', 'App\\Models\\Category', 'created', 2, NULL, NULL, '{\"attributes\":{\"id\":2,\"name\":\"Web Engineering\",\"slug\":\"web-engineering\",\"type\":\"service\",\"icon\":\"fa-solid fa-code\",\"description\":null,\"sort_order\":2,\"is_active\":true,\"created_at\":\"2026-10-23T17:11:44.000000Z\",\"updated_at\":\"2026-10-23T17:11:44.000000Z\"}}', NULL, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(3, 'default', 'created', 'App\\Models\\Category', 'created', 3, NULL, NULL, '{\"attributes\":{\"id\":3,\"name\":\"Growth & Funnels\",\"slug\":\"growth-funnels\",\"type\":\"service\",\"icon\":\"fa-solid fa-chart-line\",\"description\":null,\"sort_order\":3,\"is_active\":true,\"created_at\":\"2026-10-23T17:11:44.000000Z\",\"updated_at\":\"2026-10-23T17:11:44.000000Z\"}}', NULL, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(4, 'default', 'created', 'App\\Models\\Category', 'created', 4, NULL, NULL, '{\"attributes\":{\"id\":4,\"name\":\"Security & DevSecOps\",\"slug\":\"security-devsecops\",\"type\":\"service\",\"icon\":\"fa-solid fa-shield-halved\",\"description\":null,\"sort_order\":4,\"is_active\":true,\"created_at\":\"2026-10-23T17:11:44.000000Z\",\"updated_at\":\"2026-10-23T17:11:44.000000Z\"}}', NULL, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(5, 'default', 'created', 'App\\Models\\Category', 'created', 5, NULL, NULL, '{\"attributes\":{\"id\":5,\"name\":\"iOS & Android\",\"slug\":\"ios-android\",\"type\":\"service\",\"icon\":\"fa-solid fa-mobile-screen-button\",\"description\":null,\"sort_order\":5,\"is_active\":true,\"created_at\":\"2026-10-23T17:11:44.000000Z\",\"updated_at\":\"2026-10-23T17:11:44.000000Z\"}}', NULL, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(6, 'default', 'created', 'App\\Models\\Category', 'created', 6, NULL, NULL, '{\"attributes\":{\"id\":6,\"name\":\"Cloud & DevOps\",\"slug\":\"cloud-devops\",\"type\":\"service\",\"icon\":\"fa-solid fa-cloud\",\"description\":null,\"sort_order\":6,\"is_active\":true,\"created_at\":\"2026-10-23T17:11:44.000000Z\",\"updated_at\":\"2026-10-23T17:11:44.000000Z\"}}', NULL, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(7, 'default', 'created', 'App\\Models\\Category', 'created', 7, NULL, NULL, '{\"attributes\":{\"id\":7,\"name\":\"Search Optimization\",\"slug\":\"search-optimization\",\"type\":\"service\",\"icon\":\"fa-solid fa-magnifying-glass-chart\",\"description\":null,\"sort_order\":7,\"is_active\":true,\"created_at\":\"2026-10-23T17:11:44.000000Z\",\"updated_at\":\"2026-10-23T17:11:44.000000Z\"}}', NULL, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(8, 'default', 'created', 'App\\Models\\Category', 'created', 8, NULL, NULL, '{\"attributes\":{\"id\":8,\"name\":\"UI\\/UX & Product Design\",\"slug\":\"uiux-product-design\",\"type\":\"service\",\"icon\":\"fa-solid fa-palette\",\"description\":null,\"sort_order\":8,\"is_active\":true,\"created_at\":\"2026-10-23T17:11:44.000000Z\",\"updated_at\":\"2026-10-23T17:11:44.000000Z\"}}', NULL, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(9, 'default', 'created', 'App\\Models\\Category', 'created', 9, NULL, NULL, '{\"attributes\":{\"id\":9,\"name\":\"Custom Software\",\"slug\":\"custom-software\",\"type\":\"service\",\"icon\":\"fa-solid fa-laptop-code\",\"description\":null,\"sort_order\":9,\"is_active\":true,\"created_at\":\"2026-10-23T17:11:44.000000Z\",\"updated_at\":\"2026-10-23T17:11:44.000000Z\"}}', NULL, '2026-10-23 11:11:44', '2026-10-23 11:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `read_time` varchar(255) NOT NULL DEFAULT '5 min read',
  `date` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `category`, `read_time`, `date`, `excerpt`, `image`, `author`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 'Building Scalable ERP Systems in 2026: Lessons from the Field', 'building-scalable-erp-systems-2026', 'Software Engineering', '5 min read', 'Oct 18, 2026', 'How modular software architecture and decoupled database designs help modern businesses automate supply chains without performance bottlenecks.', '/images/happymeeting.jpg', 'Taukir Ahmed', 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(2, 'Why Monolithic SPAs with Inertia.js are Winning Web Development', 'why-monolithic-spas-inertiajs-are-winning', 'Web Architecture', '4 min read', 'Oct 14, 2026', 'Eliminating REST API boilerplate while preserving pure Vue 3 client-side reactivity creates faster software and happier development teams.', '/images/skills-1.jpg', 'Sabbir Ahmed', 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(3, 'Modern Retail: The Secret to High-Speed Point of Sale Systems', 'modern-retail-high-speed-pos', 'Retail Tech', '6 min read', 'Sep 29, 2026', 'A technical breakdown of how POS-LTE achieves instant receipt generation and offline sync for high-volume restaurant and retail environments.', '/images/projects/5b.png', 'Azmir Hossain', 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1793552214),
('laravel_cache_5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1793552214;', 1793552214);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'service',
  `icon` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `type`, `icon`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Enterprise Architecture', 'enterprise-architecture', 'service', 'fa-solid fa-sitemap', NULL, 1, 1, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(2, 'Web Engineering', 'web-engineering', 'service', 'fa-solid fa-code', NULL, 2, 1, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(3, 'Growth & Funnels', 'growth-funnels', 'service', 'fa-solid fa-chart-line', NULL, 3, 1, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(4, 'Security & DevSecOps', 'security-devsecops', 'service', 'fa-solid fa-shield-halved', NULL, 4, 1, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(5, 'iOS & Android', 'ios-android', 'service', 'fa-solid fa-mobile-screen-button', NULL, 5, 1, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(6, 'Cloud & DevOps', 'cloud-devops', 'service', 'fa-solid fa-cloud', NULL, 6, 1, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(7, 'Search Optimization', 'search-optimization', 'service', 'fa-solid fa-magnifying-glass-chart', NULL, 7, 1, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(8, 'UI/UX & Product Design', 'uiux-product-design', 'service', 'fa-solid fa-palette', NULL, 8, 1, '2026-10-23 11:11:44', '2026-10-23 11:11:44'),
(9, 'Custom Software', 'custom-software', 'service', 'fa-solid fa-laptop-code', NULL, 9, 1, '2026-10-23 11:11:44', '2026-10-23 11:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'What technologies do you use for custom software and web applications?', 'We engineer high-performance platforms using full-stack Laravel 12, Inertia.js, Vue 3, Tailwind CSS, PostgreSQL, and MariaDB/MySQL, backed by secure cloud infrastructure on AWS, DigitalOcean, and dedicated VPS nodes.', 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(2, 'How long does it take to deliver an enterprise website or custom software?', 'Standard business portals take 2 to 4 weeks. Complex enterprise CRM, ERP, and multi-branch POS platforms are structured in agile 2-week sprints, with initial functional prototypes delivered within the first 14 days.', 2, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(3, 'Will my application be mobile-responsive, secure, and SEO-optimized?', 'Yes. Every platform is designed mobile-first, follows strict OWASP top-10 security standards, includes automated database backups, clean semantic architecture, and high Google Lighthouse performance scores.', 3, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(4, 'Who owns the intellectual property (IP) and source code upon completion?', 'You retain 100% full ownership of all proprietary source code, database architectures, and digital assets. Upon final handover, we transfer all private Git repositories, server keys, and deployment pipelines directly to your team.', 4, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(5, 'Can you integrate local and international payment gateways?', 'Yes! We have native integration expertise with bKash Merchant API, Nagad, Rocket, Upay, and SSLCommerz for Bangladesh, as well as Stripe, PayPal, and Paddle for international multi-currency transactions.', 5, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(6, 'How do you handle data security, backups, and disaster recovery?', 'We configure automated daily off-site encrypted backups, zero-trust role-based permissions (RBAC), database transaction logs, and automated health checks to ensure continuous 99.9% system availability.', 6, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(7, 'Do you provide continuous maintenance and post-launch support?', 'Yes! Every project includes a 30 to 90-day post-launch warranty. Afterwards, we offer flexible SLA-backed maintenance packages covering security updates, server monitoring, feature additions, and dedicated priority support.', 7, '2026-10-22 13:24:37', '2026-10-22 13:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'contact',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL,
  `selected_features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`selected_features`)),
  `budget_range` varchar(255) DEFAULT NULL,
  `timeline` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','reviewed','contacted','closed') NOT NULL DEFAULT 'new',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `type`, `name`, `email`, `phone`, `company`, `service`, `selected_features`, `budget_range`, `timeline`, `message`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'contact', 'zxdfgsdfg', 'hasanasdf@mail.com', '01234567890', NULL, 'Custom Software Development', NULL, NULL, NULL, 'sadfasdf', 'new', NULL, '2026-10-22 22:18:09', '2026-10-22 22:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_23_000001_create_inquiries_table', 1),
(5, '2026_10_23_000002_create_products_table', 1),
(6, '2026_10_23_000003_create_services_table', 1),
(7, '2026_10_23_000004_create_portfolio_projects_table', 1),
(8, '2026_10_23_000005_create_team_members_table', 1),
(9, '2026_10_23_000006_create_testimonials_table', 1),
(10, '2026_10_23_000007_create_pricing_plans_table', 1),
(11, '2026_10_23_000008_create_blog_posts_table', 1),
(12, '2026_10_23_000009_create_faqs_table', 1),
(13, '2026_10_23_161840_create_activity_log_table', 2),
(14, '2026_10_23_161841_add_event_column_to_activity_log_table', 2),
(15, '2026_10_23_161842_add_batch_uuid_column_to_activity_log_table', 2),
(16, '2026_10_23_000010_create_categories_table', 3),
(17, '2026_10_23_000011_add_category_id_to_services_table', 3),
(18, '2026_10_24_000001_add_performance_indexes_and_soft_deletes', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_projects`
--

CREATE TABLE `portfolio_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `tagline` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `live_url` varchar(255) NOT NULL DEFAULT '#',
  `metrics` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolio_projects`
--

INSERT INTO `portfolio_projects` (`id`, `number`, `title`, `slug`, `category`, `tagline`, `description`, `image`, `live_url`, `metrics`, `sort_order`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, '01', 'POS-LTE', 'pos-lte', 'Retail & Restaurant Tech', 'Modern Point of Sale and Receipt Management System', 'A streamlined interface for managing food items, creating orders, tracking branch sales, and printing customer receipts instantly with offline cache support.', '/images/projects/5b.png', 'https://pos-lte.vercel.app/', '3x Faster Order Processing', 1, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(2, '02', 'TicketBari', 'ticketbari', 'Transport & Ticketing', 'Online Bus, Train, Flight & Launch Ticket Booking Platform', 'Comprehensive booking platform for travelers across Bangladesh with live route searching, seat selection, and automated digital ticket issuance.', '/images/projects/3.png', 'https://ticketbari-client-side.netlify.app/', 'Seamless Multi-Route Booking', 2, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(3, '03', 'StyleDecor', 'styledecor', 'Smart Home & Events', 'Event Decoration & Smart Home Service Booking Platform', 'Interactive service catalog for event styling and interior renovations with geographical service area locator and vendor booking calendar.', '/images/projects/1.png', 'https://style-decor-client-side.netlify.app/', 'Interactive Area Mapping', 3, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(4, '04', 'CMS Company Portal', 'cms-company-portal', 'Publishing & Media', 'Content Management System & Enterprise Web Solutions', 'Modern headless CMS featuring dynamic block editors, role-based publishing workflows, and integrated media optimization.', '/images/projects/2.png', '#', 'Modular Content Blocks', 4, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_plans`
--

CREATE TABLE `pricing_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `audience` varchar(255) NOT NULL,
  `monthly_price` decimal(8,2) NOT NULL,
  `annual_price` decimal(8,2) NOT NULL,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`features`)),
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricing_plans`
--

INSERT INTO `pricing_plans` (`id`, `name`, `audience`, `monthly_price`, `annual_price`, `is_popular`, `features`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Starter Solution', 'Ideal for startups and growing businesses establishing their digital footprint.', 299.00, 249.00, 0, '[\"Custom Responsive Website (Up to 7 Pages)\",\"Modern Vue 3 + Tailwind Interface\",\"Contact & Lead Capture Form Integration\",\"Basic Technical SEO & Speed Optimization\",\"SSL Certificate & Cloud Hosting Setup\",\"30 Days Dedicated Post-Launch Support\"]', 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(2, 'Professional Business', 'For expanding companies needing custom CRM, POS or web applications.', 699.00, 599.00, 1, '[\"Full Custom Web Application or CRM\",\"Multi-User Role Management & Permissions\",\"Payment Gateway Integration (bKash, Nagad, Stripe)\",\"Automated Email & SMS Alerts\",\"Advanced Analytics & Reporting Dashboard\",\"Daily Automated Cloud Backups\",\"3 Months Dedicated Priority Support\"]', 2, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(3, 'Enterprise Custom', 'Tailored ERP and multi-branch systems for large enterprises.', 1499.00, 1299.00, 0, '[\"End-to-End Scalable ERP \\/ POS Architecture\",\"Multi-Branch & Warehouse Inventory Sync\",\"Offline First Data Replication\",\"Dedicated DevSecOps & High-Availability Servers\",\"Custom Third-Party API Integrations\",\"Dedicated Account Manager & SLA Guarantee\",\"1 Year Extended Maintenance & SLA\"]', 3, '2026-10-22 13:24:37', '2026-10-22 13:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'fa-gear',
  `bg` varchar(255) NOT NULL DEFAULT '#E8E4FF',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `description`, `icon`, `bg`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'CRM', 'crm', 'Building Stronger Relationships, One Interaction at a Time.', 'fa-users-gear', '#E8E4FF', 1, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(2, 'EDU CRM', 'edu-crm', 'One Stop Solution for Empowering Education Consultancy Firm.', 'fa-graduation-cap', '#D9FFE0', 2, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(3, 'HRM', 'hrm', 'Unlocking Human Potential, Driving Organizational Success, Saving Time.', 'fa-id-card-clip', '#FFF0F1', 3, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(4, 'ERP', 'erp', 'Optimize business processes, improving efficiency and productivity for clients.', 'fa-sitemap', '#DBF5FF', 4, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(5, 'E-commerce', 'e-commerce', 'Transforming Online Shopping Experiences, Affordable and Convenient.', 'fa-cart-shopping', '#FFE7D6', 5, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(6, 'Accounting Software', 'accounting-software', 'Manage Accounting, Simplifying Finances, Empowering Sustainable Growth.', 'fa-file-invoice-dollar', '#DAECFF', 6, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(7, 'Inventory Management (POS)', 'pos-inventory-management', 'Manage Sales Easy, Effortless Transactions, Elevated Retail Experiences.', 'fa-cash-register', '#E1FCFF', 7, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(8, 'Restaurant Management', 'restaurant-management', 'Manage Your Restaurant Perfectly — Optimizing Kitchen and Guest Services.', 'fa-utensils', '#FFDAE8', 8, 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `slug`, `description`, `image`, `category_id`, `tag`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Software Solutions & Consultancy', 'software-solutions-consultancy', 'Custom enterprise software designed to automate core business workflows, integrate databases, and scale operations.', '/images/service-2.png', 1, 'Enterprise Architecture', 1, 1, '2026-10-22 13:24:37', '2026-10-23 11:11:44'),
(2, 'Website & Portfolio', 'website-portfolio', 'High-conversion corporate websites and interactive digital portals built for performance, mobile responsiveness, and SEO.', '/images/service/website.jpg', 2, 'Web Engineering', 2, 1, '2026-10-22 13:24:37', '2026-10-23 11:11:44'),
(3, 'Digital Marketing & Consultancy', 'digital-marketing-consultancy', 'Data-driven growth strategies, programmatic ad campaigns, and targeted customer acquisition funnels.', '/images/service/Digi.jpg', 3, 'Growth & Funnels', 3, 1, '2026-10-22 13:24:37', '2026-10-23 11:11:44'),
(4, 'Cyber Security & Consulting', 'cyber-security-consulting', 'Penetration testing, cloud infrastructure hardening, vulnerability audits, and proactive disaster recovery systems.', '/images/service/cyber.jpg', 4, 'Security & DevSecOps', 4, 1, '2026-10-22 13:24:37', '2026-10-23 11:11:44'),
(5, 'Mobile App Development', 'mobile-app-development', 'Native and cross-platform iOS & Android mobile apps engineered with offline sync and intuitive UX.', '/images/service/mobile.jpg', 5, 'iOS & Android', 5, 1, '2026-10-22 13:24:37', '2026-10-23 11:11:44'),
(6, 'Domain & Web Hosting', 'domain-web-hosting', 'High-availability managed cloud hosting, automated SSL encryption, global CDN, and zero-downtime deployments.', '/images/service/web-hosting.jpg', 6, 'Cloud & DevOps', 6, 1, '2026-10-22 13:24:37', '2026-10-23 11:11:44'),
(7, 'SEO Services', 'seo-services', 'Technical on-page SEO, speed optimization, structured schema markup, and authoritative ranking strategies.', '/images/service/seo.jpg', 7, 'Search Optimization', 7, 1, '2026-10-22 13:24:37', '2026-10-23 11:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bm5eQgfwHpWvjzGWsbQiUwNxI02Kr6ItksVeAwyg', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZFBnT2JNdklVdHlacDhFejFQM2ZsdXRrbVFwM3JUYzdadmZKaXphVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vc29mdHBvbGxpLnRlc3QvYWRtaW4vcHJvZmlsZSI7czo1OiJyb3V0ZSI7czoxMzoiYWRtaW4ucHJvZmlsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mjg6Imh0dHBzOi8vc29mdHBvbGxpLnRlc3QvYWRtaW4iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiI5ZjkxOGI3NmNjMjg2NzNmMmI0YWQyNWY2OGVjOWVhZjQ2ZDU1YWIxZGFhMTE3ODM1ZjNiMzViMWJhMzQ0ZTg1Ijt9', 1793553148),
('jDXXQgNPisU0htbfJaH95FKk7HAWW2s46Uag87Eu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidGdNT2ZCd1BxNUFLOUVZbFJSQ2hVdTd0VklOdnIyU2lRa0JVSTFzMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vc29mdHBvbGxpLnRlc3QiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fX0=', 1793385367);

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `social` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social`)),
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `role`, `image`, `social`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Azmir Hossain', 'Operations Manager', '/images/Azmir_Hossain_Gemini.png', '{\"facebook\":\"https:\\/\\/facebook.com\",\"linkedin\":\"https:\\/\\/linkedin.com\"}', 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(2, 'Fahim Ahmed', 'Head of Supply Chain', '/images/Fahim_Ahmed_Gemini.png', '{\"facebook\":\"https:\\/\\/facebook.com\",\"linkedin\":\"https:\\/\\/linkedin.com\"}', 2, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(3, 'Taukir Ahmed', 'Developer Team Lead', '/images/taukir_gemini.png', '{\"facebook\":\"https:\\/\\/www.facebook.com\\/taukir.ahmed.30\",\"linkedin\":\"https:\\/\\/www.linkedin.com\\/in\\/taukir-dev\",\"website\":\"https:\\/\\/taukir-ahmed.netlify.app\\/\"}', 3, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(4, 'Sabbir Ahmed', 'Senior Developer', '/images/sabbir.png', '{\"facebook\":\"https:\\/\\/www.facebook.com\\/sabbirbd912\",\"linkedin\":\"https:\\/\\/www.linkedin.com\\/in\\/sabbir-ahmed-dev\\/\",\"website\":\"https:\\/\\/sabbir-web.netlify.app\\/\"}', 4, '2026-10-22 13:24:37', '2026-10-22 13:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `quote` text NOT NULL,
  `src` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `designation`, `company`, `category`, `quote`, `src`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Tanvir Rahman', 'Managing Director', 'Trust Winner Restaurant', 'Hotel & Restaurant Management', 'SoftPolli has been an invaluable partner in our digital transformation journey. Their expertise in web and POS solutions, coupled with their dedication to quality, helped us scale our branches seamlessly.', '/images/t1.jpg', 1, '2026-10-22 13:24:37', '2026-10-22 13:24:37'),
(2, 'Sajal Ahmed', 'Chief Executive Officer', 'IB Educational Institute', 'Education & Learning Management', 'The team at SoftPolli exceeded our expectations in every way. Their custom EDU CRM automated our entire student admission pipeline and saved hundreds of administrative hours.', '/images/t2.png', 2, '2026-10-22 13:24:37', '2026-10-22 13:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'SoftPolli Admin', 'admin@softpolli.com', '2026-10-22 13:24:37', '$2y$12$HVQwQouCZGYHJQy5zxDWGu02PMOP4fv/Mqr8hHPt1c9gyPRNft1QW', NULL, '2026-10-22 13:24:37', '2026-10-22 13:24:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  ADD KEY `blog_posts_is_published_id_index` (`is_published`,`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inquiries_status_type_index` (`status`,`type`),
  ADD KEY `inquiries_created_at_index` (`created_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `portfolio_projects`
--
ALTER TABLE `portfolio_projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `portfolio_projects_slug_unique` (`slug`),
  ADD KEY `portfolio_projects_is_featured_sort_order_index` (`is_featured`,`sort_order`);

--
-- Indexes for table `pricing_plans`
--
ALTER TABLE `pricing_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_is_active_sort_order_index` (`is_active`,`sort_order`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`),
  ADD KEY `services_category_id_foreign` (`category_id`),
  ADD KEY `services_is_active_sort_order_index` (`is_active`,`sort_order`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `portfolio_projects`
--
ALTER TABLE `portfolio_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pricing_plans`
--
ALTER TABLE `pricing_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
