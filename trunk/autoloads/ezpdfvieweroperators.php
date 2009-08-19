<?php
/**
 * PHP version 5
 *
 * @category  PHP
 * @package   eZPDFViewer
 * @copyright 2009 Jean-Yves Zinsou
 * @author    Jean-Yves Zinsou
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License V2
 * version    2.0                                                                                                                                                                                        
 *
**/

// This program is free software; you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation; either version 2 of the License, or
//  (at your option) any later version.

//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//


class eZPdfViewerOperators
{

    function __construct()
    {
        $this->Operators = array( 'pdfviewerurl' );
    }

    function operatorList()
    {
        return $this->Operators;
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array(  'pdfviewerurl' => array('pdfviewerurl_params' => array( 'type'     => 'array',
                                                                           'required' => true
                                                                         )));
    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace,
    $currentNamespace, &$operatorValue, $namedParameters )
    {
        $params = $namedParameters['pdfviewerurl_params'];
        switch ( $operatorName )
        {
            case 'pdfviewerurl':
                {
                    $attribute = isset($params['attribute'])?$params['attribute'] : '';
					include_once( 'extension/ezpdfviewer/classes/ezpdfviewer.php' );
					$ezPDFViewer=new eZPDFViewer($attribute);

					if(eZFileHandler::doExists($ezPDFViewer->resultFilePath()))
					{
						$result= $ezPDFViewer->resultFileUrl();
					}
					else
					{
						$result="";
					}
				break;
                }
        }
        $operatorValue = $result;
    }

    public $Operators;
}
?>
