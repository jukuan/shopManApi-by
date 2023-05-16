<?php

declare(strict_types=1);

namespace Tests\Entity;

use Generator;
use PHPUnit\Framework\TestCase;
use ShopManApi\Entity\OfferParams;
use LireinCore\YMLParser\Offer\Param;

class OfferParamsTest extends TestCase
{
    public function offerParamsStringProvider(): Generator
    {
        yield [null, null];
        yield [[], null];
        yield [[null], null];

        yield [[(new Param())->setName('name')], null];
        yield [[(new Param())->setName('name')->setValue(null)], null];
        yield [[(new Param())->setName('name')->setValue('')], ''];
        yield [[(new Param())->setName('name')->setValue('Dummy name')], 'Dummy name'];
        yield [[(new Param())->setName('name')->setValue('42')], '42'];
        yield [[(new Param())->setName('name')->setValue(' 42')], ' 42'];
    }

    /**
     * @dataProvider offerParamsStringProvider
     */
    public function testGettingParamValueString(array|null $params, ?string $expected): void
    {
        $offerParams = new OfferParams($params);
        $this->assertSame($expected, $offerParams->getParamValue('name'));
    }


    public function offerParamsIntProvider(): Generator
    {
        yield [null, null];
        yield [[], null];
        yield [[null], null];

        yield [[(new Param())->setName('amount')], null];
        yield [[(new Param())->setName('amount')->setValue(42)], 42];
        yield [[(new Param())->setName('amount')->setValue('42')], 42];
        yield [[(new Param())->setName('amount')->setValue(' 42')], 42];
        yield [[(new Param())->setName('amount')->setValue('42abc')], 42];
    }

    /**
     * @dataProvider offerParamsIntProvider
     */
    public function testGettingParamValueInt(array|null $params, ?int $expected): void
    {
        $offerParams = new OfferParams($params);
        $this->assertSame($expected, $offerParams->getParamValueInt('amount'));
    }

    public function offerParamsBoolProvider(): Generator
    {
        yield [null, null];
        yield [[], null];
        yield [[null], null];

        yield [[(new Param())->setName('isCorrect')], null];
        yield [[(new Param())->setName('isCorrect')->setValue(null)], null];

        yield [[
            (new Param())->setName('abc')->setValue('def'),
            (new Param())->setName('isCorrect')->setValue('yes')->setUnit('item'),
            (new Param())->setName('it_is_what_it_is')->setValue('no'),
        ], true];

        yield [[(new Param())->setName('isCorrect')->setValue('да')], true];
        yield [[(new Param())->setName('isCorrect')->setValue('1')], true];
        yield [[(new Param())->setName('isCorrect')->setValue(true)], true];

        yield [[(new Param())->setName('isCorrect')->setValue('0')], false];
        yield [[(new Param())->setName('isCorrect')->setValue('нет')], false];
        yield [[(new Param())->setName('isCorrect')->setValue('no')], false];
        yield [[(new Param())->setName('isCorrect')->setValue(false)], false];
    }

    /**
     * @dataProvider offerParamsBoolProvider
     */
    public function testGettingBoolValue(array|null $params, ?bool $expected): void
    {
        $offerParams = new OfferParams($params);
        $this->assertSame($expected, $offerParams->getParamValueBool('isCorrect'));
    }
}
