<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obra".
 *
 * @property int $id
 * @property int $cliente_id
 * @property string $nome
 *
 * @property Anexo[] $anexos
 * @property Cliente $cliente
 * @property Orcamento[] $orcamentos
 */
class Obra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_id', 'nome'], 'required'],
            [['cliente_id'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['cliente_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente_id' => 'Cliente ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Anexos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnexos()
    {
        return $this->hasMany(Anexo::className(), ['obra_id' => 'id']);
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['id' => 'cliente_id']);
    }

    /**
     * Gets query for [[Orcamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrcamentos()
    {
        return $this->hasMany(Orcamento::className(), ['obra_id' => 'id']);
    }
}
