<?php
namespace common\models;
use common\filters\ArrayFilter;

/**
 * Signup form
 */
class SignupForm extends UserExtends
{
    public $username;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required','on'=>['sign']],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.','on'=>['sign']],
            ['username', 'string', 'min' => 2, 'max' => 255,'on'=>['sign']],
            ['password', 'required','on'=>['sign']],
            ['password', 'string', 'min' => 6,'on'=>['sign']],
//            ['email', 'trim'],
//            ['email', 'required'],
//            ['email', 'email'],
//            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['company','unique','targetClass'=>'\common\models\UserExtends','message'=>'公司全称已存在','on'=>['exist']],
            ['identity','unique','targetClass'=>'\common\models\UserExtends','message'=>'统一社会信用代码已存在','on'=>['exist']],

        ];
    }

    public function scenarios()
    {
        return [
            'exist'=>['company','identity'],
            'sign'=>['username','password'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

    public function exist($params){
        $this->setScenario('exist');
        $params['company'] = '北京灵动科技';
        if(!ArrayFilter::arrayFilter($params)){
            return Result::result('参数不能为空',500);
        }
        $this->load(ArrayFilter::arrayFilter($params),'');
        if($this->validate()){
            return Result::result('验证通过');
        }
        return Result::result('验证不通过',500);
    }
}
