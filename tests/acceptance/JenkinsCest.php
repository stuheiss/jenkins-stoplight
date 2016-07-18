<?php


class JenkinsCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function hello(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('hello hello!');
        $I->amOnPage('/greet/');
        $I->see('hello stranger');
        $I->amOnPage('/greet/__tester__');
        $I->see('hello __tester__');
    }
    public function jenkins(AcceptanceTester $I)
    {
        $I->amOnPage('/jenkins');
        $I->see('Updated');
        $I->see('bld');
    }
}
