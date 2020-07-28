<?php


namespace execut\booksNative\controllers;


use execut\booksNative\CRUDController;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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

    public function actionImage($id) {
        $model = $this->getModel($id);
        if ($model) {
            $response = \yii::$app->response;
            $response->format = Response::FORMAT_RAW;
            $response->headers->set('Content-Type', $model->image_mime_type);

            return stream_get_contents($model->image_211);
        }
    }
}