<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative\migrations;

/**
 * Class m200713_112615_addAuthorsTable
 * @package execut\booksNative
 */
class m200713_112615_addAuthorsTable extends \yii\db\Migration
{
    /**
     * {@inheritDoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema('example_authors')) {
            return;
        }

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
            'created' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated' => $this->dateTime(),
        ]);
        $this->createTable('example_authors_vs_books_native', [
            'id' => $this->primaryKey(),
            'example_author_id' => $this->integer()->notNull(),
            'example_book_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('example_authors_vs_books_native_example_author_id_fk', 'example_authors_vs_books', 'example_author_id', 'example_authors', 'id');
        $this->addForeignKey('example_authors_vs_books_native_example_book_id_fk', 'example_authors_vs_books', 'example_book_id', 'example_books', 'id');
    }

    /**
     * {@inheritDoc}
     */
    public function safeDown()
    {
        if (!$this->db->getTableSchema('example_authors')) {
            return;
        }

        $this->dropTable('example_authors_vs_books');
        $this->dropTable('example_authors');
    }
}
