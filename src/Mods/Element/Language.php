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

namespace Slub\Mods\Element;

use Slub\Mods\Attribute\Common\LanguageAttribute;
use Slub\Mods\Attribute\Common\Linking\AltRepGroupAttribute;
use Slub\Mods\Attribute\Common\Linking\IdAttribute;
use Slub\Mods\Attribute\Common\Miscellaneous\DisplayLabelAttribute;
use Slub\Mods\Attribute\Common\Miscellaneous\UsageAttribute;
use Slub\Mods\Element\Common\BaseElement;
use Slub\Mods\Element\Specific\Language\LanguageTerm;
use Slub\Mods\Element\Specific\Language\ScriptTerm;

/**
 * Language MODS metadata element class for the 'dlf' extension
 *
 * @package TYPO3
 * @subpackage dlf
 *
 * @access public
 */
class Language extends BaseElement
{
    use LanguageAttribute, IdAttribute, AltRepGroupAttribute, DisplayLabelAttribute, UsageAttribute;

    /**
     * @access private
     * @var LanguageTerm
     */
    private LanguageTerm $languageTerm;

    /**
     * @access private
     * @var ScriptTerm
     */
    private ScriptTerm $scriptTerm;

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

    /**
     * Get the value of objectPart
     *
     * @access public
     *
     * @return string
     */
    public function getObjectPart(): string
    {
        return $this->getStringAttribute('objectPart');
    }

    /**
     * Get the value of languageTerm
     *
     * @access public
     *
     * @return LanguageTerm
     */
    public function getLanguageTerm(): LanguageTerm
    {
        return $this->languageTerm;
    }

    /**
     * Get the value of scriptTerm
     *
     * @access public
     *
     * @return ScriptTerm
     */
    public function getScriptTerm(): ScriptTerm
    {
        return $this->scriptTerm;
    }
}