<?php
/**
 * @version		$Id: default.php 397 2009-04-11 01:57:16Z Rob Schley $
 * @package		JXtended.Labels
 * @subpackage	com_labels
 * @copyright	Copyright (C) 2008 - 2009 JXtended, LLC. All rights reserved.
 * @license		GNU General Public License.
 * @link		http://jxtended.com
 */

defined('_JEXEC') or die;

// Get the menu item page class suffix if available.
$suffix = $this->params->get('pageclass_sfx');

// Add the default stylesheet.
JHtml::stylesheet('labels.css', 'components/com_labels/media/css/');

// Check if we need to show the page title.
if ($this->params->get('show_page_title', 1)):
	?><div id="labels_container">
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx');?>"><?php echo $this->params->get('page_title'); ?></div>
	<?php
endif;

// Check if we need to show the label's body.
if ($this->params->get('show_label_body', 1))
{
	$media = $this->params->get('show_label_media');

	// Check if we need to display label media.
	if (!empty($media))
	{
		$image	= $this->label->media->get($media);
		$alt	= $this->escape($this->label->title);
		$class	= 'labels-label-media labels-label-media-'.$media;

		if (!empty($image)) {
			echo '<img src="'.$this->baseurl.'/'.trim($image, '/').'" alt="'.$alt.'" class="'.$class.'" />';
		}
	}

	// Output the label body.
	echo $this->label->body;
}
?>

<?php
// Begin item loop.
foreach ($this->items as $item):

	// Check if we should display the item title.
 	if ($this->params->get('show_item_title', 1))
 	{
 		// Check if we should display the item type.
		if ($this->params->get('show_item_type', 1))
		{
			$separator		= $this->params->get('item_title_delimeter', ': ');
			$item->title	= JText::_($item->type_title).$separator.$item->title;
		}

		$link = ($item->map_route) ? JRoute::_($item->map_route) : JRoute::_($item->front_link.$item->id);
		echo '<div class="contentheading',$this->params->get( 'pageclass_sfx' ),'" ><a href="',$link,'" title="',$item->title,'" class="contentpagetitle',$this->params->get( 'pageclass_sfx' ),'">',$item->title,'</a></div>';
 	}

	// Check if we should display the item body.
	if ($this->params->get('show_item_text', 1))
	{
		$max_length = (int) $this->params->get('item_text_length', 255);

		// Truncate the text if necessary.
		if ($max_length !== 0 && strlen($item->text) > $max_length)
		{
			// Truncate the string at the last string within the max length.
			$tmp = JString::substr($item->text, 0, $max_length);
			$tmp = JString::substr($tmp, 0, JString::strrpos($tmp, ' '));

			if (JString::strlen($tmp) >= $max_length - 3) {
				$tmp = JString::substr($tmp, 0, strrpos($tmp, ' '));
			}

			$item->text = $tmp.'...';
		}

		// Check if we should display item media.
		if ($this->params->get('show_item_media', 0))
		{
			// Handle any item media.
			if (isset($item->media) && !empty($item->media) && is_a($item->media, 'JParameter'))
			{
				// Handle a JParameter media type (magazine, catalog).
				$image = $item->media->get('thumb');
				$alt	= $this->escape($item->title);
				$class	= 'labels-item-media labels-item-media-thumb';

				if (!empty($image)) {
					$item->text = '<img src="'.$this->baseurl.'/'.trim($image, '/').'" alt="'.$alt.'" class="'.$class.'" />'.$item->text;
				}
			}
			elseif (isset($item->media) && !empty($item->media) && is_string($item->media))
			{
				$alt	= $this->escape($item->title);
				$class	= 'labels-item-media labels-item-media-thumb';

				// Handle a string media type.
				$item->text = '<img src="'.$this->baseurl.'/'.trim($item->media, '/').'" alt="'.$alt.'" class="'.$class.'" />'.$item->text;
			}
		}

		echo '<div class="label_item_text"',$item->text,'</div>';
	}
	?>

	<?php
	// Display the read more link if enabled.
	if ($this->params->get('show_item_readmore', 0)):
		?>
		<div class="labels-item-readmore">
			<a href="<?php echo JRoute::_($link); ?>" title="<?php echo $this->escape($item->title); ?>">
				<?php echo JText::sprintf('Read more...', $item->title); ?>
			</a>
		</div>
		<?php
	endif;
	?>

	<div class="label_clr"></div>

	<?php
	if ($this->params->get('show_item_labels', 1)):
		if (isset($item->label_id) && is_array($item->label_id)):
		?>
			<div class="labels-other-labels">
				<?php
				echo JText::_('LABELS_OTHER_LABELS');
				$list = array();

				// This section renders a comma separated list of other labels for an item.
				for ($i = 0, $c = count($item->label_id); $i < $c; $i++)
				{
					// Skip the current label.
					if ($item->label_id[$i] == $this->label->label_id) continue;

					$route	= JRoute::_($item->label_route[$i]);
					$title	= $this->escape($item->label_title[$i]);
					$class	= 'label'.$suffix;
					$list[]	= '<a class="'.$class.'" href="'.$route.'" title="'.$title.'">'.$title.'</a>';
				}
				echo implode(', ', $list);
				?>
			</div>
		<?php
		endif;
	endif;

endforeach;
// End item loop.
?>

<div class="labels-label-pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div></div>