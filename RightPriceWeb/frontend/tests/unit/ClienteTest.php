<?php namespace frontend\tests;

use common\fixtures\UserFixture;
use common\models\Cliente;
use common\models\User;

class ClienteTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    protected function _after()
    {
    }

    // tests
    public function testModel()
    {
        $user = $this->tester->grabFixture('user', 0);
        $cliente = new Cliente();
        $cliente->user_id = $user['id'];
        $cliente->nome = null;
        $this->assertFalse($cliente->validate(['nome']));
        $cliente->nome = 'tooolllooonnggggnaaaammmmmmmeeeee';
        $this->assertFalse($cliente->validate(['nome']));
        $cliente->nome = 'dave';
        $this->assertTrue($cliente->validate(['nome']));

        //validar email errado
        $cliente->Email = 'dave.com';
        $this->assertFalse($cliente->validate(['Email']));

        //validar email correto
        $cliente->Email = 'dave@mail.com';
        $this->assertTrue($cliente->validate(['Email']));

        //validar nif incorreto
        $cliente->Nif = '1234567890';
        $this->assertFalse($cliente->validate(['Nif']));

        //validar nif correto
        $cliente->Nif = '123456789';
        $this->assertTrue($cliente->validate(['Nif']));

        $this->assertTrue($cliente->validate());

        $this->assertTrue($cliente->save());

        $this->tester->seeRecord(Cliente::className(),['nome'=>'dave']);
    }
}