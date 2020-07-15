<?php


namespace execut\booksNative\controllers;


use execut\booksNative\CRUDController;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AuthorsController extends CRUDController
{
    protected $filesAttributes = [
        'image' => 'imageFile',
    ];

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        $modelClass = $this->module->authorModelClass;
        return $modelClass;
    }
}