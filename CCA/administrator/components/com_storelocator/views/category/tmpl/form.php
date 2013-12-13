<?php defined('_JEXEC') or die('Restricted access'); ?>
<style>
	.icon-48-category { background-image:url(components/com_storelocator/assets/icon-48-category.png); }
		fieldset label, fieldset span.faux-label { clear:none!important; }

	
	.markericon
	{
		float:left;
		width:200px;;
		height:50px;	
	}
	.markericon img
	{ 
		max-height:40px;
		max-width:75px;
	}
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm">
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
				<input class="text_area" type="text" name="name" id="name" size="32" maxlength="500" value="<?php echo $this->category->name;?>" />
			</td>
		</tr>
        <tr>
			<td width="100" align="right" valign="top" class="key">
				<label for="name">
					<?php echo JText::_( 'Marker Type' ); ?>:				</label>			</td>
			<td>
				<?php echo $this->markers; ?>			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_storelocator" />
<input type="hidden" name="id" value="<?php echo $this->category->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="categories" />
</form>
