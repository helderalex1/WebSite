<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produto".
 *
 * @property int $id
 * @property int $fornecedor_id
 * @property resource|null $imagem
 * @property string $nome
 * @property string $referencia
 * @property string|null $descricao
 * @property float|null $preco
 *
 * @property OrcamentoProduto[] $orcamentoProdutos
 * @property Orcamento[] $orcamentos
 * @property User $fornecedor
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fornecedor_id', 'nome', 'referencia'], 'required'],
            [['fornecedor_id'], 'integer'],
            [['imagem'], 'string'],
            [['preco'], 'number'],
            [['nome', 'referencia', 'descricao'], 'string', 'max' => 255],
            [['fornecedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fornecedor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fornecedor_id' => 'Fornecedor ID',
            'imagem' => 'Imagem',
            'nome' => 'Nome',
            'referencia' => 'Referencia',
            'descricao' => 'Descricao',
            'preco' => 'Preco',
        ];
    }

    /**
     * Gets query for [[OrcamentoProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrcamentoProdutos()
    {
        return $this->hasMany(OrcamentoProduto::className(), ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Orcamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrcamentos()
    {
        return $this->hasMany(Orcamento::className(), ['id' => 'orcamento_id'])->viaTable('orcamento_produto', ['produto_id' => 'id']);
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
}
