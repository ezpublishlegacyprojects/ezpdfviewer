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

// library for template functions
require_once( 'kernel/common/template.php' );
 
// take current object of type eZModule 
$Module = $Params['Module'];
 
// read parameter Ordered View 
// http://.../modul1/list/ $Params['ParamOne'] / $Params['ParamTwo'] 
// for example .../modul1/list/view/5
 
// read parameter UnOrdered View 
// http://.../modul1/list/param4/$Params['4Param']/param3/$Params['3Param'] 
// for example.../modul1/list/.../.../param4/141/param3/131
$attribute_version= $Params['attribute_version']; 
$attribute_id = $Params['attribute_id']; 


// initialize Templateobject
$tpl = templateInit();

//declares the array to hold of the display info of the page
$Result = array(); 


//gettings values from http
$http =  eZHTTPTool::instance (); 


//gets the attribute objectcontent object
$attribute=eZContentObjectAttribute::fetch ( $attribute_id,$attribute_version);
if (! is_object ($attribute))
{
	$msg="error : Attribute not found";
	echo $msg;
	exit;
}
$attribute_content= $attribute->content() ;
$filename=$attribute_content->Filename;
$originalfilename=$attribute_content->OriginalFilename;
$filepath  = $attribute_content->filePath();


// ckecks the format
if($attribute_content->mimeTypePart() != "pdf" )
{
	$msg="error : wrong format file, only pdf allowed";
	echo $msg;
	exit;
}


//transform
$fileSep = eZSys::fileSeparator();
$tmpDir = eZSys::rootDir().$fileSep.'var'.$fileSep.'ezpdfviewer';
$viewer = eZSys::rootDir().$fileSep.'extension'.$fileSep.'ezpdfviewer'.$fileSep .'design'.$fileSep .'standard'.$fileSep .'swfobject' . $fileSep .'rfxview.swf';


        //check if $tmpdir exists else try to create it
        if(!eZFileHandler::doExists($tmpDir))
        {
            if(!eZDir::mkdir( $tmpDir, eZDir::directoryPermission(), true ))
            {
                eZDebug::writeWarning("ezPdfviewer : could not create temporary directory $tmpDir ", 'ezPdfviewer');
                eZLog::write("ezPdfviewer Error : could not create temporary directory $tmpDir ",'ezpdfviewer.log');
             //   return false;
            }
        }
        elseif(!eZFileHandler::doIsWriteable($tmpDir))
        {
            //check if $tmpdir is writable
            eZDebug::writeWarning("ezPdfviewier Error : please make $this writable ", 'ezpdfviewer');
            eZLog::write("ezPdfViewer Error : please make $this writable ",'ezpdfviewer.log');
          //  return false;
        }





$resultfileName=substr($filename,0,-4); ;
$resultfileName=$resultfileName .".swf";

$resultFile=$tmpDir.$fileSep.$resultfileName;

$ezpdfviewerINI = eZINI::instance('ezpdfviewer.ini');
$command=$ezpdfviewerINI->variable('BinarySettings', 'pdf2swfExecutable');
$command .=" -B ". $viewer; 
$command .=" -o ". $resultFile; 
$command.=" " .eZSys::rootDir().$fileSep. $filepath; 

        if(!eZFileHandler::doExists($resultFile))
		{
			exec($command);
		}

$Result['pagelayout'] ="";   

$tpl->setVariable( 'converted_pdf_swf', eZSys::wwwDir(). '/var/ezpdfviewer/'.$resultfileName);
$back_url= $attribute->object()->mainNode()->urlAlias();
$tpl->setVariable( 'back_url', $back_url);


// use find/replace (parsing) in the template and save the result for $module_result.content
$Result ['content'] = $tpl->fetch ( 'design:full/view.tpl' );
// generate route Modul1/create 
$Result ['path'] = array( array( 'url' => 'ezpdfviewer/view',
			                                 'text' => 'ezpdfviewer'), 
		                          array( 'url' => false,
                                   'text' => 'view' ) ); 

?>
