<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property int $user_id
 * @property string $nome
 * @property int|null $Telemovel
 * @property int|null $Nif
 * @property string|null $Email
 *
 * @property User $user
 * @property Obra[] $obras
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'nome'], 'required'],
            [['user_id', 'Telemovel', 'Nif'], 'integer'],
            [['nome', 'Email'], 'string', 'max' => 255],
            [['Nif'], 'unique'],
            [['Email'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'nome' => 'Nome',
            'Telemovel' => 'Telemovel',
            'Nif' => 'Nif',
            'Email' => 'Email',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Obras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObras()
    {
        return $this->hasMany(Obra::className(), ['cliente_id' => 'id']);
    }
}
