<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 

JHTML::_('behavior.modal');


?>
<style>
	.icon-48-sysgen { background-image:url(components/com_storelocator/assets/sysgen_48.png); }
	fieldset label, fieldset span.faux-label { clear:none!important; }
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Location Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'Name' ); ?>:				</label>			</td>
			<td>
				<input class="text_area" type="text" name="name" id="name" size="32" maxlength="500" value="<?php echo $this->locateplace->name;?>" /> <strong style="color:red;">* Required</strong>			</td>
		</tr>
        <tr>
			<td width="100" align="right" class="key">
				<label for="category">
					<?php echo JText::_( 'Category' ); ?>:				</label>			</td>
			<td>
				<?php echo $this->categories; ?>			</td>
		</tr>
        <tr>
			<td width="100" align="right" class="key">
				<label for="address">
					<?php echo JText::_( 'Address' ); ?>:				</label>			</td>
			<td>
				<input class="text_area" type="text" name="address" id="address" size="60" maxlength="2000" value="<?php echo $this->locateplace->address;?>" /> &nbsp; <input name="getcoords" type="button" value="Calculate Coordinates" onclick="gatherCoords()" id="auto_cal_button" />			</td>
		</tr>
        <tr>
          <td align="right" class="key">Auto Calculate:</td>
          <td><input name="auto_cal" id="auto_cal_yes" checked="checked" type="radio" value="1" onclick="setAutoType();" /><label for="auto_cal_yes">Use address to determine Latitude / Longitude.</label> &nbsp; &nbsp;  <input name="auto_cal" id="auto_cal_no" type="radio" value="0" onclick="setAutoType();" /><label for="auto_cal_no">Enable Manual Entry</label></td>
        </tr>
        <tr>
			<td width="100" align="right" class="key">
				<label for="lat">
					<?php echo JText::_( 'Latitude' ); ?>:				</label>			</td>
			<td>
				<input class="text_area" type="text" name="lat" id="lat" size="20" maxlength="50" value="<?php echo $this->locateplace->lat;?>" disabled="disabled" /> <strong style="color:red;">* Required</strong>	</td>
		</tr>
        <tr>
			<td width="100" align="right" class="key">
				<label for="lng">
					<?php echo JText::_( 'Longitude' ); ?>:				</label>			</td>
			<td>
				<input class="text_area" type="text" name="lng" id="lng" size="20" maxlength="50" value="<?php echo $this->locateplace->lng;?>" disabled="disabled" /> <strong style="color:red;">* Required</strong>			</td>
		</tr>
        <tr>
			<td width="100" align="right" class="key">
				<label for="published">
					<?php echo JText::_( 'Published' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['published']; ?>
			</td>
		</tr>   
        <tr>
			<td width="100" align="right" class="key">
				<label for="publish_up">
					<?php echo JText::_( 'Start Publishing' ); ?>:
				</label>
			</td>
			<td>
				<?php  echo JHTML::_('calendar',$this->locateplace->publish_up,'publish_up','publish_up'); ?>
			</td>
		</tr> 
        <tr>
			<td width="100" align="right" class="key">
				<label for="publish_up">
					<?php echo JText::_( 'Finish Publishing' ); ?>:
				</label>
			</td>
			<td>
            <?php  echo JHTML::_('calendar',$this->locateplace->publish_down,'publish_down','publish_down'); ?>
			</td>
		</tr>   
        <tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'Access Level' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['access']; ?>
			</td>
		</tr>
       </table> 
  </fieldset>
  <fieldset class="adminform">
		<legend><?php echo JText::_( 'Extended Information' ); ?></legend>

		<table class="admintable">   
        <tr>
			<td width="100" align="right" class="key">
				<label for="featured">
					<?php echo JText::_( 'Featured' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['featured']; ?>
			</td>
		</tr> 
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="tags">
					<?php echo JText::_( 'Tags' ); ?>:				</label>			</td>
			<td>
				<?php echo $this->tags; ?>			</td>
		</tr>
                    
        <tr>
          <td align="right" class="key"><?php echo JText::_( 'Description' ); ?></td>
          <td>   
          	<?php echo $this->editorFullAddress; ?> <br />
			<small>This is the Description that is Displayed on the Frontend Views.</small>      	
          </td>
        </tr>
        <tr>
          <td align="right" class="key"><?php echo JText::_( 'Phone' ); ?></td>
          <td><input class="text_area" type="text" name="phone" id="phone" size="60" maxlength="50" value="<?php echo $this->locateplace->phone;?>" /></td>
        </tr>
        <tr>
          <td align="right" class="key"><?php echo JText::_( 'Email' ); ?></td>
          <td><input class="text_area" type="text" name="email" id="email" size="60" maxlength="200" value="<?php echo $this->locateplace->email;?>" /></td>
        </tr>
        <tr>
          <td align="right" class="key"><?php echo JText::_( 'URL' ); ?></td>
          <td><input class="text_area" type="text" name="website" id="website" size="60" maxlength="2000" value="<?php echo $this->locateplace->website;?>" /></td>
        </tr>
        <tr>
          <td align="right" class="key"><?php echo JText::_( 'Facebook URL' ); ?></td>
          <td><input class="text_area" type="text" name="facebook" id="facebook" size="60" maxlength="500" value="<?php echo $this->locateplace->facebook;?>" /></td>
        </tr>
        <tr>
          <td align="right" class="key"><?php echo JText::_( 'Twitter Username' ); ?></td>
          <td><input class="text_area" type="text" name="twitter" id="twitter" size="30" maxlength="64" value="<?php echo $this->locateplace->twitter;?>" /></td>
        </tr>
     </table> 
  </fieldset>
  <fieldset class="adminform">
		<legend><?php echo JText::_( 'Custom Fields' ); ?></legend>
        Custom Field Names can be defined via the Component Preferences

	<table class="admintable">   
       	<tr>
          <td align="right" class="key"><?php echo JText::_( 'Custom 1' ); ?></td>
          <td><input class="text_area" type="text" name="cust1" id="cust1" size="60" maxlength="2000" value="<?php echo $this->locateplace->cust1;?>" /></td>
        </tr>
        <tr>
          <td align="right" class="key"><?php echo JText::_( 'Custom 2' ); ?></td>
          <td><input class="text_area" type="text" name="cust2" id="cust2" size="60" maxlength="2000" value="<?php echo $this->locateplace->cust2;?>" /></td>
        </tr>
        <tr>
          <td align="right" class="key"><?php echo JText::_( 'Custom 3' ); ?></td>
          <td><input class="text_area" type="text" name="cust3" id="cust3" size="60" maxlength="2000" value="<?php echo $this->locateplace->cust3;?>" /></td>
        </tr>
        <tr>
          <td align="right" class="key"><?php echo JText::_( 'Custom 4' ); ?></td>
          <td><input class="text_area" type="text" name="cust4" id="cust4" size="60" maxlength="2000" value="<?php echo $this->locateplace->cust4;?>" /></td>
        </tr>
        <tr>
          <td align="right" class="key"><?php echo JText::_( 'Custom 5' ); ?></td>
          <td><input class="text_area" type="text" name="cust5" id="cust5" size="60" maxlength="2000" value="<?php echo $this->locateplace->cust5;?>" /></td>
        </tr>
        
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_storelocator" />
<input type="hidden" name="id" value="<?php echo $this->locateplace->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="locateplaces" />
</form>
<script type="text/javascript">
	function gatherCoords() 
	{
		var geocoder = new google.maps.Geocoder();
		var address = document.getElementById('address').value;
		
		geocoder.geocode({address: address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				$('lat').value = results[0].geometry.location.lat();
				$('lng').value = results[0].geometry.location.lng();
			} else { //implement errors				 
				 <?php if(StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17()) : ?>
					SqueezeBox.open(new Element('div#errorbox[style=padding:15px;font-size:12px;font-weight:bold;color:#990033;text-align:center;][text=Address: ' + address + ' not found]'), {handler: 'adopt', size:{x: 400, y: 50}});
				<?php else : ?>
					SqueezeBox.applyContent('<div style="padding:15px;font-size:12px;font-weight:bold;color:#990033;text-align:center;">Address: ' + address + ' not found</div>', {x: 400, y: 50});
				<?php endif; ?>
			}
		});
	}
	
	function setAutoType()
	{
		if ($('auto_cal_yes').checked)
		{
			document.getElementById('lat').disabled = true;
			document.getElementById('lng').disabled = true;
			document.getElementById('auto_cal_button').style.visibility = '';
		} else {
			document.getElementById('lat').disabled = false;
			document.getElementById('lng').disabled = false;
			document.getElementById('auto_cal_button').style.visibility = 'hidden';
		}
	
	}
	
	
	Joomla.submitbutton = function(pressbutton) 
	{
		submitbutton(pressbutton);
		return;
	}

	
	function submitbutton(pressbutton) 
	{
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		
		// do field validation
		if ( $('name').value == '' )
		{
			<?php if(StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17()) : ?>
				SqueezeBox.open(new Element('div#errorbox[style=padding:15px;font-size:12px;font-weight:bold;color:#990033;text-align:center;][text=Please enter a Name for this Location]'), {handler: 'adopt', size:{x: 400, y: 46}});
			<?php else : ?>
				SqueezeBox.applyContent('<div style="padding:15px;font-size:12px;font-weight:bold;color:#990033;text-align:center;">Please enter a Name for this Location</div>', {x: 400, y: 46});
			<?php endif; ?>
		} 
		else if ( $('lat').value == '' || isNaN($('lat').value) 
					|| $('lat').value < -90 || $('lat').value > 90)
		{
			<?php if(StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17()) : ?>
				SqueezeBox.open(new Element('div#errorbox[style=padding:15px;font-size:12px;font-weight:bold;color:#990033;text-align:center;][text=Latitude and longitude values must correspond to a valid location on the face of the earth. Latitude values can take any value between -90 and 90]'), {handler: 'adopt', size:{x: 500, y: 100}});
			<?php else : ?>
				SqueezeBox.applyContent('<div style="padding:15px;font-size:12px;font-weight:bold;color:#990033;text-align:center;">Latitude and longitude values must correspond to a valid location on the face of the earth.<br /><br />Latitude values can take any value between -90 and 90</div>', {x: 550, y: 80});
			<?php endif; ?>
		} 
		else if ( $('lng').value == '' || isNaN($('lng').value) 
					||  $('lng').value < -180 || $('lng').value > 180)
		{
			<?php if(StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17()) : ?>
				SqueezeBox.open(new Element('div#errorbox[style=padding:15px;font-size:12px;font-weight:bold;color:#990033;text-align:center;][text=Latitude and longitude values must correspond to a valid location on the face of the earth. Longitude values can take any value between -180 and 180]'), {handler: 'adopt', size:{x: 500, y: 100}});
			<?php else : ?>
				SqueezeBox.applyContent('<div style="padding:15px;font-size:12px;font-weight:bold;color:#990033;text-align:center;">Latitude and longitude values must correspond to a valid location on the face of the earth.<br /><br />Longitude values can take any value between -180 and 180</div>', {x: 550, y: 80});
			<?php endif; ?>
		} else {
			document.getElementById('lat').disabled = false;
			document.getElementById('lng').disabled = false;
			submitform( pressbutton );
		}
	}
</script>