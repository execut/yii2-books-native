<?php
namespace execut\crudExample\migrations;

use yii\db\Migration;

class m200708_105338_addBooksTable extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('example_books', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('example_books');
    }
}

