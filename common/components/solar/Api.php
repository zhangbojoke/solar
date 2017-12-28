<?php
/**
 * Created by PhpStorm.
 * User: zhangBo
 * Date: 2017/12/28
 * Time: 10:52
 */

namespace common\components\solar;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlFactory;
use yii\base\ErrorException;
use yii\base\InvalidCallException;

/**
 * Class Api
 * @package common\components\solar
 *
 * @property string $_appId
 * @property string $_appKey
 * @property string $_grantType
 * @property string $token
 * @property string $_baseUrl
 * @property array $config
 * @property array $params
 * @property array $_provider
 * @property Client $_client
 */
class Api
{
    private $_appId;
    private $_appKey;
    private $_grantType;
    public  $token;
    private $_client;
    private $_baseUrl;
    public $params;
    private $config = [
        'AppId'=>'10063',
        'AppKey'=>'C3KyNDTWsmYhtHbrbrHyfHd9bC525Det',
        'GrantType'=>'client_credentials',
        'BaseUrl'=>'http://openapi.solarmanpv.com/v1/',
    ];
    private $_provider = [
        'oauth'=>[
            'get'=>'oauth2/accessToken',
            'detail'=>'token/usage',
        ],
        'user'=>[
            'post'=>'user/b_user_register',
            'list'=>'user/c_user_list',
            'update'=>'user/modify',
            'validate'=>'user/account_validate',
        ],
        'plant'=>[
            'list'=>'plant/list',
            'detail'=>'plant/details',
            'data'=>'plant/data',
            'energy'=>'plant/energy',
            'power'=>'plant/power',
            'post'=>'plant/add',
            'delete'=>'plant/delete',
        ],
//        'device'=>[
//            ''
//        ]
    ];

    private function _getRequestUrl($action,$method){
        if(isset($this->_provider[$action])){
            if(isset($this->_provider[$action][$method])){
                return $this->_baseUrl.''.$this->_provider[$action][$method];
            }
            throw new InvalidCallException('invalid config to method');
        }
        throw new InvalidCallException('invalid config to action');
    }

    public function request($rMethod,$action,$method){
        $request = $this->_client->request($rMethod,$this->_getRequestUrl($action,$method),
            [
                'header'=>[
                    'Content-Type'=>'application/x-www-form-urlencoded',
                ],
                'query'=>$this->params,
            ]);
        $res = \GuzzleHttp\json_decode($request->getBody()->getContents());
        if($res->error_code == 0){
            $res->result = true;
        }else{
            throw new ErrorException($res->error_msg);
        }
        return $res;
    }

    public function __construct()
    {
        foreach($this->config as $k=>$v){
            $func = 'set'.$k;
            $this->$func($v);
        }
        $this->_client = new Client(['verify'=>false]);
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->_appId;
    }

    /**
     * @param mixed $appId
     */
    public function setAppId($appId)
    {
        $this->_appId = $appId;
    }

    /**
     * @return mixed
     */
    public function getAppKey()
    {
        return $this->_appKey;
    }

    /**
     * @param mixed $appKey
     */
    public function setAppKey($appKey)
    {
        $this->_appKey = $appKey;
    }

    /**
     * @return mixed
     */
    public function getGrantType()
    {
        return $this->_grantType;
    }

    /**
     * @param mixed $grantType
     */
    public function setGrantType($grantType)
    {
        $this->_grantType = $grantType;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        if(!$this->token){
            $this->params['client_id'] = $this->getAppId();
            $this->params['client_secret'] = $this->getAppKey();
            $this->params['grant_type'] = $this->getGrantType();
            $res =  $this->request('GET','oauth','get');
            if($res->result){
                $this->setToken($res->data->access_token);
            }
        }
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
        \Yii::$app->redis->set('token',$token);
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->_client = $client;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->_baseUrl = $baseUrl;
    }


    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->_baseUrl;
    }
}