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
use Slub\Mods\Element\Classification;
use Slub\Mods\ModsReaderTest;

/**
 * Tests for reading Classification element
 */
class ClassificationReaderTest extends ModsReaderTest
{

    #[Test]
    public function getClassificationsForBookDocument()
    {
        $classifications = $this->bookReader->getClassifications();
        self::assertNotEmpty($classifications);
        self::assertCount(2, $classifications);
        self::assertFirstClassificationForBookDocument($classifications[0]);
    }

    #[Test]
    public function getClassificationForBookDocument()
    {
        $classification = $this->bookReader->getClassification(0);
        self::assertFirstClassificationForBookDocument($classification);
    }

    #[Test]
    public function getFirstClassificationForBookDocument()
    {
        $classification = $this->bookReader->getFirstClassification();
        self::assertFirstClassificationForBookDocument($classification);
    }

    #[Test]
    public function getLastClassificationForBookDocument()
    {
        $classification = $this->bookReader->getLastClassification();
        self::assertSecondClassificationForBookDocument($classification);
    }

    #[Test]
    public function getClassificationsByQueryForBookDocument()
    {
        $classifications = $this->bookReader->getClassifications('[@authority="ddc"]');
        self::assertNotEmpty($classifications);
        self::assertCount(1, $classifications);
        self::assertSecondClassificationForBookDocument($classifications[0]);
    }

    #[Test]
    public function getNoClassificationsByQueryForBookDocument()
    {
        $classifications = $this->bookReader->getClassifications('[@generator="xyz"]');
        self::assertEmpty($classifications);
    }

    #[Test]
    public function getNoClassificationByQueryForBookDocument()
    {
        $classification = $this->bookReader->getClassification(1, '[@generator="xyz"]');
        self::assertNull($classification);
    }

    #[Test]
    public function getNoFirstClassificationByQueryForBookDocument()
    {
        $classification = $this->bookReader->getFirstClassification('[@generator="xyz"]');
        self::assertNull($classification);

        $lastClassification = $this->bookReader->getLastClassification('[@generator="xyz"]');
        self::assertNull($lastClassification);
    }

    #[Test]
    public function getNoLastClassificationByQueryForBookDocument()
    {
        $classification = $this->bookReader->getLastClassification('[@generator="xyz"]');
        self::assertNull($classification);
    }

    #[Test]
    public function getClassificationsForSerialDocument()
    {
        $classifications = $this->serialReader->getClassifications();
        self::assertNotEmpty($classifications);
        self::assertCount(1, $classifications);
        self::assertClassificationForSerialDocument($classifications[0]);
    }

    #[Test]
    public function getClassificationsByQueryForSerialDocument()
    {
        $classifications = $this->serialReader->getClassifications('[@authority="ddc"]');
        self::assertNotEmpty($classifications);
        self::assertCount(1, $classifications);
        self::assertClassificationForSerialDocument($classifications[0]);
    }

    #[Test]
    public function getNoClassificationsByQueryForSerialDocument()
    {
        $classifications = $this->serialReader->getClassifications('[@edition="22"]');
        self::assertEmpty($classifications);
    }

    private static function assertFirstClassificationForBookDocument(Classification $classification): void
    {
        self::assertNotEmpty($classification->getValue());
        self::assertEquals('PN4888.P6 A48 1999', $classification->getValue());
        self::assertNotEmpty($classification->getAuthority());
        self::assertEquals('lcc', $classification->getAuthority());
        self::assertEmpty($classification->getId());
        self::assertEmpty($classification->getUsage());
    }

    private static function assertSecondClassificationForBookDocument(Classification $classification): void
    {
        self::assertNotEmpty($classification->getValue());
        self::assertEquals('071/.3', $classification->getValue());
        self::assertNotEmpty($classification->getEdition());
        self::assertEquals('21', $classification->getEdition());
        self::assertEmpty($classification->getDisplayLabel());
        self::assertEmpty($classification->getGenerator());
    }

    private static function assertClassificationForSerialDocument(Classification $classification): void
    {
        self::assertNotEmpty($classification->getValue());
        self::assertEquals('027.7/05', $classification->getValue());
        self::assertNotEmpty($classification->getAuthority());
        self::assertEquals('ddc', $classification->getAuthority());
        self::assertNotEmpty($classification->getEdition());
        self::assertEquals('21', $classification->getEdition());
        self::assertEmpty($classification->getDisplayLabel());
        self::assertEmpty($classification->getGenerator());
    }
}
