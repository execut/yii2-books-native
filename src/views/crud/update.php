<?php
use kartik\detail\DetailView;

echo \yii\helpers\Html::a(\yii::t('execut/booksNative', 'List'), ['/' . $this->context->uniqueId]) . ' / ' . \yii::t('execut/booksNative', 'Edit') . ' ' . $model->name;

/**
 * @var \execut\crudFields\example\models\Book $model
 */
if ($message) {
    echo \yii\bootstrap\Alert::widget([
        'body' => $message,
    ]);
}

echo DetailView::widget([
    'formOptions' => [
//        'enableAjaxValidation' => false,
//        'validateOnChange' => false,
//        'validateOnSubmit' => false,
//        'validateOnBlur' => false,
        'options' => [
            'enctype'=>'multipart/form-data',
        ],
    ],
    'panel' => [
        'heading',
    ],
    'enableEditMode' => true,
    'mode' => DetailView::MODE_EDIT,
    'model' => $model,
    'attributes' => $model->getFormFields(),
]);