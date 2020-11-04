<?php

use yii\db\Migration;

/**
 * Class m201104_153933_anexo
 */
class m201104_153933_anexo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('anexo', [
            'id' => $this->primaryKey(),
            'obra_id' => $this->integer()->notNull(),
            'nome' => $this->string()->notNull(),
            'imagem' => $this->binary(),
        ]);

        $this->createIndex(
            'idx-anexo-obra_id',
            'anexo',
            'obra_id'
        );
        $this->addForeignKey(
            'fk-anexo-obra_id',
            'anexo',
            'obra_id',
            'obra',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201104_153933_anexo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201104_153933_anexo cannot be reverted.\n";

        return false;
    }
    */
}
