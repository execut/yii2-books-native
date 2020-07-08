<?php


namespace execut\crudExample\controllers;

use execut\crudExample\models\Book;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class BooksController extends Controller
{
    public function actionIndex()
    {
        $model = $this->getModel();
        $model->setScenario('grid');
        if ($model->load(\yii::$app->request->getQueryParams())) {
            $model->validate();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id = null) {
        if ($id < 0 || $id !== null) {
            throw new NotFoundHttpException('Bad id');
        }

        $id = (int) $id;
        $model = $this->getModel($id);
        $model->setScenario('form');
        if (!$model) {
            throw new NotFoundHttpException('Record with id ' . $id . ' is not founded');
        }

        $message = false;
        if ($model->load(\yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                $message = 'Model updated';
            }
        }

        return $this->render('update', [
            'message' => $message,
            'model' => $model,
        ]);
    }
    /**
     * @return ActiveRecord
     */
    protected function getModel($id = null): ActiveRecord
    {
        $modelClass = $this->getModelClass();
        if ($id) {
            $model = $modelClass::findOne($id);
        } else {
            $model = new $modelClass();
        }

        return $model;
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        $modelClass = Book::class;
        return $modelClass;
    }
}