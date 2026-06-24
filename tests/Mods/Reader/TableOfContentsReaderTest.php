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
use Slub\Mods\Element\TableOfContents;
use Slub\Mods\ModsReaderTest;

/**
 * Tests for reading TableOfContents element
 */
class TableOfContentsReaderTest extends ModsReaderTest
{

    #[Test]
    public function getTablesOfContentsForBookDocument()
    {
        $tablesOfContents = $this->bookReader->getTablesOfContents();
        self::assertNotEmpty($tablesOfContents);
        self::assertCount(1, $tablesOfContents);
        self::assertTableOfContentsForBookDocument($tablesOfContents[0]);
    }

    #[Test]
    public function getTableOfContentsForBookDocument()
    {
        $tableOfContents = $this->bookReader->getTableOfContents(0);
        self::assertTableOfContentsForBookDocument($tableOfContents);
    }

    #[Test]
    public function getFirstTableOfContentsForBookDocument()
    {
        $tableOfContents = $this->bookReader->getFirstTableOfContents();
        self::assertTableOfContentsForBookDocument($tableOfContents);
    }

    #[Test]
    public function getLastTableOfContentsForBookDocument()
    {
        $tableOfContents = $this->bookReader->getLastTableOfContents();
        self::assertTableOfContentsForBookDocument($tableOfContents);
    }

    #[Test]
    public function getTablesOfContentsByQueryForBookDocument()
    {
        $tablesOfContents = $this->bookReader->getTablesOfContents('[@displayLabel="Chapters"]');
        self::assertNotEmpty($tablesOfContents);
        self::assertCount(1, $tablesOfContents);
        self::assertTableOfContentsForBookDocument($tablesOfContents[0]);
    }

    #[Test]
    public function getTableOfContentsByQueryForBookDocument()
    {
        $tableOfContents = $this->bookReader->getTableOfContents(0, '[@displayLabel="Chapters"]');
        self::assertTableOfContentsForBookDocument($tableOfContents);
    }

    #[Test]
    public function getFirstTableOfContentsByQueryForBookDocument()
    {
        $tableOfContents = $this->bookReader->getFirstTableOfContents('[@displayLabel="Chapters"]');
        self::assertTableOfContentsForBookDocument($tableOfContents);
    }

    #[Test]
    public function getLastTableOfContentsByQueryForBookDocument()
    {
        $tableOfContents = $this->bookReader->getLastTableOfContents('[@displayLabel="Chapters"]');
        self::assertTableOfContentsForBookDocument($tableOfContents);
    }

    #[Test]
    public function getNoTablesOfContentsByQueryForBookDocument()
    {
        $tablesOfContents = $this->bookReader->getTablesOfContents('[@displayLabel="Pages"]');
        self::assertEmpty($tablesOfContents);
    }

    #[Test]
    public function getNoTableOfContentsByQueryForBookDocument()
    {
        $tableOfContents = $this->bookReader->getTableOfContents(0, '[@displayLabel="Pages"]');
        self::assertNull($tableOfContents);
    }

    #[Test]
    public function getNoFirstTableOfContentsByQueryForBookDocument()
    {
        $tableOfContents = $this->bookReader->getFirstTableOfContents('[@displayLabel="Pages"]');
        self::assertNull($tableOfContents);
    }

    #[Test]
    public function getNoLastTableOfContentsByQueryForBookDocument()
    {
        $tableOfContents = $this->bookReader->getLastTableOfContents('[@displayLabel="Pages"]');
        self::assertNull($tableOfContents);
    }

    #[Test]
    public function getNoTablesOfContentsForSerialDocument()
    {
        $tablesOfContents = $this->serialReader->getTablesOfContents();
        self::assertEmpty($tablesOfContents);
    }

    private static function assertTableOfContentsForBookDocument(TableOfContents $tableOfContents)
    {
        self::assertNotEmpty($tableOfContents->getValue());
        self::assertEquals('Bluegrass odyssey -- Hills of Tennessee -- Sassafrass -- Muddy river -- Take your shoes off Moses -- Let Smokey Mountain smoke get in your eyes -- Farewell party -- Faded love', $tableOfContents->getValue());
        self::assertNotEmpty($tableOfContents->getDisplayLabel());
        self::assertEquals('Chapters', $tableOfContents->getDisplayLabel());

        // TODO: implement reading of elements
    }
}
