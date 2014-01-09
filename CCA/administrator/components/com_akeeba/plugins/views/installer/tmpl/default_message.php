<?php // no direct access
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: view.html.php 747 2011-06-19 22:18:02Z nikosdion $
 * @since 3.3
 */

	defined( '_JEXEC' ) or die( 'Restricted access' ); 
	if(version_compare(JVERSION,'1.6.0','ge')) {
		$model = JModel::getInstance('Installer','AkeebaModel');
		$app = JFactory::getApplication();
		$model->setState('message', $app->getUserState('com_installer.message'));
		$model->setState('extension_message', $app->getUserState('com_installer.extension_message'));
		$app->setUserState('com_installer.message', '');
		$app->setUserState('com_installer.extension_message', '');
		
		$state			= $this->get('State');
		$message1		= $state->get('message');
		$message2		= $state->get('extension_message');
	} else {
		$state			= &$this->get('State');
		$message1		= $state->get('message');
		$message2		= $state->get('extension.message');
	}
?>
<table class="adminform">
	<tbody>
		<?php if($message1) : ?>
		<tr>
			<?php if(!version_compare(JVERSION,'1.6.0','ge')): ?>
			<th><?php echo JText::_($message1) ?></th>
			<?php else: ?>
			<th><?php echo $message1 ?></th>
			<?php endif; ?>
		</tr>
		<?php endif; ?>
		<?php if($message2) : ?>
		<tr>
			<td><?php echo $message2; ?></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>
