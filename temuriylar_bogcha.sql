-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 20 2025 г., 16:01
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `temuriylar_bogcha`
--

-- --------------------------------------------------------

--
-- Структура таблицы `balans`
--

CREATE TABLE `balans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `naqt` int(11) NOT NULL DEFAULT 0,
  `card` int(11) NOT NULL DEFAULT 0,
  `shot` int(11) NOT NULL DEFAULT 0,
  `exson_naqt` int(11) NOT NULL DEFAULT 0,
  `exson_card` int(11) NOT NULL DEFAULT 0,
  `exson_shot` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `balans`
--

INSERT INTO `balans` (`id`, `naqt`, `card`, `shot`, `exson_naqt`, `exson_card`, `exson_shot`, `created_at`, `updated_at`) VALUES
(1, 380000, 0, 0, 0, 0, 0, '2025-11-20 13:22:22', '2025-11-20 15:30:26');

-- --------------------------------------------------------

--
-- Структура таблицы `balans_histories`
--

CREATE TABLE `balans_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('naqt','card','shot') NOT NULL DEFAULT 'naqt',
  `status` enum('kassa_chiqim','kassa_xarajat','kassa_ish_haqi','tulov_card','tulov_shot','qaytar_naqt','qaytar_card','qaytar_shot','ish_haqi_naqt','ish_haqi_card','ish_haqi_shot','xarajat_naqt','xarajat_card','xarajat_shot','exson_naqt','exson_card','exson_shot','daromad_naqt','daromad_card','daromad_shot') NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `about` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `balans_histories`
--

INSERT INTO `balans_histories` (`id`, `type`, `status`, `amount`, `about`, `user_id`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'naqt', 'ish_haqi_naqt', 60000, 'Test uchun', 1, 1, '2025-11-20 15:25:22', '2025-11-20 15:25:22'),
(2, 'naqt', 'ish_haqi_naqt', 30000, 'Test uchun', 1, 1, '2025-11-20 15:25:41', '2025-11-20 15:25:41'),
(3, 'naqt', 'ish_haqi_naqt', 30000, 'Test uchun', 1, 1, '2025-11-20 15:30:26', '2025-11-20 15:30:26');

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `children`
--

CREATE TABLE `children` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `seria` varchar(255) DEFAULT NULL,
  `tkun` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `balans` int(11) NOT NULL DEFAULT 0,
  `balans_data` date DEFAULT NULL,
  `guvohnoma` tinyint(1) NOT NULL DEFAULT 0,
  `passport` tinyint(1) NOT NULL DEFAULT 0,
  `gepatet` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `children`
--

