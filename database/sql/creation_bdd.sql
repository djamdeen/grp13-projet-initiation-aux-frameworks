-- Gestionnaire de tâches - Groupe 13
-- Script MySQL / phpMyAdmin (XAMPP)

CREATE DATABASE IF NOT EXISTS `gestionnaire_taches`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `gestionnaire_taches`;

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `responsible` VARCHAR(100) NOT NULL,
  `due_date` DATE NOT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'a_faire',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tasks` (`title`, `description`, `responsible`, `due_date`, `status`, `created_at`, `updated_at`) VALUES
('Préparer la présentation Laravel', 'Préparer les diapositives pour la soutenance.', 'Alice Martin', DATE_ADD(CURDATE(), INTERVAL 5 DAY), 'a_faire', NOW(), NOW()),
('Créer les vues Blade', 'Mettre en place le layout et les formulaires.', 'Thomas Dubois', DATE_SUB(CURDATE(), INTERVAL 2 DAY), 'terminee', NOW(), NOW()),
('Développer le contrôleur des tâches', 'Implémenter le CRUD et les filtres.', 'Emma Bernard', DATE_ADD(CURDATE(), INTERVAL 2 DAY), 'en_cours', NOW(), NOW()),
('Rédiger le README', 'Expliquer l''installation et le démarrage du projet.', 'Alice Martin', DATE_ADD(CURDATE(), INTERVAL 3 DAY), 'en_cours', NOW(), NOW()),
('Créer la migration tasks', 'Définir les colonnes de la table tasks.', 'Thomas Dubois', DATE_SUB(CURDATE(), INTERVAL 4 DAY), 'terminee', NOW(), NOW());
