<?php namespace frontend\tests;

use common\fixtures\ClienteFixture;
use common\fixtures\OrcamentoProdutoFixture;
use common\fixtures\ProdutoFixture;
use common\fixtures\UserFixture;
use common\models\Cliente;
use common\models\Orcamento;
use common\models\OrcamentoProduto;

class OrcamentoTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected $orcamento;
    
    protected function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'cliente' => [
                'class' => ClienteFixture::className(),
                'dataFile' => codecept_data_dir() . 'clientes.php'
            ],
            'produto' =>[
                'class' => ProdutoFixture::classname(),
                'dataFile' => codecept_data_dir() . 'produtos.php'
            ],
        ]);
    }

    protected function _after()
    {
        Orcamento::deleteAll();
    }

    // tests
    public function testOrcamentoSave()
    {
        //valida a inserçao na DB
        $orcamento = new Orcamento();
        $this->assertFalse($orcamento->validate());

        $orcamento->nome = 'moradia leiria';
        $orcamento->cliente_id = 2;
        $this->assertTrue($orcamento->validate());

        $this->assertTrue($orcamento->save());

        $this->tester->seeRecord(Orcamento::className(),['nome'=>'moradia leiria']);
    }

    public function testOrcamentoTestOwner()
    {
        // esta função testa que o dono deste orçamento é o utilizador 2
        // sabendo que o utilizador 2 criou o cliente 2
        $orcamento = new Orcamento();
        $orcamento->cliente_id = 2;

        $this->assertTrue($orcamento->save());
        $this->assertEquals('2', $orcamento->getOwner());
    }

    public function testOrcamentoTotal()
    {
        // esta função testa o total do orcamento Aplicando as margens do orcamento
        $orcamento = new Orcamento();
        $orcamento->cliente_id = 2;
        $orcamento->margem = 1;
        $orcamento->nome = 'moradia';
        $this->assertTrue($orcamento->save());
        $this->tester->seeRecord(Orcamento::className(),['nome'=>'moradia']);

        //Adicionar 1 produto
        $orcProd = new OrcamentoProduto();

        $orcProd->orcamento_id = $orcamento['id'];
        $orcProd->produto_id = 1;
        $orcProd->quantidade = 1;
        $this->assertTrue($orcProd->save());
        $this->tester->seeRecord(OrcamentoProduto::className(),['orcamento_id'=>$orcamento['id'],'produto_id' => '1']);

        $this->assertEquals('10.1', $orcamento->getTotal());

        $orcProd->orcamento_id = $orcamento['id'];
        $orcProd->produto_id = 2;
        $orcProd->quantidade = 2;
        $this->assertTrue($orcProd->save());
        $this->tester->seeRecord(OrcamentoProduto::className(),['orcamento_id'=>$orcamento['id'],'produto_id' => '2']);

        //$this->tester->seeInDatabase('orcamento_produto', ['orcamento_id' => $orcamento['id'],'produto_id' => '2']);

        $this->assertEquals('20.301000000000002', $orcamento->getTotal());
    }

}