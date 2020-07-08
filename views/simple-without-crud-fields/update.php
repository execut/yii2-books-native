<?php
use \kartik\detail\DetailView;
/**
 * @var \execut\crudFields\example\models\Book $model
 */
if ($message) {
    echo \yii\bootstrap\Alert::widget([
        'body' => $message,
    ]);
}

echo DetailView::widget([
    'panel' => [
        'heading',
    ],
    'enableEditMode' => true,
    'mode' => DetailView::MODE_EDIT,
    'model' => $model,
    'attributes' => $model->getFormFields(),
]);