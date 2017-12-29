<?php
namespace common\components\wechat;

use Codeception\Lib\Connector\Guzzle;
use EasyWeChat\Core\Http;
use EasyWeChat\Foundation\Application;
use GuzzleHttp\Client;
use Yii;
use yii\base\InvalidCallException;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/6
 * Time: 13:52
 */
class wxSdk
{
    private $app;
    public $server;
    public $user;
    public $menu;
    public $qrcode;
    public $merchant_pay;
    public $tag;
    public $payment;
    public $oauth;
    public $js;
    public $notice;
    protected $access_token;

    public function initUserAttributes()
    {
        // TODO: Implement initUserAttributes() method.
    }

    public function __construct(array $config = [])
    {
        $options = [
            'debug' => false,
            'app_id' => 'wxb234ed2d0d7bd34c',//Yii::$app->wxsdk->getAppID(),
            'secret' => '29961f33afbf87feb770283f2f5be151',//Yii::$app->wxsdk->getAppSecret(),
            'token' => 'wei0707xinjupai',
            'payment' => [
                'key' => 'f8dsa6f78easfy78asdyf78wq3gfqw7g',
                'merchant_id' => 1254361601,
                'cert_path' => '/root/backend/apiclient_cert.pem', // XXX: 绝对路径！！！！
                'key_path' => '/root/backend/apiclient_key.pem',
                'notify_url' => $_SERVER['HTTP_HOST'],
            ],
            'oauth' => [
                'scopes' => ['snsapi_base'],
                'callback' => '/site/login-oauth',
            ]
            // ...
        ];
        $this->app = new Application($options);
        $this->access_token = $this->app->access_token->getToken();
        $this->server = $this->app->server;
        $this->user = $this->app->user;
        $this->menu = $this->app->menu;
        $this->qrcode = $this->app->qrcode;
        $this->tag = $this->app->user_tag;
        $this->payment = $this->app->payment;
        $this->oauth = $this->app->oauth;
        $this->js = $this->app->js;
        $this->notice = $this->app->notice;
        $this->merchant_pay = $this->app->merchant_pay;
        Http::setDefaultOptions($this->app['config']->get('guzzle', ['timeout' => 120.0]));
    }

    public function getUserInfo($openID)
    {
        if (!$this->access_token) {
            $this->access_token = $this->app->access_token->getToken(true);
        }
        //现在使用openid兑换UnionId
        //当确认openId安全性之后可直接通过数据库查询pay_openid
        $params = [
            'access_token' => $this->access_token,
            'openid' => $openID,
            'lang' => 'zh_CN'
        ];
        $client = new Client();
        $res = $client->request('GET','https://api.weixin.qq.com/cgi-bin/user/info',['query'=>
            $params
        ]);
        $request = json_decode($res->getBody()->getContents(),true);
        if (!isset($request['errcode'])) {
            return $request;
        } else {
            if ($request['errcode'] == 40001) {
                //if invalid access_token
                $this->access_token = $this->app->access_token->getToken(true);
                return $this->getUserInfo($openID);
            } else {
                throw new InvalidCallException('错误:' . $request['errmsg']);
            }
        }
    }

    public function getMedia($mediaID)
    {

        $access = $this->access_token;
        if ($access) {
            $ch = curl_init("http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$access&media_id=$mediaID");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOBODY, 0);    //对body进行输出。
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_exec($ch);
            $wxMediaUrl = curl_getinfo($ch);
            curl_close($ch);
            try{
                $client = new Client();
                $result = $client->request('GET',"http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$access&media_id=$mediaID");
                $result = (json_decode($result->getBody()->getContents(),true));
                var_dump($result);
            }catch (\Exception $e){
                //如果出现了exception 表示正确的请求道了微信的数据
            }
            if(isset($result['errcode'])){
                return false;
            }
            return $wxMediaUrl['url'];
        }
        return false;
    }

    public function getMediaToUpload($media){
        $i = 0;
        do {
            $wx = $this->getMedia($media);
            $i++;
//            sleep(3);
        } while (!($i > 3 || $wx));
        if (!$wx) {
            return false;
        }
        $result = Yii::$app->qiniu->upload($wx);
        if ($result) {
            return $result;
        }
        return false;
    }

    /**
     * @description 扫码获得openId
     * @param $code
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getOpenidByPc($code){
        $client = new Client();
        $res = $client->request('GET','https://api.weixin.qq.com/sns/oauth2/access_token',[
            'query'=>[
                'appid'=>'wx90922816db62b329',
                'secret'=>'76cc434685908040cf2eae5abec94726',
                'code'=>$code,
                'grant_type'=>'authorization_code'
            ]
        ]);
        $res= json_decode($res->getBody()->getContents(),true);
        $access_token = $res['access_token'];
        $refresh_token = $res['refresh_token'];
        if(isset($res['access_token'])){
            $res = $client->request('GET','https://api.weixin.qq.com/sns/userinfo',[
                'query'=>[
                    'access_token'=>$access_token,
                    'openid'=>$res['openid'],
                ]
            ]);
            $res= (json_decode($res->getBody()->getContents(),true));
            $res['access_token'] = $access_token;
            $res['refresh_token'] = $refresh_token;
            if(isset($res['nickname'])){
                $res['subscribe'] = 1;
            }else{
                $res['subscribe'] = 0;
            }
            return $res;
        }
        return false;
    }

}
