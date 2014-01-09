<?php defined('_JEXEC') or die('Restricted access'); ?>
<style>
	.icon-48-marker { background-image:url(components/com_storelocator/assets/icon-48-marker.png); }
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">   
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'Name' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="name" id="name" size="40" maxlength="99" value="<?php echo $this->marker->name;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="image_upload"> 
					<?php echo JText::_( 'Image' ); ?>:
				</label>
			</td>
			<td>
            	<?php if(!empty($this->marker->image_url)) : ?>
                	<img src="<?php echo $this->marker->image_url; ?>" style="margin-bottom:5px;margin-right:5px;" align="absmiddle" /> <strong>Existing Image</strong>
                    <br />
                <?php endif; ?>
            
                <input class="text_area" type="file" name="image_upload" id="image_upload" size="50" />
                <br />
                <span style="font-size:0.9em; color:#C00">File must be of type PNG</span> 
			</td>
		</tr>                    
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="image_url" value-"<?php echo $this->marker->image_url; ?>" />
<input type="hidden" name="shadow_url" value="http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png" />
<input type="hidden" name="option" value="com_storelocator" />
<input type="hidden" name="id" value="<?php echo $this->marker->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="markers" />
</form>
