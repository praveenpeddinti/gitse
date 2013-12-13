<?php defined('_JEXEC') or die('Restricted access');
JHTML::_( 'behavior.mootools' );
?>
<style>
	.icon-48-geocode { background-image:url(components/com_storelocator/assets/icon-48-geocode.png); }
</style>
<script>
	function beginCoding()
	{
		$('geocode').disabled = true;
		$('spinner').style.display = 'inline';
	}
</script>
<form action="index.php" method="post" enctype="multipart/form-data" name="adminForm">
<div id="editcell">

  <h3>Geocode multiple locations quiclky using the power of the Google Geocoding Web Service</h3>
  <p>Geocoding is the process of converting addresses (like &quot;1600  Amphitheatre Parkway, Mountain View, CA&quot;) <br />
    into geographic  coordinates (like latitude 37.423021 and longitude -122.083739),  which you can use to place markers or position the map.</p>
  <p><strong><em>We have found 
      <?php echo $this->nonCodedCount?> 
    locations to encode...
    </em>&nbsp; &nbsp; 
    <input name="geocode" type="button" id="geocode" onclick="beginCoding();<?php if(StorelocatorHelper::isVersion17()) echo 'Joomla.'; ?>submitbutton('geocode')" value="Process Locations" /> &nbsp; <img src="components/com_storelocator/assets/spinner.gif" style="display:none;" align="absmiddle" id="spinner" />
      </strong></p>
  <p><em>Note: Google imposes a Daily limit of 2,500 Geocode Requests per IP Address...</em></p>
</div>
<div id="copyright-block" align="center" style="margin-top:10px;">
	<a title="Store Locator Joomla Component" href="http://www.sysgenmedia.com">Store Locator</a> by <a title="Long Island Website Design" href="http://www.sysgenmedia.com">Sysgen Media LLC</a>
</div>
<input type="hidden" name="option" value="com_storelocator" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="geocode" />
</form>
