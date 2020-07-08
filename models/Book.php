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
        return 'example_simple';
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
                'filter' => true,
            ],
            'name' => [
                'attribute' => 'name',
                'filter' => true,
            ],
            'actions' => [
                'class' => ActionColumn::class,
//                'urlCreator' => function () {
//                    return [
//                        '/test',
//                    ];
//                },
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
            'created' => [
                'attribute' => 'created',
            ],
        ];
    }
}