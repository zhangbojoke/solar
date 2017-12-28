<?php

/**
 * Created by PhpStorm.
 * User: quanzhenan
 * Date: 17/8/15
 * Time: 3:47 PM
 */
namespace common\filters;
use common\models\GachaCustomer;
use gacha\models\Result;
use yii\filters\AccessRule as BasicAccessRule;
class AccessRule extends BasicAccessRule
{
    protected function matchRole($user)
    {
        if(empty($this->roles))
        {
            return true;
        }
        foreach($this->roles as $role)
        {
            if($role==='?')
            {
                if($user->getIsGuest()) return true;
            }
            elseif($role==='@')
            {
                if(!$user->getIsGuest()){
                    return true;
                }
            }elseif(!$user->getIsGuest() && ($role & $user->getIdentity()->role) ){
                return true;
            }
        }
        return false;
    }

}