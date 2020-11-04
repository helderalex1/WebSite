<?php

use yii\db\Migration;

/**
 * Class m130524_162723_categoria
 */
class m130524_162723_categoria extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categoria', [
            'id' => $this->primaryKey(),
            'nome_Categoria' => $this->string()->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m130524_162723_categoria cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m130524_162723_categoria cannot be reverted.\n";

        return false;
    }
    */
}
