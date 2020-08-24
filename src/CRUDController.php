<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Abstract class for CRUDs
 * @package execut\booksNative
 */
abstract class CRUDController extends Controller
{
    /**
     * @var array Files upload attributes names list
     */
    protected $filesAttributes = [];

    /**
     * Index action for CRUD list
     * @return array|string
     */
    public function actionIndex()
    {
        $model = $this->getModel();
        $model->setScenario('grid');
        if ($model->load(\yii::$app->request->getQueryParams())) {
            $model->validate();
        }


        if (\yii::$app->request->isAjax) {
            $result = [];
            $dataProvider = $model->search();
            foreach ($dataProvider->models as $row) {
                $attributes = ['id' => 'id', 'text' => 'name'];
                $modelAttributes = array_values($attributes);
                if ($row instanceof Model) {
                    $row = $row->getAttributes($modelAttributes);
                }
                $res = [];
                foreach ($attributes as $targetKey => $attribute) {
                    if (is_int($targetKey)) {
                        $targetKey = $attribute;
                    }

                    $res[$targetKey] = $row[$attribute];
                }

                $result[] = $res;
            }

            $pagination = $dataProvider->pagination;

            $response = \yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            return [
                'results' => $result,
                'pagination' => [
                    'more' => $pagination ? ($pagination->page < $pagination->pageCount - 1) : false,
                ],
                'totalCount' => $pagination->totalCount,
            ];
        }

        return $this->render('@vendor/execut/yii2-books-native/src/views/crud/index', [
            'model' => $model,
        ]);
    }

    /**
     * Update action
     * @param string? $id Record primary key
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id = null)
    {
        if ($id < 0) {
            throw new NotFoundHttpException('Bad id');
        }

        $model = $this->getModel($id);
        $model->setScenario('form');
        if (!$model) {
            throw new NotFoundHttpException('Record with id ' . $id . ' is not founded');
        }

        $message = false;
        if ($model->load(\yii::$app->request->post())) {
            foreach ($this->filesAttributes as $contentAttribute => $attribute) {
                $file = UploadedFile::getInstance($model, $attribute);
                if ($file) {
                    $model->$attribute = $file;
                    $model->$contentAttribute = file_get_contents($file->tempName);
                }
            }

            if ($model->validate()) {
                $model->save();
                $message = 'Model updated';
            }
        }

        return $this->render('@vendor/execut/yii2-books-native/src/views/crud/update', [
            'message' => $message,
            'model' => $model,
        ]);
    }

    /**
     * Delete record action
     * @param string? $id Primary key
     * @return \yii\console\Response|Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id = null)
    {
        $model = $this->getModel($id);
        $model->delete();
        return \yii::$app->response->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Find model by primary key or create new instance
     * @param string? $id Primary key
     * @return ActiveRecord
     */
    protected function getModel($id = null): ActiveRecord
    {
        $modelClass = $this->getModelClass();
        if ($id) {
            $id = (int) $id;
            $model = $modelClass::findOne($id);
        } else {
            $model = new $modelClass();
        }

        return $model;
    }

    /**
     * Returns CRUD model class
     * @return string
     */
    abstract protected function getModelClass();
}
