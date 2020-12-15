<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orcamento_produto".
 *
 * @property int $orcamento_id
 * @property int $produto_id
 * @property int $quantidade
 * @property string|null $created_at
 *
 * @property Orcamento $orcamento
 * @property Produto $produto
 */
class OrcamentoProduto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orcamento_produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orcamento_id', 'produto_id', 'quantidade'], 'required'],
            [['orcamento_id', 'produto_id', 'quantidade'], 'integer'],
            [['orcamento_id', 'produto_id'], 'unique', 'targetAttribute' => ['orcamento_id', 'produto_id']],
            [['orcamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orcamento::className(), 'targetAttribute' => ['orcamento_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::className(), 'targetAttribute' => ['produto_id' => 'id']],
            [['quantidade'], 'integer','max' =>'100', 'min'=>'1'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orcamento_id' => 'Orcamento ID',
            'produto_id' => 'Produto ID',
            'quantidade' => 'Quantidade',
            'created_at' => 'Created At',
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

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::className(), ['id' => 'produto_id']);
    }
}
