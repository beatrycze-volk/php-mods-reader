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

namespace Slub\Mods\Attribute\Specific;

/**
 * Trait for other type specific attributes
 */
trait OtherTypeAttribute
{

    /**
     * Get the value of otherType
     *
     * @access public
     *
     * @return string
     */
    public function getOtherType(): string
    {
        return $this->getStringAttribute('otherType');
    }

    /**
     * Get the value of otherTypeAuth
     *
     * @access public
     *
     * @return string
     */
    public function getOtherTypeAuth(): string
    {
        return $this->getStringAttribute('otherTypeAuth');
    }

    /**
     * Get the value of otherTypeAuthURI
     *
     * @access public
     *
     * @return string
     */
    public function getOtherTypeAuthURI(): string
    {
        return $this->getStringAttribute('otherTypeAuthURI');
    }

    /**
     * Get the value of otherTypeURI
     *
     * @access public
     *
     * @return string
     */
    public function getOtherTypeURI(): string
    {
        return $this->getStringAttribute('otherTypeURI');
    }
}
