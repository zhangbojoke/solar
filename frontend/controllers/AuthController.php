<?php
/**
 * Created by PhpStorm.
 * User: zhangBo
 * Date: 2017/12/28
 * Time: 17:30
 */

namespace frontend\controllers;


use common\filters\AccessControl;
use common\filters\AccessRule;
use common\models\SignupForm;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'sign'],
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['sign'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionSign(){

    }

    public function actionLogin(){

    }

    public function actionValidate(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new SignupForm();
        return $model->exist(\Yii::$app->request->post());
    }

}