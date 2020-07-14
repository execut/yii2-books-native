<?php
/**
 * @var \execut\crudFields\example\models\SimpleImproved $model
 * @var \yii\web\View $this
 */

echo \yii\helpers\Html::a(\yii::t('execut/crudExample', 'Create new'), \yii\helpers\Url::to(['/' . $this->context->uniqueId . '/update']));

echo \yii\grid\GridView::widget([
    'filterModel' => $model,
    'dataProvider' => $model->search(),
    'columns' => $model->getGridColumns(),
]);