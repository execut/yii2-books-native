<?php


namespace execut\crudExample\controllers;


use execut\crudExample\CRUDController;
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