<?php namespace App\Tests;
use App\Tests\AcceptanceTester;

class FirstCest
{
    public function firstContent(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Attendance List System');
    }



}
