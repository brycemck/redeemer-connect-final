<?php
/**
 * Copyright 2013 Asim Liaquat
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Google\Spreadsheet;

/**
 * Document feed. 
 *
 * @package    Google
 * @subpackage Spreadsheet
 * @version    0.1
 * @author     Asim Liaquat <asimlqt22@gmail.com>
 */
class DocumentFeed extends \ArrayIterator
{
    /**
     * The Document feed xml object
     * 
     * @var \SimpleXMLElement
     */
    private $xml;

    /**
     * Initializes the the Document feed object
     * 
     * @param string $xml the raw xml string of a Document feed
     */
    public function __construct($xml)
    {
        $this->xml = new \SimpleXMLElement($xml);

        $documents = array();
        foreach ($this->xml->entry as $entry) {
            $documents[] = new Document($entry);
        }
        parent::__construct($documents);
    }

    /**
     * Gets a spreadhseet from the feed by its title. i.e. the name of the Document
     * in google drive
     * 
     * @param  string $title
     * 
     * @return \Google\Spreadsheet\Document will return null if no spreadhseet found with the specified title
     */
    public function getByTitle($title)
    {
        foreach($this->xml->entry as $entry) {
            if($entry->title->__toString() == $title) {
                return new Document($entry);
            }
        }
        return null;
    }

    /**
     * Gets a spreadhseet from the feed by its title and it's category. i.e. the name of the Document
     * in google drive and the parent folder it is in
     * 
     * @param  string $title, string $category
     * 
     * @return \Google\Spreadsheet\Document will return null if no spreadhseet found with the specified title
     */
    public function getByTitleAndCategory($title,$category)
    {
        foreach($this->xml->entry as $entry) {
            foreach($entry->category as $categories) {
                if($categories->attributes()->label->__toString() == $category) {
                    if($entry->title->__toString() == $title) {
                        return new Document($entry);
                    }          
                }
            }
        }
        return null;
    }

}