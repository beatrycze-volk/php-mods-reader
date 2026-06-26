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

use Slub\Mods\Element\AbstractElement;
use Slub\Mods\Element\Xml\Element;
use Slub\Mods\Utility\Query;

/**
 * Trait for reading Abstract element
 */
trait AbstractReader
{

    /**
     * Get the value of the <abstract> element.
     * @see https://www.loc.gov/standards/mods/userguide/abstract.html
     *
     * @access public
     *
     * @param string $query for metadata search
     *
     * @return ?AbstractElement
     */
    public function getAbstract(string $query = ''): ?AbstractElement
    {
        return $this->getAbstractElement('./mods:abstract' . $query);
    }

    /**
     * Get the value of the <abstract> element by given parameters.
     * @see https://www.loc.gov/standards/mods/userguide/abstract.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     * @param array $attributes The array of attributes ['attribute' => 'value']
     * @param string $value The value for metadata search
     *
     * @return ?AbstractElement
     */
    public function getAbstractByParameters(string $query = '', array $attributes = [], string $value = ''): ?AbstractElement
    {
        $query = new Query('./mods:abstract', $query, $attributes, $value);
        return $this->getAbstractElement($query->getXPath());
    }

    /**
     * Get the value of the <abstract> element by given XPath.
     * @see https://www.loc.gov/standards/mods/userguide/abstract.html
     *
     * @access private
     *
     * @param string $xpath The XPath query for metadata search
     *
     * @return ?AbstractElement
     */
    private function getAbstractElement(string $xpath): ?AbstractElement
    {
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            return new AbstractElement($element->getFirstValue());
        }
        return null;
    }
}
