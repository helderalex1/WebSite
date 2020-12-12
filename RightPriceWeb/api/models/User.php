<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string|null $nome_empresa
 * @property int|null $telemovel
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property resource|null $imagem
 * @property int $categoria_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Cliente[] $clientes
 * @property FornecedorInstalador[] $fornecedorInstaladors
 * @property FornecedorInstalador[] $fornecedorInstaladors0
 * @property Utilizador[] $instaladors
 * @property Utilizador[] $fornecedors
 * @property Produto[] $produtos
 * @property Categoria $categoria
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'categoria_id', 'created_at', 'updated_at'], 'required'],
            [['telemovel', 'categoria_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['imagem'], 'string'],
            [['username', 'nome_empresa', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
     * Gets query for [[Clientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[FornecedorInstaladors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedorInstaladors()
    {
        return $this->hasMany(FornecedorInstalador::className(), ['fornecedor_id' => 'id']);
    }

    /**
     * Gets query for [[FornecedorInstaladors0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedorInstaladors0()
    {
        return $this->hasMany(FornecedorInstalador::className(), ['instalador_id' => 'id']);
    }

    /**
     * Gets query for [[Instaladors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstaladors()
    {
        return $this->hasMany(Utilizador::className(), ['id' => 'instalador_id'])->viaTable('fornecedor_instalador', ['fornecedor_id' => 'id']);
    }

    /**
     * Gets query for [[Fornecedors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedors()
    {
        return $this->hasMany(Utilizador::className(), ['id' => 'fornecedor_id'])->viaTable('fornecedor_instalador', ['instalador_id' => 'id']);
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

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['verification_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}