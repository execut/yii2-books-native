<?php


namespace execut\crudExample;


use execut\crudExample\models\Book;
use execut\crudExample\models\Author;

class Module extends \yii\base\Module
{
    public $bookModelClass = Book::class;
    public $authorModelClass = Author::class;
}