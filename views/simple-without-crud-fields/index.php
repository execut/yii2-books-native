<?php
/**
 * @var \execut\crudFields\example\models\SimpleImproved $model
 */

echo \yii\helpers\Html::a('Create new', \yii\helpers\Url::to('simple-without-crud-fields/update'));

echo \yii\grid\GridView::widget([
    'filterModel' => $model,
    'dataProvider' => $model->search(),
    'columns' => $model->getGridColumns(),
]);