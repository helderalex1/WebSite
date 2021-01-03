<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class FriendCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->submitForm('#login-form', [
            'LoginForm[username]'=>'marcos',
            'LoginForm[password]'=>'12345678',
        ]);
        $I->see('marcos' );
    }

    // tests
    public function tryAddFriend(FunctionalTester $I)
    {
        //para adicionar um fornecedor
        $I->amOnRoute('friend');
        $I->see('Helder');
        $I->click('Adicionar','#Helder');
        $I->click('As suas conexoes');
        $I->amOnRoute('friend/view');
        $I->see('Helder');
    }

    public function tryRemoveFriend(FunctionalTester $I)
    {
        //para remover um fornecedor
        $this->tryAddFriend($I);
        $I->amOnRoute('friend/view');
        $I->see('Helder');
        $I->click('Remover','#Helder');
        $I->click('Adicionar Fornecedores');
        $I->see('Helder');
    }
}
