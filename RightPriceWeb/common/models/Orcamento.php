<?php

namespace common\models;

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
            [['cliente_id'], 'required'],
            [['cliente_id', 'margem'], 'integer'],
            ['margem', 'integer','max' =>'100', 'min'=>'0'],
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
     * Gets query for [[Obra]].
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
    public function getProdutosQuantidade()
    {
         $produtos = $this->hasMany(Produto::className(), ['id' => 'produto_id'])->viaTable('orcamento_produto', ['orcamento_id' => 'id']);
         $produtos = $produtos->asArray()->all();
         foreach ( $produtos as $produto){
             $produto["quantidade"] = OrcamentoProduto::find()->where(['orcamento_id' =>$this['id'], 'produto_id' =>$produto['id']])->select(['quantidade'])->asArray()->all();
         }
        return $produtos;
    }

    public function getOwner()
    {
        $cliente = $this->getCliente()->select(['user_id'])->asArray()->all();
        return $cliente[0]['user_id'];
    }

    public function getTotal()
    {
        foreach ($this->getProdutos()->asArray()->all() as $produto){
            $preco = Produto::findOne($produto["id"])->preco;
            $quantidade = $this->getOrcamentoProdutos()->where(['produto_id'=> $produto["id"]])->select('quantidade')->asArray()->all();
            $this->total += $quantidade[0]["quantidade"] * $preco;
        }
        $this->total = $this->total * (1+($this->margem/100));
        return $this->total ;
    }

}
