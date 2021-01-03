<?php namespace frontend\tests;

use common\fixtures\UserFixture;
use common\models\FornecedorInstalador;

class FriendTest extends \Codeception\Test\Unit
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
        FornecedorInstalador::deleteAll();
    }

    // tests
    public function testAddFriend()
    {
        $fornecedor = $this->tester->grabFixture('user', 0);
        $instalador = $this->tester->grabFixture('user', 1);

        //valida se os ID dos users sao diferentes
        $friend = new FornecedorInstalador();
        $friend->fornecedor_id = $instalador['id'];
        $friend->instalador_id = $instalador['id'];
        $this->assertFalse($friend->save());

        //valida se os campos estão preenchidos incorretamente
        $friend->fornecedor_id = null;
        $this->assertFalse($friend->save());


        //valida se os campos estão preenchidos corretamente
        $friend->fornecedor_id = $fornecedor['id'];
        $this->assertTrue($friend->save());

        //valida se já não existe uma inserção igual
        $friendCopy = new FornecedorInstalador();
        $friendCopy->fornecedor_id = $fornecedor['id'];
        $friendCopy->instalador_id = $instalador['id'];
        $this->assertFalse($friendCopy->save());
    }
}