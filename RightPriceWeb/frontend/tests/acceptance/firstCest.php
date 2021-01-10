<?php namespace frontend\tests;
use frontend\tests\AcceptanceTester;

class firstCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('site/login');
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->fillField('username', 'davert');
        $I->fillField('password', 'qwerty');
        $I->click('LOGIN');
        $I->see('Welcome, Davert!');
    }
}
