<?php defined('_JEXEC') or die('Restricted access'); 
JHTML::_( 'behavior.mootools' ); ?>
<style>
	.icon-48-impexp { background-image:url(components/com_storelocator/assets/icon-48-impexp.png); }
</style>
<form action="index.php" method="post" enctype="multipart/form-data" name="adminForm">
<div id="editcell">
<div style="float:left;width:375px;">
  <h2><img src="components/com_storelocator/assets/Load.png" alt="Import" width="48" height="48" align="absmiddle" />CSV Import  </h2>
  <p>
    <label><strong>Please Select a CSV file to Import:</strong><br />
    <input type="file" name="csvfile" id="csvfile" />
    </label>
  Max File Size <?php echo ini_get('upload_max_filesize')?><br />

  <input name="skipfirst" type="checkbox" id="skipfirst" checked="checked" />
  <label for="skipfirst">First Row Contains Column Names (Skip First Row)</label>
  <br />
  <br />
  <input type="button" name="import" id="import" value="Import" onclick="<?php if(StorelocatorHelper::isVersion17()) echo 'Joomla.'; ?>submitbutton('import')" />
  <br />
  </p>
  </div>
<div style="float:left;width:375px;">
  <h2><img src="components/com_storelocator/assets/Save.png" alt="Export" width="48" height="48" align="absmiddle" />CSV Export </h2>
  <p><strong>
    <label for="exp_cat">Choose Which Categories to Export:</label>
    <br />
    <?php echo $this->categories; ?>
    <br />
    <br />
    <input type="button" name="exportcsv" id="exportcsv" value="Export" onclick="<?php if(StorelocatorHelper::isVersion17()) echo 'Joomla.'; ?>submitbutton('export')" />
  </strong></p>
</div>
<div style="float:left;width:200px;">
  <h2><img src="components/com_storelocator/assets/Save.png" alt="Export" width="48" height="48" align="absmiddle" />Search Log Export</h2>
  <p><strong>
    <input type="button" name="exportlogs" id="exportlogs" value="Export Logs" onclick="<?php if(StorelocatorHelper::isVersion17()) echo 'Joomla.'; ?>submitbutton('exportlogs')" />
  </strong></p>
</div>
<div style="float:left;width:200px;">
  <h2>Clear Search Log</h2>
  <p><strong>
    <input type="button" name="clearlogs" id="clearlogs" value="Clear Logs" onclick="<?php if(StorelocatorHelper::isVersion17()) echo 'Joomla.'; ?>submitbutton('clearlogs')" />
  </strong></p>
</div>
<div style="clear:both">
  <h3>CSV Instructions</h3>
  <p>To see an example import file, add one location to the database from the location manager and then run an export.</p>
  <p><strong>Column Format:</strong><br />
    Name,Address,Phone,Website,Lattitude,Longitude,Category,Email,Facebook,Twitter,Custom1,Custom2,Custom3,Custom4,Custom5,Tags,Featured,Published,&quot;Start Publishing&quot;,&quot;Finished Publishing&quot;,Description</p>
  <p> <strong>Example:</strong> <br />
    &quot;Sysgen Media&quot;,&quot;81 Scudder Ave Northport NY&quot;,&quot;631-343-2211&quot;,&quot;http://www.sysgenmedia.com&quot;,40.899818,-73.347762,&quot;General&quot;,&quot;test@example.com&quot;,&quot;http://facebook.com/SysgenMedia&quot;,&quot;sysgenmedia&quot;,&quot;custom text 1&quot;,&quot;custom text 2&quot;,&quot;custom text 3&quot;,&quot;custom text 4&quot;,&quot;custom text 5&quot;,&quot;Tag 1,Tag 2&quot;,1,1</p>
<p><strong><em>CSV File - Syntax Rules:</em></strong></p>
<ul>
  <li><em> File should be a  Formatted as a CSV File.</em></li>
  <li><strong><em>Every Row MUST have at least 18 columns</em></strong></li>
  <li><em>Name, Category,  Featured, and Published fields are required</em></li>
  <li><em>Category can be specified by Name or by existing category ID. If the  category doesnt exist it will be  created. Category is Required.</em></li>
  <li><em>Tags should be enclosed in quotes. Multiple tags should be delimited by commas. If the Tag doesn't exist, it will be created. Example:&nbsp;&quot;Tag 1, Tag 2&quot;</em></li>
  <li><em>Featured should be specified as a 0 or 1. 0 = Unfeatured, 1 = Featured</em></li>
  <li><em>Published should be specified as a 0 or 1. 0 - Unpublished, 1 = Published.</em></li>
  <li>Start Publishing, Finished Publishing and Description are Optional Columns</li>
</ul>
</div>
</div>
<div id="copyright-block" align="center" style="margin-top:10px;">
	<a title="Store Locator Joomla Component" href="http://www.sysgenmedia.com">Store Locator</a> by <a title="Long Island Website Design" href="http://www.sysgenmedia.com">Sysgen Media LLC</a>
</div>
<input type="hidden" name="option" value="com_storelocator" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="dataflow" />
</form>
