<?php


namespace execut\booksNative;


use execut\crudFields\example\models\Author;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

abstract class CRUDController extends Controller
{
    protected $filesAttributes = [];
    public function actionIndex()
    {
//        $model = new Author();
//        var_export($model->getField('mainBook')->getField());
//        exit;
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

        return $this->render('@vendor/execut/yii2-books-native/views/crud/index', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id = null) {
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

        return $this->render('@vendor/execut/yii2-books-native/views/crud/update', [
            'message' => $message,
            'model' => $model,
        ]);
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

    public function actionDelete()
    {
        $model = $this->getModel(\yii::$app->request->getQueryParam('id'));
        $model->delete();
        return \yii::$app->response->redirect(\Yii::$app->request->referrer);
    }

    /**
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
     * @return string
     */
    abstract protected function getModelClass();
}