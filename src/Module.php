<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative;

use execut\booksNative\models\Book;
use execut\booksNative\models\Author;

/**
 * Module class
 * @package execut\booksNative
 */
class Module extends \yii\base\Module
{
    /**
     * @var string Book model class
     */
    public $bookModelClass = Book::class;
    /**
     * @var string Author model class
     */
    public $authorModelClass = Author::class;
}
