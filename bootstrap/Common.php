<?php


namespace execut\crudExample\bootstrap;


use execut\crudExample\Module;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;
use yii\i18n\PhpMessageSource;

class Common implements BootstrapInterface
{
    public $moduleConfig = [];
    public function bootstrap($app)
    {
        $app->setModule('crudExample', ArrayHelper::merge([
            'class' => Module::class,
        ], $this->moduleConfig));
        $this->bootstrapI18n($app);
    }

    public function bootstrapI18n($app) {
        $i18n = $app->i18n;
        $i18n->translations['execut/crudExample'] = [
            'class' => PhpMessageSource::class,
            'basePath' => '@vendor/execut/yii2-crud-example/messages',
            'sourceLanguage' => 'en-US',
            'fileMap' => [
                'execut/crudExample' => 'crudExample.php',
            ],
        ];
    }
}