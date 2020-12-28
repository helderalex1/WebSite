<?php namespace frontend\tests;

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

    }

    protected function _after()
    {
    }

    // tests
    public function testModel()
    {
        $cliente = new Cliente();
        $cliente->nome = null;
        $this->assertFalse($cliente->validate(['nome']));
        $cliente->nome = 'tooolllooonnggggnaaaammmmmmmeeeee';
        $this->assertFalse($cliente->validate(['nome']));
        $cliente->nome = 'dave';
        $this->assertTrue($cliente->validate(['nome']));

        $cliente->Email = 'dave.com';
        $this->assertFalse($cliente->validate(['Email']));

        $cliente->Email = 'dave@mail.com';
        $this->assertTrue($cliente->validate(['Email']));

        $cliente->Nif = '1234567890';
        $this->assertFalse($cliente->validate(['Nif']));

        $cliente->Nif = '123456789';
        $this->assertTrue($cliente->validate(['Nif']));
    }

    public function testDb(){
        $user = $this->make(User::class, ['find' => new User]);
        $cliente = new Cliente();
        $cliente->nome = 'Miles';
        $cliente->Email = 'miles@email.com';
        $cliente->Nif = '123456789';
        $this->assertFalse($cliente->save());
        $cliente->user_id = 1;
        $this->assertTrue($cliente->save());
        $this->tester->seeRecord(Cliente::className(),['nome'=> 'Miles']);
    }
}