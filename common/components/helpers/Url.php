<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 20:28
 */

namespace common\components\helpers;

use Yii;
use yii\base\InvalidParamException;

class Url extends \yii\helpers\Url
{
    protected static function normalizeRoute($route)
    {
        $route = Yii::getAlias((string) $route);
        if (strncmp($route, '/', 1) === 0) {
            // absolute route
            //兼容自定义域名
            return ltrim(Html::getDomain().''.$route.'/');
        }

        // relative route
        if (Yii::$app->controller === null) {
            throw new InvalidParamException("Unable to resolve the relative route: $route. No active controller is available.");
        }

        if (strpos($route, '/') === false) {
            // empty or an action ID
            return $route === '' ? Yii::$app->controller->getRoute() : Yii::$app->controller->getUniqueId() . '/' . $route;
        }
        // relative to module
        return ltrim(Html::getDomain().Yii::$app->controller->module->getUniqueId() . '/' . $route, '/');
    }
}