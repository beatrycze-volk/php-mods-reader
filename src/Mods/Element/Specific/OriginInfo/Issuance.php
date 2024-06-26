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

namespace Slub\Mods\Element\Specific\OriginInfo;

use Slub\Mods\Element\Common\BaseElement;

/**
 * Issuance MODS metadata element class for the 'php-mods-reader' library.
 *
 * @access public
 */
class Issuance extends BaseElement
{

    /**
     * @access private
     * @var array
     */
    private array $allowedValues = [
        'monographic',
        'single unit',
        'multipart monograph',
        'continuing',
        'serial',
        'integrating resource'
    ];

    /**
     * This extracts the essential MODS metadata from XML
     *
     * @access public
     *
     * @param \SimpleXMLElement $xml The XML to extract the metadata from
     *
     * @return void
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        parent::__construct($xml);
    }
}