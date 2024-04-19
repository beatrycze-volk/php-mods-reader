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

/**
 * Query class for the 'php-mods-reader' library.
 *
 * @access public
 */
class Query
{

    /**
     * @access private
     * @var string The query
     **/
    private $xPath;

    /**
     * This creates the query eq. './xyz[@att="zty"]="vcx"'.
     *
     * @access public
     *
     * @param string $xpath The base XPath for element
     * @param string $query The XPath query for metadata search
     * @param array $attributes The array of attributes ['attribute' => 'value']
     * @param string $value The value for metadata search
     *
     * @return void
     */
    public function __construct(string $xpath, string $query = '', array $attributes = [], string $value = '')
    {
        if (!empty($query) && !empty($attributes) && !empty($value)) {
            $xpath .= '[' . $query . '[' . $this->getParsedAttributes($attributes) .']="' . $value .'"]';
        } else if (empty($query) && !empty($attributes) && !empty($value)) {
            $xpath .= '[' . $this->getParsedAttributes($attributes) .']="' . $value .'"';
        } else if (empty($query) && empty($attributes) && !empty($value)) {
            $xpath .= '="' . $value.'"';
        } else if (empty($query) && !empty($attributes) && empty($value)) {
            $xpath .= '[' . $this->getParsedAttributes($attributes) .']';
        } else if (!empty($query) && empty($attributes) && empty($value)) {
            $xpath .= '[' . $query .']';
        } else if (!empty($query) && empty($attributes) && !empty($value)) {
            $xpath .= '[' . $query .']="' . $value .'"';
        } else if (!empty($query) && !empty($attributes) && empty($value)) {
            $xpath .= '[' . $query .'[' . $this->getParsedAttributes($attributes) . ']]';
        }

        $this->xPath = $xpath;
    }

    public function getXPath(): string
    {
        var_dump($this->xPath);
        return $this->xPath;
    }

    private function getParsedAttributes(array $attributes): string
    {
        $parsedAttributes = '';

        $amountAttributes = count($attributes);

        if ($amountAttributes == 1) {
            foreach ($attributes as $key => $value) {
                $parsedAttributes .= '@' . $key . '="' . $value . '"';
            }
        } else {
            $i = 0;
            $lastIndex = $amountAttributes - 1;

            foreach ($attributes as $key => $value) {
                $parsedAttributes .= '@' . $key . '="' . $value . '"';
                if ($i < $lastIndex) {
                    $parsedAttributes .= ' AND ';
                }
                $i++;
            }
        }

        return $parsedAttributes;
    }
}
