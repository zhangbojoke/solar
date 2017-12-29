<?php

namespace common\components\helpers;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 20:26
 */
use common\models\ColumnTable;
use Yii;
class Html extends \yii\helpers\Html
{
    public static function createImgUrl($src,$w=0,$h=0){
        if($w || $h){
            return Yii::$app->params['base_img'].$src.'?imageView2/3/w/'.$w.'/h/'.$h.'/format/jpg/q/75%7Cimageslim';

        }
        return Yii::$app->params['base_img'].$src;
    }

    public static function getDomain(){
        $m = '';
        (preg_match('*^/.+?\?*',\Yii::$app->request->url,$m));
        if($m && substr_count($m[0],'/') == 3){
            $m = substr($m[0],1);
            $m = substr($m,0,strpos($m,'/'));
        }else{
            $m = '';
        }
        return $m;
    }
}