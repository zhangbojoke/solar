<?php
namespace common\models;

use common\filters\ArrayFilter;
use yii\db\Exception;

/**
 * Signup form
 */
class SignupForm extends UserExtends
{
    public $username;
    public $nick;
    public $captcha;
    public $password;
    public $rePassword;
    public $birthday;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'on' => ['sign','create']],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '用户名已存在', 'on' => ['sign','create']],
            ['username', 'string', 'min' => 2, 'max' => 255, 'on' => ['sign','create']],
            ['password', 'required', 'on' => ['sign']],
            ['password', 'string', 'min' => 6,'max'=>12, 'on' => ['sign'],'message'=>'密码长度需要在6-12位之间'],
            ['rePassword','required','on'=>['sign']],
            ['rePassword','validatePassword','on'=>['sign']],
            [['nick','license','identity','company','brand','mobile','logo'],'required','on'=>['sign']],
//            ['email', 'trim'],
//            ['email', 'required'],
//            ['email', 'email'],
//            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['company', 'unique', 'targetClass' => '\common\models\UserExtends', 'message' => '公司全称已存在', 'on' => ['exist', 'sign']],
            ['identity', 'unique', 'targetClass' => '\common\models\UserExtends', 'message' => '统一社会信用代码已存在', 'on' => ['exist', 'sign']],
            [['birthday','nick','nick','mobile'],'required','on'=>['create']],
        ];
    }

    public function scenarios()
    {
        return [
            'exist' => ['company', 'identity'],
            'sign' => ['username', 'password', 'company', 'identity', 'license', 'brand', 'mobile', 'logo', 'nick', 'captcha','rePassword'],
            'register'=>['username','birthday','nick','mobile'],
        ];
    }

    public function validatePassword($attribute){
        if($this->$attribute == $this->password){
            return true;
        }
        return $this->addError($attribute,'两次密码不一致');
    }


    /**
     * @param $params
     * @return User|array
     */
    public function signup($params)
    {
        $this->setScenario('sign');
        $this->load(ArrayFilter::arrayFilter($params), '');
        if (!$this->validate()) {
            var_dump($this->getErrors());
            return Result::result('验证不通过', 500);
        }

        $trs = \Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->nick = $this->nick;
            $user->mobile = $this->mobile;
            $user->username = $this->username;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->role = $user::INSTALLER;
            $user->save(false);
            $this->id = $user->id;
            $this->save(false);
            $trs->commit();
            return $user;
        } catch (Exception $e) {
            $trs->rollBack();
            return Result::result($e->getMessage(), 500);
        }
//        $user->username = $this->username;
//        $user->email = $this->email;
//        $user->setPassword($this->password);
//        $user->generateAuthKey();

//        return $user->save() ? $user : null;
    }

    public function exist($params)
    {
        $this->setScenario('exist');
        if (!ArrayFilter::arrayFilter($params)) {
            return Result::result('参数不能为空', 500);
        }
        $this->load(ArrayFilter::arrayFilter($params), '');
        if ($this->validate()) {
            return Result::result('验证通过');
        }
        return Result::result('验证不通过', 500);
    }

    public function createUser($params){
        $this->setScenario('register');
        $this->load(ArrayFilter::arrayFilter($params),'');
        if($this->validate()){
            $user = new User();
            $user->nick = $this->nick;
            $user->username = $this->username;
            $user->setPassword(rand(100000,99999999));
            $user->generateAuthKey();
            $user->email = $this->username.'@gmail.com';
            $user->role = $user::NORMAL_USER;
            $user->status = $user::STATUS_DELETED;
            $user->mobile = $this->mobile;
            $user->bind_code = sprintf("%06d",rand(000000,99999));
            $user->birthday = $this->birthday;
            //安装商是当前用户
            $user->parent = \Yii::$app->user->getId();
            if($user->save()){
                return $user->registerToApi();
            }
        }
        return false;
    }
}
