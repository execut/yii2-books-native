<?php
namespace execut\crudExample\models;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\grid\ActionColumn;
use yii\helpers\Html;
class Book extends ActiveRecord
{
    public static function tableName()
    {
        return 'example_books';
    }

    public function getQuery() {
        $query = self::find();
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere([
            'ILIKE',
            'name',
            $this->name,
        ]);

        return $query;
    }

    public function search() {
        $q = $this->getQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $q,
        ]);

        return $dataProvider;
    }

    public function rules()
    {
        return [
            ['id', 'safe', 'on' => 'grid'],
            ['name', 'safe', 'on' => ['grid', 'form']],
        ];
    }

    public function getGridColumns() {
        return [
            'id' => [
                'attribute' => 'id',
            ],
            'name' => [
                'attribute' => 'name',
            ],
            'actions' => [
                'class' => ActionColumn::class,
                'buttons' => [
                    'view' => function () {
                        return false;
                    },
                ],
            ]
        ];
    }

    public function getFormFields() {
        return [
            'id' => [
                'attribute' => 'id',
                'displayOnly' => true,
            ],
            'name' => [
                'attribute' => 'name',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \yii::t('execut/crudExample', 'Id'),
            'name' => \yii::t('execut/crudExample', 'Name'),
        ];
    }
}