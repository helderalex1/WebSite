<?php

use yii\db\Migration;

/**
 * Class m201104_163933_anexo
 */
class m201104_163933_anexo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('anexo', [
            'id' => $this->primaryKey(),
            'orcamento_id' => $this->integer()->notNull(),
            'nome' => $this->string()->notNull(),
            'imagem' => $this->binary(),
        ]);

        $this->createIndex(
            'idx-anexo-orcamento_id',
            'anexo',
            'orcamento_id'
        );
        $this->addForeignKey(
            'fk-anexo-orcamento_id',
            'anexo',
            'orcamento_id',
            'orcamento',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201104_163933_anexo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201104_163933_anexo cannot be reverted.\n";

        return false;
    }
    */
}
