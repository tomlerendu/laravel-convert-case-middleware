<?php

namespace TomLerendu\LaravelConvertCaseMiddleware\Tests;

use PHPUnit\Framework\TestCase;
use TomLerendu\LaravelConvertCaseMiddleware\ConvertToCase;

class ConvertToCaseTest extends TestCase
{
    /**
     * @test
     * @dataProvider provider
     */
    public function itCanConvertToCamelCase($input, $output, $case)
    {
        $class = new class extends ConvertToCase { };

        $array = $class->convertKeysToCase(
            $case,
            $input,
        );

        $this->assertEquals($output, $array);
    }

    public function provider()
    {
        return [
            [
                ['one_key' => 'value'],
                ['oneKey' => 'value'],
                ConvertToCase::CASE_CAMEL,
            ],
            [
                ['test_1' => 1, 'test_2' => 2, 'inner' => ['inner_test' => 'inner_test']],
                ['test1' => 1, 'test2' => 2, 'inner' => ['innerTest' => 'inner_test']],
                ConvertToCase::CASE_CAMEL,
            ],
            [
                ['testOne' => 1, 'testTwo' => 2, 'inner' => ['innerTest' => 'inner_test']],
                ['test_one' => 1, 'test_two' => 2, 'inner' => ['inner_test' => 'inner_test']],
                ConvertToCase::CASE_SNAKE,
            ],
            [
                [],
                [],
                ConvertToCase::CASE_SNAKE,
            ],
            [
                ['no' => 'change'],
                ['no' => 'change'],
                ConvertToCase::CASE_SNAKE,
            ],
        ];
    }
}
