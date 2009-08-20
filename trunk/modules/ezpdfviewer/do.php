<?php
/**
 * PHP version 5
 *
 * @category  PHP
 * @package   eZPDFViewer
 * @copyright 2009 Jean-Yves Zinsou
 * @author    Jean-Yves Zinsou
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License V2
 * version    1.3                                                                                                                                                                                        
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



// take current object of type eZModule 
$Module = $Params['Module'];

// read parameter UnOrdered View 
// http://.../ezpdfviewer/attribute_version/124/attribute_id/3
$attributeVersion= $Params['attribute_version']; 
$attributeID = $Params['attribute_id']; 
$context= $Params['context']; 
$fullscreen= $Params['fullscreen']; 


//declares the array to hold of the display info of the page
$result = array(); 

//intantiates the http tool
$http =  eZHTTPTool::instance (); 


// library for template functions
require_once( 'kernel/common/template.php' );
// initialize Templateobject
$tpl = templateInit();

//gets the attribute objectcontent object
$attribute=eZContentObjectAttribute::fetch ( $attributeID,$attributeVersion);
if (! is_object ($attribute))
{
	$error['title']="ERROR :Attribute not found";
	$error['description']="Id : " .  $attributeID . " / Version : " .$attributeVersion ;
	$tpl->setVariable( 'error_title',$error['title'] );
	$tpl->setVariable( 'error_description',$error['description'] );

	$Result ['content'] = $tpl->fetch ( 'design:full/error.tpl' );
	// generate route Modul1/create 
	$Result ['path'] = array( array( 'url' => false,
											 'text' => 'ezpftpupload'), 
								  array( 'url' => false,
								   'text' => 'error' ) ); 
}


// ckecks the format
if($attribute->content()->mimeTypePart() != "pdf" )
{
	$error['title']="ERROR : Wrong format";
	$error['description']="Only pdf files can be previewed";
	$tpl->setVariable( 'error_title',$error['title'] );
	$tpl->setVariable( 'error_description',$error['description'] );

	$Result ['content'] = $tpl->fetch ( 'design:full/error.tpl' );
	// generate route Modul1/create 
	$Result ['path'] = array( array( 'url' => false,
											 'text' => 'ezpftpupload'), 
								  array( 'url' => false,
								   'text' => 'error' ) ); 
	return;
}

include_once( 'extension/ezpdfviewer/classes/ezpdfviewer.php' );
$ezPDFViewer=new eZPDFViewer($attribute);

if ($context=="edit")	
{
	// creates the viewer
	if ( ! $ezPDFViewer->create())
	{
		$error['title']="ERROR : Conversion failed";
		$error['description']="The pdf file could not be created.Please contact your webmaster";
		$tpl->setVariable( 'error_title',$error['title'] );
		$tpl->setVariable( 'error_description',$error['description'] );

		$Result ['content'] = $tpl->fetch ( 'design:full/error.tpl' );
		// generate route Modul1/create 
		$Result ['path'] = array( array( 'url' => false,
												 'text' => 'ezpftpupload'), 
									  array( 'url' => false,
									   'text' => 'error' ) ); 
	return;
	}
	
		$objectEditUrl="/content/edit/".$attribute->ContentObjectID . "/" .$attribute->Version."/".$attribute->LanguageCode;
		if($fullscreen==="yes")
		{
			$Result['pagelayout'] ="";   
		}

		$tpl->setVariable( 'converted_pdf_swf', $ezPDFViewer->resultFileUrl());





		$backUrl= $objectEditUrl;
		$tpl->setVariable( 'back_url', $backUrl);
		eZURI::transformURI($backUrl);
		$http->setSessionVariable( "LastAccessesURI", "content/view/full/2" );
		// use find/replace (parsing) in the template and save the result for $module_result.content
		echo $tpl->fetch ( 'design:full/create.tpl' );

		/*
		   fix to avoid going back to viewer creation after publishing
		   */
		eZDB::checkTransactionCounter();
		eZExecution::cleanExit();
		return;
/*
   fix
		// use find/replace (parsing) in the template and save the result for $module_result.content
		$Result ['content'] = $tpl->fetch ( 'design:full/create.tpl' );
		// generate route Modul1/create 
		$Result ['path'] = array( array( 'url' => 'ezpdfviewer',
			                                 'text' => 'ezpdfviewer'), 
		                          array( 'url' => false,
                                   'text' => 'view' ) ); 
		return;
*/
}

if ($context=="view")	
{
	//checks if the viewer exists , if not, creates it
	if ( ! $ezPDFViewer->view())
	{
		$error['title']="ERROR : Conversion failed";
		$error['description']="The pdf file could not be created.Please contact your webmaster";
		$tpl->setVariable( 'error_title',$error['title'] );
		$tpl->setVariable( 'error_description',$error['description'] );

		$Result ['content'] = $tpl->fetch ( 'design:full/error.tpl' );
		// generate route Modul1/create 
		$Result ['path'] = array( array( 'url' => false,
												 'text' => 'ezpftpupload'), 
									  array( 'url' => false,
									   'text' => 'error' ) ); 
	return;
	}
	
		if($fullscreen==="yes")
		{
			$Result['pagelayout'] ="";   
		}

		$tpl->setVariable( 'converted_pdf_swf', $ezPDFViewer->resultFileUrl());
		$backUrl= $attribute->object()->mainNode()->urlAlias();
		$tpl->setVariable( 'back_url', $backUrl);
		eZURI::transformURI($backUrl);

		// use find/replace (parsing) in the template and save the result for $module_result.content
		$Result ['content'] = $tpl->fetch ( 'design:full/view.tpl' );
		// generate route Modul1/create 
		$Result ['path'] = array( array( 'url' => 'ezpdfviewer',
			                                 'text' => 'ezpdfviewer'), 
		                          array( 'url' => false,
                                   'text' => 'view' ) ); 
		return;
}
?>
