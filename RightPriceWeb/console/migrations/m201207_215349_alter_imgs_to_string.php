<?php

use yii\db\Migration;

/**
 * Class m201207_215349_alter_imgs_to_string
 */
class m201207_215349_alter_imgs_to_string extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'imagem', $this->string(250));
        $this->alterColumn('produto', 'imagem', $this->string(250));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201207_215349_alter_imgs_to_string cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201207_215349_alter_imgs_to_string cannot be reverted.\n";

        return false;
    }
    */
}
