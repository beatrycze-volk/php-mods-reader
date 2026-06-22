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

use PHPUnit\Framework\Attributes\Test;
use Slub\Mods\ModsReaderTest;

/**
 * Tests for reading Extension element
 */
class ExtensionReaderTest extends ModsReaderTest
{

    #[Test]
    public function getExtensionsForBookDocument()
    {
        // $extensions = $this->bookReader->getExtensions();
        $this->assertTrue(true, 'WIP');
    }

    #[Test]
    public function getExtensionsForSerialDocument()
    {
        // $extensions = $this->serialReader->getExtensions();
        $this->assertTrue(true, 'WIP');
    }
}
