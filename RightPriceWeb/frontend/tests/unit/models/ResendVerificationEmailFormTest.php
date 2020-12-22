<?php

namespace frontend\tests\unit\models;


use Codeception\Test\Unit;
use common\fixtures\UserFixture;
use frontend\models\ResendVerificationEmailForm;

class ResendVerificationEmailFormTest extends Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    public function testWrongEmailAddress()
    {
        $model = new ResendVerificationEmailForm();
        $model->attributes = [
            'email' => 'aaa@bbb.cc'
        ];

        expect($model->validate())->false();
        expect($model->hasErrors())->true();
        expect($model->getFirstError('email'))->equals('There is no user with this email address.');
    }

    public function testEmptyEmailAddress()
    {
        $model = new ResendVerificationEmailForm();
        $model->attributes = [
            'email' => ''
        ];

        expect($model->validate())->false();
        expect($model->hasErrors())->true();
        expect($model->getFirstError('email'))->equals('Email cannot be blank.');
    }

    public function testResendToActiveUser()
    {
        $model = new ResendVerificationEmailForm();
        $model->attributes = [
            'email' => 'test2@mail.com'
        ];

        expect($model->validate())->false();
        expect($model->hasErrors())->true();
        expect($model->getFirstError('email'))->equals('There is no user with this email address.');
    }

}
