<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('Right Price');

        $I->seeLink('Contact');
        $I->click('Contact');
        $I->wait(2); // wait for page to be opened

        $I->see('If you have business');
    }
}
