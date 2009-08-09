Extension : ezpdfviewer
Requires  : eZ Publish 4.x.x (not tested on 3.X but can be easily customised for)
Authors   : Jean-Yves Zinsou


What is ezPdfViewer?
-------------------

ezPdfViewer is an ezpublish extension allows pdf to be transformed as flash files for visualisation without the downloading

Why ParadoxPDF?
License
-------

This program is free software; you can redistribute it and/or
modify it under the terms of version 2.0  of the GNU General
Public License as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.


ezPdfViewer uses an executable binary pdf2swf provided by swftools (http://www.swftools.org/). You will have to install it on your server
and set the path to the pdf2swf binary in ezpdfviewer.ini


ezPdfViewer features
-------------------
	- When a pdf file is uploaded the user can generate a flash viewer for it
	- Redefines the ezbinaryfile.tpl (edit mode) to allow users to store pdf files and generate flash previewer.


Todo
------------

	Find a solution to handle the removal of the flash previewer when the original pdf file is deleted.(cron ?)

Requirements
------------

-The extension requires the pdf2swf binary from swftools (http://www.swftools.org/). You will have to install it on your server
and set the path to the pdf2swf binary in ezpdfviewer.ini




