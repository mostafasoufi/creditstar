<?php
namespace tests\models;
use app\models\Auth;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = Auth::findIdentity(100));
        expect($user->username)->equals('admin');

        expect_not(Auth::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = Auth::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('admin');

        expect_not(Auth::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = Auth::findByUsername('admin'));
        expect_not(Auth::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = Auth::findByUsername('admin');
        expect_that($user->validateAuthKey('test100key'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('123456'));        
    }

}
