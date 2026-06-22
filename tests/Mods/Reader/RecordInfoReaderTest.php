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
use Slub\Mods\Element\RecordInfo;
use Slub\Mods\Exception\IncorrectValueInAttributeException;
use Slub\Mods\ModsReaderTest;

/**
 * Tests for reading RecordInfo element
 */
class RecordInfoReaderTest extends ModsReaderTest
{

    #[Test]
    public function getRecordInfosForBookDocument()
    {
        $recordInfos = $this->bookReader->getRecordInfos();
        self::assertNotEmpty($recordInfos);
        self::assertCount(1, $recordInfos);
        self::assertRecordInfoForBookDocument($recordInfos[0]);
    }

    #[Test]
    public function getRecordInfoForBookDocument()
    {
        $recordInfo = $this->bookReader->getRecordInfo(0);
        self::assertRecordInfoForBookDocument($recordInfo);
    }

    #[Test]
    public function getFirstRecordInfoForBookDocument()
    {
        $recordInfo = $this->bookReader->getFirstRecordInfo();
        self::assertRecordInfoForBookDocument($recordInfo);
    }

    #[Test]
    public function getLastRecordInfoForBookDocument()
    {
        $recordInfo = $this->bookReader->getLastRecordInfo();
        self::assertRecordInfoForBookDocument($recordInfo);
    }

    #[Test]
    public function getRecordInfosByQueryForBookDocument()
    {
        $recordInfos = $this->bookReader->getRecordInfos('[./mods:descriptionStandard="aacr"]');
        self::assertNotEmpty($recordInfos);
        self::assertCount(1, $recordInfos);
        self::assertRecordInfoForBookDocument($recordInfos[0]);
    }

    #[Test]
    public function getRecordInfoByQueryForBookDocument()
    {
        $recordInfo = $this->bookReader->getRecordInfo(0, '[./mods:descriptionStandard="aacr"]');
        self::assertRecordInfoForBookDocument($recordInfo);
    }

    #[Test]
    public function getFirstRecordInfoByQueryForBookDocument()
    {
        $recordInfo = $this->bookReader->getFirstRecordInfo('[./mods:descriptionStandard="aacr"]');
        self::assertRecordInfoForBookDocument($recordInfo);
    }

    #[Test]
    public function getLastRecordInfoByQueryForBookDocument()
    {
        $recordInfo = $this->bookReader->getLastRecordInfo('[./mods:descriptionStandard="aacr"]');
        self::assertRecordInfoForBookDocument($recordInfo);
    }

    #[Test]
    public function getNoRecordInfosByQueryForBookDocument()
    {
        $recordInfos = $this->bookReader->getRecordInfos('[./mods:descriptionStandard="xyz"]');
        self::assertEmpty($recordInfos);
    }

    #[Test]
    public function getNoRecordInfoByQueryForBookDocument()
    {
        $recordInfo = $this->bookReader->getRecordInfo(5, '[./mods:descriptionStandard="xyz"]');
        self::assertNull($recordInfo);

        $firstRecordInfo = $this->bookReader->getFirstRecordInfo('[./mods:descriptionStandard="xyz"]');
        self::assertNull($firstRecordInfo);

        $lastRecordInfo = $this->bookReader->getLastRecordInfo('[./mods:descriptionStandard="xyz"]');
        self::assertNull($lastRecordInfo);
    }

    #[Test]
    public function getRecordInfosForSerialDocument()
    {
        $recordInfos = $this->serialReader->getRecordInfos();
        self::assertNotEmpty($recordInfos);
        self::assertCount(1, $recordInfos);
        self::assertRecordInfoForSerialDocument($recordInfos[0]);

        $this->expectException(IncorrectValueInAttributeException::class);
        $recordInfos[0]->getRecordCreationDates()[0]->getEncoding();
    }


    #[Test]
    public function getRecordInfosByQueryForSerialDocument()
    {
        $recordInfos = $this->serialReader->getRecordInfos('[./mods:descriptionStandard="aacr"]');
        self::assertNotEmpty($recordInfos);
        self::assertCount(1, $recordInfos);
        self::assertRecordInfoForSerialDocument($recordInfos[0]);

        $this->expectException(IncorrectValueInAttributeException::class);
        $recordInfos[0]->getRecordCreationDates()[0]->getEncoding();
    }

