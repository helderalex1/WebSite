<?php

use yii\db\Migration;

/**
 * Class m201104_144738_obra
 */
class m201104_144738_obra extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('obra', [
            'id' => $this->primaryKey(),
            'cliente_id' => $this->integer()->notNull(),
            'nome' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-obra-cliente_id',
            'obra',
            'cliente_id'
        );

        $this->addForeignKey(
            'fk-obra-cliente_id',
            'obra',
            'cliente_id',
            'cliente',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201104_144738_obra cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201104_144738_obra cannot be reverted.\n";

        return false;
    }
    */
}
