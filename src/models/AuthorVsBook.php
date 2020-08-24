<?php


namespace execut\booksNative\models;

use yii\db\ActiveRecord;

class AuthorVsBook extends ActiveRecord
{
    public static function tableName()
    {
        return 'example_authors_vs_books';
    }

    public function rules()
    {
        return [
            [self::primaryKey(), 'safe', 'on' => 'form'],
        ];
    }

    public static function primaryKey()
    {
        return ['example_book_id', 'example_author_id'];
    }
}