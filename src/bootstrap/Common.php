<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative\bootstrap;

use execut\booksNative\Module;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;
use yii\i18n\I18N;
use yii\i18n\PhpMessageSource;

/**
 * Common module bootstrap class
 * @package execut\booksNative
 */
class Common implements BootstrapInterface
{
    /**
     * @var array Module config array
     */
    public $moduleConfig = [];

    /**
     * Bootstrap application
     * @param Application $app
     */
    public function bootstrap($app)
    {
        $app->setModule('booksNative', ArrayHelper::merge([
            'class' => Module::class,
        ], $this->moduleConfig));
        $this->bootstrapI18n($app);
    }

    /**
     * Bootstrap i18n
     * @param Application $app
     */
    public function bootstrapI18n($app)
    {
        /**
         * @var I18N $i18n
         */
        $i18n = $app->i18n;
        $i18n->translations['execut/booksNative*'] = [
            'class' => PhpMessageSource::class,
            'basePath' => '@vendor/execut/yii2-books-native/src/messages',
            'sourceLanguage' => 'en-US',
            'fileMap' => [
                'execut/booksNative' => 'booksNative.php',
            ],
        ];
    }
}
