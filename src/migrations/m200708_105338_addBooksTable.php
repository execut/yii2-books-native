<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\books\migrations;

use yii\db\Migration;

/**
 * Class m200708_105338_addBooksTable
 * @package execut\books
 */
class m200708_105338_addBooksTable extends Migration
{
    /**
     * {@inheritDoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema('example_books')) {
            return;
        }

        $this->createTable('example_books', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function safeDown()
    {
        if (!$this->db->getTableSchema('example_books')) {
            return;
        }

        $this->dropTable('example_books');
    }
}
