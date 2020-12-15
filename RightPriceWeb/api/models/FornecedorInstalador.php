<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fornecedor_instalador".
 *
 * @property int $fornecedor_id
 * @property int $instalador_id
 * @property string|null $created_at
 *
 * @property User $fornecedor
 * @property User $instalador
 */
class FornecedorInstalador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fornecedor_instalador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fornecedor_id', 'instalador_id'], 'required'],
            [['fornecedor_id', 'instalador_id'], 'integer'],
            [['created_at'], 'safe'],
            [['fornecedor_id', 'instalador_id'], 'unique', 'targetAttribute' => ['fornecedor_id', 'instalador_id']],
            [['fornecedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fornecedor_id' => 'id']],
            [['instalador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['instalador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fornecedor_id' => 'Fornecedor ID',
            'instalador_id' => 'Instalador ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Fornecedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedor()
    {
        return $this->hasOne(User::className(), ['id' => 'fornecedor_id']);
    }

    /**
     * Gets query for [[Instalador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstalador()
    {
        return $this->hasOne(User::className(), ['id' => 'instalador_id']);
    }
}
