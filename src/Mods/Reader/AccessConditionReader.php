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

namespace Slub\Mods\Reader;

use Slub\Mods\Element\AccessCondition;
use Slub\Mods\Utility\Query;

/**
 * Trait for reading AccessCondition element
 */
trait AccessConditionReader
{

    /**
     * Get the the array of the <accessCondition> elements.
     * @see https://www.loc.gov/standards/mods/userguide/accesscondition.html
     *
     * @access public
     *
     * @param string $query for metadata search
     *
     * @return AccessCondition[]
     */
    public function getAccessConditions(string $query = ''): array
    {
        $accessConditions = [];
        $values = $this->getValues('./mods:accessCondition' . $query);
        foreach ($values as $value) {
            $accessConditions[] = new AccessCondition($value);
        }
        return $accessConditions;
    }

    /**
     * Get the the array of the <accessCondition> elements by given parameters.
     * @see https://www.loc.gov/standards/mods/userguide/accesscondition.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     * @param array $attributes The array of attributes ['attribute' => 'value']
     * @param string $value The value for metadata search
     *
     * @return AccessCondition[]
     */
    public function getAccessConditionsByParameters(string $query = '', array $attributes = [], string $value = ''): array
    {
        $accessConditions = [];
        $query = new Query('./mods:accessCondition', $query, $attributes, $value);
        $values = $this->getValues($query->getXPath());
        foreach ($values as $value) {
            $accessConditions[] = new AccessCondition($value);
        }
        return $accessConditions;
    }

    /**
     * Get the matching <accessCondition> element.
     * @see https://www.loc.gov/standards/mods/userguide/accesscondition.html
     *
     * @access public
     *
     * @param int $index of the searched element
     * @param string $query for metadata search
     *
     * @return ?AccessCondition
     */
    public function getAccessCondition(int $index, string $query = ''): ?AccessCondition
    {
        $values = $this->getValues('./mods:accessCondition' . $query);
        if (array_key_exists($index, $values)) {
            return new AccessCondition($values[$index]);
        }
        return null;
    }

    /**
     * Get the the first matching <accessCondition> element.
     * @see https://www.loc.gov/standards/mods/userguide/accesscondition.html
     *
     * @access public
     *
     * @param string $query for metadata search
     *
     * @return ?AccessCondition
     */
    public function getFirstAccessCondition(string $query = ''): ?AccessCondition
    {
        return $this->getAccessCondition(0, $query);
    }

    /**
     * Get the the last matching <accessCondition> element.
     * @see https://www.loc.gov/standards/mods/userguide/accesscondition.html
     *
     * @access public
     *
     * @param string $query for metadata search
     *
     * @return ?AccessCondition
     */
    public function getLastAccessCondition(string $query = ''): ?AccessCondition
    {
        $elements = $this->getAccessConditions($query);
        $count = count($elements);
        if ($count > 0) {
            return $elements[$count - 1];
        }
        return null;
    }
}
