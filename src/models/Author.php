<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative\models;

use execut\booksNative\models\AuthorVsBook;
use Imagine\Image\ImageInterface;
use Imagine\Image\ManipulatorInterface;
use kartik\detail\DetailView;
use kartik\select2\Select2;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\imagine\BaseImage;
use yii\imagine\Image as ImagineImage;
use yii\web\UploadedFile;

/**
 * Author model
 * @package execut\booksNative
 */
class Author extends ActiveRecord
{
    /**
     * Model name for translation
     */
    const MODEL_NAME = '{n,plural,=0{Authors} =1{Author} other{Authors}}';

    /**
     * Attribute for image file uploading
     * @var UploadedFile
     */
    public $imageFile = null;

    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return 'example_authors';
    }

    /**
     * Returns query for CRUD list
     * @return ActiveQuery
     */
    public function getQuery()
    {
        $query = self::find();
        $query->andFilterWhere([
            'id' => $this->id,
            'main_book_id' => $this->main_book_id,
        ]);

        $stringFields = [
            'name',
            'surname',
            'image_name',
            'image_extension',
            'image_md5',
            'image_mime_type'
        ];

        foreach ($stringFields as $stringField) {
            $query->andFilterWhere([
                'ILIKE',
                $stringField,
                $this->$stringField,
            ]);
        }

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
            [['name', 'surname'], 'safe', 'on' => ['grid']],
            [['name', 'surname'], 'required', 'on' => ['form']],
            [['imageFile', 'image', 'main_book_id'], 'safe', 'on' => ['grid', 'form']],
            ['imageFile', 'file', 'skipOnEmpty' => true, 'checkExtensionByMimeType' => false, 'extensions' => 'jpg,jpeg,gif,bmp,png',],
            ['image_name', 'default', 'skipOnEmpty' => false, 'value' => function () {
                $value = $this->imageFile;
                if (!empty($value)) {
                    return $value->name;
                }

                return null;
            }],
            ['image_extension', 'default', 'value' => function () {
                $value = $this->imageFile;
                if (!empty($value)) {
                    return $value->extension;
                }

                return null;
            }],
            ['image_md5', 'default', 'value' => function () {
                $data = $this->image;
                if (!empty($data)) {
                    if (is_resource($data)) {
                        $sourceData = $data;
                        $data = stream_get_contents($data);
                        fseek($sourceData, 0);
                    }

                    return md5($data);
                }

                return null;
            }],
            ['image_mime_type', 'default', 'value' => function () {
                $value = $this->imageFile;
                if (!empty($value)) {
                    return $value->type;
                }

                return null;
            }],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => \yii::t('execut/books', 'Id'),
            'name' => \yii::t('execut/books', 'First Name'),
            'surname' => \yii::t('execut/books', 'Surname'),
            'imageFile' => \yii::t('execut/books', 'Image'),
            'image_name' => \yii::t('execut/books', 'Image Name'),
            'image_md5' => \yii::t('execut/books', 'Md5 hash'),
            'image_extension' => \yii::t('execut/books', 'Extension'),
            'image_mime_type' => \yii::t('execut/books', 'MIME type'),
            'main_book_id' => \yii::t('execut/books', 'Main Book'),
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
            'surname' => [
                'attribute' => 'surname',
            ],
            [
                'attribute' => 'image_name',
            ],
            [
                'attribute' => 'image_md5',
            ],
            [
                'attribute' => 'image_extension',
            ],
            [
                'filter' => false,
                'format' => 'raw',
                'header' => \yii::t('execut/books', 'Preview'),
                'value' => $this->getValueCallback(),
            ],
            [
                'attribute' => 'image_mime_type',
            ],
            [
                'attribute' => 'main_book_id',
                'value' => 'mainBook.name',
                'filter' => Select2::widget([
                    'model' => $this,
                    'attribute' => 'main_book_id',
                    'bsVersion' => 3,
                    'theme' => 'bootstrap',
                    'language' => 'ru',
                    'initValueText' => $this->mainBook ? $this->mainBook->name : null,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'ajax' => [
                            'dataType' => 'json',
                            'url' => Url::to(['/booksNative/books']),
                            'data' =>
                                new \yii\web\JsExpression('function(params) {
                    return {
                        "Book[name]": params.term,
                        page: params.page
                    };
                }'),
                        ],
                    ],
                    'options' => [
                        'placeholder' => \yii::t('execut/books', 'Main Book'),
                    ],
                    'showToggleAll' => false,
                ]),
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
            'surname' => [
                'attribute' => 'surname',
            ],
            'imageFile' => [
                'attribute' => 'imageFile',
                'type' => 'fileInput',
                'format' => 'raw',
                'value' => function () {
                    return $this->getDisplayedValue();
                },
            ],
            'image_md5' => [
                'type' => DetailView::INPUT_TEXT,
                'displayOnly' => true,
                'label' => 'Md5 hash',
                'attribute' => 'image_md5',
            ],
            'preview' => [
                'label' => \yii::t('execut/books', 'Preview'),
                'format' => 'raw',
                'displayOnly' => true,
                'value' => function ($form, $widget) {
                    $value = $this->getValueCallback();
                    return $value($widget->model);
                },
            ],
            [
                'type' => 'widget',
                'attribute' => 'main_book_id',
                'widgetOptions' => [
                    'class' => Select2::class,
                    'bsVersion' => 3,
                    'theme' => 'bootstrap',
                    'language' => 'ru',
                    'initValueText' => $this->mainBook ? $this->mainBook->name : null,
                    'pluginOptions' => [
                            'allowClear' => true,
                            'ajax' => [
                                'dataType' => 'json',
                                'url' => Url::to(['/booksNative/books']),
                                'data' =>
                                    new \yii\web\JsExpression('function(params) {
                    return {
                        "Book[name]": params.term,
                        page: params.page
                    };
                }'),
                            ],
                    ],
                    'options' => [
                        'placeholder' => 'Main Book',
                    ],
                    'showToggleAll' => false,
                ],
                'displayOnly' => false,
            ]
        ];
    }

    /**
     * Returns mainBook relation
     * @return ActiveQuery
     */
    public function getMainBook()
    {
        return $this->hasOne(Book::class, ['id' => 'main_book_id']);
    }

    /**
     * {@inheritDoc}
     */
    public function beforeSave($insert)
    {
        $this->makeThumbnails();
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * Make thumbnails for author uploaded image
     */
    protected function makeThumbnails()
    {
        $sizes = [
            'image_211' => [
                'width' => 211,
                'mode' => ImageInterface::THUMBNAIL_OUTBOUND,
            ],
        ];
        $data = $this->image;
        if (!$data) {
            return;
        }

        if (is_string($data)) {
            $tempFile = tempnam('/tmp', 'temp_');
            file_put_contents($tempFile, $data);
            $data = fopen($tempFile, 'r+');
        }

        if (stream_get_contents($data) == '') {
            return;
        }

        fseek($data, 0);
        $sourceImage = @ImagineImage::getImagine()->read($data);
        foreach ($sizes as $sizeName => $size) {
            $thumbnailAttributeName = $sizeName;
            if (!empty($size['width'])) {
                $width = $size['width'];
                if ($width < 0) {
                    $originalWidgth = $sourceImage->getSize()->getWidth();
                    if (-$originalWidgth < $width * 4) {
                        $width = $sourceImage->getSize()->getWidth() + $width;
                    } else {
                        $width = $originalWidgth;
                    }
                }
            } else {
                $width = null;
            }

            if (!empty($size['height'])) {
                $height = $size['height'];
                if ($height < 0) {
                    $originalHeight = $sourceImage->getSize()->getHeight();
                    if (-$originalHeight < $height * 4) {
                        $height = $sourceImage->getSize()->getHeight() + $height;
                    } else {
                        $height = $originalHeight;
                    }
                }
            } else {
                $height = null;
            }

            if (!empty($size['mode'])) {
                $mode = $size['mode'];
            } else {
                $mode = ImageInterface::THUMBNAIL_INSET;
            }

            BaseImage::$thumbnailBackgroundAlpha = 0;
            $image = ImagineImage::thumbnail($sourceImage, $width, $height, $mode);

            if (!empty($size['watermark'])) {
                $watermark = fopen($size['watermark'], 'r+');
                $watermark = ImagineImage::thumbnail($watermark, $image->getSize()->getWidth(), $image->getSize()->getHeight(), ManipulatorInterface::THUMBNAIL_OUTBOUND);
                $watermark = ImagineImage::crop($watermark, $image->getSize()->getWidth(), $image->getSize()->getHeight());

                $image = ImagineImage::watermark($image, $watermark);
            }

            $fileName = tempnam(sys_get_temp_dir(), 'test');
            $image->save($fileName, [
                'format' => $this->image_extension,
            ]);

            $thumbData = fopen($fileName, 'r+');
            $this->$thumbnailAttributeName = $thumbData;
        }

        fseek($data, 0);
    }

    /**
     * Returns image file DetailView for CRUD image column
     */
    protected function getDisplayedValue()
    {
        $attributes = [
            'image_name',
            'image_extension',
            'image_md5',
            'image_mime_type',
        ];

        return \yii\widgets\DetailView::widget([
            'model' => $this,
            'attributes' => $attributes,
        ]);
    }

    /**
     * Returns callback for CRUD image column value
     * @return \Closure
     */
    protected function getValueCallback()
    {
        return function ($row) {
            return Html::a(Html::img(['/booksNative/authors/image', 'id' => $row->id, 'extension' => strtolower($row->image_extension), 'dataAttribute' => 'image_211']), [
                '/booksNative/authors/image',
                'id' => $row->id,
                'extension' => strtolower($row->image_extension),
            ]);
        };
    }
}
