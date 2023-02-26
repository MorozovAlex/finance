<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
final class Version20230224195852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', phone VARCHAR(15) NOT NULL, email VARCHAR(100) DEFAULT NULL, education SMALLINT DEFAULT NULL, is_personal_data TINYINT(1) NOT NULL, score SMALLINT DEFAULT NULL, name_first VARCHAR(100) NOT NULL, name_second VARCHAR(100) DEFAULT NULL, name_last VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users');
    }
}
