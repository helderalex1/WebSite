<?php

use yii\db\Migration;

/**
 * Class m201104_161522_produto
 */
class m201104_161522_produto extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('produto', [
            'id' => $this->primaryKey(),
            'fornecedor_id' => $this->integer()->notNull(),
            'nome' => $this->string()->notNull(),
            'referencia' => $this->string()->notNull(),
            'descricao' => $this->string(),
            'preco' => $this->float(),
        ]);
        $this->createIndex(
            'idx-produto-fornecedor_id',
            'produto',
            'fornecedor_id'
        );
        $this->addForeignKey(
            'fk-produto-fornecedor_id',
            'produto',
            'fornecedor_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201104_161522_produto cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201104_161522_produto cannot be reverted.\n";

        return false;
    }
    */
}