    #[Test]
    public function getNoRecordInfosByQueryForSerialDocument()
    {
        $recordInfos = $this->serialReader->getRecordInfos('[./mods:descriptionStandard="xyz"]');
        self::assertEmpty($recordInfos);
    }

    private static function assertRecordInfoForBookDocument(RecordInfo $recordInfo)
    {
        self::assertNotEmpty($recordInfo->getValue());
        self::assertNotEmpty($recordInfo->getDescriptionStandards());
        self::assertEquals('aacr', $recordInfo->getDescriptionStandards()[0]->getValue());

        $recordContentSources = $recordInfo->getRecordContentSources();
        self::assertNotEmpty($recordContentSources);
        self::assertEquals('marcorg', $recordContentSources[0]->getAuthority());
        self::assertEquals('DLC', $recordContentSources[0]->getValue());

        $recordCreationDates = $recordInfo->getRecordCreationDates();
        self::assertNotEmpty($recordCreationDates);
        self::assertEquals('marc', $recordCreationDates[0]->getEncoding());
        self::assertEquals('990730', $recordCreationDates[0]->getValue());

        $recordChangeDates = $recordInfo->getRecordChangeDates();
        self::assertNotEmpty($recordChangeDates);
        self::assertEquals('iso8601', $recordChangeDates[0]->getEncoding());
        self::assertEquals('20060801143536.0', $recordChangeDates[0]->getValue());

        $recordIdentifiers = $recordInfo->getRecordIdentifiers();
        self::assertNotEmpty($recordIdentifiers);
        self::assertEquals('DE-14', $recordIdentifiers[0]->getSource());
        self::assertEquals('11761548', $recordIdentifiers[0]->getValue());
        self::assertNotEmpty($recordInfo->getRecordOrigins());
        self::assertStringContainsString('Converted from MARCXML to MODS', $recordInfo->getRecordOrigins()[0]->getValue());
    }

    private static function assertRecordInfoForSerialDocument(RecordInfo $recordInfo)
    {
        self::assertNotEmpty($recordInfo->getValue());
        self::assertNotEmpty($recordInfo->getDescriptionStandards());
        self::assertEquals('aacr', $recordInfo->getDescriptionStandards()[0]->getValue());

        $recordContentSources = $recordInfo->getRecordContentSources();
        self::assertNotEmpty($recordContentSources);
        self::assertEquals('marcorg', $recordContentSources[0]->getAuthority());
        self::assertEquals('NLC', $recordContentSources[0]->getValue());

        $recordCreationDates = $recordInfo->getRecordCreationDates();
        self::assertNotEmpty($recordCreationDates);
        self::assertEquals('021127', $recordCreationDates[0]->getValue());

        $recordChangeDates = $recordInfo->getRecordChangeDates();
        self::assertNotEmpty($recordChangeDates);
        self::assertEquals('iso8601', $recordChangeDates[0]->getEncoding());
        self::assertEquals('20080910160139.0', $recordChangeDates[0]->getValue());
        self::assertNotEmpty($recordInfo->getRecordIdentifiers());
        self::assertEquals('15446420', $recordInfo->getRecordIdentifiers()[0]->getValue());
        self::assertNotEmpty($recordInfo->getRecordOrigins());
        self::assertStringContainsString('Converted from MARCXML to MODS', $recordInfo->getRecordOrigins()[0]->getValue());

        $recordInfoNotes = $recordInfo->getRecordInfoNotes();
        self::assertNotEmpty($recordInfo->getRecordInfoNotes());
        self::assertCount(2, $recordInfoNotes);
        self::assertEquals('Some info', $recordInfoNotes[1]->getValue());

        $languages = $recordInfo->getLanguageOfCatalogings();
        self::assertNotEmpty($languages);

        $languageTerm = $languages[0]->getLanguageTerm();
        self::assertNotNull($languageTerm);
        self::assertEquals('code', $languageTerm->getType());
        self::assertEquals('iso639-2b', $languageTerm->getAuthority());
        self::assertEquals('eng', $languageTerm->getValue());

        $scriptTerm = $languages[0]->getScriptTerm();
        self::assertNotNull($languages[0]->getScriptTerm());
        self::assertEquals('code', $scriptTerm->getType());
        self::assertEquals('iso15924', $scriptTerm->getAuthority());
        self::assertEquals('Latn', $scriptTerm->getValue());
    }
}
