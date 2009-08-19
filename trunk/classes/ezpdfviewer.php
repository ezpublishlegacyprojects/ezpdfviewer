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



/*!
  \class eZPDFViewer ezpdfviewer.php
  \brief Main class for dealing with ezpdfviewer tool.

*/


class eZPDFViewer
{
	private $storageDir;
	private $swfViewerPath;
	private $binary;
	private $attribute;
	private $fileSep;

    /*!
     Constructor
    */
    function __construct ($attribute)
    {
		$eZPDFViewerINI = eZINI::instance('ezpdfviewer.ini');
		$this->fileSep = eZSys::fileSeparator();
		$this->storageDir = eZSys::rootDir().$this->fileSep.'var'.$this->fileSep.'ezpdfviewer';
		$this->swfViewerPath = eZSys::rootDir().$this->fileSep.ezExtension::baseDirectory().$this->fileSep.'ezpdfviewer'.$this->fileSep .'design';
		$this->swfViewerPath .= $this->fileSep .'standard'.$this->fileSep .'swfobject' . $this->fileSep .$eZPDFViewerINI->variable ('BinarySettings','swfPlayer');
		$this->binary=$eZPDFViewerINI->variable('BinarySettings', 'pdf2swfExecutable');
		$this->attribute=$attribute;
    }

	/**
	 *returns the filename of the file contained in the attribute
	**/
	function attributeFile()
	{
		return($this->attribute->content()->Filename);
	}
	/**
	 *returns the filepath of the file contained in the attribute
	**/
	function attributeFilePath()
	{
		return($this->attribute->content()->FilePath());
	}
	
	/**
	 *returns the filename of the file result flash file
	**/
	function resultFile()
	{
		return( substr($this->attributeFile(),0,-4).".swf");
	}

	/**
	 *returns the filepath of the file result flash file
	**/
	function resultFilePath()
	{
		return($this->storageDir.$this->fileSep.$this->resultFile ());
	}

	/**
	 *returns the urlof the file result flash file
	**/
	function resultFileUrl()
	{
		return(eZSys::wwwDir() . '/var/ezpdfviewer/'.$this->resultFile());
	}

	/**
	  *creates the flash from the pdf inside the attribute, embeds in the player, and stores the resulting file
	**/
	public function create() 
	{
        //check if storage exists else try to create it
        if(!eZFileHandler::doExists($this->storageDir))
        {
            if(!eZDir::mkdir($this->storageDir, eZDir::directoryPermission(), true ))
            {
                eZDebug::writeWarning("ezPdfviewer : could not create temporary directory ". $this->storageDir , 'ezPdfviewer');
                eZLog::write("ezPdfviewer Error : could not create temporary directory ".  $this->storageDir,'ezpdfviewer.log');
                return false;
            }
        }
        elseif(!eZFileHandler::doIsWriteable( $this->storageDir))
        {
            //check if storage directory  is writable
            eZDebug::writeWarning("ezPdfviewier Error : please make  " . $this->storageDir ." writable" , 'ezpdfviewer');
            eZLog::write("ezPdfViewer Error : please make ". $this->storageDir ." writable" ,'ezpdfviewer.log');
            return false;
        }

		$resultFilePath=$this->resultFilePath();
		$command=$this->binary;
		$command .=" -B ". $this->swfViewerPath; 
		$command .=" -o ". $this ->resultFilePath(); 
		$command .=" " .eZSys::rootDir() . $this->fileSep . $this->attributeFilePath(); 


		//let the magic begin
		//create the flash from pdf and embed it to a viewer with controls (previous, next, zoom, etc...)
		exec($command,$output,$return_val);
		if ($return_val !==0)
		{
            eZDebug::writeWarning("ezPdfviewier Error : pdf2swf Error " . join("\n", $output) , 'ezpdfviewer');
            eZLog::write("ezPdfViewer Error : pdf2swf Error " . join ('\n',$output) ,'ezpdfviewer.log');
			return false;
		}
			return true;
	}
	/**
	  * checks if the viewer file exists and  creates it if not
	**/
	public function view() 
	{
echo "TT";
		if(eZFileHandler::doExists($this->resultFilePath()))
		{
echo "bb";
			return true;;
		}
		else
		{
echo "aa";
			return $this->create();
		}

	}
}


?>

