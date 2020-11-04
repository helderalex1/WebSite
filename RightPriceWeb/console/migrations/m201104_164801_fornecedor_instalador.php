<?php

use yii\db\Migration;

/**
 * Class m201104_164801_fornecedor_instalador
 */
class m201104_164801_fornecedor_instalador extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('fornecedor_instalador', [
            'fornecedor_id' => $this->integer()->notNull(),
            'instalador_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'PRIMARY KEY(fornecedor_id, instalador_id)',
        ]);

        $this->createIndex(
            'idx-fornecedor_instalador-fornecedor_id',
            'fornecedor_instalador',
            'fornecedor_id'
        );

        $this->addForeignKey(
            'fk-fornecedor_instalador-fornecedor_id',
            'fornecedor_instalador',
            'fornecedor_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-fornecedor_instalador-instalador_id',
            'fornecedor_instalador',
            'instalador_id'
        );

        $this->addForeignKey(
            'fk-fornecedor_instalador-instalador_id',
            'fornecedor_instalador',
            'instalador_id',
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
        $this->dropForeignKey(
            'fk-fornecedor_instalador-fornecedor_id',
            'fornecedor_instalador'
        );
        $this->dropIndex(
            'idx-fornecedor_instalador-fornecedor_id',
            'fornecedor_instalador'
        );
        $this->dropForeignKey(
            'fk-fornecedor_instalador-instalador_id',
            'fornecedor_instalador'
        );
        $this->dropIndex(
            'idx-fornecedor_instalador-instalador_id',
            'fornecedor_instalador'
        );
        $this->dropTable('fornecedor_instalador');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201104_164801_fornecedor_instalador cannot be reverted.\n";

        return false;
    }
    */
}
