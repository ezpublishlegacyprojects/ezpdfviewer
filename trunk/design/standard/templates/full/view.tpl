{*
<a href={$back_url|ezurl()} style="float:right;color:#AF0917;font-size:12px;"><img src={"close.gif"|ezimage} style="border:none;margin-right:5px;" >Close</a>
*}
<div id="centrepage1">

<div class="content-view-full">
    <div  class="class-folder">


        <div align=center>
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="{ezini('DisplaySettings','swfWidth','ezpdfviewer.ini')}" height="{ezini('DisplaySettings','swfHeight','ezpdfviewer.ini')}" title="">
				<!--<param name="movie" value="/design/intranet/fr/images/animation_home.swf" />-->
				<param name="movie" value="{$converted_pdf_swf}"/>
				<param name="quality" value="high" />
				<param name="bgcolor" value="#ffffff" />
				<embed src="{$converted_pdf_swf}" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="{ezini('DisplaySettings','swfWidth','ezpdfviewer.ini')}" height="{ezini('DisplaySettings','swfHeight','ezpdfviewer.ini')}" ></embed>
				</object>

		</div>

		</div>
 
</div>
<input class="button" onclick="window.location.href='{$back_url|ezurl(no)}'" type="button" name="GeneratePDF" value="{'Return to action'|i18n( 'ezpdfviewer/view' )}" title="{'return to edition'|i18n( 'ezpdfviewer/view' )}" />
</div>

