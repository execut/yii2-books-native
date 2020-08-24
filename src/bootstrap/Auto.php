<?php
/**
 */

namespace execut\booksNative\bootstrap;

use yii\base\BootstrapInterface;
use yii\console\Application;

class Auto implements BootstrapInterface
{
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