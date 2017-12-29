<?php
/**
 * Created by PhpStorm.
 * User: zhangBo
 * Date: 2017/12/28
 * Time: 17:30
 */

namespace frontend\controllers;


use common\components\wechat\wxSdk;
use common\models\LoginForm;
use common\models\User;
use Yii;
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
        if(\Yii::$app->request->isPost){
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new SignupForm();
            $params = \Yii::$app->request->post();
            $params['username'] = 'zhangbo';
            $params['nick'] = '张博';
            $params['mobile'] = 18032259400;
            $params['captcha'] = 123;
            $params['password'] = 'testset';
            $params['rePassword'] = 'testset';
            $params['company'] = '北京灵动';
            $params['license'] = 123;
            $params['identity'] = '12313';
            $params['brand'] = '灵动';
            $params['logo'] = '123fsdfst';
            return $model->signup($params);
        }
        return $this->render('sign');
    }

    public function actionLogin(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLoginOauth()
    {
        //是为了能再回到对应的定制域名
        //这边跳转到对应要登录的网址
        header("Location:http://" .  $_SERVER['HTTP_HOST'] . "/site/login-handle?code=" . Yii::$app->request->get('code') . "&state=" . Yii::$app->request->get('state') . "&to=" . urlencode(Yii::$app->session->get('toUrl')));
    }

    public function actionLoginHandle()
    {
        $wx = new wxSdk();
        $openId = ($wx->oauth->user()->getOriginal());
        $userInfo = $wx->getUserInfo($openId['openid']);
        $userInfo['access_token'] = $openId['access_token'];
        $userInfo['refresh_token'] = $openId['refresh_token'];
        $user = new User();
        $userInfo['pc'] = 0;
        $res = $user->login($userInfo);
        if($res instanceof User){
            return $this->redirect('/user/index');
        }
        return $this->redirect('/site/error');
    }

    public function actionLoginQr(){
        $wx = new wxSdk();
        $code = \Yii::$app->request->get('code',false);
        if($code){
            $userInfo = ($wx->getOpenidByPc($code));
            $userInfo['pc'] = 1;
            $user = new User();
            $res = $user->login($userInfo);
            if($res instanceof User){
                return $this->redirect('/user/info');
            }
            return $this->redirect('/site/error');
        }
        return $this->redirect('/site/error');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionValidate(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new SignupForm();
        return $model->exist(\Yii::$app->request->post());
    }

    public function actionCreate(){
        $model = new SignupForm();
        $params = \Yii::$app->request->post();
        $params['username'] = 'zhangbo';
        $params['birthday'] = '1490371200';
        $params['nick'] = '张博';
        $params['mobile'] = '18032259400';
        var_dump($model->createUser($params));
    }

}