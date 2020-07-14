<?php
namespace execut\crudExample\migrations;

class m200713_112615_addAuthorsTable extends \yii\db\Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('example_authors', [
            'id' => $this->primaryKey(),
            'surname' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'short_description' => $this->text(),
            'biography' => $this->text(),
            'birthday' => $this->date(),
            'popularity' => $this->integer()->unsigned(),
            'email' => $this->string(),
            'image' => $this->binary(),
            'image_211' => $this->binary(),
            'image_name' => $this->string(),
            'image_extension' => $this->string(),
            'image_md5' => $this->string(64),
            'image_mime_type' => $this->string(),
            'main_book_id' => $this->integer()->unsigned(),
            'created' => $this->dateTime()->notNull()->defaultValue('now()'),
            'updated' => $this->dateTime(),
        ]);
        $this->createTable('example_authors_vs_books', [
            'id' => $this->primaryKey(),
            'example_author_id' => $this->integer()->notNull(),
            'example_book_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('example_authors_vs_books_example_author_id_fk', 'example_authors_vs_books', 'example_author_id', 'example_authors', 'id');
        $this->addForeignKey('example_authors_vs_books_example_book_id_fk', 'example_authors_vs_books', 'example_book_id', 'example_books', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('example_authors_vs_books');
        $this->dropTable('example_authors');
    }
}
