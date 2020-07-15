<?php


namespace execut\booksNative\bootstrap;


use execut\books\Module;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;
use yii\i18n\PhpMessageSource;

class Common implements BootstrapInterface
{
    public $moduleConfig = [];
    public function bootstrap($app)
    {
        $app->setModule('booksNative', ArrayHelper::merge([
            'class' => Module::class,
        ], $this->moduleConfig));
        $this->bootstrapI18n($app);
    }

    public function bootstrapI18n($app) {
        $i18n = $app->i18n;
        $i18n->translations['execut/books'] = [
            'class' => PhpMessageSource::class,
            'basePath' => '@vendor/execut/yii2-books-native/messages',
            'sourceLanguage' => 'en-US',
            'fileMap' => [
                'execut/books' => 'books.php',
            ],
        ];
    }
}