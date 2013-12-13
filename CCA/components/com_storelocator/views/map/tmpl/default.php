<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 	if($this->include_mootools) JHTML::_( 'behavior.mootools' ); 
 	if($this->include_css) JHTML::_('stylesheet', 'styles.css', 'components/com_storelocator/assets/');
	
	$document = &JFactory::getDocument();
	$document->addScript( JRoute::_( 'index.php?option=com_storelocator&format=js&Itemid='.$this->menuitemid.'&mod_storelocator_search='.($this->isModSearch?'1':'0') ));
?>
<?php if($this->fix_jquery): ?>
<script type="text/javascript">if ('undefined' != typeof jQuery) jQuery.noConflict();</script>
<?php endif; ?>
<?php if (StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17()) : ?>
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
    <h1>
        <?php echo $this->escape($this->params->get('page_heading')); ?>
    </h1>
    <?php endif; ?>
<?php else : ?>
	<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
        <div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
            <?php echo $this->escape($this->params->get('page_title')); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php if ( $this->params->get( 'articleid_head', 0 ) ) : ?>
	<?php 
		$articleid_head = StorelocatorHelper::getArticle($this->params->get( 'articleid_head', 0 ));
		
		echo '<div class="sl_article_top">'.$articleid_head->introtext . $articleid_head->fulltext.'</div>';
	 ?>
<?php endif; ?>
<div id="sl_search_container" <?php if(!$this->search_enabled) echo 'style="display:none;"'; ?>>
<?php echo JText::_( 'INSTRUCTIONS' ); ?><br />
    <form action="#" onsubmit="searchLocations(); return false;" id="locate_form">
    <div class="sl_search_row">
      <strong><?php echo JText::_( 'ADDRESS' ); ?>:</strong>
      <input type="text" id="addressInput" value="<?php echo $this->addressInput?>" class="inputbox" onkeydown="if (event.keyCode == 13) { searchLocations(); return false; }" /> 
	  <?php if ( $radius_search = $this->params->get( 'radiussearch_enabled', 1 ) ) : ?>
         &nbsp;&nbsp; <strong><?php echo JText::_( 'RADIUS' ); ?>:</strong>
          <select id="radiusSelect" class="inputbox" style="width:100px;">
            <?php
                foreach( $this->radius_list as $radius )
                printf("<option value=\"%d\" %s>%d %s</option>",
                        $radius,
                        ($this->radiusSelect==$radius)?'selected="selected"':'',
                        $radius,
                        ($this->map_units?JText::_( 'MILES' ):JText::_( 'KILOMETERS' ))
                        );
            ?>
          </select> 
      <?php endif; ?>
      <?php if ( $this->params->get( 'name_search', 1 ) ) : ?>
         &nbsp;&nbsp; <strong><?php echo JText::_( 'NAME' ); ?>:</strong>
      	<input type="text" id="name_search" value="<?php echo $this->name_search?>" class="inputbox" onkeydown="if (event.keyCode == 13) { searchLocations(); return false; }" />
      <?php endif; ?>
      
      
      <input type="button" class="buttonlink_small" onclick="searchLocations()" value="<?php echo JText::_( 'LOCATE' ); ?>"/>
      <img src="components/com_storelocator/assets/spinner.gif" alt="Loading" style="display:none; padding-left:3px; vertical-align:middle;" id="sl_map_spinner" />
   </div>
   <?php if($this->featsearch_enabled || $this->catsearch_enabled ) : ?>
   <div class="sl_search_row">
      <?php if($this->catsearch_enabled) echo '<strong>'.JText::_('CATEGORY').':</strong> '. $this->catsearch; ?>
      <?php if($this->featsearch_enabled && $this->catsearch_enabled ): ?> &nbsp;&nbsp; <?php endif; ?>
      <?php if($this->featsearch_enabled) echo '&nbsp;&nbsp;<strong>'.JText::_('FEATURED').':</strong> '. $this->featsearch; ?>
   </div>
   <?php endif; ?>
   <?php if($this->tagsearch_enabled > 0) : ?>
   <div class="sl_search_row">
       <strong><?php echo JText::_('TAGS'); ?>:</strong> <?php echo $this->tagsearch; ?>  
   </div>
   <?php endif; ?>
   <?php if ( !$radius_search ) : ?>
   <input type="hidden" id="radiusSelect" name="radiusSelect" value="<?php echo $this->radiusSelect; ?>"  />
   <?php endif; ?>
   </form>
</div>
<br/>
<div id="sl_results_container">
  <div id="sl_locate_results" <?php if(!$this->search_enabled) echo 'style="display:none;"'; ?>><?php echo JText::_( 'PRESEARCH_TEXT' ); ?></div>
  <div id="sl_sidebar" style="height: <?php echo $this->map_height?>px;<?php if(!$this->list_enabled || $this->hide_list_onload) echo 'display:none;'; ?>"><?php echo JText::_( 'NO_RESULTS' ); ?></div>
  <div id="map" style="width: <?php echo intval($this->map_width)?>px; height: <?php echo intval($this->map_height)?>px"></div>
  <div style="clear:both"></div>
</div>
<?php 
		if ( $this->params->get( 'show_copyright', 1 ) )  
			echo '<div id="copyright-block"><a title="Store Locator Joomla Component" href="http://www.sysgenmedia.com" target="_blank">Store Locator</a> by <a title="Custom Joomla Development" href="http://www.sysgenmedia.com" target="_blank">Sysgen Media LLC</a></div>';
?>
<?php if ( $this->params->get( 'articleid_foot', 0 ) ) : ?>
	<?php 
		$articleid_foot = StorelocatorHelper::getArticle($this->params->get( 'articleid_foot', 0 ));
		
		echo '<div class="sl_article_bottom">'.$articleid_foot->introtext . $articleid_foot->fulltext.'</div>';
	 ?>
<?php endif; ?>