INSERT INTO `children` (`id`, `name`, `seria`, `tkun`, `status`, `balans`, `balans_data`, `guvohnoma`, `passport`, `gepatet`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Bola ISMI', 'TT451254245', '2022-01-11', 0, 0, NULL, 0, 0, 0, 1, '2025-11-20 16:59:44', '2025-11-20 16:59:44');

-- --------------------------------------------------------

--
-- Структура таблицы `child_balans_histories`
--

CREATE TABLE `child_balans_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `child_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `child_documents`
--

CREATE TABLE `child_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `child_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('guvohnoma','passport','gepatet') NOT NULL,
  `url` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `child_paymarts`
--

CREATE TABLE `child_paymarts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `child_id` bigint(20) UNSIGNED NOT NULL,
  `child_relative_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `type` enum('naqt','card','shot') NOT NULL,
  `about` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `child_relatives`
--

CREATE TABLE `child_relatives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `child_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
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
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `group_children`
--

CREATE TABLE `group_children` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `child_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `start_data` date DEFAULT NULL,
  `start_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_about` text DEFAULT NULL,
  `end_data` date DEFAULT NULL,
  `end_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `end_about` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `group_davomads`
--

CREATE TABLE `group_davomads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `child_id` bigint(20) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `status` enum('keldi','kechikdi','kelmadi','kasal','sababli') NOT NULL DEFAULT 'keldi',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `group_tarbiyachis`
--

CREATE TABLE `group_tarbiyachis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `start_data` date DEFAULT NULL,
  `start_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_about` text DEFAULT NULL,
  `end_data` date DEFAULT NULL,
  `end_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `end_about` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
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
-- Структура таблицы `job_batches`
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
-- Структура таблицы `kassas`
--

CREATE TABLE `kassas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kassa_naqt` int(11) NOT NULL DEFAULT 0,
  `kassa_card` int(11) NOT NULL DEFAULT 0,
  `kassa_shot` int(11) NOT NULL DEFAULT 0,
  `kassa_pedding_naqt` int(11) NOT NULL DEFAULT 0,
  `kassa_pedding_card` int(11) NOT NULL DEFAULT 0,
  `kassa_pedding_shot` int(11) NOT NULL DEFAULT 0,
  `teacher_pedding_pay_naqt` int(11) NOT NULL DEFAULT 0,
  `xarajat_pedding_naqt` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kassas`
--

INSERT INTO `kassas` (`id`, `kassa_naqt`, `kassa_card`, `kassa_shot`, `kassa_pedding_naqt`, `kassa_pedding_card`, `kassa_pedding_shot`, `teacher_pedding_pay_naqt`, `xarajat_pedding_naqt`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-20 13:23:41', '2025-11-20 13:23:41');

-- --------------------------------------------------------

--
-- Структура таблицы `kassa_histories`
--

CREATE TABLE `kassa_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('chiqim','xarajat','ish_haqi','qaytar_naqt','qaytar_card','qaytar_shot','chegirma') NOT NULL DEFAULT 'chiqim',
  `amount` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_paymart_id` bigint(20) UNSIGNED DEFAULT NULL,
  `create_data` timestamp NULL DEFAULT NULL,
  `success_data` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `about` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '0001_01_01_000009_create_positions_table', 1),
(4, '0001_01_01_000010_create_users_table', 1),
(5, '2025_11_17_153928_create_personal_access_tokens_table', 1),
(6, '2025_11_17_232716_create_rooms_table', 1),
(7, '2025_11_18_042323_create_setting_sms_table', 1),
(8, '2025_11_18_042926_create_setting_paymarts_table', 1),
(9, '2025_11_18_043108_create_kassas_table', 1),
(10, '2025_11_18_043311_create_balans_table', 1),
(11, '2025_11_18_223339_create_children_table', 1),
(12, '2025_11_18_223717_create_child_relatives_table', 1),
(13, '2025_11_18_223913_create_child_documents_table', 1),
(14, '2025_11_18_224111_create_child_paymarts_table', 1),
(15, '2025_11_19_024446_create_user_paymarts_table', 1),
(16, '2025_11_19_024715_create_kassa_histories_table', 1),
(17, '2025_11_19_025029_create_balans_histories_table', 1),
(18, '2025_11_19_224359_create_groups_table', 1),
(19, '2025_11_19_224610_create_group_tarbiyachis_table', 1),
(20, '2025_11_19_224803_create_group_children_table', 1),
(21, '2025_11_19_224957_create_group_davomads_table', 1),
(22, '2025_11_20_060842_create_child_balans_histories_table', 1),
(23, '2025_11_20_183809_create_user_davomads_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'api-token', 'b5e09fe87f45cd6ed110e36cf4f53e0d6a2413e4403db94847641e52e4af9b26', '[\"*\"]', '2025-11-20 17:00:04', NULL, '2025-11-20 15:15:15', '2025-11-20 17:00:04');

-- --------------------------------------------------------

--
-- Структура таблицы `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` enum('Management','Education-Care','Education-Teacher','Service','Extra') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `positions`
--

INSERT INTO `positions` (`id`, `name`, `category`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Management', NULL, NULL),
(2, 'direktor', 'Management', NULL, NULL),
(3, 'metodist', 'Management', NULL, NULL),
(4, 'meneger', 'Management', NULL, NULL),
(5, 'tarbiyachi', 'Education-Care', NULL, NULL),
(6, 'yordam_tarbiyachi', 'Education-Care', NULL, NULL),
(7, 'psixolog', 'Education-Teacher', NULL, NULL),
(8, 'logoped', 'Education-Teacher', NULL, NULL),
(9, 'defektolog', 'Education-Teacher', NULL, NULL),
(10, 'ingliz_tili', 'Education-Teacher', NULL, NULL),
(11, 'rus_tili', 'Education-Teacher', NULL, NULL),
(12, 'jismoniy_tarbiya', 'Education-Teacher', NULL, NULL),
(13, 'rasm_sanat', 'Education-Teacher', NULL, NULL),
(14, 'hamshira', 'Service', NULL, NULL),
(15, 'qorovul', 'Service', NULL, NULL),
(16, 'bosh_oshpaz', 'Service', NULL, NULL),
(17, 'yordam_oshpaz', 'Service', NULL, NULL),
(18, 'farrosh', 'Service', NULL, NULL),
(19, 'kir_yuvuvchi', 'Service', NULL, NULL),
(20, 'marketing_muhandis', 'Extra', NULL, NULL),
(21, 'smm_muhandis', 'Extra', NULL, NULL),
(22, 'fotograf', 'Extra', NULL, NULL),
(23, 'texnik', 'Extra', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `about` text DEFAULT NULL,
  `size` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `delete_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `setting_paymarts`
--

CREATE TABLE `setting_paymarts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exson_foiz` int(11) NOT NULL DEFAULT 0,
  `bonus_80_plus` int(11) NOT NULL DEFAULT 0,
  `bonus_85_plus` int(11) NOT NULL DEFAULT 0,
  `bonus_90_plus` int(11) NOT NULL DEFAULT 0,
  `bonus_95_plus` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `setting_paymarts`
--

INSERT INTO `setting_paymarts` (`id`, `exson_foiz`, `bonus_80_plus`, `bonus_85_plus`, `bonus_90_plus`, `bonus_95_plus`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, 0, 0, '2025-11-20 13:17:04', '2025-11-20 13:17:04');

-- --------------------------------------------------------

--
-- Структура таблицы `setting_sms`
--

CREATE TABLE `setting_sms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  `parol` varchar(255) DEFAULT NULL,
  `token` text DEFAULT NULL,
  `token_data` text DEFAULT NULL,
  `create_child_status` tinyint(1) NOT NULL DEFAULT 0,
  `create_child_text` text NOT NULL DEFAULT 'Yangi bola qabul qilinganda yuboriladigan sms.',
  `debet_send_status` tinyint(1) NOT NULL DEFAULT 0,
  `debet_send_text` text NOT NULL DEFAULT 'Qarzdorlik mavjud bo\'lganda yuboriladigan sms xabar.',
  `paymart_status` tinyint(1) NOT NULL DEFAULT 0,
  `paymart_text` text NOT NULL DEFAULT 'To\'lov qilganda yuboriladigan sms xabar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `setting_sms`
--

INSERT INTO `setting_sms` (`id`, `login`, `parol`, `token`, `token_data`, `create_child_status`, `create_child_text`, `debet_send_status`, `debet_send_text`, `paymart_status`, `paymart_text`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, 0, 'Yangi bola qabul qilinganda yuboriladigan sms.', 0, 'Qarzdorlik mavjud bo\'lganda yuboriladigan sms xabar.', 0, 'To\'lov qilganda yuboriladigan sms xabar', '2025-11-20 13:16:39', '2025-11-20 13:16:39');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `tkun` date DEFAULT NULL,
  `seriya` varchar(20) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'full_time',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `password` varchar(255) NOT NULL,
  `salary` int(10) UNSIGNED DEFAULT NULL,
  `about` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `position_id`, `name`, `phone`, `address`, `tkun`, `seriya`, `type`, `status`, `password`, `salary`, `about`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Super Admin', '+998 90 123 0001', 'Toshkent shahri', '1995-05-10', 'AB1234587', 'full_time', 1, '$2y$12$1JDwpxhWc/vQmrO54c7biOYUIsLLFa0.c/3B1m44BP/xrH666A3WS', 7000000, 'Super admin — tizimni boshqaradi.', NULL, NULL, NULL, NULL),
(2, 2, 'Elshod M', '+998 90 883 0450', 'Qarshi shaxar', '1997-01-01', 'AC9876743', 'full_time', 1, '$2y$12$BNe.a2QBftzlhLSC53I0w.K38P5.ajYmGddbGi2ULQVDOH/IencoW', 1000000, 'Yangilandi', NULL, NULL, '2025-11-20 16:58:57', NULL),
(3, 3, 'Metodist Kamron', '+998 90 123 0003', 'Samarkand viloyati', '1988-09-17', 'AC9876553', 'full_time', 1, '$2y$12$ccpfMXlgx4/EtISn7n.GlefUX5H8QeoNH9LthOKoRwnZDPcTejrwK', 6000000, 'Asosiy boshqaruv shaxsi.', NULL, NULL, NULL, NULL),
(4, 4, 'Meneger Bobur', '+998 90 123 0004', 'Samarkand viloyati', '1988-09-17', 'AC9876545', 'full_time', 1, '$2y$12$l9hacjOErWCdO7EYTdA52.smHJ8c.Yk5wynepo0NA2PLuXkDdk6Ry', 6000000, 'Asosiy boshqaruv shaxsi.', NULL, NULL, NULL, NULL),
(5, 5, 'Tarbiyachi Saida', '+998 90 123 0005', 'Qashqadaryo viloyati', '1999-02-02', 'AA5544332', 'part_time', 1, '$2y$12$DXGnPnrBAPzxXzS2l/VmS.O0qnM9FFv/yjbTnUMQNLakDgsjmPl5O', 2500000, 'Tarbiyalanuvchilar bilan ishlaydi.', NULL, NULL, NULL, NULL),
(6, 6, 'Yordamchi Tarbiyachi Sohiba', '+998 90 123 0006', 'Qashqadaryo viloyati', '1999-02-02', 'AA5577332', 'part_time', 1, '$2y$12$99OjmOo6RfsN8LJdBoFTCOmoFk.E4q6F9orILgmKFWdwK9QfICHfq', 2500000, 'Tarbiyalanuvchilar bilan ishlaydi.', NULL, NULL, NULL, NULL),
(7, 7, 'Psixolog Maftuna', '+998 90 123 0007', 'Qashqadaryo viloyati', '1999-02-02', 'AA5544377', 'part_time', 1, '$2y$12$z0YlYe.qCHgMFZbvywVcyOxcXp3f05mpJ2QPtF.V7/X7058.pGitS', 2500000, 'Tarbiyalanuvchilar bilan ishlaydi.', NULL, NULL, NULL, NULL),
(8, 14, 'Hamshira Anora', '+998 90 123 0008', 'Qashqadaryo viloyati', '1999-02-02', 'AA5545377', 'part_time', 1, '$2y$12$0IpqYp.Y3mhE7ATKXWCqwOKms1U3Uo5ia4NPiPIVWZP5GPG4Q9nmK', 2500000, 'Tarbiyalanuvchilar bilan ishlaydi.', NULL, NULL, NULL, NULL),
(9, 20, 'Marketing Akbarali', '+998 90 123 0009', 'Qashqadaryo viloyati', '1999-02-02', 'AA5565377', 'part_time', 1, '$2y$12$vluBGaKkEv1eRrww1m4GxeKfOdWFgf7UBXo9G8HU1O2i2hyTKpdiy', 2500000, 'Tarbiyalanuvchilar bilan ishlaydi.', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_davomads`
--

CREATE TABLE `user_davomads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('formada_keldi','formasiz_keldi','ish_kuni_emas','kelmadi','kechikdi','kasal','sababli') NOT NULL DEFAULT 'formada_keldi',
  `data` date NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_davomads`
--

INSERT INTO `user_davomads` (`id`, `user_id`, `status`, `data`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'formada_keldi', '2025-10-15', 1, '2025-11-20 15:55:03', '2025-11-20 15:55:03'),
(2, 1, 'formasiz_keldi', '2025-11-04', 1, '2025-11-20 15:55:03', '2025-11-20 15:55:03'),
(3, 1, 'ish_kuni_emas', '2025-11-05', 1, '2025-11-20 15:55:03', '2025-11-20 15:55:03'),
(4, 1, 'kelmadi', '2025-11-06', 1, '2025-11-20 15:55:03', '2025-11-20 15:55:03'),
(5, 1, 'kechikdi', '2025-11-07', 1, '2025-11-20 15:55:03', '2025-11-20 15:55:03'),
(6, 1, 'kasal', '2025-11-10', 1, '2025-11-20 15:55:03', '2025-11-20 15:55:03'),
(7, 1, 'sababli', '2025-11-11', 1, '2025-11-20 15:55:03', '2025-11-20 15:55:03'),
(8, 1, 'formada_keldi', '2025-11-12', 1, '2025-11-20 15:55:03', '2025-11-20 15:55:03'),
(9, 1, 'formasiz_keldi', '2025-11-13', 1, '2025-11-20 15:55:03', '2025-11-20 15:55:03'),
(10, 1, 'formada_keldi', '2025-11-14', 1, '2025-11-20 15:55:55', '2025-11-20 15:55:55'),
(11, 1, 'formasiz_keldi', '2025-11-18', 1, '2025-11-20 15:55:55', '2025-11-20 15:55:55'),
(12, 3, 'ish_kuni_emas', '2025-11-18', 1, '2025-11-20 15:55:55', '2025-11-20 15:55:55'),
(13, 4, 'kelmadi', '2025-11-18', 1, '2025-11-20 15:55:55', '2025-11-20 15:55:55'),
(14, 5, 'kechikdi', '2025-11-18', 1, '2025-11-20 15:55:55', '2025-11-20 15:55:55'),
(15, 6, 'kasal', '2025-11-18', 1, '2025-11-20 15:55:55', '2025-11-20 15:55:55'),
(16, 7, 'sababli', '2025-11-18', 1, '2025-11-20 15:55:55', '2025-11-20 15:55:55'),
(17, 8, 'formada_keldi', '2025-11-18', 1, '2025-11-20 15:55:55', '2025-11-20 15:55:55'),
(18, 9, 'formasiz_keldi', '2025-11-18', 1, '2025-11-20 15:55:55', '2025-11-20 15:55:55'),
(19, 1, 'formada_keldi', '2025-11-19', 1, '2025-11-20 15:56:35', '2025-11-20 15:56:35'),
(20, 2, 'formasiz_keldi', '2025-11-19', 1, '2025-11-20 15:56:35', '2025-11-20 15:56:35'),
(21, 3, 'ish_kuni_emas', '2025-11-19', 1, '2025-11-20 15:56:35', '2025-11-20 15:56:35'),
(22, 4, 'kelmadi', '2025-11-19', 1, '2025-11-20 15:56:35', '2025-11-20 15:56:35'),
(23, 5, 'kechikdi', '2025-11-19', 1, '2025-11-20 15:56:35', '2025-11-20 15:56:35'),
(24, 6, 'kasal', '2025-11-19', 1, '2025-11-20 15:56:35', '2025-11-20 15:56:35'),
(25, 7, 'sababli', '2025-11-19', 1, '2025-11-20 15:56:35', '2025-11-20 15:56:35'),
(26, 8, 'formada_keldi', '2025-11-19', 1, '2025-11-20 15:56:35', '2025-11-20 15:56:35'),
(27, 9, 'formasiz_keldi', '2025-11-19', 1, '2025-11-20 15:56:35', '2025-11-20 15:56:35'),
(28, 1, 'formada_keldi', '2025-11-20', 1, '2025-11-20 15:57:27', '2025-11-20 15:57:27'),
(29, 2, 'formasiz_keldi', '2025-11-20', 1, '2025-11-20 15:57:27', '2025-11-20 15:57:27'),
(30, 3, 'ish_kuni_emas', '2025-11-20', 1, '2025-11-20 15:57:27', '2025-11-20 15:57:27'),
(31, 4, 'kelmadi', '2025-11-20', 1, '2025-11-20 15:57:27', '2025-11-20 15:57:27'),
(32, 5, 'kechikdi', '2025-11-20', 1, '2025-11-20 15:57:27', '2025-11-20 15:57:27'),
(33, 6, 'kasal', '2025-11-20', 1, '2025-11-20 15:57:27', '2025-11-20 15:57:27'),
(34, 7, 'sababli', '2025-11-20', 1, '2025-11-20 15:57:27', '2025-11-20 15:57:27'),
(35, 8, 'formada_keldi', '2025-11-20', 1, '2025-11-20 15:57:27', '2025-11-20 15:57:27'),
(36, 9, 'formasiz_keldi', '2025-11-20', 1, '2025-11-20 15:57:27', '2025-11-20 15:57:27');

-- --------------------------------------------------------

--
-- Структура таблицы `user_paymarts`
--

CREATE TABLE `user_paymarts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `amount` int(11) NOT NULL DEFAULT 0,
  `type` enum('naqt','card','shot') NOT NULL DEFAULT 'naqt',
  `about` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_paymarts`
--

INSERT INTO `user_paymarts` (`id`, `user_id`, `admin_id`, `status`, `amount`, `type`, `about`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 60000, 'naqt', 'Test uchun', '2025-11-20 15:25:22', '2025-11-20 15:25:22'),
(2, 1, 1, 1, 30000, 'naqt', 'Test uchun', '2025-11-20 15:25:41', '2025-11-20 15:25:41'),
(3, 1, 1, 1, 30000, 'naqt', 'Test uchun', '2025-11-20 15:30:26', '2025-11-20 15:30:26');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `balans`
--
ALTER TABLE `balans`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `balans_histories`
--
ALTER TABLE `balans_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balans_histories_user_id_foreign` (`user_id`),
  ADD KEY `balans_histories_admin_id_foreign` (`admin_id`);

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `children_seria_unique` (`seria`),
  ADD KEY `children_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `child_balans_histories`
--
ALTER TABLE `child_balans_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_balans_histories_child_id_foreign` (`child_id`),
  ADD KEY `child_balans_histories_group_id_foreign` (`group_id`);

--
-- Индексы таблицы `child_documents`
--
ALTER TABLE `child_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_documents_child_id_foreign` (`child_id`),
  ADD KEY `child_documents_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `child_paymarts`
--
ALTER TABLE `child_paymarts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_paymarts_child_id_foreign` (`child_id`),
  ADD KEY `child_paymarts_child_relative_id_foreign` (`child_relative_id`),
  ADD KEY `child_paymarts_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `child_relatives`
--
ALTER TABLE `child_relatives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_relatives_child_id_foreign` (`child_id`),
  ADD KEY `child_relatives_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_room_id_foreign` (`room_id`),
  ADD KEY `groups_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `group_children`
--
ALTER TABLE `group_children`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_children_child_id_foreign` (`child_id`),
  ADD KEY `group_children_group_id_foreign` (`group_id`),
  ADD KEY `group_children_start_user_id_foreign` (`start_user_id`),
  ADD KEY `group_children_end_user_id_foreign` (`end_user_id`);

--
-- Индексы таблицы `group_davomads`
--
ALTER TABLE `group_davomads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_davomads_group_id_foreign` (`group_id`),
  ADD KEY `group_davomads_child_id_foreign` (`child_id`),
  ADD KEY `group_davomads_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `group_tarbiyachis`
--
ALTER TABLE `group_tarbiyachis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_tarbiyachis_user_id_foreign` (`user_id`),
  ADD KEY `group_tarbiyachis_group_id_foreign` (`group_id`),
  ADD KEY `group_tarbiyachis_start_user_id_foreign` (`start_user_id`),
  ADD KEY `group_tarbiyachis_end_user_id_foreign` (`end_user_id`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Индексы таблицы `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kassas`
--
ALTER TABLE `kassas`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kassa_histories`
--
ALTER TABLE `kassa_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kassa_histories_user_id_foreign` (`user_id`),
  ADD KEY `kassa_histories_admin_id_foreign` (`admin_id`),
  ADD KEY `kassa_histories_teacher_id_foreign` (`teacher_id`),
  ADD KEY `kassa_histories_user_paymart_id_foreign` (`user_paymart_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Индексы таблицы `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_name_unique` (`name`),
  ADD KEY `rooms_user_id_foreign` (`user_id`),
  ADD KEY `rooms_delete_user_id_foreign` (`delete_user_id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `setting_paymarts`
--
ALTER TABLE `setting_paymarts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `setting_sms`
--
ALTER TABLE `setting_sms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_seriya_unique` (`seriya`),
  ADD KEY `users_position_id_foreign` (`position_id`);

--
-- Индексы таблицы `user_davomads`
--
ALTER TABLE `user_davomads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_davomads_user_id_foreign` (`user_id`),
  ADD KEY `user_davomads_admin_id_foreign` (`admin_id`);

--
-- Индексы таблицы `user_paymarts`
--
ALTER TABLE `user_paymarts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_paymarts_user_id_foreign` (`user_id`),
  ADD KEY `user_paymarts_admin_id_foreign` (`admin_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `balans`
--
ALTER TABLE `balans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `balans_histories`
--
ALTER TABLE `balans_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `children`
--
ALTER TABLE `children`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `child_balans_histories`
--
ALTER TABLE `child_balans_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `child_documents`
--
ALTER TABLE `child_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `child_paymarts`
--
ALTER TABLE `child_paymarts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `child_relatives`
--
ALTER TABLE `child_relatives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `group_children`
--
ALTER TABLE `group_children`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `group_davomads`
--
ALTER TABLE `group_davomads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `group_tarbiyachis`
--
ALTER TABLE `group_tarbiyachis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `kassas`
--
ALTER TABLE `kassas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `kassa_histories`
--
ALTER TABLE `kassa_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `setting_paymarts`
--
ALTER TABLE `setting_paymarts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `setting_sms`
--
ALTER TABLE `setting_sms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `user_davomads`
--
ALTER TABLE `user_davomads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `user_paymarts`
--
ALTER TABLE `user_paymarts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `balans_histories`
--
ALTER TABLE `balans_histories`
  ADD CONSTRAINT `balans_histories_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `balans_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `child_balans_histories`
--
ALTER TABLE `child_balans_histories`
  ADD CONSTRAINT `child_balans_histories_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `child_balans_histories_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `child_documents`
--
ALTER TABLE `child_documents`
  ADD CONSTRAINT `child_documents_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `child_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `child_paymarts`
--
ALTER TABLE `child_paymarts`
  ADD CONSTRAINT `child_paymarts_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `child_paymarts_child_relative_id_foreign` FOREIGN KEY (`child_relative_id`) REFERENCES `child_relatives` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `child_paymarts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `child_relatives`
--
ALTER TABLE `child_relatives`
  ADD CONSTRAINT `child_relatives_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `child_relatives_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group_children`
--
ALTER TABLE `group_children`
  ADD CONSTRAINT `group_children_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_children_end_user_id_foreign` FOREIGN KEY (`end_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `group_children_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_children_start_user_id_foreign` FOREIGN KEY (`start_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `group_davomads`
--
ALTER TABLE `group_davomads`
  ADD CONSTRAINT `group_davomads_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_davomads_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_davomads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group_tarbiyachis`
--
ALTER TABLE `group_tarbiyachis`
  ADD CONSTRAINT `group_tarbiyachis_end_user_id_foreign` FOREIGN KEY (`end_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `group_tarbiyachis_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_tarbiyachis_start_user_id_foreign` FOREIGN KEY (`start_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `group_tarbiyachis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `kassa_histories`
--
ALTER TABLE `kassa_histories`
  ADD CONSTRAINT `kassa_histories_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kassa_histories_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kassa_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kassa_histories_user_paymart_id_foreign` FOREIGN KEY (`user_paymart_id`) REFERENCES `user_paymarts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_delete_user_id_foreign` FOREIGN KEY (`delete_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_davomads`
--
ALTER TABLE `user_davomads`
  ADD CONSTRAINT `user_davomads_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_davomads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_paymarts`
--
ALTER TABLE `user_paymarts`
  ADD CONSTRAINT `user_paymarts_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_paymarts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
