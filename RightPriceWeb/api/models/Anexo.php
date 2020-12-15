<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anexo".
 *
 * @property int $id
 * @property int $orcamento_id
 * @property string $nome
 * @property resource|null $imagem
 *
 * @property Orcamento $orcamento
 */
class Anexo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anexo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orcamento_id', 'nome'], 'required'],
            [['orcamento_id'], 'integer'],
            [['imagem'], 'string'],
            [['nome'], 'string', 'max' => 255],
            [['orcamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orcamento::className(), 'targetAttribute' => ['orcamento_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orcamento_id' => 'Orcamento ID',
            'nome' => 'Nome',
            'imagem' => 'Imagem',
        ];
    }

    /**
     * Gets query for [[Orcamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrcamento()
    {
        return $this->hasOne(Orcamento::className(), ['id' => 'orcamento_id']);
    }
}
