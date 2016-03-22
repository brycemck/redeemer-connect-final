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
 * Document. Represents a single Document.
 *
 * @package    Google
 * @subpackage Spreadsheet
 * @version    0.1
 * @author     Asim Liaquat <asimlqt22@gmail.com>
 */
class Document
{
    /**
     * The Document xml object
     * 
     * @var \SimpleXMLElement
     */
    private $xml;

    /**
     * Initializes the Document object
     * 
     * @param string|\SimpleXMLElement $xml
     */
    public function __construct($xml) {
        if(is_string($xml))
            $this->xml = new \SimpleXMLElement($xml);
        else
            $this->xml = $xml;
    }

    /**
     * Get the Document xml
     * 
     * @return \SimpleXMLElement
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * Returns the title (name) of the Document
     * 
     * @return string
     */
    public function getTitle() {
        return $this->xml->title->__toString();
    }

}