<?php

namespace frontend\tests\functional;

use common\models\User;
use frontend\tests\FunctionalTester;

class SignupCest
{
    protected $formId = '#form-signup';


    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/signup');
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->see('Signup', 'h1');
        $I->see('Please fill out the following fields to signup:');
        $I->submitForm($this->formId, []);
        $I->see('Username cannot be blank.');
        $I->see('Email cannot be blank.');
        $I->see('Password cannot be blank.');

    }

    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
            'SignupForm[username]'  => 'tester',
            'SignupForm[email]'     => 'ttttt',
            'SignupForm[password]'  => 'tester_password',
        ]
        );
        $I->dontSee('Username cannot be blank.');
        $I->dontSee('Password cannot be blank.');
        $I->see('Email is not a valid email address.');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->fillField(['name' => 'SignupForm[username]'], 'tester');
        $I->fillField(['name' => 'SignupForm[nome]'], 'tester hello');
        $I->fillField(['name' => 'SignupForm[email]'], 'tester.email@example.com');
        $I->fillField(['name' => 'SignupForm[password]'], 'tester_password');


        $I->selectOption(['name' => 'SignupForm[categoria_id]'], '1');
        $I->seeOptionIsSelected('SignupForm[categoria_id]', 'Canalização');
        $I->selectOption(['name' => 'SignupForm[role]'], 'fornecedor');
        $I->seeOptionIsSelected('SignupForm[role]', 'Fornecedor');

        $I->click('signup-button');

        $I->seeRecord(User::className(), [
            'username' => 'tester',
            'email' => 'tester.email@example.com',
            'status' => \common\models\User::STATUS_INACTIVE
        ]);

        $I->seeEmailIsSent();
        $I->see('Thank you for registration. Please check your inbox for verification email.');
    }
}
