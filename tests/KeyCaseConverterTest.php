<?php

namespace TomLerendu\LaravelConvertCaseMiddleware\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TomLerendu\LaravelConvertCaseMiddleware\KeyCaseConverter;

class KeyCaseConverterTest extends TestCase
{
    /**
     * @test
     */
    public function itThrowsAnInvalidArgumentExceptionWhenCaseIsInvalid()
    {
        $this->expectException(InvalidArgumentException::class);

        (new KeyCaseConverter())->convert(
            'invalid',
            ['test' => 'data']
        );
    }

    /**
     * @test
     * @dataProvider provider
     * @param $input
     * @param $output
     * @param $case
     */
    public function itCanConvertToCamelCase(array $input, array $output, string $case)
    {
        $array = (new KeyCaseConverter())->convert(
            $case,
            $input
        );

        $this->assertEquals($output, $array);
    }

    public function provider()
    {
        return [
            [
                ['one_key' => 'value'],
                ['oneKey' => 'value'],
                KeyCaseConverter::CASE_CAMEL,
            ],
            [
                ['test_1' => 1, 'test_2' => 2, 'inner' => ['inner_test' => 'inner_test']],
                ['test1' => 1, 'test2' => 2, 'inner' => ['innerTest' => 'inner_test']],
                KeyCaseConverter::CASE_CAMEL,
            ],
            [
                ['testOne' => 1, 'testTwo' => 2, 'inner' => ['innerTest' => 'inner_test']],
                ['test_one' => 1, 'test_two' => 2, 'inner' => ['inner_test' => 'inner_test']],
                KeyCaseConverter::CASE_SNAKE,
            ],
            [
                [],
                [],
                KeyCaseConverter::CASE_SNAKE,
            ],
            [
                ['no' => 'change'],
                ['no' => 'change'],
                KeyCaseConverter::CASE_SNAKE,
            ],
        ];
    }
}
