<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orcamento".
 *
 * @property int $id
 * @property int $cliente_id
 * @property string|null $data_orcamento
 * @property int|null $margem
 * @property float|null $total
 * @property string|null $nome
 *
 * @property Anexo[] $anexos
 * @property Cliente $cliente
 * @property OrcamentoProduto[] $orcamentoProdutos
 * @property Produto[] $produtos
 */
class Orcamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orcamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_id'], 'required'],
            [['cliente_id', 'margem'], 'integer'],
            [['data_orcamento'], 'safe'],
            [['total'], 'number'],
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
            'data_orcamento' => 'Data Orcamento',
            'margem' => 'Margem',
            'total' => 'Total',
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
        return $this->hasMany(Anexo::className(), ['orcamento_id' => 'id']);
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
     * Gets query for [[OrcamentoProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrcamentoProdutos()
    {
        return $this->hasMany(OrcamentoProduto::className(), ['orcamento_id' => 'id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::className(), ['id' => 'produto_id'])->viaTable('orcamento_produto', ['orcamento_id' => 'id']);
    }
}
