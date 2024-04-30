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

use Slub\Mods\Element\AbstractElement;
use Slub\Mods\Element\AccessCondition;
use Slub\Mods\Element\Classification;
use Slub\Mods\Element\Extension;
use Slub\Mods\Element\Genre;
use Slub\Mods\Element\Identifier;
use Slub\Mods\Element\Language;
use Slub\Mods\Element\Location;
use Slub\Mods\Element\Name;
use Slub\Mods\Element\Note;
use Slub\Mods\Element\OriginInfo;
use Slub\Mods\Element\Part;
use Slub\Mods\Element\PhysicalDescription;
use Slub\Mods\Element\RecordInfo;
use Slub\Mods\Element\RelatedItem;
use Slub\Mods\Element\Subject;
use Slub\Mods\Element\TableOfContents;
use Slub\Mods\Element\TargetAudience;
use Slub\Mods\Element\TitleInfo;
use Slub\Mods\Element\TypeOfResource;
use Slub\Mods\Element\Xml\Element;

/**
 * Metadata MODS reader class for the 'php-mods-reader' library.
 * @see https://www.loc.gov/standards/mods/userguide/generalapp.html
 *
 * @access public
 */
class ModsReader
{
    /**
     * @access private
     * @var \SimpleXMLElement The metadata XML
     **/
    private $xml;

