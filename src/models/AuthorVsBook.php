<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative\models;

use yii\db\ActiveRecord;

/**
 * AuthorVsBook model
 * @package execut\booksNative
 */
class AuthorVsBook extends ActiveRecord
{
    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return 'example_authors_vs_books';
    }

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [self::primaryKey(), 'safe', 'on' => 'form'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function primaryKey()
    {
        return ['example_book_id', 'example_author_id'];
    }
}
