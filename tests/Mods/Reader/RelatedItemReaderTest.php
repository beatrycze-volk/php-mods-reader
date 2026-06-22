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
use Slub\Mods\Element\RelatedItem;
use Slub\Mods\ModsReaderTest;

/**
 * Tests for reading RelatedItem element
 */
class RelatedItemReaderTest extends ModsReaderTest
{

    #[Test]
    public function getNoRelatedItemsForBookDocument()
    {
        $relatedItems = $this->bookReader->getRelatedItems();
        self::assertEmpty($relatedItems);
    }

    #[Test]
    public function getNoRelatedItemForBookDocument()
    {
        $relatedItem = $this->bookReader->getRelatedItem(0);
        self::assertNull($relatedItem);
    }

    #[Test]
    public function getNoFirstRelatedItemForBookDocument()
    {
        $relatedItem = $this->bookReader->getFirstRelatedItem();
        self::assertNull($relatedItem);
    }

    #[Test]
    public function getNoLastRelatedItemForBookDocument()
    {
        $relatedItem = $this->bookReader->getLastRelatedItem();
        self::assertNull($relatedItem);
    }

    #[Test]
    public function getRelatedItemsForSerialDocument()
    {
        $relatedItems = $this->serialReader->getRelatedItems();
        self::assertNotEmpty($relatedItems);
        self::assertCount(1, $relatedItems);
        self::assertRelatedItemForSerialDocument($relatedItems[0]);
    }

    #[Test]
    public function getRelatedItemForSerialDocument()
    {
        $relatedItem = $this->serialReader->getRelatedItem(0);
        self::assertRelatedItemForSerialDocument($relatedItem);
    }

    #[Test]
    public function getFirstRelatedItemForSerialDocument()
    {
        $relatedItem = $this->serialReader->getFirstRelatedItem();
        self::assertRelatedItemForSerialDocument($relatedItem);
    }

    #[Test]
    public function getLastRelatedItemForSerialDocument()
    {
        $relatedItem = $this->serialReader->getLastRelatedItem();
        self::assertRelatedItemForSerialDocument($relatedItem);
    }

    #[Test]
    public function getRelatedItemsByQueryForSerialDocument()
    {
        $relatedItems = $this->serialReader->getRelatedItems('[./mods:identifier="1525-321X"]');
        self::assertNotEmpty($relatedItems);
        self::assertCount(1, $relatedItems);
        self::assertRelatedItemForSerialDocument($relatedItems[0]);
    }

    #[Test]
    public function getNoRelatedItemsByQueryForSerialDocument()
    {
        $relatedItems = $this->serialReader->getRelatedItems('[./mods:identifier="15-32"]');
        self::assertEmpty($relatedItems);
    }

    private static function assertRelatedItemForSerialDocument(RelatedItem $relatedItem)
    {
        self::assertNotEmpty($relatedItem->getType());
        self::assertEquals('preceding', $relatedItem->getType());
        self::assertNotEmpty($relatedItem->getTitleInfos());
        self::assertEquals('Journal of southern academic and special librarianship', $relatedItem->getTitleInfos()[0]->getTitle()->getValue());
        self::assertNotEmpty($relatedItem->getOriginInfos());
        // TODO: implement back compatibility for 'publisher' element
        // self::assertEquals('Journal of southern academic and special librarianship', $relatedItem->getOriginInfos()[0]->getPublisher());
        self::assertNotEmpty($relatedItem->getIdentifiers());
        self::assertCount(4, $relatedItem->getIdentifiers());
        self::assertEquals('1525-321X', $relatedItem->getIdentifiers()[0]->getValue());

        $localIdentifiers = $relatedItem->getIdentifiers('[@type="local"]');
        self::assertNotEmpty($localIdentifiers);
        self::assertCount(3, $localIdentifiers);
        self::assertEquals('(OCoLC)41477508', $localIdentifiers[0]->getValue());
    }
}