    /**
     * This creates the MODS Reader for given XML
     *
     * @access public
     *
     * @param \SimpleXMLElement $xml The XML for reader
     *
     * @return void
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }

    /**
     * Get the value of the <abstract> element.
     * @see https://www.loc.gov/standards/mods/userguide/abstract.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return ?AbstractElement
     */
    public function getAbstract(string $query = ''): ?AbstractElement
    {
        $xpath = './mods:abstract' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            return new AbstractElement($element->getValues()[0]);
        }
        return null;
    }

    /**
     * Get the the array of the <accessCondition> elements.
     * @see https://www.loc.gov/standards/mods/userguide/accesscondition.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return AccessCondition[]
     */
    public function getAccessConditions(string $query = ''): array
    {
        $accessConditions = [];
        $xpath = './mods:accessCondition' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $accessConditions[] = new AccessCondition($value);
            }
        }
        return $accessConditions;
    }

    /**
     * Get the the array of the <classification> elements.
     * @see https://www.loc.gov/standards/mods/userguide/classification.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return Classification[]
     */
    public function getClassifications(string $query = ''): array
    {
        $classifications = [];
        $xpath = './mods:classification' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $classifications[] = new Classification($value);
            }
        }
        return $classifications;
    }

    /**
     * Get the the array of the <extension> elements.
     * @see https://www.loc.gov/standards/mods/userguide/extension.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return Extension[]
     */
    public function getExtensions(string $query = ''): array
    {
        $extensions = [];
        $xpath = './mods:extension' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $extensions[] = new Extension($value);
            }
        }
        return $extensions;
    }

    /**
     * Get the the array of the <genre> elements.
     * @see https://www.loc.gov/standards/mods/userguide/genre.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return Genre[]
     */
    public function getGenres(string $query = ''): array
    {
        $genres = [];
        $xpath = './mods:genre' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $genres[] = new Genre($value);
            }
        }
        return $genres;
    }

    /**
     * Get the the array of the <identifier> elements.
     * @see https://www.loc.gov/standards/mods/userguide/identifier.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return Identifier[]
     */
    public function getIdentifiers(string $query = ''): array
    {
        $identifiers = [];
        $xpath = './mods:identifier' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $identifiers[] = new Identifier($value);
            }
        }
        return $identifiers;
    }

    /**
     * Get the array of the <language> elements.
     * @see https://www.loc.gov/standards/mods/userguide/language.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return Language[]
     */
    public function getLanguages(string $query = ''): array
    {
        $languages = [];
        $xpath = './mods:language' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $languages[] = new Language($value);
            }
        }
        return $languages;
    }

    /**
     * Get the the array of the <location> elements.
     * @see https://www.loc.gov/standards/mods/userguide/location.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return Location[]
     */
    public function getLocations(string $query = ''): array
    {
        $locations = [];
        $xpath = './mods:location' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $locations[] = new Location($value);
            }
        }
        return $locations;
    }

    /**
     * Get the the array of the <name> elements.
     * @see https://www.loc.gov/standards/mods/userguide/name.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return Name[]
     */
    public function getNames(string $query = ''): array
    {
        $names = [];
        $xpath = './mods:name' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $names[] = new Name($value);
            }
        }
        return $names;
    }

    /**
     * Get the the array of the <note> elements.
     * @see https://www.loc.gov/standards/mods/userguide/note.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return Note[]
     */
    public function getNotes(string $query = ''): array
    {
        $notes = [];
        $xpath = './mods:note' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $notes[] = new Note($value);
            }
        }
        return $notes;
    }

     /**
     * Get the the array of the <originInfo> elements.
     * @see https://www.loc.gov/standards/mods/userguide/origininfo.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return OriginInfo[]
     */
    public function getOriginInfos(string $query = ''): array
    {
        $originInfos = [];
        $xpath = './mods:originInfo' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $originInfos[] = new OriginInfo($value);
            }
        }
        return $originInfos;
    }

    /**
     * Get the the array of the <part> elements.
     * @see https://www.loc.gov/standards/mods/userguide/part.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return Part[]
     */
    public function getParts(string $query = ''): array
    {
        $parts = [];
        $xpath = './mods:part' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $parts[] = new Part($value);
            }
        }
        return $parts;
    }

    /**
     * Get the the array of the <physicalDescription> elements.
     * @see https://www.loc.gov/standards/mods/userguide/physicaldescription.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return PhysicalDescription[]
     */
    public function getPhysicalDescriptions(string $query = ''): array
    {
        $physicalDescriptions = [];
        $xpath = './mods:physicalDescription' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $physicalDescriptions[] = new PhysicalDescription($value);
            }
        }
        return $physicalDescriptions;
    }

    /**
     * Get the the array of the <recordInfo> elements.
     * @see https://www.loc.gov/standards/mods/userguide/recordinfo.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return RecordInfo[]
     */
    public function getRecordInfos(string $query = ''): array
    {
        $recordInfos = [];
        $xpath = './mods:recordInfo' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $recordInfos[] = new RecordInfo($value);
            }
        }
        return $recordInfos;
    }

    /**
     * Get the the array of the <relatedItem> elements.
     * @see https://www.loc.gov/standards/mods/userguide/relateditem.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return RelatedItem[]
     */
    public function getRelatedItems(string $query = ''): array
    {
        $relatedItems = [];
        $xpath = './mods:relatedItem' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $relatedItems[] = new RelatedItem($value);
            }
        }
        return $relatedItems;
    }

    /**
     * Get the the array of the <subject> elements.
     * @see https://www.loc.gov/standards/mods/userguide/subject.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return Subject[]
     */
    public function getSubjects(string $query = ''): array
    {
        $subjects = [];
        $xpath = './mods:subject' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $subjects[] = new Subject($value);
            }
        }
        return $subjects;
    }

    /**
     * Get the the array of the <tableOfContents> elements.
     * @see https://www.loc.gov/standards/mods/userguide/tableofcontents.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return TableOfContents[]
     */
    public function getTableOfContents(string $query = ''): array
    {
        $tableOfContents = [];
        $xpath = './mods:tableOfContents' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $tableOfContents[] = new TableOfContents($value);
            }
        }
        return $tableOfContents;
    }

    /**
     * Get the the array of the <targetAudience> elements.
     * @see https://www.loc.gov/standards/mods/userguide/targetaudience.html
     *
     * @access public
     *
     * @param string $query The XPath query for metadata search
     *
     * @return TargetAudience[]
     */
    public function getTargetAudience(string $query = ''): array
    {
        $targetAudiences = [];
        $xpath = './mods:targetAudience' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $targetAudiences[] = new TargetAudience($value);
            }
        }
        return $targetAudiences;
    }

    /**
     * Get the the array of the <titleInfo> elements.
     * @see https://www.loc.gov/standards/mods/userguide/titleinfo.html
     *
     * @access public
     *
     *  @param string $query The XPath query for metadata search
     *
     * @return TitleInfo[]
     */
    public function getTitleInfos(string $query = ''): array
    {
        $titleInfos = [];
        $xpath = './mods:titleInfo' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            foreach ($element->getValues() as $value) {
                $titleInfos[] = new TitleInfo($value);
            }
        }
        return $titleInfos;
    }

    /**
     * Get the value of the <typeOfResource> element.
     * @see https://www.loc.gov/standards/mods/userguide/typeofresource.html
     *
     * @access public
     * 
     * @param string $query The XPath query for metadata search
     *
     * @return ?TypeOfResource
     */
    public function getTypeOfResource(string $query = ''): ?TypeOfResource
    {
        $xpath = './mods:typeOfResource' . $query;
        $element = new Element($this->xml, $xpath);
        if ($element->exists()) {
            return new TypeOfResource($element->getValues()[0]);
        }
        return null;
    }
}
