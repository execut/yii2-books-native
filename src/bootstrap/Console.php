<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative\bootstrap;

use yii\base\BootstrapInterface;
use yii\console\controllers\MigrateController;

/**
 * Console module bootstrap
 * @package execut\booksNative
 */
class Console implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $this->addMigrationNamespace($app);
    }

    /**
     * @param \yii\base\Application $app
     */
    protected function addMigrationNamespace(\yii\base\Application $app): void
    {
        $controllerMap = $app->controllerMap;
        if (empty($controllerMap['migrate'])) {
            $controllerMap['migrate'] = [
                'class' => MigrateController::class,
            ];
        }

        if (empty($controllerMap['migrate']['migrationNamespaces'])) {
            $controllerMap['migrate']['migrationNamespaces'] = [];
        }

        $controllerMap['migrate']['migrationNamespaces'][] = 'execut\booksNative\migrations';
        $app->setAliases([
            '@execut/booksNative' => 'vendor/execut/yii2-books-native',
        ]);
        $app->controllerMap = $controllerMap;
    }
}