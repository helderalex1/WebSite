<?php namespace frontend\tests\functional;
use common\fixtures\UserFixture;
use common\models\Produto;
use common\models\User;
use frontend\tests\FunctionalTester;

class ProdutosCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
            'produtos' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'produtos.php',
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->submitForm('#login-form', [
            'LoginForm[username]'=>'helder',
            'LoginForm[password]'=>'12345678',
        ]);
        $I->see('helder' );
        $I->amOnRoute('user/view?id=3');
        $I->see('helder@mail.com' );
    }

    // tests
    public function tryAddProduto(FunctionalTester $I)
    {
        $I->amOnRoute('produto/create');
        $I->see('Create Produto');
        $I->fillField(['name' => 'Produto[nome]'], 'produto-teste');
        $I->fillField(['name' => 'Produto[referencia]'], 'teste');
        $I->fillField(['name' => 'Produto[descricao]'], 'teste');
        $I->fillField(['name' => 'Produto[preco]'], '2');
        $I->attachFile('#produto-imagem', 'default.png');
        //$I->fillField(['name' => 'Produto[imagem]', 'type'=>'file' ], 'default.png');
        $I->click('Save');

        $I->dontSee('Erro ao inserir! ( Imagem Inválida )');

        $I->seeRecord(Produto::className(), [
            'referencia' => 'teste',
        ]);

    }

    // A função UNLINK está a causar problemas por as FIXTURES nao guardarem a imagem localmente, pelo que a funcção nao consegue encontrar o ficheiro

    /*public function tryUpdateProduto(FunctionalTester $I)
    {

        $this->tryAddProduto($I);
        $produto= Produto::find()->where(['referencia' =>'teste'])->asArray()->all();
        $I->amOnRoute('produto/index');
        $I->see('teste');
        $I->amOnRoute('produto/update?id='.$produto[0]['id'] . '');
        $I->see('Update Produto: produto-teste');
        $I->fillField(['name' => 'Produto[referencia]'], 'teste-update');
        $I->attachFile('#produto-imagem', 'default.png');
        $I->click('Save');
        $I->dontSee('Erro ao inserir! ( Imagem Inválida )');

        $I->seeRecord(Produto::className(), [
            'referencia' => 'teste-update',
        ]);
    }*/
}
