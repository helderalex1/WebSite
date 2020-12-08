<?php

use yii\db\Migration;

/**
 * Class m201104_161908_orcamento
 */
class m201104_161908_orcamento extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('orcamento', [
            'id' => $this->primaryKey(),
            'cliente_id' => $this->integer()->notNull(),
            'data_orcamento' => $this->dateTime(),
            'margem' => $this->integer(),
            'total' => $this->float(),
        ]);

        $this->createIndex(
            'idx-orcamento-cliente_id',
            'orcamento',
            'cliente_id'
        );
        $this->addForeignKey(
            'fk-orcamento-cliente_id',
            'orcamento',
            'cliente_id',
            'cliente',
            'id',
            'CASCADE'
        );
        // creates table `orcamento_produto`
        $this->createTable('orcamento_produto', [
            'orcamento_id' => $this->integer()->notNull(),
            'produto_id' => $this->integer()->notNull(),
            'quantidade' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'PRIMARY KEY(orcamento_id, produto_id)',
        ]);

        $this->createIndex(
            'idx-orcamento_produto-orcamento_id',
            'orcamento_produto',
            'orcamento_id'
        );

        $this->addForeignKey(
            'fk-orcamento_produto-orcamento_id',
            'orcamento_produto',
            'orcamento_id',
            'orcamento',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-orcamento_produto-produto_id',
            'orcamento_produto',
            'produto_id'
        );

        $this->addForeignKey(
            'fk-orcamento_produto-produto_id',
            'orcamento_produto',
            'produto_id',
            'produto',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-orcamento-obra_id',
            'orcamento'
        );

        $this->dropIndex(
            'idx-orcamento-obra_id',
            'orcamento'
        );

        $this->dropTable('orcamento');

        $this->dropForeignKey(
            'fk-orcamento_produto-orcamento_id',
            'orcamento_produto'
        );

        $this->dropIndex(
            'idx-orcamento_produto-orcamento_id',
            'orcamento_produto'
        );

        $this->dropForeignKey(
            'fk-orcamento_produto-produto_id',
            'orcamento_produto'
        );

        $this->dropIndex(
            'idx-orcamento_produto-produto_id',
            'orcamento_produto'
        );

        $this->dropTable('orcamento_produto');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201104_161908_orcamento cannot be reverted.\n";

        return false;
    }
    */
}
