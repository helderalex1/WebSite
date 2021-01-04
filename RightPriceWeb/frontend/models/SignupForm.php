<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $nome;
    public $email;
    public $imagem;
    public $password;
    public $categoria_id;
    public $role;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['username', 'email'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['imagem', 'string'],
            ['imagem', 'default', 'value' => 'uploads/default.png'],

            ['nome', 'trim'],
            ['nome', 'required'],

            ['categoria_id', 'trim'],
            ['categoria_id', 'required'],

            ['role', 'trim'],
            ['role', 'required'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'nome' => 'Nome Completo',
            'categoria_id' => 'Categoria',
            'role' => 'Tipo de utilizador',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {

        if ($this->validate()) {
            $user = new User();
            $user->nome = $this->nome;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->imagem = $this->imagem;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->categoria_id = $this->categoria_id;
            if(!$user->save()){
                return null;
            }
            $auth = \Yii::$app->authManager;
            $authorRole = $auth->getRole($this->role);
            $auth->assign($authorRole, $user->getId());
            return $this->sendEmail($user);
        }
        return null;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
