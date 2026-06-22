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
use Slub\Mods\Element\Subject;
use Slub\Mods\ModsReaderTest;

/**
 * Tests for reading Subject element
 */
class SubjectReaderTest extends ModsReaderTest
{

    #[Test]
    public function getSubjectsForBookDocument()
    {
        $subjects = $this->bookReader->getSubjects();
        self::assertNotEmpty($subjects);
        self::assertCount(8, $subjects);
        self::assertFirstSubjectForBookDocument($subjects[0]);
    }

    #[Test]
    public function getSubjectForBookDocument()
    {
        $subjects = $this->bookReader->getSubject(1);
        self::assertSecondSubjectForBookDocument($subjects);
    }

    #[Test]
    public function getFirstSubjectForBookDocument()
    {
        $subjects = $this->bookReader->getFirstSubject();
        self::assertFirstSubjectForBookDocument($subjects);
    }

    #[Test]
    public function getLastSubjectForBookDocument()
    {
        $subjects = $this->bookReader->getLastSubject();
        self::assertEightSubjectForBookDocument($subjects);
    }

    #[Test]
    public function getSubjectsByQueryForBookDocument()
    {
        $subjects = $this->bookReader->getSubjects('[./mods:topic="Mass media"]');
        self::assertNotEmpty($subjects);
        self::assertCount(1, $subjects);
        self::assertFourthSubjectForBookDocument($subjects[0]);
    }

    #[Test]
    public function getSubjectByQueryForBookDocument()
    {
        $subject = $this->bookReader->getSubject(0, '[./mods:topic="Mass media"]');
        self::assertFourthSubjectForBookDocument($subject);
    }

    #[Test]
    public function getFirstSubjectByQueryForBookDocument()
    {
        $subject = $this->bookReader->getFirstSubject('[./mods:topic="Mass media"]');
        self::assertFourthSubjectForBookDocument($subject);
    }

    #[Test]
    public function getLastSubjectByQueryForBookDocument()
    {
        $subject = $this->bookReader->getLastSubject('[./mods:topic="Mass media"]');
        self::assertFourthSubjectForBookDocument($subject);
    }

    #[Test]
    public function getNoSubjectsByQueryForBookDocument()
    {
        $subjects = $this->bookReader->getSubjects('[./mods:topic="Unknown"]');
        self::assertEmpty($subjects);
    }

    #[Test]
    public function getNoSubjectByQueryForBookDocument()
    {
        $subject = $this->bookReader->getSubject(5, '[./mods:topic="Unknown"]');
        self::assertNull($subject);
    }

    #[Test]
    public function getNoFirstSubjectByQueryForBookDocument()
    {
        $subject = $this->bookReader->getFirstSubject(5, '[./mods:topic="Unknown"]');
        self::assertNull($subject);
    }

    #[Test]
    public function getNoLastSubjectByQueryForBookDocument()
    {
        $subject = $this->bookReader->getLastSubject('[./mods:topic="Unknown"]');
        self::assertNull($subject);
    }

    #[Test]
    public function getSubjectsForSerialDocument()
    {
        $subjects = $this->serialReader->getSubjects();
        self::assertNotEmpty($subjects);
        self::assertCount(7, $subjects);
        self::assertNotEmpty($subjects[0]->getValue());
        self::assertNotEmpty($subjects[0]->getCartographics());

        // TODO: implement reading of cartographics
        /*
        self::assertNotEmpty($subjects[0]->getCartographics()[0]->getCoordinates());
        self::assertEquals('', $subjects[0]->getCartographics()[0]->getCoordinates()[0]->getValue());
        self::assertNotEmpty($subjects[0]->getCartographics()[0]->getScale());
        self::assertNotEmpty($subjects[0]->getCartographics()[0]->getProjection());
        */
    }

