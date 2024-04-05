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
namespace Slub\Mods;

use PHPUnit\Framework\TestCase;

class ModsReaderTest extends TestCase
{

    /**
     * @access private
     * @var ModsReader The MODS metadata reader for book document
     **/
    private $bookReader;

    /**
     * @access private
     * @var ModsReader The MODS metadata reader for serial document
     **/
    private $serialReader;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $xmlBook = simplexml_load_file(__DIR__.'/../resources/mods_book.xml');
        $this->bookReader = new ModsReader($xmlBook);

        $xmlSerial = simplexml_load_file(__DIR__.'/../resources/mods_serial.xml');
        $this->serialReader = new ModsReader($xmlSerial);
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
    }

    public function testGetAbstractForBookDocument()
    {
        $abstract = $this->bookReader->getAbstract();
        self::assertNotNull($abstract);
        self::assertNotEmpty($abstract->getDisplayLabel());
        self::assertEquals('Content description', $abstract->getDisplayLabel());
        self::assertNotEmpty($abstract->getValue());
        self::assertEquals('Test description for document which contains display label.', $abstract->getValue());
        self::assertTrue($abstract->isShareable());
    }

    public function testGetAbstractByQueryForBookDocument()
    {
        $abstract = $this->bookReader->getAbstract('[@displayLabel="Content description"]');
        self::assertNotNull($abstract);
        self::assertNotEmpty($abstract->getDisplayLabel());
        self::assertEquals('Content description', $abstract->getDisplayLabel());
        self::assertNotEmpty($abstract->getValue());
        self::assertEquals('Test description for document which contains display label.', $abstract->getValue());
        self::assertTrue($abstract->isShareable());
    }

    public function testGetNoAbstractByQueryForBookDocument()
    {
        $abstract = $this->bookReader->getAbstract('[@displayLabel="Random"]');
        self::assertNull($abstract);
    }

    public function testGetAbstractForSerialDocument()
    {
        $abstract = $this->serialReader->getAbstract();
        self::assertNotNull($abstract);
        self::assertEmpty($abstract->getDisplayLabel());
        self::assertNotEmpty($abstract->getValue());
        self::assertEquals('Test description for non shareable document.', $abstract->getValue());
        self::assertFalse($abstract->isShareable());
    }

    public function testGetAbstractByQueryForSerialDocument()
    {
        $abstract = $this->serialReader->getAbstract('[@shareable="no"]');
        self::assertNotNull($abstract);
        self::assertEmpty($abstract->getDisplayLabel());
        self::assertNotEmpty($abstract->getValue());
        self::assertEquals('Test description for non shareable document.', $abstract->getValue());
        self::assertFalse($abstract->isShareable());
    }

    public function testGetNoAbstractByQueryForSerialDocument()
    {
        $abstract = $this->serialReader->getAbstract('[@shareable="yes"]');
        self::assertNull($abstract);
    }

    public function testGetAccessConditionsForBookDocument()
    {
        $accessConditions = $this->bookReader->getAccessConditions();
        self::assertNotEmpty($accessConditions);
        self::assertEquals(1, count($accessConditions));
        self::assertNotEmpty($accessConditions[0]->getValue());
        self::assertEquals('Use of this public-domain resource is unrestricted.', $accessConditions[0]->getValue());
        self::assertNotEmpty($accessConditions[0]->getType());
        self::assertEquals('use and reproduction', $accessConditions[0]->getType());
        self::assertEmpty($accessConditions[0]->getDisplayLabel());
        self::assertEmpty($accessConditions[0]->getXlinkHref());
    }

    public function testGetAccessConditionsByQueryForBookDocument()
    {
        $accessConditions = $this->bookReader->getAccessConditions('[@type="use and reproduction"]');
        self::assertNotEmpty($accessConditions);
        self::assertEquals(1, count($accessConditions));
        self::assertNotEmpty($accessConditions[0]->getValue());
        self::assertEquals('Use of this public-domain resource is unrestricted.', $accessConditions[0]->getValue());
        self::assertNotEmpty($accessConditions[0]->getType());
        self::assertEquals('use and reproduction', $accessConditions[0]->getType());
        self::assertEmpty($accessConditions[0]->getDisplayLabel());
        self::assertEmpty($accessConditions[0]->getXlinkHref());
    }

    public function testGetNoAccessConditionsByQueryForBookDocument()
    {
        $accessConditions = $this->bookReader->getAccessConditions('[@type="restriction on access"]');
        self::assertEmpty($accessConditions);
    }

    public function testGetAccessConditionsForSerialDocument()
    {
        $accessConditions = $this->serialReader->getAccessConditions();
        self::assertNotEmpty($accessConditions);
        self::assertEquals(1, count($accessConditions));
        self::assertNotEmpty($accessConditions[0]->getValue());
        self::assertEquals('Open Access', $accessConditions[0]->getValue());
        self::assertNotEmpty($accessConditions[0]->getType());
        self::assertEquals('restriction on access', $accessConditions[0]->getType());
        self::assertNotEmpty($accessConditions[0]->getDisplayLabel());
        self::assertEquals('Access Status', $accessConditions[0]->getDisplayLabel());
        // TODO: check out xlink
        //self::assertEquals('http://purl.org/eprint/accessRights/OpenAccess', $accessConditions[0]->getXlinkHref());
    }

    public function testGetAccessConditionsByQueryForSerialDocument()
    {
        $accessConditions = $this->serialReader->getAccessConditions('[@type="restriction on access"]');
        self::assertNotEmpty($accessConditions);
        self::assertEquals(1, count($accessConditions));
        self::assertNotEmpty($accessConditions[0]->getValue());
        self::assertEquals('Open Access', $accessConditions[0]->getValue());
        self::assertNotEmpty($accessConditions[0]->getType());
        self::assertEquals('restriction on access', $accessConditions[0]->getType());
        self::assertNotEmpty($accessConditions[0]->getDisplayLabel());
        self::assertEquals('Access Status', $accessConditions[0]->getDisplayLabel());
        // TODO: check out xlink
        //self::assertEquals('http://purl.org/eprint/accessRights/OpenAccess', $accessConditions[0]->getXlinkHref());
    }

    public function testGetNoAccessConditionsByQueryForSerialDocument()
    {
        $accessConditions = $this->serialReader->getAccessConditions('[@type="use and reproduction"]');
        self::assertEmpty($accessConditions);
    }

    public function testGetClassificationsForBookDocument()
    {
        $classifications = $this->bookReader->getClassifications();
        self::assertNotEmpty($classifications);
        self::assertEquals(2, count($classifications));
        self::assertNotEmpty($classifications[0]->getValue());
        self::assertEquals('PN4888.P6 A48 1999', $classifications[0]->getValue());
        self::assertNotEmpty($classifications[0]->getAuthority());
        self::assertEquals('lcc', $classifications[0]->getAuthority());
        self::assertEmpty($classifications[0]->getId());
        self::assertEmpty($classifications[0]->getUsage());
    }

    public function testGetClassificationsByQueryForBookDocument()
    {
        $classifications = $this->bookReader->getClassifications('[@authority="ddc"]');
        self::assertNotEmpty($classifications);
        self::assertEquals(1, count($classifications));
        self::assertNotEmpty($classifications[0]->getValue());
        self::assertEquals('071/.3', $classifications[0]->getValue());
        self::assertNotEmpty($classifications[0]->getEdition());
        self::assertEquals('21', $classifications[0]->getEdition());
        self::assertEmpty($classifications[0]->getDisplayLabel());
        self::assertEmpty($classifications[0]->getGenerator());
    }

    public function testGetNoClassificationsByQueryForBookDocument()
    {
        $classifications = $this->bookReader->getAccessConditions('[@generator="xyz"]');
        self::assertEmpty($classifications);
    }

    public function testGetClassificationsForSerialDocument()
    {
        $classifications = $this->serialReader->getClassifications();
        self::assertNotEmpty($classifications);
        self::assertEquals(1, count($classifications));
        self::assertNotEmpty($classifications[0]->getValue());
        self::assertEquals('027.7/05', $classifications[0]->getValue());
        self::assertNotEmpty($classifications[0]->getAuthority());
        self::assertEquals('ddc', $classifications[0]->getAuthority());
        self::assertNotEmpty($classifications[0]->getEdition());
        self::assertEquals('21', $classifications[0]->getEdition());
        self::assertEmpty($classifications[0]->getDisplayLabel());
        self::assertEmpty($classifications[0]->getGenerator());
    }

    public function testGetClassificationsByQueryForSerialDocument()
    {
        $classifications = $this->serialReader->getClassifications('[@authority="ddc"]');
        self::assertNotEmpty($classifications);
        self::assertEquals(1, count($classifications));
        self::assertNotEmpty($classifications[0]->getValue());
        self::assertEquals('027.7/05', $classifications[0]->getValue());
        self::assertNotEmpty($classifications[0]->getAuthority());
        self::assertEquals('ddc', $classifications[0]->getAuthority());
        self::assertNotEmpty($classifications[0]->getEdition());
        self::assertEquals('21', $classifications[0]->getEdition());
        self::assertEmpty($classifications[0]->getDisplayLabel());
        self::assertEmpty($classifications[0]->getGenerator());
    }

    public function testGetNoClassificationsByQueryForSerialDocument()
    {
        $classifications = $this->serialReader->getClassifications('[@edition="22"]');
        self::assertEmpty($classifications);
    }

    public function testGetExtensionsForBookDocument()
    {
        $extensions = $this->bookReader->getExtensions();

        $this->assertTrue(true, 'WIP');
    }

    public function testGetExtensionsForSerialDocument()
    {
        $extensions = $this->serialReader->getExtensions();

        $this->assertTrue(true, 'WIP');
    }

    public function testGetGenresForBookDocument()
    {
        $genres = $this->bookReader->getGenres();
        self::assertNotEmpty($genres);
        self::assertEquals(1, count($genres));
        self::assertNotEmpty($genres[0]->getValue());
        self::assertEquals('bibliography', $genres[0]->getValue());
        self::assertNotEmpty($genres[0]->getAuthority());
        self::assertEquals('marcgt', $genres[0]->getAuthority());
        self::assertEmpty($genres[0]->getLang());
        self::assertEmpty($genres[0]->getScript());
    }

    public function testGetGenresByQueryForBookDocument()
    {
        $genres = $this->bookReader->getGenres('[@authority="marcgt"]');
        self::assertNotEmpty($genres);
        self::assertEquals(1, count($genres));
        self::assertNotEmpty($genres[0]->getValue());
        self::assertEquals('bibliography', $genres[0]->getValue());
        self::assertNotEmpty($genres[0]->getAuthority());
        self::assertEquals('marcgt', $genres[0]->getAuthority());
        self::assertEmpty($genres[0]->getLang());
        self::assertEmpty($genres[0]->getScript());
    }

    public function testGetNoGenresByQueryForBookDocument()
    {
        $genres = $this->bookReader->getGenres('[@authority="merc"]');
        self::assertEmpty($genres);
    }

    public function testGetGenresForSerialDocument()
    {
        $genres = $this->serialReader->getGenres();
        self::assertNotEmpty($genres);
        self::assertEquals(2, count($genres));
        self::assertNotEmpty($genres[0]->getValue());
        self::assertEquals('periodical', $genres[0]->getValue());
        self::assertNotEmpty($genres[0]->getUsage());
        self::assertEquals('primary', $genres[0]->getUsage());
        self::assertEmpty($genres[0]->getDisplayLabel());
        self::assertEmpty($genres[0]->getTransliteration());
    }

    public function testGetGenresByQueryForSerialDocument()
    {
        $genres = $this->serialReader->getGenres('[@usage="primary"]');
        self::assertNotEmpty($genres);
        self::assertEquals(1, count($genres));
        self::assertNotEmpty($genres[0]->getValue());
        self::assertEquals('periodical', $genres[0]->getValue());
        self::assertNotEmpty($genres[0]->getUsage());
        self::assertEquals('primary', $genres[0]->getUsage());
        self::assertEmpty($genres[0]->getDisplayLabel());
        self::assertEmpty($genres[0]->getTransliteration());
    }

    public function testGetNoGenresByQueryForSerialDocument()
    {
        $genres = $this->serialReader->getGenres('[@type="xyz"]');
        self::assertEmpty($genres);
    }

    public function testGetIdentifiersForBookDocument()
    {
        $identifiers = $this->bookReader->getIdentifiers();
        self::assertNotEmpty($identifiers);
        self::assertEquals(2, count($identifiers));
        self::assertNotEmpty($identifiers[0]->getValue());
        self::assertEquals('0801486394 (pbk. : acid-free, recycled paper)', $identifiers[0]->getValue());
        self::assertNotEmpty($identifiers[0]->getType());
        self::assertEquals('isbn', $identifiers[0]->getType());
        self::assertEmpty($identifiers[0]->getLang());
        self::assertFalse($identifiers[0]->isInvalid());
    }

    public function testGetIdentifiersByQueryForBookDocument()
    {
        $identifiers = $this->bookReader->getIdentifiers('[@type="lccn"]');
        self::assertNotEmpty($identifiers);
        self::assertEquals(1, count($identifiers));
        self::assertNotEmpty($identifiers[0]->getValue());
        self::assertEquals('99042030', $identifiers[0]->getValue());
        self::assertNotEmpty($identifiers[0]->getType());
        self::assertEquals('lccn', $identifiers[0]->getType());
        self::assertEmpty($identifiers[0]->getLang());
        self::assertFalse($identifiers[0]->isInvalid());
    }

    public function testGetNoIdentifiersByQueryForBookDocument()
    {
        $identifiers = $this->bookReader->getIdentifiers('[@type="xyz"]');
        self::assertEmpty($identifiers);
    }

    public function testGetIdentifiersForSerialDocument()
    {
        $identifiers = $this->serialReader->getIdentifiers();
        self::assertNotEmpty($identifiers);
        self::assertEquals(4, count($identifiers));
        self::assertNotEmpty($identifiers[0]->getValue());
        self::assertEquals('1704-8532', $identifiers[0]->getValue());
        self::assertNotEmpty($identifiers[0]->getType());
        self::assertEquals('issn', $identifiers[0]->getType());
        self::assertEmpty($identifiers[0]->getDisplayLabel());
        self::assertFalse($identifiers[0]->isInvalid());
    }

    public function testGetIdentifiersByQueryForSerialDocument()
    {
        $identifiers = $this->serialReader->getIdentifiers('[@type="issn"]');
        self::assertNotEmpty($identifiers);
        self::assertEquals(2, count($identifiers));
        self::assertNotEmpty($identifiers[1]->getValue());
        self::assertEquals('1525-321X', $identifiers[1]->getValue());
        self::assertNotEmpty($identifiers[0]->getType());
        self::assertEquals('issn', $identifiers[1]->getType());
        self::assertEmpty($identifiers[1]->getDisplayLabel());
        self::assertTrue($identifiers[1]->isInvalid());
    }

    public function testGetNoIdentifiersByQueryForSerialDocument()
    {
        $identifiers = $this->serialReader->getIdentifiers('[@type="xyz"]');
        self::assertEmpty($identifiers);
    }

    public function testGetLanguageForBookDocument()
    {
        $language = $this->bookReader->getLanguage();
        self::assertNotNull($language);
        // TODO: implement reading of languageTerm and scriptTerm
        // self::assertNotEmpty($language->getLanguageTerm());
        // self::assertNotEmpty($language->getScriptTerm());

        $language = $this->bookReader->getLanguage('[@type="text"]');
        self::assertNull($language);
    }

    public function testGetLanguageForSerialDocument()
    {
        $language = $this->serialReader->getLanguage();
        self::assertNotNull($language);
        // TODO: implement reading of languageTerm and scriptTerm
        // self::assertNotEmpty($language->getLanguageTerm());
        // self::assertNotEmpty($language->getScriptTerm());

        $language = $this->serialReader->getLanguage('[@type="text"]');
        self::assertNull($language);
    }

    public function testGetLocationsForBookDocument()
    {
        $locations = $this->bookReader->getLocations();
        self::assertNotEmpty($locations);
        self::assertEquals(1, count($locations));
        
        // TODO: implement reading of location elements

    }

    public function testGetLocationsForSerialDocument()
    {
        $locations = $this->serialReader->getLocations();
        self::assertNotEmpty($locations);
        self::assertEquals(2, count($locations));
        
        // TODO: implement reading of location elements
    }

    public function testGetNamesForBookDocument()
    {
        $names = $this->bookReader->getNames();
        self::assertNotEmpty($names);
        self::assertEquals(2, count($names));
        
        // TODO: implement reading of name elements

    }

    public function testGetNamesForSerialDocument()
    {
        $names = $this->serialReader->getNames();
        self::assertNotEmpty($names);
        self::assertEquals(1, count($names));
        
        // TODO: implement reading of name elements
    }

    public function testGetNotesForBookDocument()
    {
        $notes = $this->bookReader->getNotes();
        self::assertNotEmpty($notes);
        self::assertEquals(2, count($notes));
        self::assertNotEmpty($notes[0]->getValue());
        self::assertEquals('Eric Alterman.', $notes[0]->getValue());
        self::assertNotEmpty($notes[0]->getType());
        self::assertEquals('statement of responsibility', $notes[0]->getType());
    }

    public function testGetNotesByQueryForBookDocument()
    {
        $notes = $this->bookReader->getNotes('[@type="bibliography"]');
        self::assertNotEmpty($notes);
        self::assertEquals(1, count($notes));
        self::assertNotEmpty($notes[0]->getValue());
        self::assertEquals('Includes bibliographical references (p. 291-312) and index.', $notes[0]->getValue());
        self::assertNotEmpty($notes[0]->getType());
        self::assertEquals('bibliography', $notes[0]->getType());
    }

    public function testGetNoNotesByQueryForBookDocument()
    {
        $notes = $this->bookReader->getNotes('[@type="xyz"]');
        self::assertEmpty($notes);
    }

    public function testGetNotesForSerialDocument()
    {
        $notes = $this->serialReader->getNotes();
        self::assertNotEmpty($notes);
        self::assertEquals(6, count($notes));
        self::assertNotEmpty($notes[0]->getValue());
        self::assertEquals('V. 3, no. 1/2 (winter 2002)-', $notes[0]->getValue());
        self::assertNotEmpty($notes[0]->getType());
        self::assertEquals('date/sequential designation', $notes[0]->getType());
    }

    public function testGetNotesByQueryForSerialDocument()
    {
        $notes = $this->serialReader->getNotes('[@type="system details"]');
        self::assertNotEmpty($notes);
        self::assertEquals(1, count($notes));
        self::assertNotEmpty($notes[0]->getValue());
        self::assertEquals('Mode of access: World Wide Web.', $notes[0]->getValue());
        self::assertNotEmpty($notes[0]->getType());
        self::assertEquals('system details', $notes[0]->getType());
    }

    public function testGetNoNotesByQueryForSerialDocument()
    {
        $notes = $this->serialReader->getNotes('[@type="xyz"]');
        self::assertEmpty($notes);
    }

    public function testGetOriginInfosForBookDocument()
    {
        $originInfos = $this->bookReader->getOriginInfos();
        self::assertNotEmpty($originInfos);
        self::assertEquals(2, count($originInfos));
        self::assertNotEmpty($originInfos[0]->getValue());
        self::assertNotEmpty($originInfos[0]->getEventType());
        self::assertEquals('publication', $originInfos[0]->getEventType());

        // TODO: implement reading of elements
    }

    public function testGetOriginInfosByQueryForBookDocument()
    {
        $originInfos = $this->bookReader->getOriginInfos('[@eventType="redaction"]');
        self::assertNotEmpty($originInfos);
        self::assertEquals(1, count($originInfos));
        self::assertNotEmpty($originInfos[0]->getValue());
        self::assertNotEmpty($originInfos[0]->getEventType());
        self::assertEquals('redaction', $originInfos[0]->getEventType());

        // TODO: implement reading of elements
    }

    public function testGetNoOriginInfosByQueryForBookDocument()
    {
        $originInfos = $this->bookReader->getOriginInfos('[@eventType="xyz"]');
        self::assertEmpty($originInfos);
    }

    public function testGetOriginInfosForSerialDocument()
    {
        $originInfos = $this->serialReader->getOriginInfos();
        self::assertNotEmpty($originInfos);
        self::assertEquals(1, count($originInfos));
        self::assertNotEmpty($originInfos[0]->getValue());
        self::assertNotEmpty($originInfos[0]->getEventType());
        self::assertEquals('publication', $originInfos[0]->getEventType());

        // TODO: implement reading of elements
    }

    public function testGetOriginInfosByQueryForSerialDocument()
    {
        $originInfos = $this->serialReader->getOriginInfos('[@eventType="publication"]');
        self::assertNotEmpty($originInfos);
        self::assertEquals(1, count($originInfos));
        self::assertNotEmpty($originInfos[0]->getValue());
        self::assertNotEmpty($originInfos[0]->getEventType());
        self::assertEquals('publication', $originInfos[0]->getEventType());

        // TODO: implement reading of elements
    }

    public function testGetNoOriginInfosByQueryForSerialDocument()
    {
        $originInfos = $this->serialReader->getOriginInfos('[@eventType="xyz"]');
        self::assertEmpty($originInfos);
    }

    public function testGetPartsForBookDocument()
    {
        $parts = $this->bookReader->getParts();
        self::assertNotEmpty($parts);
        self::assertEquals(2, count($parts));
        self::assertNotEmpty($parts[0]->getValue());
        self::assertNotEmpty($parts[0]->getType());
        self::assertEquals('poem', $parts[0]->getType());
        self::assertNotEmpty($parts[0]->getOrder());
        self::assertEquals(1, $parts[0]->getOrder());

        // TODO: implement reading of elements
    }

    public function testGetPartsByQueryForBookDocument()
    {
        $parts = $this->bookReader->getParts('[@order="2"]');
        self::assertNotEmpty($parts);
        self::assertEquals(1, count($parts));
        self::assertNotEmpty($parts[0]->getValue());
        self::assertNotEmpty($parts[0]->getType());
        self::assertEquals('poem', $parts[0]->getType());
        self::assertNotEmpty($parts[0]->getOrder());
        self::assertEquals(2, $parts[0]->getOrder());

        // TODO: implement reading of elements
    }

    public function testGetNoPartsByQueryForBookDocument()
    {
        $parts = $this->bookReader->getParts('[@order="3"]');
        self::assertEmpty($parts);
    }

    public function testGetNoPartsForSerialDocument()
    {
        $parts = $this->serialReader->getParts();
        self::assertEmpty($parts);
    }

    public function testGetPhysicalDescriptionsForBookDocument()
    {
        $physicalDescriptions = $this->bookReader->getPhysicalDescriptions();
        self::assertNotEmpty($physicalDescriptions);
        self::assertEquals(1, count($physicalDescriptions));
        self::assertNotEmpty($physicalDescriptions[0]->getValue());
        //self::assertEquals('', $physicalDescriptions[0]->getValue());
        //self::assertNotEmpty($physicalDescriptions[0]->getForm());
        //self::assertNotEmpty($physicalDescriptions[0]->getExtent());

        // TODO: implement reading of elements
    }

    public function testGetPhysicalDescriptionsByQueryForBookDocument()
    {
        $physicalDescriptions = $this->bookReader->getPhysicalDescriptions('[./mods:form[@authority="marcform"]="print"]');
        self::assertNotEmpty($physicalDescriptions);
        self::assertEquals(1, count($physicalDescriptions));
        self::assertNotEmpty($physicalDescriptions[0]->getValue());
        //self::assertEquals('', $physicalDescriptions[0]->getValue());
        //self::assertNotEmpty($physicalDescriptions[0]->getForm());
        //self::assertNotEmpty($physicalDescriptions[0]->getExtent());

        // TODO: implement reading of elements
    }

    public function testGetNoPhysicalDescriptionsByQueryForBookDocument()
    {
        $physicalDescriptions = $this->bookReader->getPhysicalDescriptions('[./mods:form[@authority="marcform"]="electronic"]');
        self::assertEmpty($physicalDescriptions);
    }

    public function testGetPhysicalDescriptionsForSerialDocument()
    {
        $physicalDescriptions = $this->serialReader->getPhysicalDescriptions();
        self::assertNotEmpty($physicalDescriptions);
        self::assertEquals(1, count($physicalDescriptions));
        self::assertNotEmpty($physicalDescriptions[0]->getValue());
        //self::assertEquals('', $physicalDescriptions[0]->getValue());
        //self::assertNotEmpty($physicalDescriptions[0]->getForm());
        //self::assertNotEmpty($physicalDescriptions[0]->getExtent());

        // TODO: implement reading of elements
    }

    public function testGetPhysicalDescriptionsByQueryForSerialDocument()
    {
        $physicalDescriptions = $this->serialReader->getPhysicalDescriptions('[./mods:form[@authority="marcform"]="electronic"]');
        self::assertNotEmpty($physicalDescriptions);
        self::assertEquals(1, count($physicalDescriptions));
        self::assertNotEmpty($physicalDescriptions[0]->getValue());
        //self::assertEquals('', $physicalDescriptions[0]->getValue());
        //self::assertNotEmpty($physicalDescriptions[0]->getForm());
        //self::assertNotEmpty($physicalDescriptions[0]->getExtent());

        // TODO: implement reading of elements
    }

    public function testGetNoPhysicalDescriptionsByQueryForSerialDocument()
    {
        $physicalDescriptions = $this->serialReader->getPhysicalDescriptions('[./mods:form[@authority="marcform"]="print"]');
        self::assertEmpty($physicalDescriptions);
    }

    public function testGetRecordInfosForBookDocument()
    {
        $recordInfos = $this->bookReader->getRecordInfos();
        self::assertNotEmpty($recordInfos);
        self::assertEquals(1, count($recordInfos));
        self::assertNotEmpty($recordInfos[0]->getValue());
        //self::assertEquals('', $recordInfos[0]->getRecordIdentifier());
        //self::assertNotEmpty($recordInfos[0]->getRecordOrigin());
        //self::assertNotEmpty($recordInfos[0]->getLanguageOfCataloging());

        // TODO: implement reading of elements
    }

    public function testGetRecordInfosByQueryForBookDocument()
    {
        $recordInfos = $this->bookReader->getRecordInfos('[./mods:descriptionStandard="aacr"]');
        self::assertNotEmpty($recordInfos);
        self::assertEquals(1, count($recordInfos));
        self::assertNotEmpty($recordInfos[0]->getValue());
        //self::assertEquals('', $recordInfos[0]->getRecordIdentifier());
        //self::assertNotEmpty($recordInfos[0]->getRecordOrigin());
        //self::assertNotEmpty($recordInfos[0]->getLanguageOfCataloging());

        // TODO: implement reading of elements
    }

    public function testGetNoRecordInfosByQueryForBookDocument()
    {
        $recordInfos = $this->bookReader->getRecordInfos('[./mods:descriptionStandard="xyz"]');
        self::assertEmpty($recordInfos);
    }

    public function testGetRecordInfosForSerialDocument()
    {
        $recordInfos = $this->serialReader->getRecordInfos();
        self::assertNotEmpty($recordInfos);
        self::assertEquals(1, count($recordInfos));
        self::assertNotEmpty($recordInfos[0]->getValue());
        //self::assertEquals('', $recordInfos[0]->getRecordIdentifier());
        //self::assertNotEmpty($recordInfos[0]->getRecordOrigin());
        //self::assertNotEmpty($recordInfos[0]->getLanguageOfCataloging());

        // TODO: implement reading of elements
    }

    public function testGetRecordInfosByQueryForSerialDocument()
    {
        $recordInfos = $this->serialReader->getRecordInfos('[./mods:descriptionStandard="aacr"]');
        self::assertNotEmpty($recordInfos);
        self::assertEquals(1, count($recordInfos));
        self::assertNotEmpty($recordInfos[0]->getValue());
        //self::assertEquals('', $recordInfos[0]->getRecordIdentifier());
        //self::assertNotEmpty($recordInfos[0]->getRecordOrigin());
        //self::assertNotEmpty($recordInfos[0]->getLanguageOfCataloging());

        // TODO: implement reading of elements
    }

    public function testGetNoRecordInfosByQueryForSerialDocument()
    {
        $recordInfos = $this->serialReader->getRecordInfos('[./mods:descriptionStandard="xyz"]');
        self::assertEmpty($recordInfos);
    }

    public function testGetNoRelatedItemsForBookDocument()
    {
        $relatedItems = $this->bookReader->getRelatedItems();
        self::assertEmpty($relatedItems);
    }

    public function testGetRelatedItemsForSerialDocument()
    {
        $relatedItems = $this->serialReader->getRelatedItems();
        self::assertNotEmpty($relatedItems);
        self::assertEquals(1, count($relatedItems));
        self::assertNotEmpty($relatedItems[0]->getValue());
        self::assertNotEmpty($relatedItems[0]->getType());
        self::assertEquals('preceding', $relatedItems[0]->getType());

        // TODO: implement reading of elements
    }

    public function testGetRelatedItemsByQueryForSerialDocument()
    {
        $relatedItems = $this->serialReader->getRelatedItems('[./mods:identifier="1525-321X"]');
        self::assertNotEmpty($relatedItems);
        self::assertEquals(1, count($relatedItems));
        self::assertNotEmpty($relatedItems[0]->getValue());
        self::assertNotEmpty($relatedItems[0]->getType());
        self::assertEquals('preceding', $relatedItems[0]->getType());

        // TODO: implement reading of elements
    }

    public function testGetNoRelatedItemsByQueryForSerialDocument()
    {
        $relatedItems = $this->serialReader->getRelatedItems('[./mods:identifier="15-32"]');
        self::assertEmpty($relatedItems);
    }

    public function testGetSubjectsForBookDocument()
    {
        $subjects = $this->bookReader->getSubjects();
        self::assertNotEmpty($subjects);
        self::assertEquals(7, count($subjects));
        self::assertNotEmpty($subjects[0]->getValue());
        //self::assertNotEmpty($subjects[0]->getTopic());
        //self::assertNotEmpty($subjects[0]->getGeographic());

        // TODO: implement reading of elements
    }

    public function testGetSubjectsByQueryForBookDocument()
    {
        $subjects = $this->bookReader->getSubjects('[./mods:topic="Mass media"]');
        self::assertNotEmpty($subjects);
        self::assertEquals(1, count($subjects));
        self::assertNotEmpty($subjects[0]->getValue());
        //self::assertNotEmpty($subjects[0]->getTopic());
        //self::assertNotEmpty($subjects[0]->getGeographic());

        // TODO: implement reading of elements
    }

    public function testGetNoSubjectsByQueryForBookDocument()
    {
        $subjects = $this->bookReader->getSubjects('[./mods:topic="Unknown"]');
        self::assertEmpty($subjects);
    }

    public function testGetSubjectsForSerialDocument()
    {
        $subjects = $this->serialReader->getSubjects();
        self::assertNotEmpty($subjects);
        self::assertEquals(6, count($subjects));
        self::assertNotEmpty($subjects[0]->getValue());
        //self::assertNotEmpty($subjects[0]->getTopic());
        //self::assertNotEmpty($subjects[0]->getGenre());

        // TODO: implement reading of elements
    }

    public function testGetSubjectsByQueryForSerialDocument()
    {
        $subjects = $this->serialReader->getSubjects('[./mods:genre="Directories"]');
        self::assertNotEmpty($subjects);
        self::assertEquals(1, count($subjects));
        self::assertNotEmpty($subjects[0]->getValue());
        //self::assertNotEmpty($subjects[0]->getForm());
        //self::assertNotEmpty($subjects[0]->getGenre());

        // TODO: implement reading of elements
    }

    public function testGetNoSubjectsByQueryForSerialDocument()
    {
        $subjects = $this->serialReader->getSubjects('[./mods:topic="Unknown"]');
        self::assertEmpty($subjects);
    }

    public function testGetTableOfContentsForBookDocument()
    {
        $tableOfContents = $this->bookReader->getTableOfContents();
        self::assertNotEmpty($tableOfContents);
        self::assertEquals(1, count($tableOfContents));
        self::assertNotEmpty($tableOfContents[0]->getValue());
        self::assertEquals('Bluegrass odyssey -- Hills of Tennessee -- Sassafrass -- Muddy river -- Take your shoes off Moses -- Let Smokey Mountain smoke get in your eyes -- Farewell party -- Faded love', $tableOfContents[0]->getValue());
        self::assertNotEmpty($tableOfContents[0]->getDisplayLabel());
        self::assertEquals('Chapters', $tableOfContents[0]->getDisplayLabel());

        // TODO: implement reading of elements
    }

    public function testGetTableOfContentsByQueryForBookDocument()
    {
        $tableOfContents = $this->bookReader->getTableOfContents('[@displayLabel="Chapters"]');
        self::assertNotEmpty($tableOfContents);
        self::assertEquals(1, count($tableOfContents));
        self::assertNotEmpty($tableOfContents[0]->getValue());
        self::assertEquals('Bluegrass odyssey -- Hills of Tennessee -- Sassafrass -- Muddy river -- Take your shoes off Moses -- Let Smokey Mountain smoke get in your eyes -- Farewell party -- Faded love', $tableOfContents[0]->getValue());
        self::assertNotEmpty($tableOfContents[0]->getDisplayLabel());
        self::assertEquals('Chapters', $tableOfContents[0]->getDisplayLabel());

        // TODO: implement reading of elements
    }

    public function testGetNoTableOfContentsByQueryForBookDocument()
    {
        $tableOfContents = $this->bookReader->getTableOfContents('[@displayLabel="Pages"]');
        self::assertEmpty($tableOfContents);
    }

    public function testGetNoTableOfContentsForSerialDocument()
    {
        $tableOfContents = $this->serialReader->getTableOfContents();
        self::assertEmpty($tableOfContents);
    }

    public function testGetTitleInfosForBookDocument()
    {
        $titleInfos = $this->bookReader->getTitleInfos();
        self::assertNotEmpty($titleInfos);
        self::assertEquals(1, count($titleInfos));
        self::assertNotEmpty($titleInfos[0]->getValue());
        //self::assertNotEmpty($titleInfos[0]->getTitle());
        //self::assertNotEmpty($titleInfos[0]->getSubTitle());

        // TODO: implement reading of elements
    }

    public function testGetTitleInfosForSerialDocument()
    {
        $titleInfos = $this->serialReader->getTitleInfos();
        self::assertNotEmpty($titleInfos);
        self::assertEquals(3, count($titleInfos));
        self::assertNotEmpty($titleInfos[0]->getValue());
        //self::assertNotEmpty($titleInfos[0]->getTitle());
        //self::assertNotEmpty($titleInfos[0]->getSubTitle());

        // TODO: implement reading of elements
    }

    public function testGetTitleInfosByQueryForSerialDocument()
    {
        $titleInfos = $this->serialReader->getTitleInfos('[@type="alternative"]');
        self::assertNotEmpty($titleInfos);
        self::assertEquals(1, count($titleInfos));
        self::assertNotEmpty($titleInfos[0]->getValue());
        //self::assertNotEmpty($titleInfos[0]->getTitle());
        //self::assertEmpty($titleInfos[0]->getSubTitle());

        // TODO: implement reading of elements
    }

    public function testGetNoTitleInfosByQueryForSerialDocument()
    {
        $titleInfos = $this->serialReader->getTitleInfos('[@type="uniform"]');
        self::assertEmpty($titleInfos);
    }

    public function testGetTypeOfResourceForBookDocument()
    {
        $typeOfResource = $this->bookReader->getTypeOfResource();
        self::assertNotNull($typeOfResource);
        self::assertNotEmpty($typeOfResource->getDisplayLabel());
        self::assertEquals('format', $typeOfResource->getDisplayLabel());
        self::assertNotEmpty($typeOfResource->getValue());
        self::assertEquals('text', $typeOfResource->getValue());
    }

    public function testGetTypeOfResourceByQueryForBookDocument()
    {
        $typeOfResource = $this->bookReader->getTypeOfResource('[@displayLabel="format"]');
        self::assertNotNull($typeOfResource);
        self::assertNotEmpty($typeOfResource->getDisplayLabel());
        self::assertEquals('format', $typeOfResource->getDisplayLabel());
        self::assertNotEmpty($typeOfResource->getValue());
        self::assertEquals('text', $typeOfResource->getValue());
    }

    public function testGetNoTypeOfResourceByQueryForBookDocument()
    {
        $typeOfResource = $this->bookReader->getTypeOfResource('[@displayLabel="random"]');
        self::assertNull($typeOfResource);
    }

    public function testGetTypeOfResourceForSerialDocument()
    {
        $typeOfResource = $this->serialReader->getTypeOfResource();
        self::assertNotNull($typeOfResource);
        self::assertEmpty($typeOfResource->getDisplayLabel());
        self::assertNotEmpty($typeOfResource->getValue());
        self::assertEquals('text', $typeOfResource->getValue());
    }

    public function testGetNoTypeOfResourceByQueryForSerialDocument()
    {
        $abstract = $this->serialReader->getAbstract('[@displayForm="format"]');
        self::assertNull($abstract);
    }
}
