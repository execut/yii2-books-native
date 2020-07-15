<?php
/**
 * @var \execut\crudFields\example\models\SimpleImproved $model
 * @var \yii\web\View $this
 */

echo \yii\widgets\Breadcrumbs::widget([
    'links' => [
        [
            'label' => \yii::t('execut/booksNative', $model::MODEL_NAME , ['n' => 2]),
            'url' => ['/' . $this->context->uniqueId],
        ]
    ]
]);
echo '<h1>' . \yii::t('execut/booksNative', $model::MODEL_NAME , ['n' => 2]) . '</h1>';

echo \yii\helpers\Html::a(\yii::t('execut/booksNative', 'Create new'), \yii\helpers\Url::to(['/' . $this->context->uniqueId . '/update']));

echo \yii\grid\GridView::widget([
    'filterModel' => $model,
    'dataProvider' => $model->search(),
    'columns' => $model->getGridColumns(),
]);