<?php


namespace execut\booksNative;


use execut\booksNative\models\Book;
use execut\booksNative\models\Author;

class Module extends \yii\base\Module
{
    public $bookModelClass = Book::class;
    public $authorModelClass = Author::class;
}