<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210626061651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, country VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE promotion (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, body VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE tweet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, author_id INTEGER NOT NULL, body VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_3D660A3B727ACA70 ON tweet (parent_id)');
        $this->addSql('CREATE INDEX IDX_3D660A3BF675F31B ON tweet (author_id)');
        $this->addSql('CREATE TABLE tweet_article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT \'Tweet Article\' NOT NULL)');
        $this->addSql('CREATE TABLE tweet_article_tweet (tweet_article_id INTEGER NOT NULL, tweet_id INTEGER NOT NULL, PRIMARY KEY(tweet_article_id, tweet_id))');
        $this->addSql('CREATE INDEX IDX_1FA1EE883C0794F7 ON tweet_article_tweet (tweet_article_id)');
        $this->addSql('CREATE INDEX IDX_1FA1EE881041E39B ON tweet_article_tweet (tweet_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER DEFAULT NULL, avatar_url VARCHAR(255) DEFAULT NULL, biography VARCHAR(255) DEFAULT NULL, full_name VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, registration_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , salt VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_8D93D6498BAC62AF ON user (city_id)');
        $this->addSql('CREATE TABLE user_user (user_source INTEGER NOT NULL, user_target INTEGER NOT NULL, PRIMARY KEY(user_source, user_target))');
        $this->addSql('CREATE INDEX IDX_F7129A803AD8644E ON user_user (user_source)');
        $this->addSql('CREATE INDEX IDX_F7129A80233D34C1 ON user_user (user_target)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE tweet');
        $this->addSql('DROP TABLE tweet_article');
        $this->addSql('DROP TABLE tweet_article_tweet');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_user');
    }
}
