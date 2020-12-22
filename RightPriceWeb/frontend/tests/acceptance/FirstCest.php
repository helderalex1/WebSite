<?php namespace frontend\tests\acceptance;
use frontend\tests\AcceptanceTester;

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->wait(2);
        $I->see('A NOSSA EQUIPA');
    }
}
