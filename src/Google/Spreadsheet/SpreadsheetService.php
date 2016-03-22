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
 * Spreadsheet Service.
 *
 * @package    Google
 * @subpackage Spreadsheet
 * @version    0.1
 * @author     Asim Liaquat <asimlqt22@gmail.com>
 */
class SpreadsheetService
{
    /**
     * Fetches a list of spreadhsheet spreadsheets from google drive.
     *
     * @return \Google\Spreadsheet\SpreadsheetFeed
     */
    public function getSpreadsheets()
    {
        $serviceRequest = ServiceRequestFactory::getInstance();
        $serviceRequest->getRequest()->setFullUrl('https://docs.google.com/feeds/documents/private/full/-/spreadsheet');
        $res = $serviceRequest->execute();
        return new SpreadsheetFeed($res);
    }

    /**
     * Fetches a single spreadsheet from google drive by id if you decide
     * to store the id locally. This can help reduce api calls.
     *
     * @param  string $id the id of the spreadsheet
     *
     * @return \Google\Spreadsheet\Spreadsheet
     */
    public function getSpreadsheetById($id)
    {
        $serviceRequest = ServiceRequestFactory::getInstance();
        $serviceRequest->getRequest()->setFullUrl('https://docs.google.com/feeds/documents/private/full/-/spreadsheet/'. $id);
        $res = $serviceRequest->execute();
        return new Spreadsheet($res);
    }

    /**
     * Fetches spreadsheet from google drive searching by title
     * 
     * @param  string $title the id of the spreadsheet
     *
     * @return \Google\Spreadsheet\Spreadsheet
     */
    public function getSpreadsheetsByTitle($title)
    {
        $serviceRequest = ServiceRequestFactory::getInstance();
        $serviceRequest->getRequest()->setFullUrl('https://docs.google.com/feeds/documents/private/full/-/spreadsheet/?title='. urlencode($title));
        $res = $serviceRequest->execute();
        return new SpreadsheetFeed($res);
    }

    /**
     * copy a spreadsheet
     * 
     * @param  string $id id of spreadsheet to copy, string $title name of copy
     * 
     * @return void
     */
    public function copySpreadsheet($id,$title)
    {
        $serviceRequest = ServiceRequestFactory::getInstance();

        $entry = '
            <entry xmlns="http://www.w3.org/2005/Atom">
              <id>https://docs.google.com/feeds/default/private/full/document:'.$id.'</id>
              <title>'.$title.'</title>
            </entry>
        ';

        $serviceRequest->getRequest()->setFullUrl('https://docs.google.com/feeds/documents/private/full');
        $serviceRequest->getRequest()->setMethod(Request::POST);
        $serviceRequest->getRequest()->setHeaders(array('Content-Type'=>'application/atom+xml'));
        $serviceRequest->getRequest()->setPost($entry);
        $res = $serviceRequest->execute();
#        var_dump($res);
    }

}
