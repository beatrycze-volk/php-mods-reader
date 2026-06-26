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

use Slub\Mods\Element\Classification;
use Slub\Mods\Utility\Query;

/**
 * Trait for reading Classification element
 */
trait ClassificationReader
{
    /**
     * Get the array of the <classification> elements.
     * @see https://www.loc.gov/standards/mods/userguide/classification.html
     *
     * @access public
     *
     * @param string $query for metadata search
     *
     * @return Classification[]
     */
    public function getClassifications(string $query = ''): array
    {
        return $this->getClassificationElements('./mods:classification' . $query);
    }

    /**
     * Get the array of the <classification> elements by parameters.
     * @see https://www.loc.gov/standards/mods/userguide/classification.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     * @param array $attributes The array of attributes ['attribute' => 'value']
     * @param string $value The value for metadata search
     *
     * @return Classification[]
     */
    public function getClassificationsByParameters(string $query = '', array $attributes = [], string $value = ''): array
    {
        $query = new Query('./mods:classification', $query, $attributes, $value);
        return $this->getClassificationElements($query->getXPath());
    }

    /**
     * Get the matching <classification> element.
     * @see https://www.loc.gov/standards/mods/userguide/classification.html
     *
     * @access public
     *
     * @param int $index of the searched element
     * @param string $query for metadata search
     *
     * @return ?Classification
     */
    public function getClassification(int $index, string $query = ''): ?Classification
    {
        $values = $this->getValues('./mods:classification' . $query);
        if (array_key_exists($index, $values)) {
            return new Classification($values[$index]);
        }
        return null;
    }

    /**
     * Get the first matching <classification> element.
     * @see https://www.loc.gov/standards/mods/userguide/classification.html
     *
     * @access public
     *
     * @param string $query for metadata search
     *
     * @return ?Classification
     */
    public function getFirstClassification(string $query = ''): ?Classification
    {
        return $this->getClassification(0, $query);
    }

    /**
     * Get the last matching <classification> element.
     * @see https://www.loc.gov/standards/mods/userguide/classification.html
     *
     * @access public
     *
     * @param string $query for metadata search
     *
     * @return ?Classification
     */
    public function getLastClassification(string $query = ''): ?Classification
    {
        $elements = $this->getClassifications($query);
        $count = count($elements);
        if ($count > 0) {
            return $elements[$count - 1];
        }
        return null;
    }

    /**
     * Get the array of the <classification> elements.
     * @see https://www.loc.gov/standards/mods/userguide/classification.html
     *
     * @access public
     *
     * @param string $xpath The XPath query for metadata search
     *
     * @return Classification[]
     */
    private function getClassificationElements(string $xpath): array
    {
        $classifications = [];
        $values = $this->getValues($xpath);
        foreach ($values as $value) {
            $classifications[] = new Classification($value);
        }
        return $classifications;
    }
}
