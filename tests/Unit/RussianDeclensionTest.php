<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\RussianDeclension;

class RussianDeclensionTest extends TestCase
{
    public function test_genitive_for_tabata_and_acronym()
    {
        $this->assertEquals('Табаты', RussianDeclension::toGenitive('Табата'));
        $this->assertEquals('TRX', RussianDeclension::toGenitive('TRX'));
    }

    public function test_prepositional_and_genitive_for_ploskiy()
    {
        $this->assertEquals('Плоском', RussianDeclension::toPrepositional('Плоский'));
        $this->assertEquals('Плоского', RussianDeclension::toGenitive('Плоский'));
    }
}
