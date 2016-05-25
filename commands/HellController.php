<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;


class HellController extends Controller
{

    public function actionIndex($message = 'hellergebtbt world')
    {
        echo $message . "\n";
    }
}
