<?php
/**
 * PdfViewerOperators
 *
 * PHP version 5
 *
 * @category  PHP
 * @author    Jean-Yves Zinsou
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License V2
 * @link      http://projects.ez.no/ezpdfviewer
 */

// This program is free software; you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation; either version 2 of the License, or
//  (at your option) any later version.

//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] = array( 'script' => 'extension/ezpdfviewer/autoloads/ezpdfvieweroperators.php',
                                    'class' => 'eZPdfViewerOperators',
                                    'operator_names' => array( 'pdfviewerurl' ) );

?>
