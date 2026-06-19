<?php

/**
 * Copyright (C) 2024 Saxon State and University Library Dresden
 *
 * This file is part of the php-mods-reader.
 *
 * @license GNU General Public License version 3 or later.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
namespace Slub\Mods\Utility;

use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{

    /**
     * @var mixed[]
     */
    private static array $testData = [
        'All parameters present' => [
            'query' => 'div',
            'attributes' => ['class' => 'test'],
            'value' => 'active',
            'expectedSuffix' => '[div[@class="test"]="active"]'
        ],
        'No query, attributes and value present' => [
            'query' => '',
            'attributes' => ['class' => 'test'],
            'value' => 'active',
            'expectedSuffix' => '[@class="test"]="active"'
        ],
        'Only value present' => [
            'query' => '',
            'attributes' => [],
            'value' => 'active',
            'expectedSuffix' => '="active"'
        ],
        'Only attributes present' => [
            'query' => '',
            'attributes' => ['class' => 'test'],
            'value' => '',
            'expectedSuffix' => '[@class="test"]'
        ],
        'Only query present' => [
            'query' => 'div',
            'attributes' => [],
            'value' => '',
            'expectedSuffix' => '[div]'
        ],
        'Query and value present, no attributes' => [
            'query' => 'div',
            'attributes' => [],
            'value' => 'active',
            'expectedSuffix' => '[div]="active"'
        ],
        'Query and attributes present, no value' => [
            'query' => 'div',
            'attributes' => ['class' => 'test'],
            'value' => '',
            'expectedSuffix' => '[div[@class="test"]]'
        ],
        'All optional parameters empty' => [
            'query' => '',
            'attributes' => [],
            'value' => '',
            'expectedSuffix' => ''
        ],
        'Multiple attributes present with query and value' => [
            'query' => 'div',
            'attributes' => ['class' => 'test', 'id' => 'main'],
            'value' => 'visible',
            'expectedSuffix' => '[div[@class="test" AND @id="main"]="visible"]'
        ]
    ];

    /**
     * @test
     */
    public function testConstructorAppendsCorrectXpath()
    {
        $initialXPath = '/initial/xpath';

        foreach (self::$testData as $testMessage => $testData) {
            $resultQuery = new Query($initialXPath, $testData['query'], $testData['attributes'], $testData['value']);
            self::assertSame($initialXPath . $testData['expectedSuffix'], $resultQuery->getXpath(), $testMessage);
        }
    }
}
