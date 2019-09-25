<?php

namespace tests\models;

use app\models\Loan;
use app\models\User;
use RKD\PersonalIdCode\PersonalIdCode;

class LoanTest extends \Codeception\Test\Unit
{
    private $loan_sample;

    public function _before()
    {
        $this->loan_sample = [
            'amount' => '300.0000',
            'interest' => '15.0000',
            'duration' => '30',
            'end_date' => '2015-07-23',
            'start_date' => '2015-04-24',
            'campaign' => '3',
            'status' => '1',
        ];
    }

    public function testLoanAllowed()
    {
        $user = new User();
        $user->setAttributes(array(
            'first_name' => 'Kristina',
            'last_name' => 'Naumov',
            'email' => 'kristana@mail.ru',
            'personal_code' => '48311192221', // Age 35
            'phone' => '54622181',
            'active' => '1',
            'lang' => 'est',
        ), false);

        $this->assertTrue($user->save());

        $loan = new Loan();
        $loan->setAttributes(array_merge($this->loan_sample, ['user_id' => $user->id]), false);

        $this->assertTrue($loan->save());
    }

    public function testLoanNotAllowed()
    {
        $user = new User();
        $user->setAttributes(array(
            'first_name' => 'Svetlana',
            'last_name' => 'Borissimova',
            'email' => 'sveta@mail.ru',
            'personal_code' => '49507070247', // Age 24
            'phone' => '53877932',
            'active' => '1',
            'lang' => 'rus',
        ), false);

        $this->assertTrue($user->save());

        $loan = new Loan();
        $loan->setAttributes(array_merge($this->loan_sample, ['user_id' => $user->id]), false);

        $this->assertFalse($loan->save());
    }
}
