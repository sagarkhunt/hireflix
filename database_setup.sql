-- HireFlix Interview Management System Database Setup
-- Run this script in MySQL Workbench to create the database and tables

-- Create the database
CREATE DATABASE IF NOT EXISTS `hire_flix` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `hire_flix`;

-- Create users table
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','reviewer','candidate') NOT NULL DEFAULT 'candidate',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create password reset tokens table
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create failed jobs table
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create personal access tokens table
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create interviews table
CREATE TABLE `interviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `interviews_created_by_foreign` (`created_by`),
  CONSTRAINT `interviews_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create questions table
CREATE TABLE `questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `interview_id` bigint(20) unsigned NOT NULL,
  `question_text` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_interview_id_foreign` (`interview_id`),
  CONSTRAINT `questions_interview_id_foreign` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create submissions table
CREATE TABLE `submissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `interview_id` bigint(20) unsigned NOT NULL,
  `question_id` bigint(20) unsigned NOT NULL,
  `candidate_id` bigint(20) unsigned NOT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `answer_text` text DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `reviewed_by` bigint(20) unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `submissions_interview_id_foreign` (`interview_id`),
  KEY `submissions_question_id_foreign` (`question_id`),
  KEY `submissions_candidate_id_foreign` (`candidate_id`),
  KEY `submissions_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `submissions_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `submissions_interview_id_foreign` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`) ON DELETE CASCADE,
  CONSTRAINT `submissions_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `submissions_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert test users
INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Admin User', 'admin@hireflix.com', '$2y$12$zfY5WvizZGVqQcy0d4HMIu1skXEVHE7h061I5PIxTkZq5mxjlRBKG', 'admin', NOW(), NOW()),
('Reviewer User', 'reviewer@hireflix.com', '$2y$12$zfY5WvizZGVqQcy0d4HMIu1skXEVHE7h061I5PIxTkZq5mxjlRBKG', 'reviewer', NOW(), NOW()),
('Candidate User', 'candidate@hireflix.com', '$2y$12$zfY5WvizZGVqQcy0d4HMIu1skXEVHE7h061I5PIxTkZq5mxjlRBKG', 'candidate', NOW(), NOW()),
('John Doe', 'john@example.com', '$2y$12$zfY5WvizZGVqQcy0d4HMIu1skXEVHE7h061I5PIxTkZq5mxjlRBKG', 'candidate', NOW(), NOW()),
('Jane Smith', 'jane@example.com', '$2y$12$zfY5WvizZGVqQcy0d4HMIu1skXEVHE7h061I5PIxTkZq5mxjlRBKG', 'candidate', NOW(), NOW());

-- Insert sample interviews
INSERT INTO `interviews` (`title`, `description`, `created_by`, `is_active`, `created_at`, `updated_at`) VALUES
('Software Developer Interview', 'This interview will assess your technical skills, problem-solving abilities, and communication skills for the Software Developer position.', 1, 1, NOW(), NOW()),
('Marketing Manager Interview', 'This interview will evaluate your marketing expertise, leadership skills, and strategic thinking for the Marketing Manager role.', 1, 1, NOW(), NOW());

-- Insert questions for Software Developer Interview
INSERT INTO `questions` (`interview_id`, `question_text`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Tell us about yourself and your experience in software development.', 1, NOW(), NOW()),
(1, 'What programming languages are you most comfortable with, and why?', 2, NOW(), NOW()),
(1, 'Describe a challenging project you worked on and how you overcame the difficulties.', 3, NOW(), NOW()),
(1, 'How do you approach debugging and troubleshooting code issues?', 4, NOW(), NOW()),
(1, 'What is your experience with version control systems like Git?', 5, NOW(), NOW()),
(1, 'How do you stay updated with the latest technologies and best practices?', 6, NOW(), NOW()),
(1, 'Describe a time when you had to work in a team and how you contributed to the project\'s success.', 7, NOW(), NOW()),
(1, 'What questions do you have about our company and this position?', 8, NOW(), NOW());

-- Insert questions for Marketing Manager Interview
INSERT INTO `questions` (`interview_id`, `question_text`, `order`, `created_at`, `updated_at`) VALUES
(2, 'Tell us about your marketing background and key achievements.', 1, NOW(), NOW()),
(2, 'How do you develop and execute marketing strategies?', 2, NOW(), NOW()),
(2, 'Describe your experience with digital marketing channels.', 3, NOW(), NOW()),
(2, 'How do you measure the success of marketing campaigns?', 4, NOW(), NOW()),
(2, 'What is your approach to managing a marketing team?', 5, NOW(), NOW()),
(2, 'How do you stay current with marketing trends and technologies?', 6, NOW(), NOW()),
(2, 'Describe a successful marketing campaign you led and its results.', 7, NOW(), NOW()),
(2, 'How would you approach marketing for a new product launch?', 8, NOW(), NOW());

-- Show completion message
SELECT 'Database setup completed successfully!' as message;
