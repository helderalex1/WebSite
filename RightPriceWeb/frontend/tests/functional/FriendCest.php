<?php namespace frontend\tests\functional;
use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;

class FriendCest
{

    //  APENAS A VISÃO DO INSTALADOR

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }


    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->submitForm('#login-form', [
            'LoginForm[username]'=>'erau',
            'LoginForm[password]'=>'password_0',
        ]);
        $I->see('erau' );
        $I->amOnRoute('user/view?id=1');
        $I->see('sfriesen@jenkins.info' );
    }

    // tests
    public function tryAddFriend(FunctionalTester $I)
    {
        //para adicionar um fornecedor
        $I->amOnRoute('friend/index');
        $I->see('Test');
        $I->click('Adicionar','#Test');
        $I->click('As suas conexoes');
        $I->amOnRoute('friend/view');
        $I->see('Test');
    }

    public function tryRemoveFriend(FunctionalTester $I)
    {
        //para remover um fornecedor
        $this->tryAddFriend($I);
        $I->amOnRoute('friend/view');
        $I->see('Test');
        $I->click('Remover','#Test');
        $I->click('Adicionar Fornecedores');
        $I->see('Test');
    }
}
