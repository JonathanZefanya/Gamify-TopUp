-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ⚠️  SECURITY NOTICE ⚠️
-- This is a SANITIZED version of the database for GitHub.
-- ALL API KEYS AND SECRETS have been replaced with placeholders.
-- DO NOT use this file directly in production!
-- Replace placeholders with actual API keys before use.
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2025 at 03:52 PM
-- Server version: 9.2.0
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kampus_si`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `sell_post_id` bigint UNSIGNED NOT NULL,
  `activityable_id` text COLLATE utf8mb4_unicode_ci,
  `activityable_type` text COLLATE utf8mb4_unicode_ci,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_driver` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `role_id` int DEFAULT NULL,
  `admin_access` text COLLATE utf8mb4_unicode_ci,
  `last_login` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_seen` datetime DEFAULT NULL,
  `status` tinyint DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `password`, `image`, `image_driver`, `phone`, `address`, `role_id`, `admin_access`, `last_login`, `last_seen`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$oJjedvDptyOeFa42S55bY.1vR065RK4wZAUAuVDBPVg4fS7bANY1u', 'adminProfileImage/P8667idwGvCpWBeeVKAodCjWumgVvk.webp', 'local', '+62 83807914090', 'Jl Pahlawan. Kec. Serpong, Tangsel', NULL, NULL, '2025-09-19 20:37:08', '2025-09-19 20:37:23', 1, NULL, NULL, '2025-09-19 13:37:23');

-- --------------------------------------------------------

--
-- Table structure for table `basic_controls`
--

CREATE TABLE `basic_controls` (
  `id` bigint UNSIGNED NOT NULL,
  `theme` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_zone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_currency` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_prefix` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_currency_position` enum('left','right') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'left',
  `has_space_between_currency_and_amount` tinyint(1) NOT NULL DEFAULT '0',
  `is_force_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `is_maintenance_mode` tinyint(1) NOT NULL DEFAULT '0',
  `paginate` int DEFAULT NULL,
  `strong_password` tinyint(1) NOT NULL DEFAULT '0',
  `registration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => disable, 1 => enable',
  `fraction_number` int DEFAULT NULL,
  `sender_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_email_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_description` text COLLATE utf8mb4_unicode_ci,
  `push_notification` tinyint(1) NOT NULL DEFAULT '0',
  `in_app_notification` tinyint(1) NOT NULL DEFAULT '0',
  `active_in_app` enum('pusher','reverb') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pusher',
  `email_notification` tinyint(1) NOT NULL DEFAULT '0',
  `email_verification` tinyint(1) NOT NULL DEFAULT '0',
  `sms_notification` tinyint(1) NOT NULL DEFAULT '0',
  `sms_verification` tinyint(1) NOT NULL DEFAULT '0',
  `tawk_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tawk_status` tinyint(1) NOT NULL DEFAULT '0',
  `fb_messenger_status` tinyint(1) NOT NULL DEFAULT '0',
  `fb_app_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_page_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manual_recaptcha` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 =>inactive, 1 => active',
  `google_recaptcha` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=>inactive, 1 =>active',
  `recaptcha_admin_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '	0 => inactive, 1 => active',
  `google_reCapture_admin_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '	0 => inactive, 1 => active',
  `google_reCaptcha_status_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '	0 => inactive, 1 => active',
  `google_recaptcha_admin_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '	0 => inactive, 1 => active',
  `google_reCaptcha_status_registration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '	0 => inactive, 1 => active',
  `reCaptcha_status_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '	0 => inactive, 1 => active',
  `reCaptcha_status_registration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '	0 => inactive, 1 => active',
  `measurement_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `analytic_status` tinyint(1) DEFAULT NULL,
  `error_log` tinyint(1) DEFAULT NULL,
  `is_active_cron_notification` tinyint(1) DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_driver` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon_driver` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_logo_driver` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_dark_mode_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_dark_mode_logo_driver` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_layer_access_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_layer_auto_update_at` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_layer_auto_update` tinyint(1) NOT NULL DEFAULT '0',
  `coin_market_cap_app_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coin_market_cap_auto_update_at` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coin_market_cap_auto_update` tinyint(1) NOT NULL DEFAULT '0',
  `date_time_format` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cookie_status` tinyint(1) NOT NULL DEFAULT '0',
  `cookie_heading` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cookie_description` text COLLATE utf8mb4_unicode_ci,
  `cookie_button` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cookie_button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cookie_image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cookie_image_driver` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_view` enum('flex','scrolling') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scrolling' COMMENT 'How to show user pannel mobile version table view',
  `sell_post` tinyint(1) NOT NULL DEFAULT '1',
  `payment_expired` int NOT NULL DEFAULT '15',
  `payment_released` int NOT NULL DEFAULT '7',
  `top_up` tinyint(1) NOT NULL DEFAULT '1',
  `card` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `app_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_build` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_major` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `light_primary_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `light_secondary_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dark_primary_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dark_secondary_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basic_controls`
--

INSERT INTO `basic_controls` (`id`, `theme`, `site_title`, `time_zone`, `base_currency`, `currency_symbol`, `admin_prefix`, `is_currency_position`, `has_space_between_currency_and_amount`, `is_force_ssl`, `is_maintenance_mode`, `paginate`, `strong_password`, `registration`, `fraction_number`, `sender_email`, `sender_email_name`, `email_description`, `push_notification`, `in_app_notification`, `active_in_app`, `email_notification`, `email_verification`, `sms_notification`, `sms_verification`, `tawk_id`, `tawk_status`, `fb_messenger_status`, `fb_app_id`, `fb_page_id`, `manual_recaptcha`, `google_recaptcha`, `recaptcha_admin_login`, `google_reCapture_admin_login`, `google_reCaptcha_status_login`, `google_recaptcha_admin_login`, `google_reCaptcha_status_registration`, `reCaptcha_status_login`, `reCaptcha_status_registration`, `measurement_id`, `analytic_status`, `error_log`, `is_active_cron_notification`, `logo`, `logo_driver`, `favicon`, `favicon_driver`, `admin_logo`, `admin_logo_driver`, `admin_dark_mode_logo`, `admin_dark_mode_logo_driver`, `currency_layer_access_key`, `currency_layer_auto_update_at`, `currency_layer_auto_update`, `coin_market_cap_app_key`, `coin_market_cap_auto_update_at`, `coin_market_cap_auto_update`, `date_time_format`, `contact_number`, `cookie_status`, `cookie_heading`, `cookie_description`, `cookie_button`, `cookie_button_link`, `cookie_image`, `cookie_image_driver`, `table_view`, `sell_post`, `payment_expired`, `payment_released`, `top_up`, `card`, `created_at`, `updated_at`, `app_color`, `app_version`, `app_build`, `is_major`, `light_primary_color`, `light_secondary_color`, `dark_primary_color`, `dark_secondary_color`) VALUES
(1, 'dark', 'Gamify', 'Asia/Jakarta', 'IDR', 'Rp.', 'admin', 'left', 0, 0, 0, 10, 0, 1, 2, 'support@gmail.com', 'Bug Admin', '<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n<meta name=\"viewport\" content=\"width=device-width\">\n<style type=\"text/css\">\n    @media only screen and (min-width: 620px) {\n        * [lang=x-wrapper] h1 {\n        }\n\n        * [lang=x-wrapper] h1 {\n            font-size: 26px !important;\n            line-height: 34px !important\n        }\n\n        * [lang=x-wrapper] h2 {\n        }\n\n        * [lang=x-wrapper] h2 {\n            font-size: 20px !important;\n            line-height: 28px !important\n        }\n\n        * [lang=x-wrapper] h3 {\n        }\n\n        * [lang=x-layout__inner] p,\n        * [lang=x-layout__inner] ol,\n        * [lang=x-layout__inner] ul {\n        }\n\n        * div [lang=x-size-8] {\n            font-size: 8px !important;\n            line-height: 14px !important\n        }\n\n        * div [lang=x-size-9] {\n            font-size: 9px !important;\n            line-height: 16px !important\n        }\n\n        * div [lang=x-size-10] {\n            font-size: 10px !important;\n            line-height: 18px !important\n        }\n\n        * div [lang=x-size-11] {\n            font-size: 11px !important;\n            line-height: 19px !important\n        }\n\n        * div [lang=x-size-12] {\n            font-size: 12px !important;\n            line-height: 19px !important\n        }\n\n        * div [lang=x-size-13] {\n            font-size: 13px !important;\n            line-height: 21px !important\n        }\n\n        * div [lang=x-size-14] {\n            font-size: 14px !important;\n            line-height: 21px !important\n        }\n\n        * div [lang=x-size-15] {\n            font-size: 15px !important;\n            line-height: 23px !important\n        }\n\n        * div [lang=x-size-16] {\n            font-size: 16px !important;\n            line-height: 24px !important\n        }\n\n        * div [lang=x-size-17] {\n            font-size: 17px !important;\n            line-height: 26px !important\n        }\n\n        * div [lang=x-size-18] {\n            font-size: 18px !important;\n            line-height: 26px !important\n        }\n\n        * div [lang=x-size-18] {\n            font-size: 18px !important;\n            line-height: 26px !important\n        }\n\n        * div [lang=x-size-20] {\n            font-size: 20px !important;\n            line-height: 28px !important\n        }\n\n        * div [lang=x-size-22] {\n            font-size: 22px !important;\n            line-height: 31px !important\n        }\n\n        * div [lang=x-size-24] {\n            font-size: 24px !important;\n            line-height: 32px !important\n        }\n\n        * div [lang=x-size-26] {\n            font-size: 26px !important;\n            line-height: 34px !important\n        }\n\n        * div [lang=x-size-28] {\n            font-size: 28px !important;\n            line-height: 36px !important\n        }\n\n        * div [lang=x-size-30] {\n            font-size: 30px !important;\n            line-height: 38px !important\n        }\n\n        * div [lang=x-size-32] {\n            font-size: 32px !important;\n            line-height: 40px !important\n        }\n\n        * div [lang=x-size-34] {\n            font-size: 34px !important;\n            line-height: 43px !important\n        }\n\n        * div [lang=x-size-36] {\n            font-size: 36px !important;\n            line-height: 43px !important\n        }\n\n        * div [lang=x-size-40] {\n            font-size: 40px !important;\n            line-height: 47px !important\n        }\n\n        * div [lang=x-size-44] {\n            font-size: 44px !important;\n            line-height: 50px !important\n        }\n\n        * div [lang=x-size-48] {\n            font-size: 48px !important;\n            line-height: 54px !important\n        }\n\n        * div [lang=x-size-56] {\n            font-size: 56px !important;\n            line-height: 60px !important\n        }\n\n        * div [lang=x-size-64] {\n            font-size: 64px !important;\n            line-height: 63px !important\n        }\n    }\n</style>\n<style type=\"text/css\">\n    body {\n        margin: 0;\n        padding: 0;\n    }\n\n    table {\n        border-collapse: collapse;\n        table-layout: fixed;\n    }\n\n    * {\n        line-height: inherit;\n    }\n\n    [x-apple-data-detectors],\n    [href^=\"tel\"],\n    [href^=\"sms\"] {\n        color: inherit !important;\n        text-decoration: none !important;\n    }\n\n    .wrapper .footer__share-button a:hover,\n    .wrapper .footer__share-button a:focus {\n        color: #ffffff !important;\n    }\n\n    .btn a:hover,\n    .btn a:focus,\n    .footer__share-button a:hover,\n    .footer__share-button a:focus,\n    .email-footer__links a:hover,\n    .email-footer__links a:focus {\n        opacity: 0.8;\n    }\n\n    .preheader,\n    .header,\n    .layout,\n    .column {\n        transition: width 0.25s ease-in-out, max-width 0.25s ease-in-out;\n    }\n\n    .layout,\n    .header {\n        max-width: 400px !important;\n        -fallback-width: 95% !important;\n        width: calc(100% - 20px) !important;\n    }\n\n    div.preheader {\n        max-width: 360px !important;\n        -fallback-width: 90% !important;\n        width: calc(100% - 60px) !important;\n    }\n\n    .snippet,\n    .webversion {\n        Float: none !important;\n    }\n\n    .column {\n        max-width: 400px !important;\n        width: 100% !important;\n    }\n\n    .fixed-width.has-border {\n        max-width: 402px !important;\n    }\n\n    .fixed-width.has-border .layout__inner {\n        box-sizing: border-box;\n    }\n\n    .snippet,\n    .webversion {\n        width: 50% !important;\n    }\n\n    .ie .btn {\n        width: 100%;\n    }\n\n    .ie .column,\n    [owa] .column,\n    .ie .gutter,\n    [owa] .gutter {\n        display: table-cell;\n        float: none !important;\n        vertical-align: top;\n    }\n\n    .ie div.preheader,\n    [owa] div.preheader,\n    .ie .email-footer,\n    [owa] .email-footer {\n        max-width: 560px !important;\n        width: 560px !important;\n    }\n\n    .ie .snippet,\n    [owa] .snippet,\n    .ie .webversion,\n    [owa] .webversion {\n        width: 280px !important;\n    }\n\n    .ie .header,\n    [owa] .header,\n    .ie .layout,\n    [owa] .layout,\n    .ie .one-col .column,\n    [owa] .one-col .column {\n        max-width: 600px !important;\n        width: 600px !important;\n    }\n\n    .ie .fixed-width.has-border,\n    [owa] .fixed-width.has-border,\n    .ie .has-gutter.has-border,\n    [owa] .has-gutter.has-border {\n        max-width: 602px !important;\n        width: 602px !important;\n    }\n\n    .ie .two-col .column,\n    [owa] .two-col .column {\n        width: 300px !important;\n    }\n\n    .ie .three-col .column,\n    [owa] .three-col .column,\n    .ie .narrow,\n    [owa] .narrow {\n        width: 200px !important;\n    }\n\n    .ie .wide,\n    [owa] .wide {\n        width: 400px !important;\n    }\n\n    .ie .two-col.has-gutter .column,\n    [owa] .two-col.x_has-gutter .column {\n        width: 290px !important;\n    }\n\n    .ie .three-col.has-gutter .column,\n    [owa] .three-col.x_has-gutter .column,\n    .ie .has-gutter .narrow,\n    [owa] .has-gutter .narrow {\n        width: 188px !important;\n    }\n\n    .ie .has-gutter .wide,\n    [owa] .has-gutter .wide {\n        width: 394px !important;\n    }\n\n    .ie .two-col.has-gutter.has-border .column,\n    [owa] .two-col.x_has-gutter.x_has-border .column {\n        width: 292px !important;\n    }\n\n    .ie .three-col.has-gutter.has-border .column,\n    [owa] .three-col.x_has-gutter.x_has-border .column,\n    .ie .has-gutter.has-border .narrow,\n    [owa] .has-gutter.x_has-border .narrow {\n        width: 190px !important;\n    }\n\n    .ie .has-gutter.has-border .wide,\n    [owa] .has-gutter.x_has-border .wide {\n        width: 396px !important;\n    }\n\n    .ie .fixed-width .layout__inner {\n        border-left: 0 none white !important;\n        border-right: 0 none white !important;\n    }\n\n    .ie .layout__edges {\n        display: none;\n    }\n\n    .mso .layout__edges {\n        font-size: 0;\n    }\n\n    .layout-fixed-width,\n    .mso .layout-full-width {\n        background-color: #ffffff;\n    }\n\n    @media only screen and (min-width: 620px) {\n\n        .column,\n        .gutter {\n            display: table-cell;\n            Float: none !important;\n            vertical-align: top;\n        }\n\n        div.preheader,\n        .email-footer {\n            max-width: 560px !important;\n            width: 560px !important;\n        }\n\n        .snippet,\n        .webversion {\n            width: 280px !important;\n        }\n\n        .header,\n        .layout,\n        .one-col .column {\n            max-width: 600px !important;\n            width: 600px !important;\n        }\n\n        .fixed-width.has-border,\n        .fixed-width.ecxhas-border,\n        .has-gutter.has-border,\n        .has-gutter.ecxhas-border {\n            max-width: 602px !important;\n            width: 602px !important;\n        }\n\n        .two-col .column {\n            width: 300px !important;\n        }\n\n        .three-col .column,\n        .column.narrow {\n            width: 200px !important;\n        }\n\n        .column.wide {\n            width: 400px !important;\n        }\n\n        .two-col.has-gutter .column,\n        .two-col.ecxhas-gutter .column {\n            width: 290px !important;\n        }\n\n        .three-col.has-gutter .column,\n        .three-col.ecxhas-gutter .column,\n        .has-gutter .narrow {\n            width: 188px !important;\n        }\n\n        .has-gutter .wide {\n            width: 394px !important;\n        }\n\n        .two-col.has-gutter.has-border .column,\n        .two-col.ecxhas-gutter.ecxhas-border .column {\n            width: 292px !important;\n        }\n\n        .three-col.has-gutter.has-border .column,\n        .three-col.ecxhas-gutter.ecxhas-border .column,\n        .has-gutter.has-border .narrow,\n        .has-gutter.ecxhas-border .narrow {\n            width: 190px !important;\n        }\n\n        .has-gutter.has-border .wide,\n        .has-gutter.ecxhas-border .wide {\n            width: 396px !important;\n        }\n    }\n\n    @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {\n        .fblike {\n            background-image: url(https://i3.createsend1.com/static/eb/customise/13-the-blueprint-3/images/fblike@2x.png) !important;\n        }\n\n        .tweet {\n            background-image: url(https://i4.createsend1.com/static/eb/customise/13-the-blueprint-3/images/tweet@2x.png) !important;\n        }\n\n        .linkedinshare {\n            background-image: url(https://i6.createsend1.com/static/eb/customise/13-the-blueprint-3/images/lishare@2x.png) !important;\n        }\n\n        .forwardtoafriend {\n            background-image: url(https://i5.createsend1.com/static/eb/customise/13-the-blueprint-3/images/forward@2x.png) !important;\n        }\n    }\n\n    @media (max-width: 321px) {\n        .fixed-width.has-border .layout__inner {\n            border-width: 1px 0 !important;\n        }\n\n        .layout,\n        .column {\n            min-width: 320px !important;\n            width: 320px !important;\n        }\n\n        .border {\n            display: none;\n        }\n    }\n\n    .mso div {\n        border: 0 none white !important;\n    }\n\n    .mso .w560 .divider {\n        margin-left: 260px !important;\n        margin-right: 260px !important;\n    }\n\n    .mso .w360 .divider {\n        margin-left: 160px !important;\n        margin-right: 160px !important;\n    }\n\n    .mso .w260 .divider {\n        margin-left: 110px !important;\n        margin-right: 110px !important;\n    }\n\n    .mso .w160 .divider {\n        margin-left: 60px !important;\n        margin-right: 60px !important;\n    }\n\n    .mso .w354 .divider {\n        margin-left: 157px !important;\n        margin-right: 157px !important;\n    }\n\n    .mso .w250 .divider {\n        margin-left: 105px !important;\n        margin-right: 105px !important;\n    }\n\n    .mso .w148 .divider {\n        margin-left: 54px !important;\n        margin-right: 54px !important;\n    }\n\n    .mso .font-avenir,\n    .mso .font-cabin,\n    .mso .font-open-sans,\n    .mso .font-ubuntu {\n        font-family: sans-serif !important;\n    }\n\n    .mso .font-bitter,\n    .mso .font-merriweather,\n    .mso .font-pt-serif {\n        font-family: Georgia, serif !important;\n    }\n\n    .mso .font-lato,\n    .mso .font-roboto {\n        font-family: Tahoma, sans-serif !important;\n    }\n\n    .mso .font-pt-sans {\n        font-family: \"Trebuchet MS\", sans-serif !important;\n    }\n\n    .mso .footer__share-button p {\n        margin: 0;\n    }\n\n    @media only screen and (min-width: 620px) {\n        .wrapper .size-8 {\n            font-size: 8px !important;\n            line-height: 14px !important;\n        }\n\n        .wrapper .size-9 {\n            font-size: 9px !important;\n            line-height: 16px !important;\n        }\n\n        .wrapper .size-10 {\n            font-size: 10px !important;\n            line-height: 18px !important;\n        }\n\n        .wrapper .size-11 {\n            font-size: 11px !important;\n            line-height: 19px !important;\n        }\n\n        .wrapper .size-12 {\n            font-size: 12px !important;\n            line-height: 19px !important;\n        }\n\n        .wrapper .size-13 {\n            font-size: 13px !important;\n            line-height: 21px !important;\n        }\n\n        .wrapper .size-14 {\n            font-size: 14px !important;\n            line-height: 21px !important;\n        }\n\n        .wrapper .size-15 {\n            font-size: 15px !important;\n            line-height: 23px !important;\n        }\n\n        .wrapper .size-16 {\n            font-size: 16px !important;\n            line-height: 24px !important;\n        }\n\n        .wrapper .size-17 {\n            font-size: 17px !important;\n            line-height: 26px !important;\n        }\n\n        .wrapper .size-18 {\n            font-size: 18px !important;\n            line-height: 26px !important;\n        }\n\n        .wrapper .size-20 {\n            font-size: 20px !important;\n            line-height: 28px !important;\n        }\n\n        .wrapper .size-22 {\n            font-size: 22px !important;\n            line-height: 31px !important;\n        }\n\n        .wrapper .size-24 {\n            font-size: 24px !important;\n            line-height: 32px !important;\n        }\n\n        .wrapper .size-26 {\n            font-size: 26px !important;\n            line-height: 34px !important;\n        }\n\n        .wrapper .size-28 {\n            font-size: 28px !important;\n            line-height: 36px !important;\n        }\n\n        .wrapper .size-30 {\n            font-size: 30px !important;\n            line-height: 38px !important;\n        }\n\n        .wrapper .size-32 {\n            font-size: 32px !important;\n            line-height: 40px !important;\n        }\n\n        .wrapper .size-34 {\n            font-size: 34px !important;\n            line-height: 43px !important;\n        }\n\n        .wrapper .size-36 {\n            font-size: 36px !important;\n            line-height: 43px !important;\n        }\n\n        .wrapper .size-40 {\n            font-size: 40px !important;\n            line-height: 47px !important;\n        }\n\n        .wrapper .size-44 {\n            font-size: 44px !important;\n            line-height: 50px !important;\n        }\n\n        .wrapper .size-48 {\n            font-size: 48px !important;\n            line-height: 54px !important;\n        }\n\n        .wrapper .size-56 {\n            font-size: 56px !important;\n            line-height: 60px !important;\n        }\n\n        .wrapper .size-64 {\n            font-size: 64px !important;\n            line-height: 63px !important;\n        }\n    }\n\n    .mso .size-8,\n    .ie .size-8 {\n        font-size: 8px !important;\n        line-height: 14px !important;\n    }\n\n    .mso .size-9,\n    .ie .size-9 {\n        font-size: 9px !important;\n        line-height: 16px !important;\n    }\n\n    .mso .size-10,\n    .ie .size-10 {\n        font-size: 10px !important;\n        line-height: 18px !important;\n    }\n\n    .mso .size-11,\n    .ie .size-11 {\n        font-size: 11px !important;\n        line-height: 19px !important;\n    }\n\n    .mso .size-12,\n    .ie .size-12 {\n        font-size: 12px !important;\n        line-height: 19px !important;\n    }\n\n    .mso .size-13,\n    .ie .size-13 {\n        font-size: 13px !important;\n        line-height: 21px !important;\n    }\n\n    .mso .size-14,\n    .ie .size-14 {\n        font-size: 14px !important;\n        line-height: 21px !important;\n    }\n\n    .mso .size-15,\n    .ie .size-15 {\n        font-size: 15px !important;\n        line-height: 23px !important;\n    }\n\n    .mso .size-16,\n    .ie .size-16 {\n        font-size: 16px !important;\n        line-height: 24px !important;\n    }\n\n    .mso .size-17,\n    .ie .size-17 {\n        font-size: 17px !important;\n        line-height: 26px !important;\n    }\n\n    .mso .size-18,\n    .ie .size-18 {\n        font-size: 18px !important;\n        line-height: 26px !important;\n    }\n\n    .mso .size-20,\n    .ie .size-20 {\n        font-size: 20px !important;\n        line-height: 28px !important;\n    }\n\n    .mso .size-22,\n    .ie .size-22 {\n        font-size: 22px !important;\n        line-height: 31px !important;\n    }\n\n    .mso .size-24,\n    .ie .size-24 {\n        font-size: 24px !important;\n        line-height: 32px !important;\n    }\n\n    .mso .size-26,\n    .ie .size-26 {\n        font-size: 26px !important;\n        line-height: 34px !important;\n    }\n\n    .mso .size-28,\n    .ie .size-28 {\n        font-size: 28px !important;\n        line-height: 36px !important;\n    }\n\n    .mso .size-30,\n    .ie .size-30 {\n        font-size: 30px !important;\n        line-height: 38px !important;\n    }\n\n    .mso .size-32,\n    .ie .size-32 {\n        font-size: 32px !important;\n        line-height: 40px !important;\n    }\n\n    .mso .size-34,\n    .ie .size-34 {\n        font-size: 34px !important;\n        line-height: 43px !important;\n    }\n\n    .mso .size-36,\n    .ie .size-36 {\n        font-size: 36px !important;\n        line-height: 43px !important;\n    }\n\n    .mso .size-40,\n    .ie .size-40 {\n        font-size: 40px !important;\n        line-height: 47px !important;\n    }\n\n    .mso .size-44,\n    .ie .size-44 {\n        font-size: 44px !important;\n        line-height: 50px !important;\n    }\n\n    .mso .size-48,\n    .ie .size-48 {\n        font-size: 48px !important;\n        line-height: 54px !important;\n    }\n\n    .mso .size-56,\n    .ie .size-56 {\n        font-size: 56px !important;\n        line-height: 60px !important;\n    }\n\n    .mso .size-64,\n    .ie .size-64 {\n        font-size: 64px !important;\n        line-height: 63px !important;\n    }\n\n    .footer__share-button p {\n        margin: 0;\n    }\n</style>\n\n<title></title>\n<!--[if !mso]><!-->\n<style type=\"text/css\">\n    @import url(https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Cabin:400,700,400italic,700italic|Open+Sans:400italic,700italic,700,400);\n</style>\n<link href=\"https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Cabin:400,700,400italic,700italic|Open+Sans:400italic,700italic,700,400\" rel=\"stylesheet\" type=\"text/css\">\n<!--<![endif]-->\n<style type=\"text/css\">\n    body {\n        background-color: #f5f7fa\n    }\n\n    .mso h1 {\n    }\n\n    .mso h1 {\n        font-family: sans-serif !important\n    }\n\n    .mso h2 {\n    }\n\n    .mso h3 {\n    }\n\n    .mso .column,\n    .mso .column__background td {\n    }\n\n    .mso .column,\n    .mso .column__background td {\n        font-family: sans-serif !important\n    }\n\n    .mso .btn a {\n    }\n\n    .mso .btn a {\n        font-family: sans-serif !important\n    }\n\n    .mso .webversion,\n    .mso .snippet,\n    .mso .layout-email-footer td,\n    .mso .footer__share-button p {\n    }\n\n    .mso .webversion,\n    .mso .snippet,\n    .mso .layout-email-footer td,\n    .mso .footer__share-button p {\n        font-family: sans-serif !important\n    }\n\n    .mso .logo {\n    }\n\n    .mso .logo {\n        font-family: Tahoma, sans-serif !important\n    }\n\n    .logo a:hover,\n    .logo a:focus {\n        color: #859bb1 !important\n    }\n\n    .mso .layout-has-border {\n        border-top: 1px solid #b1c1d8;\n        border-bottom: 1px solid #b1c1d8\n    }\n\n    .mso .layout-has-bottom-border {\n        border-bottom: 1px solid #b1c1d8\n    }\n\n    .mso .border,\n    .ie .border {\n        background-color: #b1c1d8\n    }\n\n    @media only screen and (min-width: 620px) {\n        .wrapper h1 {\n        }\n\n        .wrapper h1 {\n            font-size: 26px !important;\n            line-height: 34px !important\n        }\n\n        .wrapper h2 {\n        }\n\n        .wrapper h2 {\n            font-size: 20px !important;\n            line-height: 28px !important\n        }\n\n        .wrapper h3 {\n        }\n\n        .column p,\n        .column ol,\n        .column ul {\n        }\n    }\n\n    .mso h1,\n    .ie h1 {\n    }\n\n    .mso h1,\n    .ie h1 {\n        font-size: 26px !important;\n        line-height: 34px !important\n    }\n\n    .mso h2,\n    .ie h2 {\n    }\n\n    .mso h2,\n    .ie h2 {\n        font-size: 20px !important;\n        line-height: 28px !important\n    }\n\n    .mso h3,\n    .ie h3 {\n    }\n\n    .mso .layout__inner p,\n    .ie .layout__inner p,\n    .mso .layout__inner ol,\n    .ie .layout__inner ol,\n    .mso .layout__inner ul,\n    .ie .layout__inner ul {\n    }\n</style>\n<meta name=\"robots\" content=\"noindex,nofollow\">\n\n<meta property=\"og:title\" content=\"Just One More Step\">\n\n<link href=\"https://css.createsend1.com/css/social.min.css?h=0ED47CE120160920\" media=\"screen,projection\" rel=\"stylesheet\" type=\"text/css\">\n\n\n<div class=\"wrapper\" style=\"min-width: 320px;background-color: #f5f7fa;\" lang=\"x-wrapper\">\n    <div class=\"preheader\" style=\"margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;\">\n        <div style=\"border-collapse: collapse;display: table;width: 100%;\">\n            <div class=\"snippet\" style=\"display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;padding: 10px 0 5px 0;color: #b9b9b9;\">\n            </div>\n            <div class=\"webversion\" style=\"display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;padding: 10px 0 5px 0;text-align: right;color: #b9b9b9;\">\n            </div>\n        </div>\n\n        <div class=\"layout one-col fixed-width\" style=\"margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;\">\n            <div class=\"layout__inner\" style=\"border-collapse: collapse;display: table;width: 100%;background-color: #c4e5dc;\" lang=\"x-layout__inner\">\n                <div class=\"column\" style=\"text-align: left;color: #60666d;font-size: 14px;line-height: 21px;max-width:600px;min-width:320px;\">\n                    <div style=\"margin-left: 20px;margin-right: 20px;margin-top: 24px;margin-bottom: 24px;\">\n                        <h1 style=\"margin-top: 0;margin-bottom: 0;font-style: normal;font-weight: normal;color: #44a8c7;font-size: 36px;line-height: 43px;font-family: bitter,georgia,serif;text-align: center;\">\n                            <img style=\"width: 200px;\" src=\"https://bug-finder.s3.ap-southeast-1.amazonaws.com/assets/logo/header-logo.svg\" data-filename=\"imageedit_76_3542310111.png\"></h1>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"layout one-col fixed-width\" style=\"margin: 0 auto;max-width: 600px;min-width: 320px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;\">\n                <div class=\"layout__inner\" style=\"border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;\" lang=\"x-layout__inner\">\n                    <div class=\"column\" style=\"text-align: left; background: rgb(237, 241, 235); line-height: 21px; max-width: 600px; min-width: 320px; width: 320px;\">\n\n                        <div style=\"color: rgb(96, 102, 109); font-size: 14px; margin-left: 20px; margin-right: 20px; margin-top: 24px;\">\n                            <div style=\"line-height:10px;font-size:1px\">&nbsp;</div>\n                        </div>\n\n                        <div style=\"margin-left: 20px; margin-right: 20px;\">\n\n                            <p style=\"color: rgb(96, 102, 109); font-size: 14px; margin-top: 16px; margin-bottom: 0px;\"><strong>Hello [[name]],</strong></p>\n                            <p style=\"color: rgb(96, 102, 109); font-size: 14px; margin-top: 20px; margin-bottom: 20px;\"><strong>[[message]]</strong></p>\n                            <p style=\"margin-top: 20px; margin-bottom: 20px;\"><strong style=\"color: rgb(96, 102, 109); font-size: 14px;\">Sincerely,<br>Team&nbsp;</strong><font color=\"#60666d\"><b>Bug Finder</b></font></p>\n                        </div>\n\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"layout__inner\" style=\"border-collapse: collapse;display: table;width: 100%;background-color: #2c3262; margin-bottom: 20px\" lang=\"x-layout__inner\">\n                <div class=\"column\" style=\"text-align: left;color: #60666d;font-size: 14px;line-height: 21px;max-width:600px;min-width:320px;\">\n                    <div style=\"margin-top: 5px;margin-bottom: 5px;\">\n                        <p style=\"margin-top: 0;margin-bottom: 0;font-style: normal;font-weight: normal;color: #ffffff;font-size: 16px;line-height: 35px;font-family: bitter,georgia,serif;text-align: center;\">\n                            2024 ©  All Right Reserved</p>\n                    </div>\n                </div>\n            </div>\n\n        </div>\n\n\n        <div style=\"border-collapse: collapse;display: table;width: 100%;\">\n            <div class=\"snippet\" style=\"display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;padding: 10px 0 5px 0;color: #b9b9b9;\">\n            </div>\n            <div class=\"webversion\" style=\"display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;padding: 10px 0 5px 0;text-align: right;color: #b9b9b9;\">\n            </div>\n        </div>\n    </div>\n</div>', 0, 0, 'pusher', 0, 0, 0, 0, 'XXXXXXXXXXXX', 0, 0, 'XXXXXXXXXXXX', 'XXXXXXXXXXXX', 0, 0, 1, 1, 1, 1, 1, 1, 1, 'XXXXXXXXXXXXXXX', 1, 0, 1, 'logo/2goyRo7MeBAt8eCZW0ZcHfP80SLiNZ.webp', 'local', 'logo/bB6DWZcUQbASh6YVkrUycuIFOkmON4.webp', 'local', 'logo/iriu4ngGjiHcqlj4eFCsLzUNSy0FY1.webp', 'local', 'logo/f1OTohWTyPMu9zhPkSXnVv4r24GjtO.webp', 'local', 'XXXXXXXXXXXX', 'everyMinute', 0, 'XXXXXXXXXXXX', 'everyMinute', 0, 'l, F j, Y', '+6283807914090', 0, 'We Use Cookies!', 'We use cookies to ensure that give you the best experience on your website.', 'See more', 'cookie-policy', 'cookie/mMlmi1wOgdEIIlB8S9Oxpp7kA8IcKT.webp', 'local', 'flex', 1, 30, 7, 1, 1, NULL, '2025-09-19 12:02:09', '#2c9cfe', '1.1.0', '25,26,27', '1', '#6f4ff2', '#292d32', '#6f4ff2', '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` int DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blog_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blog_image_driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_image` text COLLATE utf8mb4_unicode_ci,
  `banner_image_driver` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breadcrumb_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breadcrumb_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breadcrumb_image_driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_image_driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `category_id`, `slug`, `blog_image`, `blog_image_driver`, `banner_image`, `banner_image_driver`, `breadcrumb_status`, `breadcrumb_image`, `breadcrumb_image_driver`, `status`, `page_title`, `meta_title`, `meta_keywords`, `meta_description`, `meta_image`, `meta_image_driver`, `created_at`, `updated_at`) VALUES
(1, 2, 'guide-to-game-top-up', 'blog/bbMhuaLFzwzxgETDtTeW6M48AODiw5.webp', 'local', 'blog/9QB8k33amSURRmgZwhI6w7p4IvrB5W.webp', 'local', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-31 11:03:50', '2025-01-27 11:30:07'),
(2, 2, 'guide-to-gift-card', 'blog/IiAV8a9fLn5o0EM5YGE2RiibjcUZ3N.webp', 'local', 'blog/D4PnbbHSOS9hKiouMxRhWUxoRdqdZh.webp', 'local', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-31 11:09:07', '2025-09-19 04:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Top Up', 'top-up', 1, '2024-07-31 10:52:42', '2025-01-27 10:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `blog_details`
--

CREATE TABLE `blog_details` (
  `id` bigint UNSIGNED NOT NULL,
  `blog_id` int DEFAULT NULL,
  `language_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_details`
--

INSERT INTO `blog_details` (`id`, `blog_id`, `language_id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'The Ultimate Guide to Game Top-Up: Everything You Need to Know', '<h3>Introduction</h3><p>In the world of online gaming, game top-up services have become an essential part of the experience. Whether you\'re purchasing in-game currency, unlocking new content, or buying exclusive items, topping up your game account can enhance your gameplay and provide you with exciting opportunities. In this blog, we\'ll explore everything you need to know about game top-up services, from the benefits and methods to the best practices and tips for a smooth experience.</p><h3>What is a Game Top-Up?</h3><p>A game top-up is the process of adding funds or virtual currency to your gaming account. This can be used to purchase in-game items, skins, upgrades, or other digital goods. Game top-ups are typically done through online platforms, mobile apps, or directly within the game itself. They offer a convenient way for players to enhance their gaming experience by accessing premium content.</p><h3>Why Do Players Use Game Top-Up Services?</h3><ol><li><p><strong>Access to Exclusive Content</strong>: Many games offer exclusive items, characters, or levels that can only be accessed through in-game purchases. Top-up services enable players to acquire these items, giving them a competitive edge or unique customization options.</p></li><li><p><strong>Convenience</strong>: Game top-up services provide a quick and easy way to purchase in-game currency without the need for a credit card or bank transfer every time. This is especially useful for mobile gamers who prefer using prepaid cards or e-wallets.</p></li><li><p><strong>Promotions and Discounts</strong>: Players often receive bonuses, discounts, or promotional items when they top up their accounts. These offers can provide additional value and enhance the overall gaming experience.Popular Game Top-Up Methods</p></li></ol><ol><li><p><strong>Credit/Debit Cards</strong>: One of the most common methods, allowing players to use their bank cards to purchase in-game currency.</p></li><li><p><strong>E-Wallets</strong>: Platforms like PayPal, Skrill, and Payoneer offer secure and fast transactions for game top-ups.</p></li><li><p><strong>Prepaid Cards</strong>: Many players use prepaid cards like Google Play, iTunes, or specific game cards to top up their accounts without linking their bank accounts.</p></li><li><p><strong>Cryptocurrency</strong>: With the rise of digital currencies, some platforms accept cryptocurrencies like Bitcoin for game top-ups.</p></li><li><p><strong>Mobile Payment</strong>: Services like Apple Pay, Google Pay, and carrier billing allow players to charge purchases to their mobile phone bills.</p></li></ol><h3><br></h3><h3>Conclusion</h3><p>Game top-up services are a convenient and popular way for players to enhance their gaming experience. Whether you\'re looking to unlock exclusive content, gain a competitive edge, or simply enjoy the game more, understanding the ins and outs of game top-ups can help you make informed decisions. Remember to use reputable platforms, take advantage of promotions, and always practice responsible spending. Happy gaming!</p>', '2024-07-31 11:03:50', '2024-10-31 06:47:05'),
(2, 2, 1, 'The Ultimate Guide to Gift Cards: Everything You Need to Know', '<h3>Introduction</h3><p>Gift cards have become a popular and versatile gifting option for people of all ages. Whether you\'re looking for a last-minute present, a way to give someone the freedom to choose their gift, or a simple way to manage spending, gift cards offer a convenient solution. In this blog, we\'ll explore everything you need to know about gift cards, from the different types and benefits to tips for using them effectively.</p><h3>What Are Gift Cards?</h3><p>Gift cards are prepaid cards that contain a specific monetary value, which can be used to purchase goods or services from a particular retailer or a range of stores. They come in two main types: physical cards, which resemble traditional credit or debit cards, and digital (or e-gift) cards, which are delivered electronically via email or mobile apps.</p><h3>Types of Gift Cards</h3><ol><li><p><strong>Retailer-Specific Gift Cards</strong>: These cards are issued by a specific store or brand and can only be used at that retailer. Examples include Amazon, Starbucks, and Best Buy gift cards.</p></li><li><p><strong>Multi-Store Gift Cards</strong>: These cards can be used at multiple retailers within a specific group or network. Examples include shopping mall gift cards and gift cards from major payment networks like Visa, Mastercard, and American Express.</p></li><li><p><strong>Prepaid Debit Cards</strong>: These are versatile cards that can be used anywhere that accepts debit cards. They often come with fees but offer the flexibility of being used at a wide range of locations.</p></li><li><p><strong>Specialty Gift Cards</strong>: These include cards for specific services or experiences, such as spa treatments, movie tickets, or travel bookings.</p></li></ol><h3>Benefits of Gift Cards</h3><ol><li><p><strong>Convenience</strong>: Gift cards are easy to purchase and use, making them a hassle-free gifting option. They can be bought online or in-store and are available in various denominations.</p></li><li><p><strong>Flexibility</strong>: Recipients have the freedom to choose what they want to buy, ensuring they get something they truly desire. This is particularly useful for hard-to-shop-for individuals.</p></li><li><p><strong>Budget Management</strong>: For personal use, gift cards can help with budgeting by limiting spending to the card\'s value. This is especially helpful for sticking to a shopping budget or teaching kids about managing money.</p></li><li><p><strong>Last-Minute Gifting</strong>: Gift cards are an excellent solution for last-minute gifts, as they can be purchased and delivered instantly, especially digital gift cards.</p></li></ol><h3>How to Purchase and Redeem Gift Cards</h3><ol><li><p><strong>Buying Gift Cards</strong>: You can buy gift cards at retail stores, online, or through mobile apps. Many retailers also offer customizable options, allowing you to choose the card\'s design and value.</p></li><li><p><strong>Redeeming Gift Cards</strong>: To redeem a gift card, present it at the checkout (for physical cards) or enter the card code online (for digital cards). The card\'s value will be applied to your purchase, and any remaining balance can be used for future transactions.</p></li></ol><h3>Conclusion</h3><p>Gift cards are a practical and thoughtful gift option that offers recipients the freedom to choose their own gifts. Whether for birthdays, holidays, or special occasions, they provide convenience and flexibility. By understanding the different types of gift cards and how to use them effectively, you can make the most out of this versatile gifting option. Happy gifting!</p>', '2024-07-31 11:09:07', '2024-10-31 06:45:55'),
(11, 2, 2, 'La guía definitiva sobre tarjetas de regalo: todo lo que necesitas saber', '<p>Introducción</p><p>Las tarjetas de regalo se han convertido en una opción de regalo popular y versátil para personas de todas las edades. Ya sea que esté buscando un regalo de último momento, una forma de darle a alguien la libertad de elegir su regalo o una forma sencilla de administrar los gastos, las tarjetas de regalo ofrecen una solución conveniente. En este blog, exploraremos todo lo que necesita saber sobre las tarjetas de regalo, desde los diferentes tipos y beneficios hasta consejos para usarlas de manera efectiva.</p><p><br></p><p>¿Qué son las tarjetas de regalo?</p><p>Las tarjetas de regalo son tarjetas prepagas que contienen un valor monetario específico, que se puede utilizar para comprar bienes o servicios de un minorista en particular o una variedad de tiendas. Vienen en dos tipos principales: tarjetas físicas, que se parecen a las tarjetas de crédito o débito tradicionales, y tarjetas digitales (o de regalo electrónicas), que se envían electrónicamente a través de correo electrónico o aplicaciones móviles.</p><p><br></p><p>Tipos de tarjetas de regalo</p><p>Tarjetas de regalo específicas de un minorista: estas tarjetas son emitidas por una tienda o marca específica y solo se pueden usar en ese minorista. Algunos ejemplos incluyen tarjetas de regalo de Amazon, Starbucks y Best Buy.</p><p><br></p><p>Tarjetas de regalo de múltiples tiendas: estas tarjetas se pueden usar en múltiples minoristas dentro de un grupo o red específicos. Algunos ejemplos son las tarjetas de regalo de centros comerciales y las tarjetas de regalo de las principales redes de pago, como Visa, Mastercard y American Express.</p><p><br></p><p>Tarjetas de débito prepagas: son tarjetas versátiles que se pueden usar en cualquier lugar que acepte tarjetas de débito. Suelen tener comisiones, pero ofrecen la flexibilidad de poder usarse en una amplia variedad de lugares.</p><p><br></p><p>Tarjetas de regalo especiales: incluyen tarjetas para servicios o experiencias específicos, como tratamientos de spa, entradas de cine o reservas de viajes.</p><p><br></p><p>Beneficios de las tarjetas de regalo</p><p>Conveniencia: las tarjetas de regalo son fáciles de comprar y usar, lo que las convierte en una opción de regalo sin complicaciones. Se pueden comprar en línea o en la tienda y están disponibles en varias denominaciones.</p><p><br></p><p>Flexibilidad: los destinatarios tienen la libertad de elegir lo que quieren comprar, lo que garantiza que obtengan algo que realmente desean. Esto es particularmente útil para las personas a las que les resulta difícil comprar.</p><p><br></p><p>Gestión del presupuesto: para uso personal, las tarjetas de regalo pueden ayudar a elaborar un presupuesto al limitar el gasto al valor de la tarjeta. Esto es especialmente útil para ceñirse a un presupuesto de compras o enseñar a los niños a administrar el dinero.</p><p><br></p><p>Regalos de último momento: las tarjetas de regalo son una excelente solución para los regalos de último momento, ya que se pueden comprar y entregar al instante, especialmente las tarjetas de regalo digitales.</p><p><br></p><p>Cómo comprar y canjear tarjetas de regalo</p><p>Comprar tarjetas de regalo: puede comprar tarjetas de regalo en tiendas minoristas, en línea o mediante aplicaciones móviles. Muchos minoristas también ofrecen opciones personalizables, lo que le permite elegir el diseño y el valor de la tarjeta.</p><p><br></p><p>Canjear tarjetas de regalo: para canjear una tarjeta de regalo, preséntela en la caja (para tarjetas físicas) o ingrese el código de la tarjeta en línea (para tarjetas digitales). El valor de la tarjeta se aplicará a su compra y cualquier saldo restante se puede usar para futuras transacciones.</p><p><br></p><p>Conclusión</p><p>Las tarjetas de regalo son una opción de regalo práctica y considerada que ofrece a los destinatarios la libertad de elegir sus propios regalos. Ya sea para cumpleaños, días festivos u ocasiones especiales, brindan comodidad y flexibilidad. Si comprende los diferentes tipos de tarjetas de regalo y cómo usarlas de manera eficaz, puede aprovechar al máximo esta opción de obsequio versátil. ¡Feliz regalo!</p>', '2025-01-07 07:36:27', '2025-01-07 07:36:27'),
(12, 1, 2, 'La guía definitiva para recargar juegos: todo lo que necesitas saber', '<p>Introducción</p><p>En el mundo de los juegos en línea, los servicios de recarga de juegos se han convertido en una parte esencial de la experiencia. Ya sea que esté comprando moneda del juego, desbloqueando contenido nuevo o comprando artículos exclusivos, recargar su cuenta de juego puede mejorar su juego y brindarle oportunidades emocionantes. En este blog, exploraremos todo lo que necesita saber sobre los servicios de recarga de juegos, desde los beneficios y métodos hasta las mejores prácticas y consejos para una experiencia fluida.</p><p><br></p><p>¿Qué es una recarga de juego?</p><p>Una recarga de juego es el proceso de agregar fondos o moneda virtual a su cuenta de juego. Esto se puede usar para comprar artículos, aspectos, mejoras u otros bienes digitales del juego. Las recargas de juegos generalmente se realizan a través de plataformas en línea, aplicaciones móviles o directamente dentro del juego. Ofrecen una forma conveniente para que los jugadores mejoren su experiencia de juego al acceder a contenido premium.</p><p><br></p><p>¿Por qué los jugadores usan los servicios de recarga de juegos?</p><p>Acceso a contenido exclusivo: muchos juegos ofrecen artículos, personajes o niveles exclusivos a los que solo se puede acceder a través de compras dentro del juego. Los servicios de recarga permiten a los jugadores adquirir estos artículos, lo que les da una ventaja competitiva u opciones de personalización únicas.</p><p><br></p><p>Comodidad: los servicios de recarga de juegos brindan una forma rápida y sencilla de comprar moneda del juego sin la necesidad de una tarjeta de crédito o transferencia bancaria cada vez. Esto es especialmente útil para los jugadores móviles que prefieren usar tarjetas prepagas o billeteras electrónicas.</p><p><br></p><p>Promociones y descuentos: los jugadores a menudo reciben bonificaciones, descuentos o artículos promocionales cuando recargan sus cuentas. Estas ofertas pueden brindar valor adicional y mejorar la experiencia de juego en general. Métodos populares de recarga de juegos</p><p><br></p><p>Tarjetas de crédito/débito: uno de los métodos más comunes, que permite a los jugadores usar sus tarjetas bancarias para comprar moneda del juego.</p><p><br></p><p>Billeteras electrónicas: plataformas como PayPal, Skrill y Payoneer ofrecen transacciones seguras y rápidas para recargas de juegos.</p><p><br></p><p>Tarjetas prepagas: muchos jugadores usan tarjetas prepagas como Google Play, iTunes o tarjetas de juegos específicas para recargar sus cuentas sin vincular sus cuentas bancarias.</p><p><br></p><p>Criptomonedas: con el auge de las monedas digitales, algunas plataformas aceptan criptomonedas como Bitcoin para recargas de juegos.</p><p><br></p><p>Pago móvil: servicios como Apple Pay, Google Pay y facturación del operador permiten a los jugadores cargar las compras a sus facturas de telefonía móvil.</p><p><br></p><p>Conclusión</p><p>Los servicios de recarga de juegos son una forma conveniente y popular para que los jugadores mejoren su experiencia de juego. Ya sea que esté buscando desbloquear contenido exclusivo, obtener una ventaja competitiva o simplemente disfrutar más del juego, comprender los entresijos de las recargas de juegos puede ayudarlo a tomar decisiones informadas. Recuerde utilizar plataformas confiables, aprovechar las promociones y practicar siempre el gasto responsable. ¡Feliz juego!</p>', '2025-01-07 07:37:47', '2025-01-07 07:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=>off,1=>on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `instant_delivery` tinyint(1) NOT NULL DEFAULT '1',
  `image` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `guide` longtext COLLATE utf8mb4_unicode_ci,
  `sort_by` int DEFAULT NULL,
  `sell_count` int NOT NULL DEFAULT '0',
  `total_review` int NOT NULL DEFAULT '0',
  `avg_rating` float NOT NULL DEFAULT '0',
  `trending` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `card_services`
--

CREATE TABLE `card_services` (
  `id` bigint UNSIGNED NOT NULL,
  `card_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `image_driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `discount_type` enum('flat','percentage') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'flat',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=>off 1=>on',
  `is_offered` tinyint(1) NOT NULL DEFAULT '0',
  `offered_sell` int NOT NULL DEFAULT '0' COMMENT 'how many sell at the campaign',
  `max_sell` int NOT NULL DEFAULT '0' COMMENT 'max limit of sell in campaign',
  `sort_by` int NOT NULL DEFAULT '1',
  `old_data` text COLLATE utf8mb4_unicode_ci,
  `campaign_data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('top_up','card','game') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'card',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=>inactive,1=>active',
  `sort_by` int NOT NULL DEFAULT '1',
  `active_children` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `codes`
--

CREATE TABLE `codes` (
  `id` bigint UNSIGNED NOT NULL,
  `codeable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeable_id` bigint UNSIGNED NOT NULL,
  `passcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `name`, `type`, `media`, `created_at`, `updated_at`) VALUES
(1, 'topup', 'single', NULL, '2024-10-30 12:36:32', '2024-10-30 12:36:32'),
(2, 'promotion', 'single', NULL, '2024-10-30 12:36:57', '2024-10-30 12:36:57'),
(3, 'card', 'single', NULL, '2024-10-30 12:37:12', '2024-10-30 12:37:12'),
(4, 'blog', 'single', NULL, '2024-10-30 12:37:39', '2024-10-30 12:37:39'),
(5, 'feature', 'single', '{\"image\":{\"path\":\"contents\\/Cdx1KY09K4F9rBFqdhedzLPshYwdFN.webp\",\"driver\":\"local\"}}', '2024-10-30 12:38:51', '2024-10-30 12:46:28'),
(6, 'feature', 'multiple', NULL, '2024-10-30 12:39:09', '2024-10-30 12:39:09'),
(7, 'feature', 'multiple', NULL, '2024-10-30 12:39:17', '2024-10-30 12:39:17'),
(8, 'feature', 'multiple', NULL, '2024-10-30 12:39:25', '2024-10-30 12:39:25'),
(9, 'feature', 'multiple', NULL, '2024-10-30 12:39:34', '2024-10-30 12:39:34'),
(10, 'contact', 'single', '{\"my_link\":\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d193595.15830869428!2d-74.119763973046!3d40.69766374874431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1668508535036!5m2!1sen!2sbd\"}', '2024-10-30 12:42:44', '2024-10-30 12:42:44'),
(11, 'authentication', 'single', '{\"image\":{\"path\":\"contents\\/hys5bKhxaVRtiHJiU0i6L41txuSB7L.webp\",\"driver\":\"local\"}}', '2024-10-30 12:45:40', '2025-01-06 05:52:28'),
(12, 'footer', 'single', NULL, '2024-10-31 05:06:54', '2024-10-31 05:06:54'),
(13, 'social', 'single', '{\"my_link\":\"https:\\/\\/www.facebook.com\\/\",\"icon\":\"fab fa-facebook-f\"}', '2024-10-31 05:28:38', '2024-12-12 09:25:41'),
(14, 'social', 'multiple', '{\"my_link\":\"https:\\/\\/x.com\\/\",\"icon\":\"fab fa-twitter\"}', '2024-10-31 05:29:10', '2024-10-31 05:29:10'),
(15, 'social', 'multiple', '{\"my_link\":\"https:\\/\\/bd.linkedin.com\\/\",\"icon\":\"fab fa-linkedin\"}', '2024-10-31 05:29:37', '2024-10-31 05:29:37'),
(16, 'social', 'multiple', '{\"my_link\":\"https:\\/\\/www.instagram.com\\/\",\"icon\":\"fab fa-instagram\"}', '2024-10-31 05:30:03', '2024-10-31 05:30:03'),
(17, 'dark_hero', 'single', '{\"background_image\":{\"path\":\"contents\\/T9N6xELscfNdfjGBCw0cjx4WN0UV1x.webp\",\"driver\":\"local\"}}', '2024-12-09 06:32:41', '2024-12-09 07:01:32'),
(18, 'dark_hero', 'multiple', '{\"background_image\":{\"path\":\"contents\\/1RyB0xiKtBF3NDX5FpPiIZoWgG1ycx.webp\",\"driver\":\"local\"}}', '2024-12-09 06:34:35', '2024-12-09 06:34:35'),
(19, 'dark_hero', 'multiple', '{\"background_image\":{\"path\":\"contents\\/7e3mDBGEdorqr1dTbOrSKkiLq2LpRN.webp\",\"driver\":\"local\"}}', '2024-12-09 06:35:36', '2024-12-09 06:35:36'),
(20, 'dark_about', 'single', '{\"image\":{\"path\":\"contents\\/btdnwncth84In1kLNuX7Go6dIOSmHS.webp\",\"driver\":\"local\"},\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-10 12:52:52', '2025-09-19 13:17:35'),
(21, 'dark_exclusive_card', 'single', '{\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-11 04:40:58', '2024-12-11 04:40:58'),
(22, 'dark_campaign', 'single', '{\"image\":{\"path\":\"contents\\/6GGZRzmom2TXnCdXas8jAIS4Gg0gaE.webp\",\"driver\":\"local\"}}', '2024-12-11 05:26:17', '2024-12-11 05:26:17'),
(23, 'dark_top_up', 'single', '{\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-11 10:48:25', '2024-12-11 10:48:25'),
(24, 'dark_why_chose_us', 'single', '{\"image\":{\"path\":\"contents\\/84LB2IifH0m75yVzOsBkT8g0jdu3Ly.webp\",\"driver\":\"local\"}}', '2024-12-11 11:10:15', '2024-12-11 11:10:15'),
(25, 'dark_why_chose_us', 'multiple', NULL, '2024-12-11 11:16:53', '2024-12-11 11:16:53'),
(26, 'dark_why_chose_us', 'multiple', NULL, '2024-12-11 11:17:13', '2024-12-11 11:17:13'),
(27, 'dark_why_chose_us', 'multiple', NULL, '2024-12-11 11:17:31', '2024-12-11 11:17:31'),
(28, 'dark_testimonial', 'single', '{\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-11 11:36:29', '2024-12-11 11:36:29'),
(29, 'dark_testimonial', 'multiple', '{\"image\":{\"path\":\"contents\\/piyw5Pi9eJz4Mgm4SCsW3l3er48SMh.webp\",\"driver\":\"local\"}}', '2024-12-11 11:37:29', '2024-12-11 11:37:29'),
(30, 'dark_testimonial', 'multiple', '{\"image\":{\"path\":\"contents\\/ATovNLppZpliN5gJgAh5KQATtxJrH2.webp\",\"driver\":\"local\"}}', '2024-12-11 11:38:22', '2024-12-11 11:38:22'),
(31, 'dark_testimonial', 'multiple', '{\"image\":{\"path\":\"contents\\/tHdBtmmNTK9nTLZ6fKzcf1tvO01sR8.webp\",\"driver\":\"local\"}}', '2024-12-11 11:38:38', '2024-12-11 11:38:38'),
(32, 'dark_blog', 'single', '{\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-11 12:05:29', '2024-12-11 12:05:29'),
(33, 'footer', 'multiple', '{\"my_link\":\"https:\\/\\/www.facebook.com\\/\",\"icon\":\"fab fa-facebook-f\"}', '2024-12-12 07:33:04', '2024-12-12 07:34:52'),
(34, 'footer', 'multiple', '{\"my_link\":\"https:\\/\\/www.x.com\\/\",\"icon\":\"fab fa-twitter\"}', '2024-12-12 07:33:29', '2024-12-12 07:35:10'),
(35, 'footer', 'multiple', '{\"my_link\":\"https:\\/\\/www.linkedin.com\\/\",\"icon\":\"fab fa-linkedin\"}', '2024-12-12 07:33:59', '2024-12-12 07:35:24'),
(36, 'footer', 'multiple', '{\"my_link\":\"https:\\/\\/www.instagram.com\\/\",\"icon\":\"fab fa-instagram\"}', '2024-12-12 07:34:26', '2024-12-12 07:35:35'),
(37, 'dark_contact', 'single', '{\"image\":{\"path\":\"contents\\/CVDLOSZavcxz3wDsI3GxsMtfEXfA8K.webp\",\"driver\":\"local\"}}', '2024-12-12 10:26:07', '2024-12-12 10:26:07'),
(38, 'light_blog', 'single', '{\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-19 04:32:45', '2024-12-19 04:32:45'),
(39, 'light_testimonial', 'single', '{\"image\":{\"path\":\"contents\\/4gqHFkWDUadeys8AgvX6VSkEQA6nri.webp\",\"driver\":\"local\"}}', '2024-12-19 05:00:58', '2024-12-19 05:00:59'),
(40, 'light_testimonial', 'multiple', '{\"image\":{\"path\":\"contents\\/8RLcIrdj2RjVotIVz08tM10VtYYvsW.webp\",\"driver\":\"local\"}}', '2024-12-19 05:02:49', '2024-12-19 05:02:49'),
(41, 'light_testimonial', 'multiple', '{\"image\":{\"path\":\"contents\\/LY3WLtDV4MvmNvLDTAEp1uRurXO6TO.webp\",\"driver\":\"local\"}}', '2024-12-19 05:03:34', '2024-12-19 05:03:34'),
(42, 'light_testimonial', 'multiple', '{\"image\":{\"path\":\"contents\\/WBZpY2fvziMwONoXmR7Om3ijBcPVos.webp\",\"driver\":\"local\"}}', '2024-12-19 05:04:02', '2024-12-19 05:04:02'),
(43, 'light_why_chose_us', 'single', '{\"image\":{\"path\":\"contents\\/HWURlhW8c3iFLufTglFdZieYpzVL6X.webp\",\"driver\":\"local\"},\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-19 05:52:24', '2024-12-19 05:52:24'),
(44, 'light_why_chose_us', 'multiple', NULL, '2024-12-19 05:53:00', '2024-12-19 05:53:00'),
(45, 'light_why_chose_us', 'multiple', NULL, '2024-12-19 05:53:52', '2024-12-19 05:53:52'),
(46, 'light_why_chose_us', 'multiple', NULL, '2024-12-19 05:54:09', '2024-12-19 05:54:09'),
(47, 'light_why_chose_us', 'multiple', NULL, '2024-12-19 05:54:25', '2024-12-19 05:54:25'),
(48, 'light_top_up', 'single', '{\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-19 06:10:40', '2024-12-19 06:10:40'),
(49, 'light_campaign', 'single', '{\"image\":{\"path\":\"contents\\/y7bByQCD00PaLoVgupnnHgdgsciitx.webp\",\"driver\":\"local\"}}', '2024-12-19 06:56:18', '2024-12-19 06:56:26'),
(50, 'light_about', 'single', '{\"image\":{\"path\":\"contents\\/8vVjw7LOSskVOiGKOGi5vAAxmP7ZGN.webp\",\"driver\":\"local\"},\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-19 07:32:06', '2024-12-19 07:32:06'),
(51, 'light_brand', 'multiple', '{\"icon\":\"fa-regular fa-star-of-life\"}', '2024-12-19 07:42:15', '2024-12-19 07:42:15'),
(52, 'light_brand', 'multiple', '{\"icon\":\"fa-regular fa-star-of-life\"}', '2024-12-19 07:42:30', '2024-12-19 07:42:30'),
(53, 'light_brand', 'multiple', '{\"icon\":\"fa-regular fa-star-of-life\"}', '2024-12-19 07:42:39', '2024-12-19 07:42:39'),
(54, 'light_brand', 'multiple', '{\"icon\":\"fa-regular fa-star-of-life\"}', '2024-12-19 07:42:56', '2024-12-19 07:42:56'),
(55, 'light_brand', 'multiple', '{\"icon\":\"fa-regular fa-star-of-life\"}', '2024-12-19 07:43:28', '2024-12-19 07:43:28'),
(56, 'light_brand', 'multiple', '{\"icon\":\"fa-regular fa-star-of-life\"}', '2024-12-19 07:43:52', '2024-12-19 07:43:52'),
(57, 'light_brand', 'multiple', '{\"icon\":\"fa-regular fa-star-of-life\"}', '2024-12-19 07:44:20', '2024-12-19 07:44:20'),
(58, 'light_brand', 'multiple', '{\"icon\":\"fa-regular fa-star-of-life\"}', '2024-12-19 07:44:33', '2024-12-19 07:44:33'),
(59, 'light_exclusive_card', 'single', '{\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-19 07:55:58', '2024-12-19 07:55:58'),
(60, 'light_trending_item', 'single', NULL, '2024-12-19 09:27:27', '2024-12-19 09:27:27'),
(62, 'light_hero', 'multiple', '{\"image\":{\"path\":\"contents\\/ARPiIA2P0wFohNFwMVdk4MAvSG8CbS.webp\",\"driver\":\"local\"},\"image_two\":{\"path\":\"contents\\/FvVwW5GOQqTUFaOfjkNPrgxfJozoyD.webp\",\"driver\":\"local\"},\"image_three\":{\"path\":\"contents\\/Ux0tO9vqDoBtSylUaUi932y7X05u1T.webp\",\"driver\":\"local\"},\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-19 10:36:10', '2024-12-19 10:36:11'),
(63, 'light_hero', 'multiple', '{\"image\":{\"path\":\"contents\\/dQxsVMHsh5KqmuB3PBdGRYZ0X6n18j.webp\",\"driver\":\"local\"},\"image_two\":{\"path\":\"contents\\/qzpDPvZPiIip8mLa8q9mNb5L1XtG5r.webp\",\"driver\":\"local\"},\"image_three\":{\"path\":\"contents\\/toUw3FfQl6toAhAuelFIKIJtDdToQD.webp\",\"driver\":\"local\"},\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-19 10:40:25', '2024-12-19 10:40:25'),
(64, 'light_contact', 'single', NULL, '2024-12-19 10:59:28', '2024-12-19 10:59:28'),
(65, 'light_buy_game_id', 'single', '{\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-29 05:14:06', '2024-12-29 05:14:06'),
(66, 'dark_buy_game_id', 'single', '{\"button_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-12-29 12:46:50', '2024-12-29 12:46:50'),
(67, 'app_page', 'single', '{\"image\":{\"path\":\"contents\\/kdkGyFBVnw1qD4C09mAckdHPMnSz4S.webp\",\"driver\":\"local\"}}', '2025-02-04 09:33:49', '2025-02-04 09:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `content_details`
--

CREATE TABLE `content_details` (
  `id` bigint UNSIGNED NOT NULL,
  `content_id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_details`
--

INSERT INTO `content_details` (`id`, `content_id`, `language_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '{\"heading\":\"Popular Top Up\"}', '2024-10-30 12:36:32', '2024-10-30 12:36:32'),
(2, 2, 1, '{\"heading\":\"More currently trending offers\",\"sub_heading\":\"Don\'t miss out \\u2013 grab them while you still have the chance!\"}', '2024-10-30 12:36:57', '2024-10-30 12:36:57'),
(3, 3, 1, '{\"heading\":\"Latest Card\"}', '2024-10-30 12:37:12', '2024-10-30 12:37:12'),
(4, 4, 1, '{\"heading\":\"Popular Blog\",\"button_name\":\"Explore More\"}', '2024-10-30 12:37:39', '2024-10-30 12:37:39'),
(5, 5, 1, '{\"heading\":\"What G2BUlP Can Provide\",\"sub_heading\":\"Dynamically deliver multidisciplinary infrastructures via revolution process products deliverables premium after just in time scenarios.\"}', '2024-10-30 12:38:51', '2024-10-30 12:38:51'),
(6, 6, 1, '{\"heading\":\"Multiple Payment Methods\",\"sub_heading\":\"Completely synergize B2C paradigms through researched technology. Credibly term high-impact imperatives.\"}', '2024-10-30 12:39:09', '2024-10-30 12:39:09'),
(7, 7, 1, '{\"heading\":\"Promotions for various Region\",\"sub_heading\":\"Completely synergize B2C paradigms through researched technology. Credibly term high-impact imperatives.\"}', '2024-10-30 12:39:17', '2024-10-30 12:39:17'),
(8, 8, 1, '{\"heading\":\"Protection of user privacy\",\"sub_heading\":\"Completely synergize B2C paradigms through researched technology. Credibly term high-impact imperatives.\"}', '2024-10-30 12:39:25', '2024-10-30 12:39:25'),
(9, 9, 1, '{\"heading\":\"Protection of user privacy\",\"sub_heading\":\"Completely synergize B2C paradigms through researched technology. Credibly term high-impact imperatives.\"}', '2024-10-30 12:39:34', '2024-10-30 12:39:34'),
(10, 10, 1, '{\"phone\":\"+45345847431324\",\"email\":\"demo@example.com\",\"address\":\"22 Baker Street, London\",\"contact_heading\":\"Contact Information\",\"contact_sub_heading\":\"Give us a call or drop by anytime, we endeavour to answer all enquiries within 24 hours on business days. We will be happy to answer your questions.\",\"message_heading\":\"We\\u2019re always here for you\",\"message_sub_heading\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia blanditiis consequuntur rem, sit itaque impedit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam consequatur Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sequi, perferendis?\"}', '2024-10-30 12:42:44', '2024-10-30 12:42:44'),
(11, 11, 1, '{\"login_page_heading\":\"Welcome back!\",\"login_page_sub_heading\":\"Hey Enter your details to get sign in to your account\",\"register_page_heading\":\"Welcome back!\",\"register_page_sub_heading\":\"Hey Enter your details to get sign in to your account\"}', '2024-10-30 12:45:40', '2024-10-30 12:45:40'),
(12, 12, 1, '{\"newsletter_text\":\"Subscribe Newsletter\",\"newsletter_button\":\"Subscribe\",\"message\":\"Need to get in touch with us ? Please contact with us with email.\",\"footer_email\":\"example@gmail.com\",\"footer_location\":\"Jl. Puspitek, Setu, Kec. Serpong, Kota Tangerang Selatan, Banten 15314\",\"footer_phone\":\"6283807914090\",\"copyright_text_one\":\"Copyright \\u00a92024\",\"copyright_text_two\":\"All Rights Reserved!\",\"app_store_link\":\"https:\\/\\/xead.my.id\\/\",\"google_store_link\":\"https:\\/\\/xead.my.id\\/\"}', '2024-10-31 05:06:54', '2025-09-19 12:01:55'),
(13, 13, 1, '{\"footer_email\":\"example@gmail.com\",\"footer_location\":\"Jl. Puspitek, Setu, Kec. Serpong, Kota Tangerang Selatan, Banten 15314\",\"footer_phone\":\"6283807914090\"}', '2024-10-31 05:28:38', '2025-09-19 12:01:40'),
(14, 14, 1, '{\"name\":\"Twitter\"}', '2024-10-31 05:29:10', '2024-10-31 05:29:10'),
(15, 15, 1, '{\"name\":\"Linkedin\"}', '2024-10-31 05:29:37', '2024-10-31 05:29:37'),
(16, 16, 1, '{\"name\":\"Instagram\"}', '2024-10-31 05:30:03', '2024-10-31 05:30:03'),
(17, 17, 1, '{\"trend_title\":\"Trending Items\",\"trend_sub_title\":\"Don\'t miss out\\u2014grab yours now!\"}', '2024-12-09 06:32:42', '2024-12-09 07:01:32'),
(18, 18, 1, '{\"title\":\"Warrior\'s Path Resurrection\",\"sub_title\":\"25% Off Get Unlimited Offer\",\"description\":\"Exchange skins get new once with best conditions\",\"kew-text\":\"Grab the offer\",\"box_type\":\"dark-moderate-blue-box\"}', '2024-12-09 06:34:35', '2024-12-09 06:42:42'),
(19, 19, 1, '{\"title\":\"Dragon Quest Remake EN United States\",\"sub_title\":\"25% Off Get Unlimited Offer\",\"description\":\"Exchange skins get new once with best conditions\",\"kew-text\":\"Grab the offer\",\"box_type\":\"very-light-blue-box\"}', '2024-12-09 06:35:36', '2024-12-09 06:43:00'),
(20, 20, 1, '{\"title\":\"About GameShop\",\"description\":\"<div style=\\\"color: rgb(8, 8, 8);\\\"><pre style=\\\"font-family:\'JetBrains Mono\',monospace;font-size:11.3pt;\\\">GameMart is a premier digital marketplace for purchasing top-ups, gift cards, and in-game<br>currencies, offering gamers a fast and hassle-free way to elevate their gaming adventures.<br>Whether you\\u2019re recharging your<br>favorite game or gifting credits, GameMart delivers reliable and efficient solutions<br>tailored to your gaming needs..\\r\\n\\r\\n<div><pre style=\\\"font-family:\'JetBrains Mono\',monospace;font-size:11.3pt;\\\">GameMart stands out with its exclusive discounts, seasonal promotions, and<br>intuitive platform, making it the ultimate destination for gamers around the globe.<\\/pre><\\/div><\\/pre><\\/div>\",\"button\":\"know More\"}', '2024-12-10 12:52:53', '2025-09-19 04:35:11'),
(21, 21, 1, '{\"title\":\"Exclusive Card\",\"sub_title\":\"Don\'t miss our limited-time offers!  Discover current deals today!\",\"button\":\"Explore More\"}', '2024-12-11 04:40:58', '2024-12-22 05:46:02'),
(22, 22, 1, '{\"heading\":\"Flash Deal\",\"title\":\"Flash Sale offers\",\"sub_title\":\"Don\'t miss out \\u2013 grab them while you still have the chance!\"}', '2024-12-11 05:26:17', '2024-12-11 05:26:17'),
(23, 23, 1, '{\"title\":\"Game Top-Up Offers! \\ud83d\\udd25\",\"sub_title\":\"Don\'t miss our limited-time offers! Discover current deals today!\",\"button\":\"Explore More\"}', '2024-12-11 10:48:25', '2024-12-22 05:46:28'),
(24, 24, 1, '{\"title\":\"Experience the Difference with Us\",\"sub_title\":\"Delivering quality, reliability, and innovation every step of the way.\"}', '2024-12-11 11:10:15', '2024-12-11 11:10:15'),
(25, 25, 1, '{\"title\":\"Affordable Pricing\",\"description\":\"Enjoy premium services without breaking the bank. We offer competitive rates tailored to your budget\"}', '2024-12-11 11:16:53', '2024-12-11 11:16:53'),
(26, 26, 1, '{\"title\":\"Exceptional Support\",\"description\":\"Our dedicated team is available 24\\/7 to assist you, ensuring a seamless experience from start to finish.\"}', '2024-12-11 11:17:13', '2024-12-11 11:17:13'),
(27, 27, 1, '{\"title\":\"Trusted by Thousands\",\"description\":\"Join a community of happy customers who trust us for our reliability and outstanding results.\"}', '2024-12-11 11:17:31', '2024-12-11 11:17:31'),
(28, 28, 1, '{\"title\":\"Real success stories from our clients\",\"button\":\"Explore More\"}', '2024-12-11 11:36:29', '2024-12-11 11:36:29'),
(29, 29, 1, '{\"name\":\"Vladimir Putin\",\"location\":\"Moscow, Russia\",\"review\":\"Murah Meriah Cuy\",\"rating\":\"5\"}', '2024-12-11 11:37:29', '2025-09-19 13:32:13'),
(30, 30, 1, '{\"name\":\"Kim Jong Un\",\"location\":\"Pyongpyang, Korut\",\"review\":\"Ketagihan Top Up Disini\",\"rating\":\"5\"}', '2024-12-11 11:38:22', '2025-09-19 13:31:54'),
(31, 31, 1, '{\"name\":\"Xi Jinping\",\"location\":\"Beijing, China\",\"review\":\"Selalu ada paket hemat \\ud83d\\ude01\",\"rating\":\"5\"}', '2024-12-11 11:38:38', '2025-09-19 13:32:39'),
(32, 32, 1, '{\"title\":\"Updated Blogs Post\",\"button\":\"Explore More\"}', '2024-12-11 12:05:29', '2024-12-11 12:05:29'),
(33, 33, 1, '{\"name\":\"Facebook\"}', '2024-12-12 07:33:04', '2024-12-12 07:33:04'),
(34, 34, 1, '{\"name\":\"Twitter\"}', '2024-12-12 07:33:29', '2024-12-12 07:33:29'),
(35, 35, 1, '{\"name\":\"LinkedIn\"}', '2024-12-12 07:33:59', '2024-12-12 07:33:59'),
(36, 36, 1, '{\"name\":\"Instagram\"}', '2024-12-12 07:34:26', '2024-12-12 07:34:26'),
(37, 37, 1, '{\"title\":\"Keep In Touch With Us.\",\"sub_title\":\"Neque convallis a cras semper auctor. Libero id faucibus nisl tincidunt egetnvallis.\",\"form_title\":\"Send a Message\",\"form_sub_title\":\"Let\'s Ask Your Questions\",\"email\":\"demo@example.com\",\"location\":\"Jl. Puspitek, Setu, Kec. Serpong, Kota Tangerang Selatan, Banten 15314\",\"phone\":\"+6283807914090\",\"button\":\"Send a massage\"}', '2024-12-12 10:26:07', '2025-09-19 12:04:14'),
(38, 38, 1, '{\"title\":\"Updated Blogs Post\",\"button\":\"view all\"}', '2024-12-19 04:32:45', '2024-12-19 04:32:45'),
(39, 39, 1, '{\"title\":\"What\'s our Customer say\",\"sub_title\":\"GEMOT is my go-to platform for game top-ups and gift cards. Their service is always quick, and the  process is hassle-free. Highly recommended!\"}', '2024-12-19 05:00:59', '2024-12-19 05:00:59'),
(40, 40, 1, '{\"name\":\"Jim Morison\",\"location\":\"London, UK\",\"review\":\"Gamify is a paradise for gamers! I discovered amazing tips, connected with fellow gamers, and leveled up my skills like never before!\",\"rating\":\"5\"}', '2024-12-19 05:02:49', '2024-12-19 05:02:49'),
(41, 41, 1, '{\"name\":\"Jim Morison\",\"location\":\"London, UK\",\"review\":\"Thanks to Gamify, I found my perfect gaming community. The tournaments and discussions here are next-level. Truly a gamer\'s haven!\",\"rating\":\"5\"}', '2024-12-19 05:03:34', '2024-12-19 05:03:34'),
(42, 42, 1, '{\"name\":\"Jim Morison\",\"location\":\"London, UK\",\"review\":\"From the latest game reviews to strategies, Gamify has it all. It\\u2019s my go-to hub for everything gaming!\",\"rating\":\"5\"}', '2024-12-19 05:04:02', '2024-12-19 05:04:02'),
(43, 43, 1, '{\"title\":\"Experience the Difference with Us\",\"sub_title\":\"Delivering quality, reliability, and innovation every step of the way.\",\"button\":\"learn more\"}', '2024-12-19 05:52:24', '2024-12-19 05:52:24'),
(44, 44, 1, '{\"title\":\"Affordable Pricing\",\"description\":\"Enjoy premium services without breaking the bank. We offer competitive rates tailored to your budget\"}', '2024-12-19 05:53:00', '2024-12-19 05:53:00'),
(45, 45, 1, '{\"title\":\"Exceptional Support\",\"description\":\"Our dedicated team is available 24\\/7 to assist you, ensuring a seamless experience from start to finish.\"}', '2024-12-19 05:53:52', '2024-12-19 05:53:52'),
(46, 46, 1, '{\"title\":\"Trusted by Thousands\",\"description\":\"Join a community of happy customers who trust us for our reliability and outstanding results.\"}', '2024-12-19 05:54:09', '2024-12-19 05:54:09'),
(47, 47, 1, '{\"title\":\"Instant Delivery\",\"description\":\"Get purchases instantly! Our system ensures your in-game  currency or digital products are just a click away.\"}', '2024-12-19 05:54:25', '2024-12-19 05:54:25'),
(48, 48, 1, '{\"title\":\"Game Top-Up Offers! \\ud83d\\udd25\",\"sub_title\":\"Don\'t miss our limited-time offers! Discover current deals today!\",\"button\":\"view all\"}', '2024-12-19 06:10:40', '2024-12-22 05:57:45'),
(49, 49, 1, '{\"heading\":\"Flash Deal\",\"title\":\"Flash Sale offers\",\"sub_title\":\"Don\'t miss out \\u2013 grab them while you still have the chance!\"}', '2024-12-19 06:56:18', '2024-12-19 06:56:18'),
(50, 50, 1, '{\"title\":\"About GameShop\",\"description\":\"<div style=\\\"\\\"><pre style=\\\"\\\"><pre style=\\\"font-family: &quot;JetBrains Mono&quot;, monospace; font-size: 11.3pt; color: rgb(8, 8, 8);\\\">GameMart is a premier digital marketplace for purchasing top-ups, gift cards, and in-game<br>currencies, offering gamers a fast and hassle-free way to elevate their gaming adventures.<br>Whether you\\u2019re recharging your<br>favorite game or gifting credits, GameMart delivers reliable and efficient solutions<br>tailored to your gaming needs..\\r\\n\\r\\n<div><pre style=\\\"font-family: &quot;JetBrains Mono&quot;, monospace; font-size: 11.3pt;\\\">GameMart stands out with its exclusive discounts, seasonal promotions, and intuitive platform, making it the ultimate destination for gamers around the globe.<\\/pre><\\/div><\\/pre><\\/pre><\\/div>\",\"button\":\"know more\"}', '2024-12-19 07:32:06', '2024-12-21 10:55:57'),
(51, 51, 1, '{\"item\":\"Game Top-Up\"}', '2024-12-19 07:42:15', '2024-12-19 07:42:15'),
(52, 52, 1, '{\"item\":\"Digital Vouchers\"}', '2024-12-19 07:42:30', '2024-12-19 07:42:30'),
(53, 53, 1, '{\"item\":\"In-Game Currency\"}', '2024-12-19 07:42:39', '2024-12-19 07:42:39'),
(54, 54, 1, '{\"item\":\"Exclusive Deals\"}', '2024-12-19 07:42:56', '2024-12-19 07:42:56'),
(55, 55, 1, '{\"item\":\"Gift Cards\"}', '2024-12-19 07:43:28', '2024-12-19 07:43:28'),
(56, 56, 1, '{\"item\":\"Membership Codes\"}', '2024-12-19 07:43:52', '2024-12-19 07:43:52'),
(57, 57, 1, '{\"item\":\"Promo Bundles\"}', '2024-12-19 07:44:20', '2024-12-19 07:44:20'),
(58, 58, 1, '{\"item\":\"Special Gaming Offers\"}', '2024-12-19 07:44:33', '2024-12-19 07:44:33'),
(59, 59, 1, '{\"title\":\"Exclusive Cards\",\"sub_title\":\"Don\'t miss our limited-time offers! Discover current deals today!\",\"button\":\"view all\"}', '2024-12-19 07:55:58', '2024-12-22 05:49:11'),
(60, 60, 1, '{\"title\":\"Card Items\",\"sub_title\":\"Don\'t miss out\\u2014grab yours now!\"}', '2024-12-19 09:27:27', '2024-12-22 06:00:08'),
(62, 62, 1, '{\"title\":\"25% Off Get Unlimited Offer\",\"sub_title\":\"Relive the Shattering Cataclysm Arrives\",\"description\":\"Exchange skins get new once with best conditions\",\"button\":\"know more\"}', '2024-12-19 10:36:11', '2024-12-19 10:36:11'),
(63, 63, 1, '{\"title\":\"25% Off Get Unlimited Offer\",\"sub_title\":\"Relive the Shattering Cataclysm Arrives\",\"description\":\"Exchange skins get new once with best conditions\",\"button\":\"know more\"}', '2024-12-19 10:40:25', '2024-12-19 10:40:25'),
(64, 64, 1, '{\"title\":\"Contact Information\",\"sub_title\":\"Give us a call or drop by anytime, we endeavour to answer all enquiries within 24 hours on business days. We will be happy to answer your questions.\",\"form_title\":\"We\\u2019re always here for you\",\"form_sub_title\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia blanditiis consequuntur rem, sit itaque impedit. Lorem ipsum dolor sit amet consectetur  adipisicing elit. Quam consequatur Lorem ipsum dolor sit, amet consectetur  adipisicing elit. Sequi, perferendis?\",\"email\":\"demo@example.com\",\"location\":\"22 Baker Street, London\",\"phone\":\"+45345847431324\",\"button\":\"Send a massage\"}', '2024-12-19 10:59:28', '2024-12-19 10:59:28'),
(65, 65, 1, '{\"title\":\"Buy Game IDs! \\ud83c\\udfae\",\"sub_title\":\"Exclusive Limited-Time Offers Just for You!\",\"button\":\"view all\"}', '2024-12-29 05:14:06', '2024-12-29 05:14:06'),
(66, 66, 1, '{\"title\":\"Buy Game IDs! \\ud83c\\udfae\",\"sub_title\":\"Exclusive Limited-Time Offers Just for You!\",\"button\":\"Explore more\"}', '2024-12-29 12:46:50', '2024-12-29 12:47:28'),
(135, 67, 1, '{\"heading\":\"Enjoy the Game\",\"sub_heading\":\"GAMESHOP UNIVERSE\",\"button_name\":\"Shop Now\"}', '2025-02-04 09:33:49', '2025-02-04 09:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discount` float DEFAULT '0',
  `discount_type` enum('percent','flat') COLLATE utf8mb4_general_ci DEFAULT 'percent',
  `used_limit` int NOT NULL DEFAULT '0',
  `is_unlimited` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=>no,1=>yes',
  `top_up_list` longtext COLLATE utf8mb4_general_ci,
  `card_list` longtext COLLATE utf8mb4_general_ci,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `total_use` int NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` text COLLATE utf8mb4_unicode_ci,
  `rate` double NOT NULL DEFAULT '1' COMMENT '1 base currency = rate',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=>inactive,1=>active',
  `sort_by` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint UNSIGNED NOT NULL,
  `depositable_id` int DEFAULT NULL,
  `depositable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint UNSIGNED DEFAULT NULL,
  `payment_method_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `amount_in_base` double NOT NULL DEFAULT '0',
  `percentage_charge` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `fixed_charge` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `payable_amount` decimal(18,8) NOT NULL DEFAULT '0.00000000' COMMENT 'Amount payed',
  `btc_amount` decimal(18,8) DEFAULT NULL,
  `btc_wallet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `information` text COLLATE utf8mb4_unicode_ci,
  `trx_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=pending, 1=success, 2=request, 3=rejected',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_crypto_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_storages`
--

CREATE TABLE `file_storages` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 => active, 0 => inactive',
  `parameters` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_storages`
--

INSERT INTO `file_storages` (`id`, `code`, `name`, `status`, `parameters`, `created_at`, `updated_at`) VALUES
(1, 's3', 'Amazon S3', 0, '{\"access_key_id\":\"XXXXXXXXXX\",\"secret_access_key\":\"XXXXXXXXXXXX\",\"default_region\":\"blr1\",\"bucket\":\"XXXXXXXXXXXX\",\"url\":\"https:\\/\\/g2bulk.blr1.digitaloceanspaces.com\",\"endpoint\":\"https:\\/\\/blr1.digitaloceanspaces.com\"}', NULL, '2025-03-09 05:33:06'),
(2, 'sftp', 'SFTP', 0, '{\"sftp_username\":\"XXXXXXXXXXXXX\",\"sftp_password\":\"XXXXXXXXXXXXX\"}', NULL, '2025-03-09 05:33:23'),
(3, 'do', 'Digitalocean Spaces', 0, '{\"spaces_key\":\"XXXXXXXXXXXX\",\"spaces_secret\":\"XXXXXXXXXXXXXXX\",\"spaces_endpoint\":\"XXXXXXXXXXXX\",\"spaces_region\":\"XXXXXXXXXXXXX\",\"spaces_bucket\":\"assets-coral\"}', NULL, '2025-03-09 05:33:35'),
(4, 'ftp', 'FTP', 0, '{\"ftp_host\":\"XXXXXXXXXX\",\"ftp_username\":\"XXXXXXXXXXXXX\",\"ftp_password\":\"XXXXXXXXXXXX\"}', NULL, '2025-03-09 05:33:44'),
(5, 'local', 'Local Storage', 1, NULL, NULL, '2025-03-03 03:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `fire_base_tokens`
--

CREATE TABLE `fire_base_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_id` int DEFAULT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_by` int DEFAULT '1',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: inactive, 1: active',
  `parameters` text COLLATE utf8mb4_unicode_ci,
  `currencies` text COLLATE utf8mb4_unicode_ci,
  `extra_parameters` text COLLATE utf8mb4_unicode_ci,
  `supported_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receivable_currencies` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `currency_type` tinyint(1) NOT NULL DEFAULT '1',
  `is_sandbox` tinyint(1) NOT NULL DEFAULT '0',
  `environment` enum('test','live') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'live',
  `is_manual` tinyint(1) DEFAULT '1',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `code`, `name`, `sort_by`, `image`, `driver`, `status`, `parameters`, `currencies`, `extra_parameters`, `supported_currency`, `receivable_currencies`, `description`, `currency_type`, `is_sandbox`, `environment`, `is_manual`, `note`, `created_at`, `updated_at`) VALUES
(1, 'paypal', 'Paypal', 6, 'gateway/Nk4vMzucK39NN3enEZLxHKyUm8LYCC.webp', 'local', 1, '{\"cleint_id\":\"XXXXXXXXXXXXXXXX\",\"secret\":\"XXXXXXXXXXXXXXXXX\"}', '{\"0\":{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"USD\"}}', NULL, '[\"USD\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0083\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:39:46'),
(2, 'stripe', 'Stripe', 1, 'gateway/fkcARCIw6q6Fb3DY1AIS3FvxCc0khe.webp', 'local', 1, '{\"secret_key\":\"XXXXXXXXXXXX\",\"publishable_key\":\"XXXXXXXXXXXXXXXX\"}', '{\"0\":{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}}', NULL, '[\"USD\",\"EUR\",\"GBP\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"1\",\"min_limit\":\"0.1\",\"max_limit\":\"100000\",\"percentage_charge\":\"1\",\"fixed_charge\":\"0\"},{\"name\":\"EUR\",\"currency_symbol\":\"EUR\",\"conversion_rate\":\"0.94\",\"min_limit\":\"0.1\",\"max_limit\":\"100000\",\"percentage_charge\":\"1\",\"fixed_charge\":\"0\"},{\"name\":\"GBP\",\"currency_symbol\":\"GBP\",\"conversion_rate\":\"0.78\",\"min_limit\":\"0.1\",\"max_limit\":\"100000\",\"percentage_charge\":\"2\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'test', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:39:04'),
(3, 'skrill', 'Skrill', 17, 'gateway/C4thMOqpc0I1KMNzHVaLFBh1jzMv8t.webp', 'local', 0, '{\"pay_to_email\":\"XXXXXXXXXXXXXXX\",\"secret_key\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}}', NULL, '[\"AUD\",\"USD\"]', '[{\"name\":\"AUD\",\"currency_symbol\":\"AUD\",\"conversion_rate\":\"0.014\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"},{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"15000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:44:29'),
(4, 'perfectmoney', 'Perfect Money', 11, 'gateway/GuDH5siaapn6SHRDUDqXecX51zh8GE.webp', 'local', 0, '{\"passphrase\":\"XXXXXXXXXXXXXXX\",\"payee_account\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"USD\":\"USD\",\"EUR\":\"EUR\"}}', NULL, '[\"USD\",\"EUR\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0.5\",\"fixed_charge\":\"0\"},{\"name\":\"EUR\",\"currency_symbol\":\"EUR\",\"conversion_rate\":\"0.0083\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:45:27'),
(5, 'paytm', 'PayTM', 5, 'gateway/SHDMZxj6WifHck4MYwjCSapYC9mbCL.webp', 'local', 1, '{\"MID\":\"XXXXXXXXXXXXXXX\",\"merchant_key\":\"XXXXXXXXXXXXXX\",\"WEBSITE\":\"DIYtestingweb\",\"INDUSTRY_TYPE_ID\":\"Retail\",\"CHANNEL_ID\":\"WEB\",\"environment_url\":\"https:\\/\\/securegw-stage.paytm.in\",\"process_transaction_url\":\"https:\\/\\/securegw-stage.paytm.in\\/theia\\/processTransaction\"}', '{\"0\":{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}}', NULL, '[\"AUD\",\"CAD\"]', '[{\"name\":\"AUD\",\"currency_symbol\":\"AUD\",\"conversion_rate\":\"0.014\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"CAD\",\"currency_symbol\":\"CAD\",\"conversion_rate\":\"0.012\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0.5\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:39:56'),
(6, 'payeer', 'Payeer', 24, 'gateway/P5KPCePinssVbsnypNXupvk3vSFPBs.webp', 'local', 0, '{\"merchant_id\":\"XXXXXXXXXXXXX\",\"secret_key\":\"XXXXXXXXXXXX\"}', '{\"0\":{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}}', '{\"status\":\"ipn\"}', '[\"USD\",\"RUB\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"1\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"RUB\",\"currency_symbol\":\"RUB\",\"conversion_rate\":\"0.81\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0.5\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:46:12'),
(7, 'paystack', 'PayStack', 10, 'gateway/vLBlcoKlu7GJU3Lk5cHI41wpjmom5l.webp', 'local', 0, '{\"public_key\":\"XXXXXXXXXXXXXXXX\",\"secret_key\":\"XXXXXXXXXXXXXXXX\"}', '{\"0\":{\"USD\":\"USD\",\"NGN\":\"NGN\"}}', '{\"callback\":\"ipn\",\"webhook\":\"ipn\"}\r\n', '[\"USD\",\"NGN\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"NGN\",\"currency_symbol\":\"NGN\",\"conversion_rate\":\"7.40\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0.5\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:45:37'),
(8, 'voguepay', 'VoguePay', 37, 'gateway/Dp96eF1CkMZuRIOb31ZRoqnkguEEg3.webp', 'local', 0, '{\"merchant_id\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"NGN\":\"NGN\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"ZAR\":\"ZAR\",\"JPY\":\"JPY\",\"INR\":\"INR\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PLN\":\"PLN\"}}\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', NULL, '[\"NGN\",\"EUR\"]', '[{\"name\":\"NGN\",\"currency_symbol\":\"NGN\",\"conversion_rate\":\"7.40\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"EUR\",\"currency_symbol\":\"EUR\",\"conversion_rate\":\"0.0083\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0.5\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:47:50'),
(9, 'flutterwave', 'Flutterwave', 9, 'gateway/4yeVYeCUiDSsRrfJu1DXtasGr3Cn2g.webp', 'local', 0, '{\"public_key\":\"XXXXXXXXXXXXXX\",\"secret_key\":\"XXXXXXXXXXXX\",\"encryption_key\":\"YOUR_FLUTTERWAVE_ENCRYPTION_KEY\"}', '{\"0\":{\"KES\":\"KES\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"UGX\":\"UGX\",\"TZS\":\"TZS\"}}', NULL, '[\"GHS\",\"NGN\",\"USD\"]', '[{\"name\":\"GHS\",\"currency_symbol\":\"GHS\",\"conversion_rate\":\"0.11\",\"min_limit\":\"1\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"NGN\",\"currency_symbol\":\"NGN\",\"conversion_rate\":\"7.40\",\"min_limit\":\"1\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'test', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:45:46'),
(10, 'razorpay', 'RazorPay', 3, 'gateway/HW86pFkI6wkIZe5AJ0JWgqLW1oj6Ja.webp', 'local', 1, '{\"key_id\":\"XXXXXXXXXXXXXXXXXXXX\",\"key_secret\":\"XXXXXXXXXXXXXXX\"}', '{\"0\":{\"INR\":\"INR\"}}', NULL, '[\"INR\"]', '[{\"name\":\"INR\",\"currency_symbol\":\"INR\",\"conversion_rate\":\"0.76\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:43:57'),
(11, 'instamojo', 'instamojo', 21, 'gateway/AiNxmEp7ak05BnJGCgLtlvWpYloaLm.webp', 'local', 0, '{\"api_key\":\"XXXXXXXXXXXXXXX\",\"auth_token\":\"XXXXXXXXXXXXX\",\"salt\":\"XXXXXXXXXXXXXXX\"}', '{\"0\":{\"INR\":\"INR\"}}', NULL, '[\"INR\"]', '[{\"name\":\"INR\",\"currency_symbol\":\"INR\",\"conversion_rate\":\"0.76\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:46:37'),
(12, 'mollie', 'Mollie', 8, 'gateway/zHwwEwEdoELWdyoNvq4xkH0jx02QW2.webp', 'local', 1, '{\"api_key\":\"XXXXXXXXXXXX\"}', '{\"0\":{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}}', NULL, '[\"AUD\",\"BRL\"]', '[{\"name\":\"AUD\",\"currency_symbol\":\"AUD\",\"conversion_rate\":\"0.014\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"BRL\",\"currency_symbol\":\"BRL\",\"conversion_rate\":\"0.045\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:39:23'),
(13, 'twocheckout', '2checkout', 20, 'gateway/m2sdUTSsSY8pfO7BrCnf7m5vpYNo50.webp', 'local', 0, '{\"merchant_code\":\"XXXXXXXXXXXXXX\",\"secret_key\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"DZD\":\"DZD\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"AZN\":\"AZN\",\"BSD\":\"BSD\",\"BDT\":\"BDT\",\"BBD\":\"BBD\",\"BZD\":\"BZD\",\"BMD\":\"BMD\",\"BOB\":\"BOB\",\"BWP\":\"BWP\",\"BRL\":\"BRL\",\"GBP\":\"GBP\",\"BND\":\"BND\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"XCD\":\"XCD\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"FJD\":\"FJD\",\"GTQ\":\"GTQ\",\"HKD\":\"HKD\",\"HNL\":\"HNL\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JMD\":\"JMD\",\"JPY\":\"JPY\",\"KZT\":\"KZT\",\"KES\":\"KES\",\"LAK\":\"LAK\",\"MMK\":\"MMK\",\"LBP\":\"LBP\",\"LRD\":\"LRD\",\"MOP\":\"MOP\",\"MYR\":\"MYR\",\"MVR\":\"MVR\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NIO\":\"NIO\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PGK\":\"PGK\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"WST\":\"WST\",\"SAR\":\"SAR\",\"SCR\":\"SCR\",\"SGD\":\"SGD\",\"SBD\":\"SBD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"SYP\":\"SYP\",\"THB\":\"THB\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TRY\":\"TRY\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"USD\":\"USD\",\"VUV\":\"VUV\",\"VND\":\"VND\",\"XOF\":\"XOF\",\"YER\":\"YER\"}}', '{\"approved_url\":\"ipn\"}', '[\"AFN\",\"ARS\"]', '[{\"name\":\"AFN\",\"currency_symbol\":\"AFN\",\"conversion_rate\":\"0.63\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"ARS\",\"currency_symbol\":\"ARS\",\"conversion_rate\":\"3.24\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:46:44'),
(14, 'authorizenet', 'Authorize.Net', 18, 'gateway/d9l4GeVSHMxOkdmdxstnFGySMdprwr.webp', 'local', 1, '{\"login_id\":\"XXXXXXXXXXXXXXXXX\",\"current_transaction_key\":\"XXXXXXXXXXXXXX\"}', '{\"0\":{\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"USD\":\"USD\"}}', NULL, '[\"AUD\",\"CAD\"]', '[{\"name\":\"AUD\",\"currency_symbol\":\"AUD\",\"conversion_rate\":\"0.014\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0.5\",\"fixed_charge\":\"0\"},{\"name\":\"CAD\",\"currency_symbol\":\"CAD\",\"conversion_rate\":\"0.012\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0.5\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'test', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:47:01'),
(16, 'payumoney', 'PayUmoney', 32, 'gateway/R8KCOLwNGqYxgy8FM4GJxM3LiLPVV4.webp', 'local', 0, '{\"merchant_key\":\"XXXXXXXXXXXXX\",\"salt\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"INR\":\"INR\"}}', NULL, '[\"INR\"]', '[{\"name\":\"INR\",\"currency_symbol\":\"INR\",\"conversion_rate\":\"0.76\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'test', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:48:15'),
(17, 'mercadopago', 'Mercado Pago', 25, 'gateway/HL5XKciRmtAW5AMrhIhW794JKJ0hlp.webp', 'local', 0, '{\"access_token\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"ARS\":\"ARS\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"DOP\":\"DOP\",\"EUR\":\"EUR\",\"GTQ\":\"GTQ\",\"HNL\":\"HNL\",\"MXN\":\"MXN\",\"NIO\":\"NIO\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PYG\":\"PYG\",\"USD\":\"USD\",\"UYU\":\"UYU\",\"VEF\":\"VEF\",\"VES\":\"VES\"}}', NULL, '[\"ARS\"]', '[{\"name\":\"ARS\",\"currency_symbol\":\"ARS\",\"conversion_rate\":\"3.24\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:46:04'),
(18, 'coingate', 'Coingate', 26, 'gateway/M6BdYSH74P0eqyoYyIDACBotf5moDR.webp', 'local', 0, '{\"api_key\":\"XXXXXXXXXXXXXXXXX\"}', '{\"0\":{\"USD\":\"USD\",\"EUR\":\"EUR\"}}', NULL, '[\"USD\",\"EUR\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"EUR\",\"currency_symbol\":\"EUR\",\"conversion_rate\":\"0.0083\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'test', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:49:09'),
(19, 'coinbasecommerce', 'Coinbase Commerce', 23, 'gateway/GoKEpwU5XQXRfT2phJZ2sJcVlmGj1S.webp', 'local', 0, '{\"api_key\":\"XXXXXXXXXXXXXX\",\"secret\":\"XXXXXXXXXXXXXX\"}', '{\"0\":{\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CHF\":\"CHF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"EUR\":\"EUR\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GBP\":\"GBP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HKD\":\"HKD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"INR\":\"INR\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NOK\":\"NOK\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RUB\":\"RUB\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TRY\":\"TRY\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZAR\":\"ZAR\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}}', '{\"webhook\":\"ipn\"}', '[\"AED\",\"ALL\"]', '[{\"name\":\"AED\",\"currency_symbol\":\"AED\",\"conversion_rate\":\"0.033\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"ALL\",\"currency_symbol\":\"ALL\",\"conversion_rate\":\"0.85\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:46:19'),
(20, 'monnify', 'Monnify', 27, 'gateway/BbZ9WJQbxtYdFApARHyEv8h3co70cH.webp', 'local', 0, '{\"api_key\":\"XXXXXXXXXXXXXXXX\",\"secret_key\":\"XXXXXXXXXXXXXXXXXXXXXXX\",\"contract_code\":\"XXXXXXXXXXXXXXXXX\"}', '{\"0\":{\"NGN\":\"NGN\"}}', NULL, '[\"NGN\"]', '[{\"name\":\"NGN\",\"currency_symbol\":\"NGN\",\"conversion_rate\":\"7.40\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:49:02'),
(22, 'coinpayments', 'CoinPayments', 28, 'gateway/inbt6OudI8tpKqnDHgg4NqPHbXAHMc.webp', 'local', 0, '{\"merchant_id\":\"XXXXXXXXXXXXXXXX\",\"private_key\":\"XXXXXXXXXXXXXXXXXXX\",\"public_key\":\"XXXXXXXXXXXXXXXXXX\"}', '{\"0\":{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"},\"1\":{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}}', '{\"callback\":\"ipn\"}', '[\"USD\",\"AUD\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"AUD\",\"currency_symbol\":\"AUD\",\"conversion_rate\":\"0.014\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:48:52'),
(23, 'blockchain', 'Blockchain', 7, 'gateway/IRA1GwbTWfW3Bkt1R0PUb3lixxjFEY.webp', 'local', 1, '{\"api_key\":\"XXXXXXXXXXXXXXXXX\",\"xpub_code\":\"XXXXXXXXXXXXXXX\"}', '{\"1\":{\"BTC\":\"BTC\"}}', NULL, '[\"BTC\"]', '[{\"name\":\"BTC\",\"currency_symbol\":\"BTC\",\"conversion_rate\":\"0.0083\",\"min_limit\":\"0.01\",\"max_limit\":\"500000\",\"percentage_charge\":\"10\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 0, 0, 'live', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:39:33'),
(25, 'cashmaal', 'cashmaal', 30, 'gateway/fzk2sEmTAzs9yJAmxsGjaQTBvVLvtd.webp', 'local', 0, '{\"web_id\":\"XXXXXXXXXXXX\",\"ipn_key\":\"XX\"}', '{\"0\":{\"PKR\":\"PKR\",\"USD\":\"USD\"}}', '{\"ipn_url\":\"ipn\"}', '[\"PKR\",\"USD\"]', '[{\"name\":\"PKR\",\"currency_symbol\":\"PKR\",\"conversion_rate\":\"2.56\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, NULL, '2025-03-09 05:48:29'),
(26, 'midtrans', 'Midtrans', 16, 'gateway/z0Co0xJx2JlL3yYzQl1TCXxp3igSRk.webp', 'local', 0, '{\"client_key\":\"XXXXXXXXXXXXXX\",\"server_key\":\"XXXXXXXXXXXX\"}', '{\"0\":{\"IDR\":\"IDR\"}}', '{\"payment_notification_url\":\"ipn\", \"finish redirect_url\":\"ipn\", \"unfinish redirect_url\":\"failed\",\"error redirect_url\":\"failed\"}', '[\"IDR\"]', '[{\"name\":\"IDR\",\"currency_symbol\":\"IDR\",\"conversion_rate\":\"141.38\",\"min_limit\":\"1\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'test', NULL, '', '2020-09-08 21:05:02', '2025-03-09 05:44:40'),
(27, 'peachpayments', 'peachpayments', 38, 'gateway/9ok3JvnF5NjdYGFAq0AIskQK3d2ffT.webp', 'local', 0, '{\"Authorization_Bearer\":\"XXXXXXXXXXXX\",\"Entity_ID\":\"XXXXXXXXXXXXXX\",\"Recur_Channel\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"AED\":\"AED\",\"AFA\":\"AFA\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"AWG\":\"AWG\",\"AZM\":\"AZM\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYR\":\"BYR\",\"BZD\":\"BZD\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CYP\":\"CYP\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EEK\":\"EEK\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"EUR\":\"EUR\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GBP\":\"GBP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHC\":\"GHC\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HKD\":\"HKD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"INR\":\"INR\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LTL\":\"LTL\",\"LVL\":\"LVL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MTL\":\"MTL\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"MZM\":\"MZM\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NOK\":\"NOK\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PTS\":\"PTS\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDD\":\"SDD\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"SHP\":\"SHP\",\"SIT\":\"SIT\",\"SKK\":\"SKK\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SPL\":\"SPL\",\"SRD\":\"SRD\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMM\":\"TMM\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TRL\":\"TRL\",\"TRY\":\"TRY\",\"TTD\":\"TTD\",\"TVD\":\"TVD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZAR\":\"ZAR\",\"ZMK\":\"ZMK\",\"ZWD\":\"ZWD\"}}', NULL, '[\"AED\",\"CAD\"]', '[{\"name\":\"AED\",\"currency_symbol\":\"AED\",\"conversion_rate\":\"0.012\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"CAD\",\"currency_symbol\":\"CAD\",\"conversion_rate\":\"0.033\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'live', NULL, '', '2020-09-09 03:05:02', '2025-03-09 05:47:43'),
(28, 'nowpayments', 'Nowpayments', 31, 'gateway/090wVjftHnUzBNt0QXkwEYSQqATqVv.webp', 'local', 0, '{\"api_key\":\"XXXXXXXXXXXXXXX\"}', '{\"1\":{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}}', '{\"cron\":\"ipn\"}', '[\"ETH\",\"XEM\"]', '[{\"name\":\"ETH\",\"currency_symbol\":\"ETH\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"10\",\"max_limit\":\"500000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"},{\"name\":\"XEM\",\"currency_symbol\":\"XEM\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"10\",\"max_limit\":\"500000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 0, 1, 'live', NULL, '', '2020-09-08 21:05:02', '2025-03-09 05:48:21'),
(29, 'khalti', 'Khalti Payment', 33, 'gateway/x4BeAPBkYuM494NvWfAkrxTfk1tbUt.avif', 'local', 0, '{\"secret_key\":\"test_secret_key_e241fa0cf56e44b3a5e55a20f6a45e84\",\"public_key\":\"test_public_key_d4d1c327935749508ee25b52e22ebabb\"}', '{\"0\":{\"NPR\":\"NPR\"}}', NULL, '[\"NPR\"]', '[{\"name\":\"NPR\",\"currency_symbol\":\"NPR\",\"conversion_rate\":\"1.21\",\"min_limit\":\"1\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, '', '2020-09-08 21:05:02', '2025-01-08 07:26:49'),
(30, 'swagger', 'MAGUA PAY', 29, 'gateway/TAofN7wyhRqWNapL25bwpSqTtEUUos.webp', 'local', 0, '{\"MAGUA_PAY_ACCOUNT\":\"XXXXXXXXXXXXX\",\"MerchantKey\":\"XXXXXXXXXXXXXX\",\"Secret\":\"XXXXXXXXXXXXXXXXXXX\"}', '{\"0\":{\"EUR\":\"EUR\"}}', NULL, '[\"EUR\"]', '[{\"name\":\"EUR\",\"currency_symbol\":\"EUR\",\"conversion_rate\":\"0.0083\",\"min_limit\":\"1\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, '', '2020-09-08 21:05:02', '2025-03-09 05:48:42'),
(31, 'freekassa', 'Free kassa', 39, 'gateway/zW3twzzFSf6Spq3DkOpfyuMjjWSvOa.webp', 'local', 0, '{\"merchant_id\":\"8896\",\"merchant_key\":\"21b1f9f32162cdd5e59df622d0c28db5\",\"secret_word\":\"XXXXXXXXXXX\",\"secret_word2\":\"XXXXXXXXXXX\"}', '{\"0\":{\"RUB\":\"RUB\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"UAH\":\"UAH\",\"KZT\":\"KZT\"}}', '{\"ipn_url\":\"ipn\"}', '[\"RUB\",\"USD\"]', '[{\"name\":\"RUB\",\"currency_symbol\":\"RUB\",\"conversion_rate\":\"0.81\",\"min_limit\":\"1\",\"max_limit\":\"15000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, '', '2020-09-08 21:05:02', '2025-03-09 05:47:32'),
(32, 'konnect', 'Konnect', 34, 'gateway/FiY4gIT1aXAKBLW86BWuCvmrntQ4tA.webp', 'local', 0, '{\"api_key\":\"XXXXXXXXXXX\",\"receiver_wallet_Id\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"TND\":\"TND\",\"EUR\":\"EUR\",\"USD\":\"USD\"}}', '{\"webhook\":\"ipn\"}', '[\"TND\",\"EUR\",\"USD\"]', '[{\"name\":\"TND\",\"currency_symbol\":\"TND\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"15000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"EUR\",\"currency_symbol\":\"EUR\",\"conversion_rate\":\"0.028\",\"min_limit\":\"1\",\"max_limit\":\"20000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"},{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0083\",\"min_limit\":\"1\",\"max_limit\":\"60000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'live', NULL, '', '2020-09-08 21:05:02', '2025-03-09 05:48:09'),
(33, 'mypay', 'Mypay Np', 36, 'gateway/4GMe3Ij57iCQsFjrXxrPS96cVNhRut.webp', 'local', 0, '{\"merchant_username\":\"XXXXXXXXXXXX\",\"merchant_api_password\":\"XXXXXXXXXXXXXX\",\"merchant_id\":\"XXXXXXXXXXXX\",\"api_key\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"NPR\":\"NPR\"}}', NULL, '[\"NPR\"]', '[{\"name\":\"NPR\",\"currency_symbol\":\"NPR\",\"conversion_rate\":\"1.21\",\"min_limit\":\"1\",\"max_limit\":\"15000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'live', NULL, '', '2020-09-08 21:05:02', '2025-03-09 05:48:00'),
(35, 'imepay', 'IME PAY', 19, 'gateway/yssiHLTwmz6tZGHBenAyMK3MFPDtjE.webp', 'local', 0, '{\"MerchantModule\":\"XXXXXXXXXXXX\",\"MerchantCode\":\"XXXXXXXXXXXXX\",\"username\":\"XXXXXXXXXXXX\",\"password\":\"XXXXXXXXXXXX\"}', '{\"0\":{\"NPR\":\"NPR\"}}', NULL, '[\"NPR\"]', '[{\"name\":\"NPR\",\"currency_symbol\":\"NPR\",\"conversion_rate\":\"1.21\",\"min_limit\":\"10\",\"max_limit\":\"15000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"1.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, '', '2020-09-08 21:05:02', '2025-03-09 05:46:54'),
(36, 'cashonexHosted', 'Cashonex Hosted', 22, 'gateway/Bz46MPJVz8FqLOvsUHvq9p8Gy7oFj9.webp', 'local', 0, '{\"idempotency_key\":\"XXXXXXXXXXXXXX\",\"salt\":\"XXXXXXXXXXXXXX\"}', '{\"0\":{\"USD\":\"USD\"}}', NULL, '[\"USD\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"15000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2023-04-02 18:31:33', '2025-03-09 05:46:28'),
(37, 'cashonex', 'cashonex', 35, 'gateway/LYGeCnXEKepVNXbgk6yqGGEXv6DKpn.webp', 'local', 0, '{\"idempotency_key\":\"155228-ck-651971-ody-329243-h6i\",\"salt\":\"5a05d0f7336738460c4d098785cd0f2785bd60631bec019ea2ca61ed195ea8b5\"}', '{\"0\":{\"USD\":\"USD\"}}', NULL, '[\"USD\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"15000\",\"percentage_charge\":\"0.0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, NULL, '2023-04-02 18:34:54', '2025-01-08 07:26:49'),
(38, 'binance', 'Binance', 12, 'gateway/sZOVbwUjssiUdYzrEbRNq4GzPVliPp.webp', 'local', 0, '{\"mercent_api_key\":\"XXXXXXXXXXXXXXXXXXX\",\"mercent_secret\":\"XXXXXXXXXXXXXXXX\"}', '{\"1\":{\"ADA\":\"ADA\",\"ATOM\":\"ATOM\",\"AVA\":\"AVA\",\"BCH\":\"BCH\",\"BNB\":\"BNB\",\"BTC\":\"BTC\",\"BUSD\":\"BUSD\",\"CTSI\":\"CTSI\",\"DASH\":\"DASH\",\"DOGE\":\"DOGE\",\"DOT\":\"DOT\",\"EGLD\":\"EGLD\",\"EOS\":\"EOS\",\"ETC\":\"ETC\",\"ETH\":\"ETH\",\"FIL\":\"FIL\",\"FRONT\":\"FRONT\",\"FTM\":\"FTM\",\"GRS\":\"GRS\",\"HBAR\":\"HBAR\",\"IOTX\":\"IOTX\",\"LINK\":\"LINK\",\"LTC\":\"LTC\",\"MANA\":\"MANA\",\"MATIC\":\"MATIC\",\"NEO\":\"NEO\",\"OM\":\"OM\",\"ONE\":\"ONE\",\"PAX\":\"PAX\",\"QTUM\":\"QTUM\",\"STRAX\":\"STRAX\",\"SXP\":\"SXP\",\"TRX\":\"TRX\",\"TUSD\":\"TUSD\",\"UNI\":\"UNI\",\"USDC\":\"USDC\",\"USDT\":\"USDT\",\"WRX\":\"WRX\",\"XLM\":\"XLM\",\"XMR\":\"XMR\",\"XRP\":\"XRP\",\"XTZ\":\"XTZ\",\"XVS\":\"XVS\",\"ZEC\":\"ZEC\",\"ZIL\":\"ZIL\"}}', NULL, '[\"BTC\"]', '[{\"name\":\"BTC\",\"currency_symbol\":\"BTC\",\"conversion_rate\":\"0.000027\",\"min_limit\":\"1\",\"max_limit\":\"5\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 0, 0, 'live', NULL, NULL, '2023-04-02 19:36:14', '2025-03-09 05:45:19'),
(39, 'cinetpay', 'CinetPay', 40, 'gateway/8ntOYEeg7XhiHLgGjxvVi93X6vsRCl.webp', 'local', 0, '{\"apiKey\":\"XXXXXXXXXXXXXXXXXXX\",\"site_id\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"XOF\":\"XOF\",\"XAF\":\"XAF\",\"CDF\":\"CDF\",\"GNF\":\"GNF\",\"USD\":\"USD\"}}', 'NULL', '[\"XOF\"]', '[{\"name\":\"XOF\",\"currency_symbol\":\"XOF\",\"conversion_rate\":\"5.45\",\"min_limit\":\"1\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'test', NULL, NULL, '2023-04-02 19:36:14', '2025-03-09 05:47:22'),
(40, 'bkash', 'BKash', 2, 'gateway/hg54wAOO67AP6o8p8pTIn8ethI3bSk.webp', 'local', 1, '{\"username\":\"XXXXXXXXXXXXXX\",\"password\":\"XXXXXXXXXXXX\",\"app_key\":\"XXXXXXXXXXXXXXXXXXX\",\"app_secret\":\"XXXXXXXXXXXXX\"}', '{\"0\":{\"BDT\":\"BDT\"}}', NULL, '[\"BDT\"]', '[{\"name\":\"BDT\",\"currency_symbol\":\"BDT\",\"conversion_rate\":\"1\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\".5\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'test', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:44:07'),
(41, 'nagad', 'Nagad', 4, 'gateway/vERfObcEUEVDJsmdKGtcEWjBjjAgHZ.webp', 'local', 1, '{\"merchant_id\":\"683002007104225\",\"merchant_phone\":\"01670229009\",\"public_key\":\"XXXXXXXXXXXXXXXXXXX\",\"private_key\":\"XXXXXXXXXXXXXXXXXXXX\"}', '{\"0\":{\"BDT\":\"BDT\"}}', NULL, '[\"BDT\"]', '[{\"name\":\"BDT\",\"currency_symbol\":\"BDT\",\"conversion_rate\":\"1\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\".5\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'test', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:43:45'),
(42, 'toyyibpay', 'Toyyibpay', 14, 'gateway/JFmngidbrQlSsOBLPaoMElU7u0SUOY.webp', 'local', 0, '{\"category_code\":\"XXXXXXXXXXXXX\",\"secret_key\":\"XXXXXXXXXXXXXXXXXX\"}', '{\"0\":{\"MYR\":\"MYR\"}}', NULL, '[\"MYR\"]', '[{\"name\":\"MYR\",\"currency_symbol\":\"MYR\",\"conversion_rate\":\"4.27\",\"min_limit\":\"1\",\"max_limit\":\"1000000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'test', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:45:02'),
(43, 'eCitizen', 'eCitizen', 15, 'gateway/yzcQw8wKrLvu3dKxhg7t3f4J6pzErb.webp', 'local', 0, '{\"api_client_ID\":\"XXXXXXXXXX\",\"service_ID\":\"XXXXXXXXXXXX\",\"key\":\"XXXXXXXXXXXXXXXX\",\"secret\":\"XXXXXXXXXXXXXXX\"}', '{\"0\":{\"KES\":\"KES\"}}', NULL, '[\"KES\"]', '[{\"name\":\"KES\",\"currency_symbol\":\"KES\",\"conversion_rate\":\"129.04\",\"min_limit\":\"1\",\"max_limit\":\"1000000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 1, 'test', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:44:54'),
(44, 'shkeeper', 'SHKeeper', 13, 'gateway/yzcQw8wKrLvu3dKxhg7t3f4J6pzENg.webp', 'local', 0, '{\"api_key\":\"XXXXXXXXXXXXXXXXXXX\",\"hosted_url\":\"https:\\/\\/demo.shkeeper.io\"}', '{\"0\":{\"BTC\":\"BTC\",\"LTC\":\"LTC\",\"DOGE\":\"DOGE\",\"XMR\":\"XMR\",\"XRP\":\"XRP\",\"ETH\":\"ETH\",\"ETH-USDT\":\"ETH-USDT\",\"ETH-USDC\":\"ETH-USDC\",\"TRX\":\"TRX\",\"USDT\":\"USDT\",\"USDC\":\"USDC\",\"AVAX\":\"AVAX\",\"AVALANCHE-USDT\":\"AVALANCHE-USDT\",\"AVALANCHE-USDC\":\"AVALANCHE-USDC\",\"BNB\":\"BNB\",\"BNB-USDT\":\"BNB-USDT\",\"BNB-USDC\":\"BNB-USDC\",\"MATIC\":\"MATIC\",\"POLYGON-USDT\":\"POLYGON-USDT\",\"POLYGON-USDC\":\"POLYGON-USDC\"}}', NULL, '[\"BTC\",\"LTC\",\"ETH\",\"USDT\"]', '[{\"name\":\"BTC\",\"currency_symbol\":\"BTC\",\"conversion_rate\":\"0.0084\",\"min_limit\":\"1\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"LTC\",\"currency_symbol\":\"LTC\",\"conversion_rate\":\"0.0084\",\"min_limit\":\"0.1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"},{\"name\":\"ETH\",\"currency_symbol\":\"ETH\",\"conversion_rate\":\"0.0084\",\"min_limit\":\"0.1\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"1\"},{\"name\":\"USDT\",\"currency_symbol\":\"USDT\",\"conversion_rate\":\"0.0084\",\"min_limit\":\"0.1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 0, 0, 'test', NULL, NULL, '2020-09-10 03:05:02', '2025-03-09 05:45:09'),
(1000, 'bank-transfer', 'Bank Transfer', 1, 'gateway/TeZLigamHaNbyQ7zXwSDBip0rmdZAG.avif', 'local', 1, '{\"AccountNumber\":{\"field_name\":\"AccountNumber\",\"field_label\":\"Account Number\",\"type\":\"text\",\"validation\":\"required\"},\"BeneficiaryName\":{\"field_name\":\"BeneficiaryName\",\"field_label\":\"Beneficiary Name\",\"type\":\"text\",\"validation\":\"required\"},\"NID\":{\"field_name\":\"NID\",\"field_label\":\"NID\",\"type\":\"file\",\"validation\":\"required\"},\"Address\":{\"field_name\":\"Address\",\"field_label\":\"Address\",\"type\":\"text\",\"validation\":\"required\"}}', NULL, NULL, '[\"USD\",\"EUR\"]', '[{\"currency\":\"USD\",\"conversion_rate\":\"1\",\"min_limit\":\"0.1\",\"max_limit\":\"5000\",\"percentage_charge\":\"2\",\"fixed_charge\":\"0.5\"},{\"currency\":\"EUR\",\"conversion_rate\":\"0.94\",\"min_limit\":\"0.1\",\"max_limit\":\"1000\",\"percentage_charge\":\"5\",\"fixed_charge\":\"0\"}]', 'Send form your payment gateway. your bank may charge you a cash advance fee.', 1, 0, 'live', NULL, 'Please fill up the form and submit for the payment.', NULL, '2025-03-05 00:52:32');

-- --------------------------------------------------------

--
-- Table structure for table `in_app_notifications`
--

CREATE TABLE `in_app_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `in_app_notificationable_id` int DEFAULT NULL,
  `in_app_notificationable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kycs`
--

CREATE TABLE `kycs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_form` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) DEFAULT '0' COMMENT '1 => Active, 0 => Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 => Inactive, 1 => Active',
  `rtl` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => Inactive, 1 => Active',
  `default_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_name`, `flag`, `flag_driver`, `status`, `rtl`, `default_status`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'language/yvUi6uKLtH33Nhd4t6mQwMBUAZWzkx.webp', 'local', 1, 0, 1, '2023-06-16 22:35:53', '2025-03-03 04:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_modes`
--

CREATE TABLE `maintenance_modes` (
  `id` bigint UNSIGNED NOT NULL,
  `heading` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenance_modes`
--

INSERT INTO `maintenance_modes` (`id`, `heading`, `description`, `image`, `image_driver`, `created_at`, `updated_at`) VALUES
(1, 'The website under maintenance!', '<p>We are currently undergoing scheduled maintenance to improve our services and enhance your user experience. During this time, our website/system will be temporarily unavailable.\n</p><p><br></p><p>\nWe apologize for any inconvenience this may cause and appreciate your patience. Please rest assured that we are working diligently to complete the maintenance as quickly as possible.</p>', 'maintenanceMode/3jXAnm42OZuYy3kVDcHKUjW3gyiG8eSo96rlgg19.png', 'local', '2023-10-03 22:44:32', '2024-02-05 04:00:13');

-- --------------------------------------------------------

--
-- Table structure for table `manage_menus`
--

CREATE TABLE `manage_menus` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_items` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manage_menus`
--

INSERT INTO `manage_menus` (`id`, `menu_section`, `theme`, `menu_items`, `created_at`, `updated_at`) VALUES
(3, 'header', 'light', '[\"home\",\"Top Up\",\"Card\",\"Buy\",\"contact\",\"Blog\"]', '2023-10-16 06:54:10', '2025-09-19 11:42:41'),
(4, 'footer', 'light', '{\"useful_link\":[\"blog\"],\"support_link\":[\"privacy &amp; policy\",\"terms &amp; conditions\"]}', '2023-10-16 06:54:10', '2024-12-18 11:28:56'),
(5, 'header', 'dark', '[\"home\",\"Top Up\",\"Card\",\"Buy\",\"Blog\"]', '2023-10-16 06:54:10', '2025-09-19 04:33:39'),
(6, 'footer', 'dark', '{\"useful_link\":[\"blog\",\"contact\"],\"support_link\":[\"privacy and policy\",\"terms and conditions\"]}', '2023-10-16 06:54:10', '2024-12-14 05:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `manual_sms_configs`
--

CREATE TABLE `manual_sms_configs` (
  `id` bigint UNSIGNED NOT NULL,
  `action_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_data` text COLLATE utf8mb4_unicode_ci,
  `param_data` text COLLATE utf8mb4_unicode_ci,
  `form_data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manual_sms_configs`
--

INSERT INTO `manual_sms_configs` (`id`, `action_method`, `action_url`, `header_data`, `param_data`, `form_data`, `created_at`, `updated_at`) VALUES
(1, 'GET', 'https://rest.nexmo.com/sms/json', NULL, NULL, NULL, '2024-08-08 11:12:56', '2025-03-03 08:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_06_07_064911_create_admins_table', 1),
(7, '2023_06_10_061241_create_basic_controls_table', 1),
(8, '2023_06_10_123329_create_file_storages_table', 1),
(9, '2023_06_17_085447_create_languages_table', 1),
(10, '2023_06_20_080624_create_support_tickets_table', 1),
(11, '2023_06_20_080731_create_support_ticket_messages_table', 1),
(12, '2023_06_20_080833_create_support_ticket_attachments_table', 1),
(13, '2023_06_20_212143_create_fire_base_tokens_table', 1),
(14, '2023_06_21_124322_create_in_app_notifications_table', 1),
(15, '2023_06_22_084256_create_gateways_table', 1),
(16, '2023_07_15_162549_create_kycs_table', 1),
(17, '2023_07_18_084411_create_pages_table', 1),
(18, '2023_07_22_130913_create_manage_menus_table', 1),
(19, '2023_08_20_140757_create_contents_table', 1),
(20, '2023_08_20_140808_create_content_details_table', 1),
(21, '2023_09_07_151706_create_user_logins_table', 1),
(22, '2023_09_09_105217_create_transactions_table', 1),
(23, '2023_09_19_131540_create_deposits_table', 1),
(24, '2023_10_02_162152_create_page_details_table', 1),
(25, '2023_10_04_102054_create_maintenance_modes_table', 1),
(26, '2023_10_05_124445_create_notify_templates_table', 1),
(27, '2023_10_19_140559_create_manual_sms_configs_table', 1),
(28, '2023_10_19_161530_create_jobs_table', 1),
(29, '2023_12_10_085818_create_blog_categories_table', 1),
(30, '2023_12_10_094858_create_blogs_table', 1),
(31, '2023_12_10_094925_create_blog_details_table', 1),
(32, '2024_06_02_111050_create_user_kycs_table', 1),
(34, '2024_06_26_153713_create_categories_table', 2),
(35, '2024_06_27_105524_create_currencies_table', 3),
(36, '2024_06_29_161429_create_top_ups_table', 4),
(37, '2024_07_02_102744_create_top_up_services_table', 5),
(38, '2024_07_06_192044_create_cards_table', 6),
(39, '2024_07_07_114057_create_card_services_table', 7),
(40, '2024_07_07_133317_create_codes_table', 8),
(41, '2024_07_08_122749_create_games_table', 9),
(42, '2024_07_08_162131_create_game_service_maps_table', 10),
(43, '2024_07_29_161739_create_banner_settings_table', 11),
(44, '2024_08_07_110557_create_orders_table', 12),
(45, '2024_08_07_120923_create_order_details_table', 13),
(46, '2024_08_22_182852_create_reviews_table', 14),
(47, '2024_09_03_103145_create_collections_table', 15),
(48, '2024_11_11_113154_create_campaigns_table', 16),
(49, '2023_09_20_093121_create_payouts_table', 17),
(50, '2024_04_30_091056_create_notification_settings_table', 18),
(51, '2024_08_28_110406_create_payout_methods_table', 19),
(52, '2024_12_23_183941_create_notification_settings_table', 20),
(53, '2024_12_26_111104_create_sell_posts_table', 21),
(54, '2024_12_26_111232_create_sell_post_categories_table', 22),
(55, '2024_12_26_111315_create_sell_post_category_details_table', 23),
(56, '2024_12_26_111417_create_sell_post_chats_table', 24),
(57, '2024_12_26_111549_create_sell_post_offers_table', 25),
(58, '2024_12_26_111956_create_activity_logs_table', 26),
(59, '2025_01_02_105204_create_currencies_table', 27),
(60, '2025_01_20_133622_add_slug_to_blogs_table', 28),
(61, '2025_01_20_155048_add_app_settings_to_basic_controls_table', 29),
(62, '2025_01_22_131841_add_field_to_deposits_table', 30),
(64, '2025_01_12_122246_add_social_to_users_table', 31),
(65, '2025_01_30_114415_add_another_field_to_users_table', 32),
(66, '2025_02_27_131453_add_colours_to_basic_controls_table', 32);

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `notifyable_id` int DEFAULT NULL,
  `notifyable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_email_key` text COLLATE utf8mb4_unicode_ci,
  `template_sms_key` text COLLATE utf8mb4_unicode_ci,
  `template_in_app_key` text COLLATE utf8mb4_unicode_ci,
  `template_push_key` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci,
  `short_keys` text COLLATE utf8mb4_unicode_ci,
  `email` text COLLATE utf8mb4_unicode_ci,
  `sms` text COLLATE utf8mb4_unicode_ci,
  `in_app` text COLLATE utf8mb4_unicode_ci,
  `push` text COLLATE utf8mb4_unicode_ci,
  `status` text COLLATE utf8mb4_unicode_ci COMMENT '	mail = 0(inactive), mail = 1(active), sms = 0(inactive), sms = 1(active), in_app = 0(inactive), in_app = 1(active), push = 0(inactive), push = 1(active)',
  `notify_for` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => user, 1 => admin',
  `lang_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `language_id`, `name`, `email_from`, `template_key`, `subject`, `short_keys`, `email`, `sms`, `in_app`, `push`, `status`, `notify_for`, `lang_code`, `created_at`, `updated_at`) VALUES
(1, 1, 'Password Reset', 'support@gmail.com', 'PASSWORD_RESET', 'Reset Your Password', '{\"message\":\"message\"}', 'You are receiving this email because we received a password reset request for your account.[[message]]\n\n\nThis password reset link will expire in 60 minutes.\n\nIf you did not request a password reset, no further action is required.', '', '', '', '{\"mail\":\"1\",\"sms\":\"0\",\"in_app\":\"0\",\"push\":\"0\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(2, 1, 'Verification Code', 'support@gmail.com', 'VERIFICATION_CODE', 'Verification Code', '{\"code\":\"code\"}', 'Your Email verification Code  [[code]]', 'Your SMS verification Code  [[code]]', '', '', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"0\",\"push\":\"0\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(3, 1, 'Two Step Enabled.', 'support@gmail.com', 'TWO_STEP_ENABLED', 'Two step enabled.', '{\"action\":\"Enabled Or Disable\",\"ip\":\"Device Ip\",\"time\":\"Time\",\"code\":\"code\"}', 'Your verification code is: {{code}}', 'Your verification code is: {{code}}', 'Your verification code is: {{code}}', 'Your verification code is: {{code}}', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(4, 1, 'Two Step Disabled', 'support@gmail.com', 'TWO_STEP_DISABLED', 'Two Step disabled', '{\"time\":\"Time\"}', 'Google two factor verification is disabled.', 'Google two factor verification is disabled.', 'Google two factor verification is disabled.', 'Google two factor verification is disabled.', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(5, 1, 'Support Ticket Create', 'support@gmail.com', 'SUPPORT_TICKET_CREATE', 'Support Ticket New', '{\"ticket_id\":\"Support Ticket ID\",\"username\":\"username\"}', '[[username]] create a ticket\nTicket : [[ticket_id]]', '[[username]] create a ticket\nTicket : [[ticket_id]]', '[[username]] create a ticket\nTicket : [[ticket_id]]', '[[username]] create a ticket\nTicket : [[ticket_id]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 1, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(6, 1, 'Admin Replied Ticket', 'support@gmail.com', 'ADMIN_REPLIED_TICKET', 'Support Ticket Reply', '{\"ticket_id\":\"Support Ticket ID\"}', 'Your support ticket has been replied by admin\nTicket : [[ticket_id]]', 'Your support ticket has been replied by admin\nTicket : [[ticket_id]]', 'Your support ticket has been replied by admin\nTicket : [[ticket_id]]', 'Your support ticket has been replied by admin\nTicket : [[ticket_id]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(7, 1, 'Payment Request to Admin', 'support@gmail.com', 'PAYMENT_REQUEST', 'Payment Request', '{\"username\":\"User\",\"amount\":\"Amount\",\"gateway\":\"Gateway\"}', '[[username]] request to payment [[amount]] by [[gateway]].', '[[username]] request to payment [[amount]] by [[gateway]].', '[[username]] request to payment [[amount]] by [[gateway]].', '[[username]] request to payment [[amount]] by [[gateway]].', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 1, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(9, 1, 'Payment Rejected', 'support@gmail.com', 'PAYMENT_REJECTED', 'Payment Rejected', '{\"username\":\"User\",\"amount\":\"Amount\",\"gateway\":\"Gateway\"}', '[[username]] request to payment [[amount]] by [[gateway]] is rejected.', '[[username]] request to payment [[amount]] by [[gateway]] is rejected.', '[[username]] request to payment [[amount]] by [[gateway]] is rejected.', '[[username]] request to payment [[amount]] by [[gateway]] is rejected.', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(10, 1, 'Buyer Make Payment', 'support@gmail.com', 'BUYER_PAYMENT', 'Payment Complete', '{\"amount\":\"Amount\",\"currency\":\"Currency Symbol\",\"gateway\":\"Gateway\",\"transaction\":\"Trx Id\"}', 'Your [[currency]][[amount]] payment Via [[gateway]] has been completed. Trx Id: [[transaction]]', 'Your [[currency]][[amount]] payment Via [[gateway]] has been completed. Trx Id: [[transaction]]', 'Your [[currency]][[amount]] payment Via [[gateway]] has been completed. Trx Id: [[transaction]]', 'Your [[currency]][[amount]] payment Via [[gateway]] has been completed. Trx Id: [[transaction]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(11, 1, 'Buyer Make Payment To Admin', 'support@gmail.com', 'BUYER_PAYMENT_ADMIN', 'Buyer Make Payment', '{\"username\":\"username\",\"amount\":\"Amount\",\"currency\":\"Currency Symbol\",\"gateway\":\"Gateway\",\"transaction\":\"Trx Id\"}', '[[username]] make payment [[currency]][[amount]] Via [[gateway]] has been completed. Trx Id: [[transaction]]', '[[username]] make payment [[currency]][[amount]] Via [[gateway]] has been completed. Trx Id: [[transaction]]', '[[username]] make payment [[currency]][[amount]] Via [[gateway]] has been completed. Trx Id: [[transaction]]', '[[username]] make payment [[currency]][[amount]] Via [[gateway]] has been completed. Trx Id: [[transaction]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 1, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(12, 1, 'Top Up Order Complete', 'support@gmail.com', 'TOP_UP_ORDER_COMPLETE', 'Top Up Order Complete', '{\"order_id\":\"Order Id\",\"service_name\":\"Service Name\"}', 'Your [[service_name]] top up order has been completed. Order Id: [[order_id]]', 'Your [[service_name]] top up order has been completed. Order Id: [[order_id]]', 'Your [[service_name]] top up order has been completed. Order Id: [[order_id]]', 'Your [[service_name]] top up order has been completed. Order Id: [[order_id]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(13, 1, 'Top Up Order Cancel', 'support@gmail.com', 'TOP_UP_ORDER_CANCEL', 'Top Up Order Cancel', '{\"order_id\":\"Order Id\",\"service_name\":\"Service Name\"}', 'Your [[service_name]] top up order has been cancel. Order Id: [[order_id]]', 'Your [[service_name]] top up order has been cancel. Order Id: [[order_id]]', 'Your [[service_name]] top up order has been cancel. Order Id: [[order_id]]', 'Your [[service_name]] top up order has been cancel. Order Id: [[order_id]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(14, 1, 'Card Code Send', 'support@gmail.com', 'CARD_CODE_SEND', 'Card Code Send', '{\"order_id\":\"Order Id\",\"service_name\":\"Service Name\"}', 'Your order [[service_name]] card passcode has been send. Order Id: [[order_id]]', 'Your order [[service_name]] card passcode has been send. Order Id: [[order_id]]', 'Your order [[service_name]] card passcode has been send. Order Id: [[order_id]]', 'Your order [[service_name]] card passcode has been send. Order Id: [[order_id]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(15, 1, 'Card Order Complete', 'support@gmail.com', 'CARD_ORDER_COMPLETE', 'Card Complete', '{\"order_id\":\"Order Id\"}', 'Your card order has been completed. Order Id: [[order_id]]', 'Your card order has been completed. Order Id: [[order_id]]', 'Your card order has been completed. Order Id: [[order_id]]', 'Your card order has been completed. Order Id: [[order_id]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(16, 1, 'Card Order Cancel', 'support@gmail.com', 'CARD_ORDER_CANCEL', 'Card Order Cancel', '{\"order_id\":\"Order Id\"}', 'Your card order has been cancel. Order Id: [[order_id]]', 'Your card order has been cancel. Order Id: [[order_id]]', 'Your card order has been cancel. Order Id: [[order_id]]', 'Your card order has been cancel. Order Id: [[order_id]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(17, 1, 'Buyer Review', 'support@gmail.com', 'BUYER_REVIEW_TO_ADMIN', 'You have a new review', '{\"name\":\"Game Name\",\"rating\":\"Rating\"}', 'You have new [[rating]] review for [[name]]. ', 'You have new [[rating]] review for [[name]]. ', 'You have new [[rating]] review for [[name]]. ', 'You have new [[rating]] review for [[name]]. ', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 1, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(18, 1, 'Credited Balance', 'support@gmail.com', 'ADD_BALANCE', 'Your account is credited', '{\"amount\":\"Amount\",\"main_balance\":\"Main Balance\"}', 'Your account has been credited [[amount]]. Available balance is [[main_balance]].', 'Your account has been credited [[amount]]. Available balance is [[main_balance]].', 'Your account has been credited [[amount]]. Available balance is [[main_balance]].', 'Your account has been credited [[amount]]. Available balance is [[main_balance]].', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(19, 1, 'Debited Balance', 'support@gmail.com', 'DEDUCTED_BALANCE', 'Your account is debited ', '{\"amount\":\"Amount\",\"main_balance\":\"Main Balance\"}', 'Your account has been debited [[amount]]. Available balance is [[main_balance]].', 'Your account has been debited [[amount]]. Available balance is [[main_balance]].', 'Your account has been debited [[amount]]. Available balance is [[main_balance]].', 'Your account has been debited [[amount]]. Available balance is [[main_balance]].', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(20, 1, 'Payment Lock', 'support@gmail.com', 'PAYMENT_LOCK', 'Payment Has Been Locked', '{\"title\":\"Title\",\"amount\":\"Amount\"}', '[[title]] amount [[amount]] payment has been lock.', '[[title]] amount [[amount]] payment has been lock.', '[[title]] amount [[amount]] payment has been lock.', '[[title]] amount [[amount]] payment has been lock.', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(21, 1, 'SELL RE OFFER', 'support@gmail.com', 'SELL_RE_OFFER', 'Sell Post Has Been Re Offered', '{\"title\":\"Title\",\"amount\":\"Amount\",\"description\":\"Description\",\"offer_by\":\"Offer By\"}', 'Your [[title]] sell post has been re offered by [[offer_by]] \r\nAmount: [[amount]]\r\nDescription: [[description]]', 'Your [[title]] sell post has been re offered by [[offer_by]] \r\nAmount: [[amount]]\r\nDescription: [[description]]', 'Your [[title]] sell post has been re offered by [[offer_by]] \r\nAmount: [[amount]]\r\nDescription: [[description]]', 'Your [[title]] sell post has been re offered by [[offer_by]] \r\nAmount: [[amount]]\r\nDescription: [[description]]', '{\"mail\":1,\"sms\":1,\"in_app\":1,\"push\":1}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(22, 1, 'SELL OFFER', 'support@gmail.com', 'SELL_OFFER', 'Sell Post Has Been Offered', '{\"title\":\"Title\",\"amount\":\"Amount\",\"offer_by\":\"Offer By\"}', 'Your [[title]] sell post has been offered by [[offer_by]] \r\nAmount: [[amount]]', 'Your [[title]] sell post has been offered by [[offer_by]] \r\nAmount: [[amount]]', 'Your [[title]] sell post has been offered by [[offer_by]] \r\nAmount: [[amount]]', 'Your [[title]] sell post has been offered by [[offer_by]] \r\nAmount: [[amount]]', '{\"mail\":1,\"sms\":1,\"in_app\":1,\"push\":1}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(23, 1, 'OFFER_ACCEPTED', 'support@gmail.com', 'OFFER_ACCEPTED', 'Offer Has Been Accepted', '{\"title\":\"Title\",\"amount\":\"Amount\"}', '[[title]] offer amount [[amount]] has been accepted.', '[[title]] offer amount [[amount]] has been accepted.', '[[title]] offer amount [[amount]] has been accepted.', '[[title]] offer amount [[amount]] has been accepted.', '{\"mail\":1,\"sms\":1,\"in_app\":1,\"push\":1}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(24, 1, 'Payout Request  Admin', 'support@gmail.com', 'PAYOUT_REQUEST_TO_ADMIN', 'payout Request  Admin', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"transaction\":\"Transaction Number\", \"currency\":\"Payment Currency\"}', '[[sender]] payout money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] payout money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] payout money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] payout money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 1, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(25, 1, 'Payout Request Cancel', 'support@gmail.com', 'PAYOUT_CANCEL', 'Payout Request Cancel', '{\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 'You request for payout amount [[amount]] [[currency]] has been cancel. Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] has been cancel. Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] has been cancel. Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] has been cancel. Transaction: #[[transaction]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(26, 1, 'Password Reset', 'support@gmail.com', 'PASSWORD_RESET', 'Reset Your Password', '{\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 'You request for payout amount [[amount]] [[currency]] has been approved . Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] has been approved . Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] has been approved . Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] has been approved . Transaction: #[[transaction]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(27, 1, 'Payout Request from', 'support@gmail.com', 'PAYOUT_REQUEST_FROM', 'Payout Request from', '{\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 'You request for payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13'),
(28, 1, 'Payout Request Approved', 'support@gmail.com', 'PAYOUT_APPROVED', 'Payout Request Approved', '{\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 'You request for payout amount [[amount]] [[currency]] has been approved . Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] has been approved . Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] has been approved . Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] has been approved . Transaction: #[[transaction]]', '{\"mail\":\"1\",\"sms\":\"1\",\"in_app\":\"1\",\"push\":\"1\"}', 0, 'en', '2023-10-07 22:18:47', '2025-03-01 10:07:13');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `payment_method_id` int DEFAULT NULL COMMENT '-1=>for wallet payment',
  `amount` double NOT NULL DEFAULT '0' COMMENT 'total order amount',
  `discount` float NOT NULL DEFAULT '0',
  `coupon_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_id` int DEFAULT NULL,
  `info` text COLLATE utf8mb4_unicode_ci COMMENT 'for dynamic information store',
  `payment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=>incomplete,1=>complete',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>initiate,1=>complete,2=>refund,3=>stock_short',
  `order_for` enum('topup','card') COLLATE utf8mb4_unicode_ci NOT NULL,
  `utr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_interface` enum('WEB','API') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'WEB',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `parent_id` int DEFAULT NULL COMMENT 'top up or card id',
  `detailable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detailable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `qty` int NOT NULL DEFAULT '1' COMMENT 'how many code order',
  `stock_short` int NOT NULL DEFAULT '0' COMMENT 'how many code do not get buyer',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>initiate,1=>complete,2=>refund,3=>stock_short',
  `card_codes` text COLLATE utf8mb4_unicode_ci COMMENT 'buyer card service code',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `og_description` text COLLATE utf8mb4_unicode_ci,
  `meta_robots` text COLLATE utf8mb4_unicode_ci,
  `meta_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_image_driver` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breadcrumb_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breadcrumb_image_driver` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breadcrumb_status` tinyint NOT NULL DEFAULT '1' COMMENT '0 => inactive, 1 => active',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0 => unpublish, 1 => publish',
  `type` tinyint NOT NULL DEFAULT '0' COMMENT '0 => admin create, 1 => developer create, 2 => create for menus',
  `is_breadcrumb_img` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `template_name`, `custom_link`, `page_title`, `meta_title`, `meta_keywords`, `meta_description`, `og_description`, `meta_robots`, `meta_image`, `meta_image_driver`, `breadcrumb_image`, `breadcrumb_image_driver`, `breadcrumb_status`, `status`, `type`, `is_breadcrumb_img`, `created_at`, `updated_at`) VALUES
(1, 'home', '/', 'light', NULL, 'Home', 'Home meta', '[\"home\",\"meta\"]', 'this is demo meta description', 'this is demo og description', 'noindex', 'seo/bjHgBsxpCpVq81YkAWD8UrNzrXdhkZ.webp', 'local', NULL, 'local', 0, 1, 0, 1, '2024-10-30 11:50:33', '2024-11-14 11:32:21'),
(2, 'Blog', 'blog', 'light', NULL, 'Blogs', 'Blogs Meta Title', '[\"Blogs Meta\"]', 'Blogs Meta Description', 'Blogs Meta Description', 'index,noindex', 'seo/ZQdB5VRSpNT1S6RXuXhiMmflnqWXuC.webp', 'local', NULL, 'local', 0, 1, 0, 1, '2024-10-30 13:13:51', '2025-01-02 11:48:53'),
(3, 'contact', 'contact', 'light', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 0, 1, 0, 1, '2024-10-30 13:14:10', '2024-10-30 13:14:10'),
(4, 'privacy &amp; policy', 'privacy-and-policy', 'light', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 0, 1, 0, 1, '2024-10-30 13:18:19', '2024-10-30 13:18:19'),
(5, 'terms &amp; conditions', 'terms-and-conditions', 'light', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 0, 1, 0, 1, '2024-10-30 13:18:48', '2024-10-30 13:18:48'),
(6, 'developer', 'developer', 'light', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 0, 1, 0, 1, '2024-11-13 05:07:02', '2024-11-13 05:07:02'),
(7, 'home', '/', 'dark', NULL, 'Home', 'Home', '[\"gamers\",\"topup\",\"voucher\",\"giftcard\",\"Digital Online\"]', 'Most gamer wants to buy game top up, voucher &amp; virtual card. But they don’t have international card. they want to get it by local currency', 'This is OG description', 'noindex,follow', 'seo/N8JipptKmaeCvotRtwNb55cgG1sC0p.webp', 'local', NULL, 'local', 0, 1, 0, 1, '2024-12-08 11:44:19', '2025-03-03 03:43:56'),
(8, 'contact', 'contact', 'dark', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 0, 1, 0, 1, '2024-12-12 10:38:21', '2024-12-12 10:38:21'),
(9, 'Card', 'cards', 'dark', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2024-12-18 11:22:54', '2024-12-18 11:22:54'),
(10, 'Top Up', 'top-ups', 'dark', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2024-12-18 11:22:54', '2024-12-18 11:22:54'),
(13, 'Blog', 'blog', 'dark', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2024-12-12 11:26:40', '2024-12-12 11:26:40'),
(14, 'privacy and policy', 'privacy-and-policy', 'dark', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 0, 1, 0, 1, '2024-12-12 12:50:20', '2024-12-12 12:50:20'),
(15, 'terms and conditions', 'terms-and-conditions', 'dark', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 0, 1, 0, 1, '2024-12-14 04:46:17', '2024-12-14 04:46:17'),
(16, 'developer', 'developer', 'dark', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 0, 1, 0, 1, '2024-12-15 12:08:09', '2024-12-15 12:08:09'),
(18, 'Card', 'cards', 'light', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2024-12-18 11:22:54', '2024-12-18 11:22:54'),
(19, 'Top Up', 'top-ups', 'light', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2024-12-18 11:22:54', '2024-12-18 11:22:54'),
(20, 'cookie policy', 'cookie-policy', 'light', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 0, 1, 0, 1, '2024-12-21 10:35:04', '2024-12-21 10:35:04'),
(21, 'cookie policy', 'cookie-policy', 'dark', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 0, 1, 0, 1, '2024-12-21 11:08:52', '2024-12-21 11:08:52'),
(22, 'Buy', 'buy', 'dark', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2024-12-29 07:09:20', '2024-12-29 07:09:20'),
(23, 'Buy', 'buy', 'light', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, '2024-12-29 07:09:20', '2024-12-29 07:11:28'),
(26, 'google', NULL, 'dark', 'https://www.google.com/', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 1, '2025-01-06 12:22:49', '2025-01-06 12:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `page_details`
--

CREATE TABLE `page_details` (
  `id` bigint UNSIGNED NOT NULL,
  `page_id` bigint UNSIGNED DEFAULT NULL,
  `language_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `sections` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_details`
--

INSERT INTO `page_details` (`id`, `page_id`, `language_id`, `name`, `content`, `sections`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Home', '<p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_hero]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_exclusive_card]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_brand]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_about]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_campaign]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_top_up]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_why_chose_us]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_buy_game_id]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_testimonial]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_blog]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p>', '[\"light_hero\",\"light_exclusive_card\",\"light_brand\",\"light_about\",\"light_campaign\",\"light_top_up\",\"light_why_chose_us\",\"light_buy_game_id\",\"light_testimonial\",\"light_blog\"]', '2024-10-30 11:50:33', '2025-03-04 23:59:16'),
(2, 2, 1, 'Blog', '<div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_blog]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p>', '[\"light_blog\"]', '2024-10-30 13:13:51', '2024-12-18 06:01:49'),
(3, 3, 1, 'Contact', '<div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_contact]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p>', '[\"light_contact\"]', '2024-10-30 13:14:10', '2024-12-18 06:04:25'),
(4, 4, 1, 'Privacy &amp; Policy', '<h3>Our Privacy Policy</h3><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">We are committed to protecting your privacy. This Privacy Policy explains how we collect, use, and share your personal information when you visit or make a purchase from our website.</p><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\"><br></p><h5>Personal Information We Collect</h5><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">When you visit our website, we collect certain information about your device, including your IP address, browser type, and operating system. We also collect information about the pages you visit on our website, the links you click, and the products you view or purchase. We collect this information using cookies and other tracking technologies. For more information about cookies, please see the \"Cookies\" section below.</p><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\"><br></p><h5>How We Use Your Personal Information</h5><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">We use the information we collect from you to:</p><ul><li>Process your orders and fulfill your requests</li><li>Communicate with you about your orders, products, and services</li><li>Provide you with targeted advertising and marketing</li><li>Improve our website and products</li><li>Comply with applicable laws and regulations</li></ul><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\"><br><br></p><h5>Sharing Your Personal Information</h5><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">We share your personal information with third parties to help us with the purposes listed above. For example, we use Shopify to power our online store. You can read more about how Shopify uses your personal information here: https://www.shopify.com/legal/privacy. We also use Google Analytics to track website traffic. You can read more about how Google uses your personal information You can opt-out of Google Analytics tracking. Finally, we may share your personal information to comply with applicable laws and regulations, to respond to a subpoena, search warrant or other lawful request for information we receive, or to protect our rights.</p><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\"><br><br></p><h5>Contact Us</h5><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">If you have any questions about this Privacy Policy, please contact us at [email protected]</p>', NULL, '2024-10-30 13:18:19', '2024-10-30 13:18:19'),
(5, 5, 1, 'Terms &amp; Conditions', '<h3>Our Terms &amp; Conditions</h3><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">By accessing or using TalkWave, you agree to these Terms &amp; Conditions and our Privacy Policy. If you do not agree, do not use our platform.</p><p style=\"color:rgb(26,26,26);font-family:\'DM Sans\', sans-serif;font-size:16px;\"><br></p><h5>Use of Service</h5><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">You must create an account to use TalkWave. Provide accurate information and keep your login credentials secure. You agree not to misuse TalkWave, including spamming, hacking, or violating any laws.</p><h5><br></h5><h5>Communication of Service</h5><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">Use TalkWave for lawful communication purposes only. We do not monitor your messages but may act if violations are reported. You are responsible for the content you share. Do not infringe on copyrights or distribute harmful material.</p><h5><br></h5><h5>Data Privacy</h5><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">We collect and use personal information as outlined in our Privacy Policy. Your data security is important to us. Integrations with third-party services may require sharing information as per their terms.</p><h5><br></h5><h5>How We Use Your Personal Information</h5><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">We use the information we collect from you to:</p><ul><li>Process your orders and fulfill your requests</li><li>Communicate with you about your orders, products, and services</li><li>Provide you with targeted advertising and marketing</li><li>Improve our website and products</li><li>Comply with applicable laws and regulations</li></ul><p style=\"color:rgb(26,26,26);font-family:\'DM Sans\', sans-serif;font-size:16px;\"><br><br></p><h5>Sharing Your Personal Information</h5><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">We share your personal information with third parties to help us with the purposes listed above. For example, we use Shopify to power our online store. You can read more about how Shopify uses your personal information here: https://www.shopify.com/legal/privacy. We also use Google Analytics to track website traffic. You can read more about how Google uses your personal information You can opt-out of Google Analytics tracking. Finally, we may share your personal information to comply with applicable laws and regulations, to respond to a subpoena, search warrant or other lawful request for information we receive, or to protect our rights.</p><p style=\"color:rgb(26,26,26);font-family:\'DM Sans\', sans-serif;font-size:16px;\"><br><br></p><h5>Contact Us</h5><h3></h3><p style=\"color:rgb(105,105,105);font-family:\'DM Sans\', sans-serif;font-size:15px;\">If you have any questions about this Privacy Policy, please contact us at [email protected]</p>', NULL, '2024-10-30 13:18:48', '2024-10-30 13:18:48'),
(6, 6, 1, 'Developer', '<div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[light_docx]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p>', '[\"light_docx\"]', '2024-11-13 05:07:02', '2024-12-18 12:47:55'),
(8, 7, 1, 'Home', '<div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_hero]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_exclusive_card]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_about]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_campaign]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_top_up]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_why_chose_us]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_buy_game_id]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_testimonial]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_blog]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p>', '[\"dark_hero\",\"dark_exclusive_card\",\"dark_about\",\"dark_campaign\",\"dark_top_up\",\"dark_why_chose_us\",\"dark_buy_game_id\",\"dark_testimonial\",\"dark_blog\"]', '2024-12-08 11:44:19', '2024-12-15 06:27:25'),
(9, 8, 1, 'Contact', '<div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_contact]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p>', '[\"dark_contact\"]', '2024-12-12 10:38:21', '2024-12-15 06:27:40'),
(10, 9, 1, 'Card', NULL, NULL, '2024-12-12 10:53:41', '2024-12-12 10:53:41'),
(11, 10, 1, 'Top Up', NULL, NULL, '2024-12-12 10:53:49', '2024-12-12 10:53:49'),
(12, 13, 1, 'Blogs', NULL, NULL, '2024-12-12 11:28:41', '2024-12-12 11:28:41'),
(13, 11, 1, 'Cards', NULL, NULL, '2024-12-12 11:28:54', '2024-12-12 11:28:54'),
(14, 14, 1, 'Privacy And Policy', '<h1>Privacy Policy</h1><p><br></p><p>Effective Date: 14-12-2024</p><p>At Gamify, your privacy is important to us. This Privacy Policy outlines the types of information we collect, how we use it, and the measures we take to protect your data.</p><h2>1. Information We Collect</h2><h3>a. Personal Information</h3><p>We may collect personal information such as:</p><ul><li>Name</li><li>Email address</li><li>Date of birth</li><li>Payment information (for purchases or subscriptions)</li></ul><h3>b. Non-Personal Information</h3><p>We collect non-personal information, including:</p><ul><li>IP address</li><li>Browser type</li><li>Operating system</li><li>Device information</li><li>Game preferences and interaction data</li></ul><h3>c. Cookies and Tracking Technologies</h3><p>We use cookies, web beacons, and similar technologies to:</p><ul><li>Enhance your experience</li><li>Analyze website traffic</li><li>Personalize content and ads</li></ul><h2>2. How We Use Your Information</h2><p>The information we collect is used to:</p><ul><li>Provide and improve our services</li><li>Process transactions</li><li>Communicate updates, promotions, or notifications</li><li>Customize user experiences</li><li>Ensure security and prevent fraud</li></ul><h2>3. Sharing Your Information</h2><p>We do not sell your personal information. However, we may share your data:</p><ul><li>With trusted partners who assist in providing our services</li><li>For legal compliance or to protect our rights</li><li>In case of a merger, acquisition, or asset sale</li></ul><h2>4. Third-Party Services</h2><p>Our website may include links to third-party services or games. We are not responsible for the privacy practices of these external websites.</p><h2>5. Data Security</h2><p>We implement robust security measures to protect your data from unauthorized access, alteration, or disclosure. However, no method of electronic transmission is completely secure.</p><h2>6. Your Rights</h2><p>Depending on your location, you may have the following rights:</p><ul><li>Access your personal information</li><li>Request correction of inaccurate data</li><li>Delete your data</li><li>Opt-out of marketing communications</li><li>Restrict or object to certain processing activities</li></ul><p>To exercise these rights, contact us at [Insert Contact Email].</p><h2>7. Children’s Privacy</h2><p>Gamify is not directed toward children under 13, and we do not knowingly collect personal information from them. If we discover that we have inadvertently collected data from a child, we will delete it promptly.</p><h2>8. Changes to This Policy</h2><p>We may update this Privacy Policy from time to time. The revised policy will be effective immediately upon posting. Please review it periodically.</p><h2>9. Contact Us</h2><p>If you have any questions about this Privacy Policy or our data practices, please contact us at:</p><ul><li><strong>Email:</strong> [Insert Email Address]</li><li><strong>Address:</strong> [Insert Physical Address]</li></ul>', NULL, '2024-12-12 12:50:20', '2024-12-14 04:58:09'),
(15, 15, 1, 'Terms And Conditions', '<h1><span style=\"font-size:24px;\">Terms and Conditions</span></h1><p>Effective Date: 14-12-2024</p><p>Welcome to Gamify! These Terms and Conditions (\"Terms\") govern your use of our website and services. By accessing or using Gamify, you agree to be bound by these Terms. If you do not agree, please refrain from using our platform.</p><h2><span style=\"font-size:18px;\">1. Acceptance of Terms</span></h2><p>By accessing Gamify, you:</p><ul><li>Confirm that you have read, understood, and agree to these Terms.</li><li>Agree to comply with all applicable laws and regulations.</li><li>Understand that these Terms constitute a legally binding agreement.</li></ul><h2><span style=\"font-size:18px;\">2. Eligibility</span></h2><p>To use Gamify, you must:</p><ul><li>Be at least 13 years old. If you are under 18, you must have parental or guardian consent.</li><li>Ensure that your use of the platform does not violate any laws applicable to you.</li></ul><h2><span style=\"font-size:18px;\">3. User Accounts</span></h2><h3><span style=\"font-size:18px;\">a. Account Creation</span></h3><p>You may need to register for an account to access certain features. You agree to:</p><ul><li>Provide accurate and truthful information.</li><li>Keep your login credentials secure and confidential.</li></ul><h3><span style=\"font-size:18px;\">b. Account Suspension or Termination</span></h3><p>We reserve the right to suspend or terminate your account for:</p><ul><li>Breach of these Terms.</li><li>Engaging in prohibited activities.</li><li>Providing false information during registration.</li></ul><h2><span style=\"font-size:18px;\">4. Use of Services</span></h2><p>You agree to use Gamify for lawful purposes only. You are prohibited from:</p><ul><li>Uploading harmful, offensive, or illegal content.</li><li>Attempting to disrupt the functionality of the platform.</li><li>Impersonating other users or entities.</li><li>Engaging in spamming, phishing, or other fraudulent activities.</li></ul><h2><span style=\"font-size:18px;\">5. Intellectual Property</span></h2><ul><li>All content, trademarks, and materials on Gamify are owned by or licensed to us.</li><li>You may not reproduce, distribute, or modify our content without prior written permission.</li><li>Any content you submit (e.g., comments or posts) grants us a non-exclusive, royalty-free license to use it.</li></ul><h2><span style=\"font-size:18px;\">6. Purchases and Payments</span></h2><p>If you make purchases on Gamify, you agree to:</p><ul><li>Provide valid and up-to-date payment information.</li><li>Abide by any specific terms related to transactions.</li><li>Accept that all purchases are subject to our refund policy.</li></ul><h2><span style=\"font-size:18px;\">7. Content and Community Guidelines</span></h2><p>You agree that:</p><ul><li>Any content you post or share does not violate third-party rights, laws, or our guidelines.</li><li>We reserve the right to remove or edit content deemed inappropriate or in violation of these Terms.</li></ul><h2><span style=\"font-size:18px;\">8. Limitation of Liability</span></h2><p>To the maximum extent permitted by law:</p><ul><li>Gamify is provided \"as is\" without warranties of any kind.</li><li>We are not liable for any damages, including loss of data, revenue, or opportunities arising from your use of our platform.</li></ul><h2><span style=\"font-size:18px;\">9. Privacy Policy</span></h2><p>Your use of Gamify is also governed by our <a href=\"#\">Privacy Policy</a>, which explains how we collect, use, and protect your data.</p><h2><span style=\"font-size:18px;\">10. Modifications to Terms</span></h2><p>We may update these Terms periodically. By continuing to use the platform after updates, you accept the revised Terms.</p><h2><span style=\"font-size:18px;\">11. Governing Law</span></h2><p>These Terms are governed by the laws of [Your Country/Region]. Any disputes will be resolved exclusively in the courts of [Your Jurisdiction].</p><h2><span style=\"font-size:18px;\">12. Contact Information</span></h2><p>If you have questions or concerns regarding these Terms, please contact us at:</p><ul><li><strong>Email:</strong> [Insert Email Address]</li><li><strong>Address:</strong> [Insert Physical Address]</li></ul>', NULL, '2024-12-14 04:46:17', '2024-12-14 04:59:43'),
(16, 16, 1, 'Developer', '<div class=\"custom-block\" contenteditable=\"false\"><div class=\"custom-block-content\">[[dark_docx]]</div>\r\n                    <span class=\"delete-block\">×</span>\r\n                    <span class=\"up-block\">↑</span>\r\n                    <span class=\"down-block\">↓</span></div><p><br></p>', '[\"dark_docx\"]', '2024-12-15 12:08:09', '2024-12-15 12:08:09'),
(17, 18, 1, 'Cards', NULL, NULL, '2024-12-18 11:27:47', '2024-12-18 11:27:47'),
(18, 19, 1, 'Top Up', NULL, NULL, '2024-12-18 11:27:59', '2024-12-18 11:27:59'),
(19, 20, 1, 'Cookie Policy', '<p><span style=\"font-weight:bolder;\"><span style=\"font-size:24px;\">Cookie Policy for Gemars Haven</span></span></p><p>Last Updated: 21-12-2024</p><h3>1. Introduction</h3><p><span style=\"font-size:14px;\"><b>Gemars Haven</b></span>(\"we\", \"us\", or \"our\") uses cookies and similar tracking technologies on our website [<a href=\"http://www.adzilla.com/\">www.gamers.com</a>] (\"Site\"). This Cookie Policy explains what cookies are, how we use them, the types of cookies we use, and your choices regarding cookies.</p><p>By using our Site, you agree to the use of cookies as outlined in this policy. If you do not agree, you may disable cookies through your browser settings.</p><h3>2. What are Cookies?</h3><p>Cookies are small text files stored on your device (computer, tablet, or mobile) by your web browser. They help websites remember information about your visit, such as your preferences and other settings, so that your next visit can be more efficient and personalized.</p><h3>3. How We Use Cookies</h3><p>We use cookies to:</p><ul><li><span style=\"font-weight:bolder;\">Enhance User Experience</span>: Remember your preferences and settings.</li><li><span style=\"font-weight:bolder;\">Analytics</span>: Collect information about how visitors use our Site to improve its functionality.</li><li><span style=\"font-weight:bolder;\">Advertising</span>: Deliver personalized ads based on your interests and browsing behavior.</li><li><span style=\"font-weight:bolder;\">Security and Authentication</span>: Ensure the security of our Site and verify your login credentials.</li></ul><h3>4. Types of Cookies We Use</h3><p>We use both <span style=\"font-weight:bolder;\">session cookies</span> (which expire when you close your browser) and <span style=\"font-weight:bolder;\">persistent cookies</span> (which remain on your device for a set period or until you delete them). The types of cookies we may use include:</p><ul><li><span style=\"font-weight:bolder;\">Essential Cookies</span>: Necessary for the Site to function properly (e.g., enabling navigation and access to secure areas).</li><li><span style=\"font-weight:bolder;\">Performance Cookies</span>: Collect information about how visitors interact with our Site (e.g., pages visited, time spent, and errors encountered).</li><li><span style=\"font-weight:bolder;\">Functionality Cookies</span>: Remember your choices (e.g., language preferences) to provide a more personalized experience.</li><li><span style=\"font-weight:bolder;\">Targeting/Advertising Cookies</span>: Track your online activity to help deliver relevant advertisements or limit the number of times you see an ad.</li></ul><h3>5. Third-Party Cookies</h3><p>We may allow third-party service providers to place cookies on your device for advertising, analytics, and other purposes. These third parties may use cookies to collect information about your online activities across different websites.</p><p>Some of our key third-party providers include:</p><ul><li><span style=\"font-weight:bolder;\">Google Analytics</span></li><li><span style=\"font-weight:bolder;\">Facebook Pixel</span></li><li><span style=\"font-weight:bolder;\">DoubleClick</span></li></ul><p>Please review their respective privacy policies for more details on how they use your data.</p><h3>6. Your Choices Regarding Cookies</h3><p>You have the following options to manage cookies:</p><ul><li><span style=\"font-weight:bolder;\">Browser Settings</span>: You can set your browser to refuse cookies or alert you when cookies are being sent. However, some features of our Site may not function properly without cookies.</li><li><span style=\"font-weight:bolder;\">Opt-Out Tools</span>: You can opt-out of targeted advertising through tools like the <a>Network Advertising Initiative</a> or <a href=\"https://www.youronlinechoices.com/\">Your Online Choices</a>.</li></ul><h3>7. Changes to this Cookie Policy</h3><p>We may update this Cookie Policy from time to time. Any changes will be posted on this page with an updated \"Last Updated\" date. Your continued use of our Site after changes have been made signifies your acceptance of the revised policy.</p><h3>8. Contact Us</h3><p>If you have any questions or concerns about our use of cookies, please contact us at:</p><p><span style=\"font-weight:bolder;\">Gamers Haven Support Team</span><br>Email: <a>support@gamersHaven.com</a><br>Phone: [Your Phone Number]<br>Address: [Your Company Address]</p>', NULL, '2024-12-21 10:35:04', '2024-12-21 10:35:04'),
(20, 21, 1, 'Cookie Policy', '<p><span style=\"font-weight:bolder;\"><span style=\"font-size:24px;\">Cookie Policy for Gemars Haven</span></span></p><p>Last Updated: 21-12-2024</p><h3>1. Introduction</h3><p><span style=\"font-weight:bolder;\">Gemars Haven</span>(\"we\", \"us\", or \"our\") uses cookies and similar tracking technologies on our website [<a href=\"http://www.adzilla.com/\">www.gamers.com</a>] (\"Site\"). This Cookie Policy explains what cookies are, how we use them, the types of cookies we use, and your choices regarding cookies.</p><p>By using our Site, you agree to the use of cookies as outlined in this policy. If you do not agree, you may disable cookies through your browser settings.</p><h3>2. What are Cookies?</h3><p>Cookies are small text files stored on your device (computer, tablet, or mobile) by your web browser. They help websites remember information about your visit, such as your preferences and other settings, so that your next visit can be more efficient and personalized.</p><h3>3. How We Use Cookies</h3><p>We use cookies to:</p><ul><li><span style=\"font-weight:bolder;\">Enhance User Experience</span>: Remember your preferences and settings.</li><li><span style=\"font-weight:bolder;\">Analytics</span>: Collect information about how visitors use our Site to improve its functionality.</li><li><span style=\"font-weight:bolder;\">Advertising</span>: Deliver personalized ads based on your interests and browsing behavior.</li><li><span style=\"font-weight:bolder;\">Security and Authentication</span>: Ensure the security of our Site and verify your login credentials.</li></ul><h3>4. Types of Cookies We Use</h3><p>We use both <span style=\"font-weight:bolder;\">session cookies</span> (which expire when you close your browser) and <span style=\"font-weight:bolder;\">persistent cookies</span> (which remain on your device for a set period or until you delete them). The types of cookies we may use include:</p><ul><li><span style=\"font-weight:bolder;\">Essential Cookies</span>: Necessary for the Site to function properly (e.g., enabling navigation and access to secure areas).</li><li><span style=\"font-weight:bolder;\">Performance Cookies</span>: Collect information about how visitors interact with our Site (e.g., pages visited, time spent, and errors encountered).</li><li><span style=\"font-weight:bolder;\">Functionality Cookies</span>: Remember your choices (e.g., language preferences) to provide a more personalized experience.</li><li><span style=\"font-weight:bolder;\">Targeting/Advertising Cookies</span>: Track your online activity to help deliver relevant advertisements or limit the number of times you see an ad.</li></ul><h3>5. Third-Party Cookies</h3><p>We may allow third-party service providers to place cookies on your device for advertising, analytics, and other purposes. These third parties may use cookies to collect information about your online activities across different websites.</p><p>Some of our key third-party providers include:</p><ul><li><span style=\"font-weight:bolder;\">Google Analytics</span></li><li><span style=\"font-weight:bolder;\">Facebook Pixel</span></li><li><span style=\"font-weight:bolder;\">DoubleClick</span></li></ul><p>Please review their respective privacy policies for more details on how they use your data.</p><h3>6. Your Choices Regarding Cookies</h3><p>You have the following options to manage cookies:</p><ul><li><span style=\"font-weight:bolder;\">Browser Settings</span>: You can set your browser to refuse cookies or alert you when cookies are being sent. However, some features of our Site may not function properly without cookies.</li><li><span style=\"font-weight:bolder;\">Opt-Out Tools</span>: You can opt-out of targeted advertising through tools like the <a>Network Advertising Initiative</a> or <a href=\"https://www.youronlinechoices.com/\">Your Online Choices</a>.</li></ul><h3>7. Changes to this Cookie Policy</h3><p>We may update this Cookie Policy from time to time. Any changes will be posted on this page with an updated \"Last Updated\" date. Your continued use of our Site after changes have been made signifies your acceptance of the revised policy.</p><h3>8. Contact Us</h3><p>If you have any questions or concerns about our use of cookies, please contact us at:</p><p><span style=\"font-weight:bolder;\">Gamers Haven Support Team</span><br>Email: <a>support@gamersHaven.com</a><br>Phone: [Your Phone Number]<br>Address: [Your Company Address]</p>', NULL, '2024-12-21 11:08:53', '2024-12-21 11:08:53'),
(21, 23, 1, 'Buy ID', NULL, NULL, '2024-12-29 07:11:28', '2024-12-29 10:29:25'),
(22, 22, 1, 'Buy ID', NULL, NULL, '2024-12-29 10:29:09', '2024-12-29 10:29:09'),
(43, 25, 1, 'Google', NULL, NULL, '2025-01-06 12:16:59', '2025-01-06 12:16:59'),
(44, 26, 1, 'Google', NULL, NULL, '2025-01-06 12:22:49', '2025-01-06 12:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `payout_method_id` int UNSIGNED DEFAULT NULL,
  `payout_currency_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(18,8) DEFAULT '0.00000000',
  `charge` decimal(18,8) DEFAULT '0.00000000',
  `net_amount` decimal(18,8) DEFAULT '0.00000000',
  `amount_in_base_currency` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `charge_in_base_currency` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `net_amount_in_base_currency` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `response_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_error` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `information` text COLLATE utf8mb4_unicode_ci,
  `meta_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'for fullerwave',
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `trx_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0=> pending, 1=> generated, 2=>success 3=> cancel,',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payout_methods`
--

CREATE TABLE `payout_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` text COLLATE utf8mb4_unicode_ci COMMENT 'automatic payment for bank name',
  `banks` text COLLATE utf8mb4_unicode_ci COMMENT 'admin bank permission',
  `parameters` text COLLATE utf8mb4_unicode_ci COMMENT 'api parameters',
  `extra_parameters` text COLLATE utf8mb4_unicode_ci,
  `inputForm` text COLLATE utf8mb4_unicode_ci,
  `currency_lists` text COLLATE utf8mb4_unicode_ci,
  `supported_currency` text COLLATE utf8mb4_unicode_ci,
  `payout_currencies` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = inactive',
  `is_automatic` tinyint NOT NULL DEFAULT '0',
  `is_sandbox` tinyint NOT NULL DEFAULT '0',
  `environment` enum('test','live') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'live',
  `confirm_payout` tinyint(1) NOT NULL DEFAULT '1',
  `is_auto_update` tinyint NOT NULL DEFAULT '1' COMMENT 'currency rate auto update',
  `currency_type` tinyint(1) NOT NULL DEFAULT '1',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payout_methods`
--

INSERT INTO `payout_methods` (`id`, `name`, `code`, `description`, `bank_name`, `banks`, `parameters`, `extra_parameters`, `inputForm`, `currency_lists`, `supported_currency`, `payout_currencies`, `is_active`, `is_automatic`, `is_sandbox`, `environment`, `confirm_payout`, `is_auto_update`, `currency_type`, `logo`, `driver`, `created_at`, `updated_at`) VALUES
(2, 'Wire Transfer', 'paypal-manual', 'Payment will receive within 9 hours', NULL, NULL, '[]', NULL, '{\"account_name\":{\"field_name\":\"account_name\",\"field_label\":\"Account Name\",\"type\":\"text\",\"validation\":\"required\"},\"account_details\":{\"field_name\":\"account_details\",\"field_label\":\"Account Details\",\"type\":\"textarea\",\"validation\":\"required\"},\"n_i_d\":{\"field_name\":\"n_i_d\",\"field_label\":\"NID\",\"type\":\"file\",\"validation\":\"required\"}}', NULL, '[\"EUR\",\"CAD\"]', '[{\"currency_symbol\":\"EUR\",\"conversion_rate\":\"0.93\",\"min_limit\":\"1\",\"max_limit\":\"10000000\",\"percentage_charge\":\"1\",\"fixed_charge\":\"0.5\"},{\"currency_symbol\":\"CAD\",\"conversion_rate\":\"1.13\",\"min_limit\":\"1\",\"max_limit\":\"10000000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 1, 0, 0, 'test', 1, 0, 1, 'payoutMethod/XBBAl0sufa0cCQNvbigsJYuYrvtQ7J.webp', 'local', '2020-12-23 13:40:51', '2025-03-05 23:17:37'),
(3, 'Bank', 'bank', 'Payment will receive within 8 days', NULL, NULL, '[]', NULL, '{\"account_number\":{\"field_name\":\"account_number\",\"field_label\":\"Account Number\",\"type\":\"text\",\"validation\":\"required\"},\"account_name\":{\"field_name\":\"account_name\",\"field_label\":\"Account Name\",\"type\":\"text\",\"validation\":\"required\"}}', NULL, '[\"USD\"]', '[{\"currency_symbol\":\"USD\",\"conversion_rate\":\"1\",\"min_limit\":\"0.01\",\"max_limit\":\"1000000\",\"percentage_charge\":\"2\",\"fixed_charge\":\"0.5\"}]', 1, 0, 0, 'test', 1, 0, 1, 'payoutMethod/GfDP920pCPR2aXBQHEzwMxwUOCeOXf.webp', 'local', '2020-12-27 13:23:36', '2025-03-05 23:16:59'),
(9, 'Flutterwave', 'flutterwave', 'Payment will receive within 1 days', '{\"0\":{\"NGN BANK\":\"NGN BANK\",\"NGN DOM\":\"NGN DOM\",\"GHS BANK\":\"GHS BANK\",\"KES BANK\":\"KES BANK\",\"ZAR BANK\":\"ZAR BANK\",\"INTL EUR & GBP\":\"INTL EUR & GBP\",\"INTL USD\":\"INTL USD\",\"INTL OTHERS\":\"INTL OTHERS\",\"FRANCOPGONE\":\"FRANCOPGONE\",\"XAF/XOF MOMO\":\"XAF/XOF MOMO\",\"mPesa\":\"mPesa\",\"Rwanda Momo\":\"Rwanda Momo\",\"Uganda Momo\":\"Uganda Momo\",\"Zambia Momo\":\"Zambia Momo\",\"Barter\":\"Barter\",\"FLW\":\"FLW\"}}', '[\"NGN BANK\",\"NGN DOM\",\"GHS BANK\"]', '{\"Public_Key\":\"YOUR_FLUTTERWAVE_PUBLIC_KEY\",\"Secret_Key\":\"YOUR_FLUTTERWAVE_SECRET_KEY\",\"Encryption_Key\":\"YOUR_FLUTTERWAVE_ENCRYPTION_KEY\"}', NULL, '[]', '{\"USD\":\"USD\",\"KES\":\"KES\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"UGX\":\"UGX\",\"TZS\":\"TZS\"}', '[\"USD\",\"NGN\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0081\",\"min_limit\":\"1\",\"max_limit\":\"10000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"NGN\",\"currency_symbol\":\"NGN\",\"conversion_rate\":\"12.64\",\"min_limit\":\"10\",\"max_limit\":\"100000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.2\"}]', 1, 1, 0, 'test', 1, 0, 1, 'payoutMethod/iHzqdwIH1o7bRg7sv3FpD0z9iSYvo9.webp', 'local', '2020-12-27 13:23:36', '2025-01-28 11:52:21'),
(10, 'Razorpay', 'razorpay', 'Payment will receive within 1 days', '', NULL, '{\"account_number\":\"7878780080316316\",\"Key_Id\":\"YOUR_RAZORPAY_KEY_ID\",\"Key_Secret\":\"osRDebzEqbsE1kbyQJ4y0re7\"}', '{\"webhook\":\"payoutIpn\"}', '[]', '{\"INR\":\"INR\"}', '[\"INR\"]', '[{\"name\":\"INR\",\"currency_symbol\":\"INR\",\"conversion_rate\":\"0.76\",\"min_limit\":\"10\",\"max_limit\":\"15000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 1, 1, 0, 'test', 1, 0, 1, 'payoutMethod/LSxqmJA9WXUJlgvBWR7i8yCOjkemgt.webp', 'local', '2020-12-27 13:23:36', '2025-01-06 07:38:27'),
(11, 'Paystack', 'paystack', 'Payment will receive within 1 days', '', NULL, '{\"Public_key\":\"YOUR_PAYSTACK_PUBLIC_KEY\",\"Secret_key\":\"YOUR_PAYSTACK_SECRET_KEY\"}', '{\"webhook\":\"payoutIpn\"}', '[]', '{\"NGN\":\"NGN\",\"GHS\":\"GHS\",\"ZAR\":\"ZAR\"}', '[\"NGN\",\"GHS\",\"ZAR\"]', '[{\"name\":\"NGN\",\"currency_symbol\":\"NGN\",\"conversion_rate\":\"7.40\",\"min_limit\":\"50\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"GHS\",\"currency_symbol\":\"GHS\",\"conversion_rate\":\"0.11\",\"min_limit\":\"50\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"ZAR\",\"currency_symbol\":\"ZAR\",\"conversion_rate\":\"0.17\",\"min_limit\":\"50\",\"max_limit\":\"50000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 1, 1, 0, 'test', 1, 1, 1, 'payoutMethod/kKfCIKhfxYKsXLEKWDVSCmimJ7Mx9F.webp', 'local', '2020-12-27 13:23:36', '2025-01-06 07:38:43'),
(12, 'Coinbase', 'coinbase', 'Payment will receive within 1 days', '', NULL, '{\"API_Key\":\"5328e8ff2f7fe0bbc7fd6ea593038b08\",\"API_Secret\":\"ACWAncjv2fbMdvPfeJq9U\\/blqEx1FiItqbUGn+kEPCLbKGP4\\/iJlPIQDzMmJHHz\\/Inv1jYANsWDnh3RhHi6HLw==\",\"Api_Passphrase\":\"23xe3opufifi\"}', '{\"webhook\":\"payoutIpn\"}', '[]', '{\"BNB\":\"BNB\",\"BTC\":\"BTC\",\"XRP\":\"XRP\",\"ETH\":\"ETH\",\"ETH2\":\"ETH2\",\"USDT\":\"USDT\",\"BCH\":\"BCH\",\"LTC\":\"LTC\",\"XMR\":\"XMR\",\"TON\":\"TON\"}', '[\"BNB\"]', '[{\"name\":\"BNB\",\"currency_symbol\":\"BNB\",\"conversion_rate\":\"0.068\",\"min_limit\":\"1000\",\"max_limit\":\"1000000\",\"percentage_charge\":\"0.5\",\"fixed_charge\":\"0.5\"}]', 1, 1, 0, 'test', 1, 0, 1, 'payoutMethod/gWdg971iv032D4oST044YNkV8voAgj.webp', 'local', '2020-12-27 13:23:36', '2025-01-06 07:38:54'),
(14, 'Perfect Money', 'perfectmoney', 'Payment will receive within 1 days', '', NULL, '{\"Passphrase\":\"45P7GN1T8TlRfMRAPCqLArVHz\",\"Account_ID\":\"90016052\",\"Payer_Account\":\"U41722458\"}', '', '[]', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', '[\"USD\",\"EUR\"]', '[{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"15000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"},{\"name\":\"EUR\",\"currency_symbol\":\"EUR\",\"conversion_rate\":\"0.0081\",\"min_limit\":\"1\",\"max_limit\":\"15000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0.5\"}]', 1, 1, 0, 'test', 1, 0, 1, 'payoutMethod/QPrYjeUxMX2M7KYNmDGrfmyZkf5QOy.webp', 'local', '2020-12-27 13:23:36', '2025-01-06 07:35:31'),
(15, 'Paypal', 'paypal', 'Payment will receive within 1 days', '', NULL, '{\"cleint_id\":\"AUrvcotEVWZkksiGir6Ih4PyalQcguQgGN-7We5O1wBny3tg1w6srbQzi6GQEO8lP3yJVha2C6lyivK9\",\"secret\":\"EPx-YEgvjKDRFFu3FAsMue_iUMbMH6jHu408rHdn4iGrUCM8M12t7mX8hghUBAWwvWErBOa4Uppfp0Eh\"}', '{\"webhook\":\"payoutIpn\"}', '[]', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"USD\"}', '[\"EUR\",\"USD\"]', '[{\"name\":\"EUR\",\"currency_symbol\":\"EUR\",\"conversion_rate\":\"0.0081\",\"min_limit\":\"1\",\"max_limit\":\"1000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"},{\"name\":\"USD\",\"currency_symbol\":\"USD\",\"conversion_rate\":\"0.0091\",\"min_limit\":\"1\",\"max_limit\":\"1000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 1, 1, 1, 'test', 1, 0, 1, 'payoutMethod/G8L93dajF8y9g1N62Ir7AGlgRLQRyT.webp', 'local', '2020-12-27 13:23:36', '2025-01-06 07:39:10'),
(16, 'Binance', 'binance', 'Payment will receive within 1 days', '', NULL, '{\"API_Key\":\"u7UxJbqJvYKlhygtR0wlC5xOfWWIuNMUHqZrPXkwLC0neRRrC5HHq7CnbdKWacBI\",\"KEY_Secret\":\"5Z00Ecib1MBnGoHs2LxdqPCE4c4UvQ4vZKEweLmySWhvw5jM4BV2nnk0sWL9gNEL\"}', '', '[]', '{\"BNB\":\"BNB\",\"BTC\":\"BTC\",\"XRP\":\"XRP\",\"ETH\":\"ETH\",\"ETH2\":\"ETH2\",\"USDT\":\"USDT\",\"BCH\":\"BCH\",\"LTC\":\"LTC\",\"XMR\":\"XMR\",\"TON\":\"TON\"}', '[\"BNB\"]', '[{\"name\":\"BNB\",\"currency_symbol\":\"BNB\",\"conversion_rate\":\"0.0043\",\"min_limit\":\"10\",\"max_limit\":\"1000\",\"percentage_charge\":\"0\",\"fixed_charge\":\"0\"}]', 1, 1, 1, 'test', 1, 0, 1, 'payoutMethod/qWemV55N0De5GtPKTxelnysPhKQwuc.webp', 'local', '2020-12-27 13:23:36', '2025-01-06 07:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `razorpay_contacts`
--

CREATE TABLE `razorpay_contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `contact_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `reviewable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewable_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `permission` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0=>deactive,1=>active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sell_posts`
--

CREATE TABLE `sell_posts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `credential` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_specification_form` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sell_charge` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'coloum carry percentage value',
  `image` text COLLATE utf8mb4_unicode_ci,
  `image_driver` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=> not approve, 1=>approve, 2=>Re submission, 3=>hold, 4=>soft Rejected, 5=>hard Rejected\r\n ',
  `lock_for` int DEFAULT NULL COMMENT 'buyer id',
  `lock_at` timestamp NULL DEFAULT NULL,
  `payment_lock` tinyint(1) NOT NULL DEFAULT '0',
  `payment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 1=> payment complete, 2=> Reject, 3 => Pending',
  `payment_uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sell_post_categories`
--

CREATE TABLE `sell_post_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_driver` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_field` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_specification_form` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sell_charge` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sell_post_category_details`
--

CREATE TABLE `sell_post_category_details` (
  `id` bigint UNSIGNED NOT NULL,
  `sell_post_category_id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sell_post_chats`
--

CREATE TABLE `sell_post_chats` (
  `id` bigint UNSIGNED NOT NULL,
  `sell_post_id` bigint UNSIGNED NOT NULL,
  `offer_id` int NOT NULL,
  `chatable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chatable_id` bigint UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_read_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sell_post_offers`
--

CREATE TABLE `sell_post_offers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Proposed by\r\n',
  `author_id` int NOT NULL COMMENT 'Post author id',
  `sell_post_id` bigint UNSIGNED DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=>pending, 1=>accept, 2=>reject, 3=>Resubmission\r\n',
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempt_at` datetime DEFAULT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 => complete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sell_post_payments`
--

CREATE TABLE `sell_post_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL COMMENT 'Payment By',
  `sell_post_id` int DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `seller_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'seller will receive amount',
  `admin_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'admin will receive amount',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '1=> Complete',
  `payment_status` tinyint NOT NULL DEFAULT '0' COMMENT '1=> active, 2=> rejected, 3=> pending',
  `payment_release` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 => released, 2 =>Hold',
  `released_at` timestamp NULL DEFAULT NULL COMMENT 'Payment release to user',
  `transaction` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ticket` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0 => Open, 1 => Answered, 2 => Replied, 3 => Closed	',
  `last_reply` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_attachments`
--

CREATE TABLE `support_ticket_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_message_id` int DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_messages`
--

CREATE TABLE `support_ticket_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_id` bigint UNSIGNED DEFAULT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `top_ups`
--

CREATE TABLE `top_ups` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=>inactive,1=>active',
  `instant_delivery` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=>inactive,1=>active',
  `image` text COLLATE utf8mb4_unicode_ci,
  `order_information` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `guide` longtext COLLATE utf8mb4_unicode_ci,
  `total_review` int NOT NULL DEFAULT '0',
  `avg_rating` float NOT NULL DEFAULT '0',
  `sort_by` int NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `top_up_services`
--

CREATE TABLE `top_up_services` (
  `id` bigint UNSIGNED NOT NULL,
  `top_up_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `image_driver` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `discount_type` enum('flat','percentage') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'flat',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=>off,1=>on',
  `is_offered` tinyint(1) NOT NULL DEFAULT '0',
  `offered_sell` int NOT NULL DEFAULT '0' COMMENT 'how many sell at the campaign',
  `max_sell` int NOT NULL DEFAULT '0' COMMENT 'max limit of sell in campaign',
  `sort_by` int NOT NULL DEFAULT '1',
  `old_data` text COLLATE utf8mb4_unicode_ci,
  `campaign_data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `transactional_id` int DEFAULT NULL,
  `transactional_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `amount_in_base` double DEFAULT '0',
  `trx_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` double NOT NULL DEFAULT '0',
  `referral_id` int DEFAULT NULL,
  `language_id` int DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_driver` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_one` text COLLATE utf8mb4_unicode_ci,
  `address_two` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `identity_verify` tinyint NOT NULL DEFAULT '0' COMMENT '0 => Not Applied, 1=> Applied, 2=> Approved, 3 => Rejected	',
  `address_verify` tinyint NOT NULL DEFAULT '0' COMMENT '0 => Not Applied, 1=> Applied, 2=> Approved, 3 => Rejected',
  `two_fa` tinyint(1) NOT NULL DEFAULT '0',
  `two_fa_verify` tinyint(1) NOT NULL DEFAULT '1',
  `two_fa_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verification` tinyint(1) NOT NULL DEFAULT '1',
  `sms_verification` tinyint(1) NOT NULL DEFAULT '1',
  `verify_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_seen` datetime DEFAULT NULL,
  `time_zone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `public_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secret_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_dashboard` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `github_id` text COLLATE utf8mb4_unicode_ci,
  `google_id` text COLLATE utf8mb4_unicode_ci,
  `facebook_id` text COLLATE utf8mb4_unicode_ci,
  `update_password_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_kycs`
--

CREATE TABLE `user_kycs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `kyc_id` int DEFAULT NULL,
  `kyc_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_info` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>pending , 1=> verified, 2=>rejected',
  `reason` longtext COLLATE utf8mb4_unicode_ci COMMENT 'rejected reason',
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `get_device` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_trackings`
--

CREATE TABLE `user_trackings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `region_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `device` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_sell_post_id_foreign` (`sell_post_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `basic_controls`
--
ALTER TABLE `basic_controls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_details`
--
ALTER TABLE `blog_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cards_category_id_index` (`category_id`);

--
-- Indexes for table `card_services`
--
ALTER TABLE `card_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_services_card_id_index` (`card_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codes_codeable_type_codeable_id_index` (`codeable_type`,`codeable_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_details`
--
ALTER TABLE `content_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_details_content_id_index` (`content_id`),
  ADD KEY `content_details_language_id_index` (`language_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deposits_user_id_index` (`user_id`),
  ADD KEY `deposits_payment_method_id_index` (`payment_method_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `file_storages`
--
ALTER TABLE `file_storages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fire_base_tokens`
--
ALTER TABLE `fire_base_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gateways_code_unique` (`code`);

--
-- Indexes for table `in_app_notifications`
--
ALTER TABLE `in_app_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `kycs`
--
ALTER TABLE `kycs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_modes`
--
ALTER TABLE `maintenance_modes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manage_menus`
--
ALTER TABLE `manage_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manual_sms_configs`
--
ALTER TABLE `manual_sms_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification_templates_language_id_index` (`language_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_index` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_detailable_type_detailable_id_index` (`detailable_type`,`detailable_id`),
  ADD KEY `order_details_user_id_index` (`user_id`),
  ADD KEY `order_details_order_id_index` (`order_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_details`
--
ALTER TABLE `page_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payout_methods`
--
ALTER TABLE `payout_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `razorpay_contacts`
--
ALTER TABLE `razorpay_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_reviewable_type_reviewable_id_index` (`reviewable_type`,`reviewable_id`),
  ADD KEY `reviews_user_id_index` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sell_posts`
--
ALTER TABLE `sell_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_sells_category_id_foreign` (`category_id`);

--
-- Indexes for table `sell_post_categories`
--
ALTER TABLE `sell_post_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sell_post_category_details`
--
ALTER TABLE `sell_post_category_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sell_post_category_details_sell_post_category_id_foreign` (`sell_post_category_id`);

--
-- Indexes for table `sell_post_chats`
--
ALTER TABLE `sell_post_chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sell_post_chats_sell_post_id_foreign` (`sell_post_id`),
  ADD KEY `sell_post_chats_chat_type_chat_id_index` (`chatable_type`,`chatable_id`);

--
-- Indexes for table `sell_post_offers`
--
ALTER TABLE `sell_post_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sell_post_payments`
--
ALTER TABLE `sell_post_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_tickets_user_id_index` (`user_id`);

--
-- Indexes for table `support_ticket_attachments`
--
ALTER TABLE `support_ticket_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_ticket_messages`
--
ALTER TABLE `support_ticket_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_ticket_messages_support_ticket_id_index` (`support_ticket_id`),
  ADD KEY `support_ticket_messages_admin_id_index` (`admin_id`);

--
-- Indexes for table `top_ups`
--
ALTER TABLE `top_ups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `top_up_services`
--
ALTER TABLE `top_up_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `top_up_services_top_up_id_index` (`top_up_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_index` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_kycs`
--
ALTER TABLE `user_kycs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_kycs_user_id_index` (`user_id`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_logins_user_id_index` (`user_id`);

--
-- Indexes for table `user_trackings`
--
ALTER TABLE `user_trackings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_index` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `basic_controls`
--
ALTER TABLE `basic_controls`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blog_details`
--
ALTER TABLE `blog_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `card_services`
--
ALTER TABLE `card_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `codes`
--
ALTER TABLE `codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `content_details`
--
ALTER TABLE `content_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_storages`
--
ALTER TABLE `file_storages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fire_base_tokens`
--
ALTER TABLE `fire_base_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1008;

--
-- AUTO_INCREMENT for table `in_app_notifications`
--
ALTER TABLE `in_app_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `kycs`
--
ALTER TABLE `kycs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maintenance_modes`
--
ALTER TABLE `maintenance_modes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `manage_menus`
--
ALTER TABLE `manage_menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `manual_sms_configs`
--
ALTER TABLE `manual_sms_configs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `page_details`
--
ALTER TABLE `page_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payout_methods`
--
ALTER TABLE `payout_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `razorpay_contacts`
--
ALTER TABLE `razorpay_contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_posts`
--
ALTER TABLE `sell_posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_post_categories`
--
ALTER TABLE `sell_post_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_post_category_details`
--
ALTER TABLE `sell_post_category_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_post_chats`
--
ALTER TABLE `sell_post_chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_post_offers`
--
ALTER TABLE `sell_post_offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_post_payments`
--
ALTER TABLE `sell_post_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_ticket_attachments`
--
ALTER TABLE `support_ticket_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_ticket_messages`
--
ALTER TABLE `support_ticket_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `top_ups`
--
ALTER TABLE `top_ups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `top_up_services`
--
ALTER TABLE `top_up_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_kycs`
--
ALTER TABLE `user_kycs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_trackings`
--
ALTER TABLE `user_trackings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
