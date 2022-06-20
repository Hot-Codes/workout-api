<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620221134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE repetition (id INT AUTO_INCREMENT NOT NULL, workout_exercise_id INT DEFAULT NULL, number INT NOT NULL, weight INT NOT NULL, INDEX IDX_9DB9AD52E435DB6B (workout_exercise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repetition ADD CONSTRAINT FK_9DB9AD52E435DB6B FOREIGN KEY (workout_exercise_id) REFERENCES workout_exercice (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE repetition');
    }
}