    #[Test]
    public function getSubjectsByQueryForSerialDocument()
    {
        $subjects = $this->serialReader->getSubjects('[./mods:genre="Directories"]');
        self::assertNotEmpty($subjects);
        self::assertCount(1, $subjects);
        self::assertNotEmpty($subjects[0]->getValue());
        self::assertNotEmpty($subjects[0]->getTopics());
        self::assertEquals('Web sites', $subjects[0]->getTopics()[0]->getValue());
        self::assertNotEmpty($subjects[0]->getGenres());
        self::assertEquals('Directories', $subjects[0]->getGenres()[0]->getValue());
    }

    #[Test]
    public function getNoSubjectsByQueryForSerialDocument()
    {
        $subjects = $this->serialReader->getSubjects('[./mods:topic="Unknown"]');
        self::assertEmpty($subjects);
    }

    private static function assertFirstSubjectForBookDocument(Subject $subject): void
    {
        self::assertNotEmpty($subject->getValue());

        $hierarchicalGeographics = $subject->getHierarchicalGeographics();
        self::assertNotEmpty($hierarchicalGeographics);

        $countries = $hierarchicalGeographics[0]->getCountries();
        self::assertNotEmpty($countries);
        self::assertCount(2, $countries);
        self::assertEquals(1, $countries[0]->getLevel());
        self::assertEquals('United Kingdom', $countries[0]->getValue());
        self::assertNotEmpty($hierarchicalGeographics[0]->getRegions());
        self::assertEquals('North West', $hierarchicalGeographics[0]->getRegions()[0]->getValue());
        self::assertNotEmpty($hierarchicalGeographics[0]->getCounties());
        self::assertEquals('Cumbria', $hierarchicalGeographics[0]->getCounties()[0]->getValue());
        self::assertNotEmpty($hierarchicalGeographics[0]->getCities());
        self::assertEquals('Providence', $hierarchicalGeographics[0]->getCities()[0]->getValue());

        $citySections = $hierarchicalGeographics[0]->getCitySections();
        self::assertNotEmpty($citySections);
        self::assertCount(2, $citySections);
        self::assertEquals('neighborhood', $citySections[0]->getType());
        self::assertEquals(1, $citySections[0]->getLevel());
        self::assertEquals('East Side', $citySections[0]->getValue());

        $areas = $hierarchicalGeographics[0]->getAreas();
        self::assertNotEmpty($areas);
        self::assertCount(1, $areas);
        self::assertEquals('national park', $areas[0]->getType());
        self::assertEquals('Lake District', $areas[0]->getValue());
    }

    private static function assertSecondSubjectForBookDocument(Subject $subject): void
    {
        self::assertNotEmpty($subject->getValue());

        $geographicCodes = $subject->getGeographicCodes();
        self::assertNotEmpty($geographicCodes);
        self::assertEquals('marcgac', $geographicCodes[0]->getAuthority());
        self::assertEquals('n-us---', $geographicCodes[0]->getValue());
    }

    private static function assertFourthSubjectForBookDocument(Subject $subject): void
    {
        self::assertNotEmpty($subject->getValue());
        self::assertEquals('lcsh', $subject->getAuthority());

        $topics = $subject->getTopics();
        self::assertNotEmpty($topics);
        self::assertEquals('Mass media', $topics[0]->getValue());
        self::assertEquals('Political aspects', $topics[1]->getValue());

        $geographics = $subject->getGeographics();
        self::assertNotEmpty($geographics);
        self::assertEquals('United States', $geographics[0]->getValue());
    }

    private static function assertEightSubjectForBookDocument(Subject $subject): void
    {
        self::assertNotEmpty($subject->getValue());
        self::assertEquals('lcsh', $subject->getAuthority());

        $geographics = $subject->getGeographics();
        self::assertNotEmpty($geographics);
        self::assertEquals('United States', $geographics[0]->getValue());

        $topics = $subject->getTopics();
        self::assertNotEmpty($topics);
        self::assertEquals('Politics and government', $topics[0]->getValue());

        $temporals = $subject->getTemporals();
        self::assertNotEmpty($temporals);
        self::assertEquals('20th century', $temporals[0]->getValue());
    }
}
