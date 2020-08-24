<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\grid\ActionColumn;

/**
 * Book model for CRUD
 * @package execut\booksNative
 */
class Book extends ActiveRecord
{
    /**
     * Model name for translations
     */
    const MODEL_NAME = '{n,plural,=0{Books} =1{Book} other{Books}}';

    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return 'example_books';
    }

    /**
     * Returns query for CRUD list
     * @return ActiveQuery
     */
    protected function getQuery()
    {
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

    /**
     * Returns DataProvider for CRUD list
     * @return ActiveDataProvider
     */
    public function search()
    {
        $q = $this->getQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $q,
        ]);

        return $dataProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            ['id', 'safe', 'on' => 'grid'],
            ['name', 'safe', 'on' => ['grid', 'form']],
        ];
    }

    /**
     * Returns columns config for GridView widget
     * @return array
     * @throws \Exception
     */
    public function getGridColumns()
    {
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

    /**
     * Returns DetailView form attributes config
     * @return array
     */
    public function getFormFields()
    {
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

    /**
     * {@inheritDoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => \yii::t('execut/books', 'Id'),
            'name' => \yii::t('execut/books', 'Name'),
        ];
    }
}
