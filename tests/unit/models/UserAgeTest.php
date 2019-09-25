<?php

namespace tests\models;

use app\models\Auth;
use RKD\PersonalIdCode\PersonalIdCode;

class UserAgeTest extends \Codeception\Test\Unit
{
    private $personal_code;

    public function _before()
    {
        $this->personal_code = new PersonalIdCode(49005025465);
    }

    public function testInitPersonalIDClass()
    {
        $this->assertInstanceOf(PersonalIdCode::class, $this->personal_code);
    }

    public function testCalculationAge()
    {
        $this->assertEquals(29, $this->personal_code->getAge());
    }
}
