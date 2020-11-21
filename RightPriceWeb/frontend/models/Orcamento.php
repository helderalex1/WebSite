<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orcamento".
 *
 * @property int $id
 * @property int $obra_id
 * @property string|null $data_orcamento
 * @property int|null $margem
 * @property float|null $total
 * @property string|null $nome
 *
 * @property Obra $obra
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
            [['obra_id'], 'required'],
            [['obra_id', 'margem'], 'integer'],
            [['data_orcamento'], 'safe'],
            [['total'], 'number'],
            [['nome'], 'string', 'max' => 255],
            [['obra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Obra::className(), 'targetAttribute' => ['obra_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'obra_id' => 'Obra ID',
            'data_orcamento' => 'Data Orcamento',
            'margem' => 'Margem',
            'total' => 'Total',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Obra]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObra()
    {
        return $this->hasOne(Obra::className(), ['id' => 'obra_id']);
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
