<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210626073432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE city_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE promotion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tweet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tweet_article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE twitter_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE city (id INT NOT NULL, country VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE promotion (id INT NOT NULL, title VARCHAR(255) NOT NULL, body VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tweet (id INT NOT NULL, parent_id INT DEFAULT NULL, author_id INT NOT NULL, body VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3D660A3B727ACA70 ON tweet (parent_id)');
        $this->addSql('CREATE INDEX IDX_3D660A3BF675F31B ON tweet (author_id)');
        $this->addSql('COMMENT ON COLUMN tweet.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tweet_article (id INT NOT NULL, body VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT \'Tweet Article\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tweet_article_tweet (tweet_article_id INT NOT NULL, tweet_id INT NOT NULL, PRIMARY KEY(tweet_article_id, tweet_id))');
        $this->addSql('CREATE INDEX IDX_1FA1EE883C0794F7 ON tweet_article_tweet (tweet_article_id)');
        $this->addSql('CREATE INDEX IDX_1FA1EE881041E39B ON tweet_article_tweet (tweet_id)');
        $this->addSql('CREATE TABLE twitter_user (id INT NOT NULL, city_id INT DEFAULT NULL, avatar_url VARCHAR(255) DEFAULT NULL, biography VARCHAR(255) DEFAULT NULL, full_name VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, registration_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, salt VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AAD7875A8BAC62AF ON twitter_user (city_id)');
        $this->addSql('COMMENT ON COLUMN twitter_user.registration_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, PRIMARY KEY(user_source, user_target))');
        $this->addSql('CREATE INDEX IDX_F7129A803AD8644E ON user_user (user_source)');
        $this->addSql('CREATE INDEX IDX_F7129A80233D34C1 ON user_user (user_target)');
        $this->addSql('ALTER TABLE tweet ADD CONSTRAINT FK_3D660A3B727ACA70 FOREIGN KEY (parent_id) REFERENCES tweet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tweet ADD CONSTRAINT FK_3D660A3BF675F31B FOREIGN KEY (author_id) REFERENCES twitter_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tweet_article_tweet ADD CONSTRAINT FK_1FA1EE883C0794F7 FOREIGN KEY (tweet_article_id) REFERENCES tweet_article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tweet_article_tweet ADD CONSTRAINT FK_1FA1EE881041E39B FOREIGN KEY (tweet_id) REFERENCES tweet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE twitter_user ADD CONSTRAINT FK_AAD7875A8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES twitter_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES twitter_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE twitter_user DROP CONSTRAINT FK_AAD7875A8BAC62AF');
        $this->addSql('ALTER TABLE tweet DROP CONSTRAINT FK_3D660A3B727ACA70');
        $this->addSql('ALTER TABLE tweet_article_tweet DROP CONSTRAINT FK_1FA1EE881041E39B');
        $this->addSql('ALTER TABLE tweet_article_tweet DROP CONSTRAINT FK_1FA1EE883C0794F7');
        $this->addSql('ALTER TABLE tweet DROP CONSTRAINT FK_3D660A3BF675F31B');
        $this->addSql('ALTER TABLE user_user DROP CONSTRAINT FK_F7129A803AD8644E');
        $this->addSql('ALTER TABLE user_user DROP CONSTRAINT FK_F7129A80233D34C1');
        $this->addSql('DROP SEQUENCE city_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE promotion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tweet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tweet_article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE twitter_user_id_seq CASCADE');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE tweet');
        $this->addSql('DROP TABLE tweet_article');
        $this->addSql('DROP TABLE tweet_article_tweet');
        $this->addSql('DROP TABLE twitter_user');
        $this->addSql('DROP TABLE user_user');
    }
}
