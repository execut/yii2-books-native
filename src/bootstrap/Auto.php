<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\booksNative\bootstrap;

use yii\base\BootstrapInterface;
use yii\console\Application;

/**
 * Auto bootstrap for package
 * @package execut\booksNative\bootstrap
 */
class Auto implements BootstrapInterface
{
    /**
     * {@inheritDoc}
     */
    public function bootstrap($app)
    {
        $bootstraps = [];
        if ($app instanceof Application) {
            $bootstraps[] = new Console();
        } else {
            $bootstraps[] = new Common();
        }

        foreach ($bootstraps as $bootstrap) {
            $bootstrap->bootstrap($app);
        }
    }
}
