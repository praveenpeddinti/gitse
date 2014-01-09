<?php defined('_JEXEC') or die('Restricted access'); ?>
<style>
	.icon-48-sysgen { background-image:url(components/com_storelocator/assets/sysgen_48.png); }
</style>
<form action="index.php" method="post" name="adminForm">
<table>
<tr>
	<td align="left" width="100%">
		<?php echo JText::_( 'Filter' ); ?>:
		<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
	</td>
	<td nowrap="nowrap">
		<?php
		
			echo $this->lists['featured'];
			
			echo $this->lists['catid'];
			
			echo $this->lists['state'];
		?>
	</td>
</tr>
</table>
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
            	<?php echo JHTML::_( 'grid.sort', 'ID', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>			
			<th>
				<?php echo JHTML::_( 'grid.sort', 'Name', 'name', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
            <th>
            	<?php echo JHTML::_( 'grid.sort', 'Category', 'category', $this->lists['order_Dir'], $this->lists['order']); ?>
            </th>
            <th>
				<?php echo JHTML::_( 'grid.sort', 'Address', 'address', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
            <th width="75">
				<?php echo JHTML::_( 'grid.sort', 'Featured', 'featured', $this->lists['order_Dir'], $this->lists['order']); ?>            
			</th>  
            <th width="75">
				<?php echo JHTML::_( 'grid.sort', 'Published', 'published', $this->lists['order_Dir'], $this->lists['order']); ?>            
			</th>    
            <th width="125">
				<?php echo JHTML::_( 'grid.sort', 'Access', 'access', $this->lists['order_Dir'], $this->lists['order']); ?>            
			</th>         
		</tr>
	</thead>
    <tfoot>
		<tr>
			<td colspan="9">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_storelocator&controller=locateplaces&task=edit&cid[]='. $row->id );
		$cat_link 	= JRoute::_( 'index.php?option=com_storelocator&controller=categories&task=edit&cid[]='. $row->catid );
		$published		= JHTML::_('grid.published', $row, $i );
		$access 		= ($this->version==1)?$row->groupname:JHTML::_('grid.access',   $row, $i );		
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->name; ?></a>
			</td>
            <td>
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit Category' );?>::<?php echo $this->escape($row->category); ?>">
				<a href="<?php echo $cat_link; ?>" >
				<?php echo $this->escape($row->category); ?></a></span>
            </td>            
            <td>
				<?php echo $row->address; ?>
			</td>
             <td style="text-align:center">
             
             <?php if ($this->version==1) : ?>
					<a title="Toggle to change state" onclick="return listItemTask('cb<?php echo $i;?>','toggle_featured')" href="javascript:void(0);">
                    	<?php if ( $row->featured ) : ?>
						<img alt="Featured" src="templates/bluestork/images/admin/featured.png">
                        <?php else : ?>
                        <img alt="Unfeatured contact" src="templates/bluestork/images/admin/disabled.png">
                        <?php endif; ?>                    
                    </a>				
            <?php else : ?>     
             	<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','toggle_featured')" title="<?php echo ( $row->featured ) ? JText::_( 'Yes' ) : JText::_( 'No' );?>">
							<img src="images/<?php echo ( $row->featured ) ? 'tick.png' : ( $row->published != -1 ? 'publish_x.png' : 'disabled.png' );?>" width="16" height="16" border="0" alt="<?php echo ( $row->featured ) ? JText::_( 'Yes' ) : JText::_( 'No' );?>" /></a>
            <?php endif; ?>
             
		    </td>
            <td style="text-align:center">
            	<?php echo $published; ?>
            </td> 
  			
            <td style="text-align:center">
            	<?php echo $access; ?>
            </td>         
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>
<div id="copyright-block" align="center" style="margin-top:10px;">
	<a title="Store Locator Joomla Component" href="http://www.sysgenmedia.com">Store Locator</a> by <a title="Long Island Website Design" href="http://www.sysgenmedia.com">Sysgen Media LLC</a>
</div>
<input type="hidden" name="option" value="com_storelocator" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="locateplaces" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>
