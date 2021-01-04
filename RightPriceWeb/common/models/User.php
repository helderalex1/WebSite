<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'categoria_id'], 'required'],
            [['telemovel', 'categoria_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['imagem','nome'], 'string'],
            [['username', 'nome_empresa', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email','username'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['status'], 'default', 'value' => self::STATUS_INACTIVE],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['categoria_id'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'nome_empresa' => 'Nome Empresa',
            'telemovel' => 'Telemovel',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'imagem' => 'Imagem',
            'categoria_id' => 'Categoria ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

   /* /**
     * {@inheritdoc}
     */
   /* public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }*/

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }



    /**
     * Gets query for [[Clientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Instaladors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstaladors()
    {
        return $this->hasMany(User::className(), ['id' => 'instalador_id'])->viaTable('fornecedor_instalador', ['fornecedor_id' => 'id']);
    }

    /**
     * Gets query for [[Fornecedors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedors()
    {
        return $this->hasMany(User::className(), ['id' => 'fornecedor_id'])->viaTable('fornecedor_instalador', ['instalador_id' => 'id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::className(), ['fornecedor_id' => 'id']);
    }

    public function getProdutosArray()
    {
        return $this->hasMany(Produto::className(), ['fornecedor_id' => 'id'])->asArray()->all();
    }

    public function getProdutosUsadosArray()
    {
        //quantos produtos foram usados
        $produtos = $this->hasMany(Produto::className(), ['fornecedor_id' => 'id'])->asArray()->all();
        $array_produtos = [];
        $i=0;
        foreach ($produtos as $produto){
            $newProduto = OrcamentoProduto::find()->where(['produto_id'=> $produto['id']])->asArray()->all();
            if($newProduto!=null){
                $array_produtos[$i] = $newProduto;
                $i++;
            }
        }
        return $array_produtos;
    }

    public function getTotalOrcamentado()
    {
        //quantos produtos foram usados
        $produtos = $this->getProdutosArray();
        $total=0;
        foreach ($produtos as $produto){
            $newProdutos = OrcamentoProduto::find()->where(['produto_id'=> $produto['id']])->asArray()->all();
            if($newProdutos!=null){
                foreach ($newProdutos as $newProduto){
                    $total += $newProduto['quantidade'] * $produto['preco'];
                }
            }
        }
        return $total;
    }

    public function getTotalProdutos()
    {
        //quantidade e total por produto
        $produtos = $this->getProdutosArray();
        $array_produtos = [];
        $array = [];
        $i= 0;
        $total=0;
        foreach ($produtos as $produto){
            $newProdutos = OrcamentoProduto::find()->where(['produto_id'=> $produto['id']])->asArray()->all();
            if($newProdutos!=null){
                $array_produtos[$i]['quantidade'] = 0;
                $array_produtos[$i]['total']  = 0;
                foreach ($newProdutos as $newProduto){
                    $array_produtos[$i]['produto'] = $produto['referencia'];
                    $array_produtos[$i]['preco'] = $produto['preco'];
                    $array_produtos[$i]['quantidade'] += $newProduto['quantidade'];
                    $array_produtos[$i]['total']  += $newProduto['quantidade'] * $produto['preco'];
                }
            }
            $i++;
        }
        return $array_produtos;
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }
}
