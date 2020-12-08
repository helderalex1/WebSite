<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'nome' => $this->string(),
            'nome_empresa' => $this->string(),
            'telemovel' => $this->integer(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'imagem' => $this->binary(),
            'categoria_id' => $this->integer()->notNull(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ], $tableOptions);

        $this->createIndex(
            'idx-user-categoria_id',
            'user',
            'categoria_id'
        );
        $this->addForeignKey(
            'fk-user-categoria_id',
            'user',
            'categoria_id',
            'categoria',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
