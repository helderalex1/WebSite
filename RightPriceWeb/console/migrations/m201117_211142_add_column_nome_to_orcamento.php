<?php

use yii\db\Migration;

/**
 * Class m201117_211142_add_column_nome_to_orcamento
 */
class m201117_211142_add_column_nome_to_orcamento extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('orcamento', 'nome', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201117_211142_add_column_nome_to_orcamento cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201117_211142_add_column_nome_to_orcamento cannot be reverted.\n";

        return false;
    }
    */
}
