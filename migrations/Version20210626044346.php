<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210626044346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_3D660A3BF675F31B');
        $this->addSql('DROP INDEX IDX_3D660A3B727ACA70');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tweet AS SELECT id, parent_id, author_id, body, created_at FROM tweet');
        $this->addSql('DROP TABLE tweet');
        $this->addSql('CREATE TABLE tweet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, author_id INTEGER NOT NULL, body VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_3D660A3B727ACA70 FOREIGN KEY (parent_id) REFERENCES tweet (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3D660A3BF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tweet (id, parent_id, author_id, body, created_at) SELECT id, parent_id, author_id, body, created_at FROM __temp__tweet');
        $this->addSql('DROP TABLE __temp__tweet');
        $this->addSql('CREATE INDEX IDX_3D660A3BF675F31B ON tweet (author_id)');
        $this->addSql('CREATE INDEX IDX_3D660A3B727ACA70 ON tweet (parent_id)');
        $this->addSql('DROP INDEX IDX_1FA1EE881041E39B');
        $this->addSql('DROP INDEX IDX_1FA1EE883C0794F7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tweet_article_tweet AS SELECT tweet_article_id, tweet_id FROM tweet_article_tweet');
        $this->addSql('DROP TABLE tweet_article_tweet');
        $this->addSql('CREATE TABLE tweet_article_tweet (tweet_article_id INTEGER NOT NULL, tweet_id INTEGER NOT NULL, PRIMARY KEY(tweet_article_id, tweet_id), CONSTRAINT FK_1FA1EE883C0794F7 FOREIGN KEY (tweet_article_id) REFERENCES tweet_article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1FA1EE881041E39B FOREIGN KEY (tweet_id) REFERENCES tweet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tweet_article_tweet (tweet_article_id, tweet_id) SELECT tweet_article_id, tweet_id FROM __temp__tweet_article_tweet');
        $this->addSql('DROP TABLE __temp__tweet_article_tweet');
        $this->addSql('CREATE INDEX IDX_1FA1EE881041E39B ON tweet_article_tweet (tweet_id)');
        $this->addSql('CREATE INDEX IDX_1FA1EE883C0794F7 ON tweet_article_tweet (tweet_article_id)');
        $this->addSql('DROP INDEX IDX_8D93D6498BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, city_id, avatar_url, biography, full_name, login, password, registration_date FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER DEFAULT NULL, avatar_url VARCHAR(255) DEFAULT NULL COLLATE BINARY, biography VARCHAR(255) DEFAULT NULL COLLATE BINARY, full_name VARCHAR(255) NOT NULL COLLATE BINARY, login VARCHAR(255) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, registration_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , salt VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_8D93D6498BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, city_id, avatar_url, biography, full_name, login, password, registration_date) SELECT id, city_id, avatar_url, biography, full_name, login, password, registration_date FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D6498BAC62AF ON user (city_id)');
        $this->addSql('DROP INDEX IDX_F7129A80233D34C1');
        $this->addSql('DROP INDEX IDX_F7129A803AD8644E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_user AS SELECT user_source, user_target FROM user_user');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('CREATE TABLE user_user (user_source INTEGER NOT NULL, user_target INTEGER NOT NULL, PRIMARY KEY(user_source, user_target), CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_user (user_source, user_target) SELECT user_source, user_target FROM __temp__user_user');
        $this->addSql('DROP TABLE __temp__user_user');
        $this->addSql('CREATE INDEX IDX_F7129A80233D34C1 ON user_user (user_target)');
        $this->addSql('CREATE INDEX IDX_F7129A803AD8644E ON user_user (user_source)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_3D660A3B727ACA70');
        $this->addSql('DROP INDEX IDX_3D660A3BF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tweet AS SELECT id, parent_id, author_id, body, created_at FROM tweet');
        $this->addSql('DROP TABLE tweet');
        $this->addSql('CREATE TABLE tweet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, author_id INTEGER NOT NULL, body VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO tweet (id, parent_id, author_id, body, created_at) SELECT id, parent_id, author_id, body, created_at FROM __temp__tweet');
        $this->addSql('DROP TABLE __temp__tweet');
        $this->addSql('CREATE INDEX IDX_3D660A3B727ACA70 ON tweet (parent_id)');
        $this->addSql('CREATE INDEX IDX_3D660A3BF675F31B ON tweet (author_id)');
        $this->addSql('DROP INDEX IDX_1FA1EE883C0794F7');
        $this->addSql('DROP INDEX IDX_1FA1EE881041E39B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tweet_article_tweet AS SELECT tweet_article_id, tweet_id FROM tweet_article_tweet');
        $this->addSql('DROP TABLE tweet_article_tweet');
        $this->addSql('CREATE TABLE tweet_article_tweet (tweet_article_id INTEGER NOT NULL, tweet_id INTEGER NOT NULL, PRIMARY KEY(tweet_article_id, tweet_id))');
        $this->addSql('INSERT INTO tweet_article_tweet (tweet_article_id, tweet_id) SELECT tweet_article_id, tweet_id FROM __temp__tweet_article_tweet');
        $this->addSql('DROP TABLE __temp__tweet_article_tweet');
        $this->addSql('CREATE INDEX IDX_1FA1EE883C0794F7 ON tweet_article_tweet (tweet_article_id)');
        $this->addSql('CREATE INDEX IDX_1FA1EE881041E39B ON tweet_article_tweet (tweet_id)');
        $this->addSql('DROP INDEX IDX_8D93D6498BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, city_id, avatar_url, biography, full_name, login, password, registration_date FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER DEFAULT NULL, avatar_url VARCHAR(255) DEFAULT NULL, biography VARCHAR(255) DEFAULT NULL, full_name VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, registration_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO user (id, city_id, avatar_url, biography, full_name, login, password, registration_date) SELECT id, city_id, avatar_url, biography, full_name, login, password, registration_date FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D6498BAC62AF ON user (city_id)');
        $this->addSql('DROP INDEX IDX_F7129A803AD8644E');
        $this->addSql('DROP INDEX IDX_F7129A80233D34C1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_user AS SELECT user_source, user_target FROM user_user');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('CREATE TABLE user_user (user_source INTEGER NOT NULL, user_target INTEGER NOT NULL, PRIMARY KEY(user_source, user_target))');
        $this->addSql('INSERT INTO user_user (user_source, user_target) SELECT user_source, user_target FROM __temp__user_user');
        $this->addSql('DROP TABLE __temp__user_user');
        $this->addSql('CREATE INDEX IDX_F7129A803AD8644E ON user_user (user_source)');
        $this->addSql('CREATE INDEX IDX_F7129A80233D34C1 ON user_user (user_target)');
    }
}
