<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/6
 * Time: 20:05
 */

namespace common\models;


class Result
{
    public static function result($message,$code=200){
        if($code == 200){
            if(is_array($message)){
                return array_merge($message,['code'=>200]);
            }else{
                return ['message'=>$message,'code'=>200];
            }
//            return [$message,'code'=>200];
        }
        return ['error'=>['message'=>$message],'code'=>$code];
    }
}