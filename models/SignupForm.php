<?php 
 
namespace app\models; 
use Yii; 
use yii\base\Model; 
use yii\helpers\VarDumper; 
 
/** 
* Signup form 
*/ 
 
class SignupForm extends Model 
{ 
    public $username; 
    public $email; 
    public $password; 
    public $created_at; 
    public $auth_key; 
    public $access_token; 
    /** 
    * @inheritdoc 
    */ 
    public function rules() 
    { 
        return [ 
            [['username', 'password', 'created_at'], 'required'], 
            [['created_at'], 'safe'], 
            [['username', 'email'], 'string', 'max' => 63], 
            [['password'], 'string', 'max' => 127],
            [['auth_key', 'access_token'], 'string', 'max' => 255], 
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
        $user->password =  $user->setPassword($this->password); 
        $user->auth_key = $user->generateAuthKey(); 
        $user->created_at = date('Y-m-d H:i:s'); 
        
        return $user->save() ? $user : null; 
    } 
 
    public function attributeLabels() 
    { 
        return [ 
            'username' => 'Имя пользователя', 
            'email' => 'Email', 
            'password' => 'Пароль', 
        ]; 
    } 
}