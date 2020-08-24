<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative\controllers;

use execut\booksNative\CRUDController;

/**
 * Books CRUD controller
 * @package execut\booksNative\bootstrap
 */
class BooksController extends CRUDController
{
    /**
     * {@inheritDoc}
     */
    protected function getModelClass(): string
    {
        $modelClass = $this->module->bookModelClass;
        return $modelClass;
    }
}
