<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative\controllers;

use execut\booksNative\CRUDController;
use yii\web\Response;

/**
 * Authors CRUD controller
 * @package execut\booksNative
 */
class AuthorsController extends CRUDController
{
    /**
     * {@inheritDoc}
     */
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

    /**
     * Action for render author image
     * @param $id
     * @return false|string
     */
    public function actionImage($id)
    {
        $model = $this->getModel($id);
        if ($model) {
            $response = \yii::$app->response;
            $response->format = Response::FORMAT_RAW;
            $response->headers->set('Content-Type', $model->image_mime_type);

            return stream_get_contents($model->image_211);
        }

        return null;
    }
}
