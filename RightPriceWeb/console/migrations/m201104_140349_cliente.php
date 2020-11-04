<?php

use yii\db\Migration;

/**
 * Class m201104_140349_cliente
 */
class m201104_140349_cliente extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cliente', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'nome' => $this->string()->notNull(),
            'Telemovel' => $this->integer(),
            'Nif' => $this->integer()->unique(),
            'Email' => $this->string()->unique(),
        ]);
        $this->createIndex(
            'idx-cliente-user_id',
            'cliente',
            'user_id'
        );
        $this->addForeignKey(
            'fk-cliente-user_id',
            'cliente',
            'user_id',
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
        echo "m201104_140349_cliente cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201104_140349_cliente cannot be reverted.\n";

        return false;
    }
    */
}
