<?php // no direct access
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: view.html.php 747 2011-06-19 22:18:02Z nikosdion $
 * @since 3.3
 */

defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php if(version_compare(JVERSION, '1.6.0', 'ge')): ?>
<fieldset title="<?php echo JText::_('COM_INSTALLER_MSG_DESCFTPTITLE'); ?>">
	<legend><?php echo JText::_('COM_INSTALLER_MSG_DESCFTPTITLE'); ?></legend>

	<?php echo JText::_('COM_INSTALLER_MSG_DESCFTP'); ?>

	<?php if (JError::isError($this->ftp)): ?>
		<p><?php echo JText::_($this->ftp->getMessage()); ?></p>
	<?php endif; ?>

	<table class="adminform">
		<tbody>
			<tr>
				<td width="120">
					<label for="username"><?php echo JText::_('JGLOBAL_USERNAME'); ?></label>
				</td>
				<td>
					<input type="text" id="username" name="username" class="input_box" size="70" value="" />
				</td>
			</tr>
			<tr>
				<td width="120">
					<label for="password"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
				</td>
				<td>
					<input type="password" id="password" name="password" class="input_box" size="70" value="" />
				</td>
			</tr>
		</tbody>
	</table>

</fieldset>
<?php else: ?>
<fieldset title="<?php echo JText::_('DESCFTPTITLE'); ?>">
	<legend><?php echo JText::_('DESCFTPTITLE'); ?></legend>

	<?php echo JText::_('DESCFTP'); ?>

	<?php if(JError::isError($this->ftp)): ?>
		<p><?php echo JText::_($this->ftp->message); ?></p>
	<?php endif; ?>

	<table class="adminform nospace">
		<tbody>
			<tr>
				<td width="120">
					<label for="username"><?php echo JText::_('Username'); ?>:</label>
				</td>
				<td>
					<input type="text" id="username" name="username" class="input_box" size="70" value="" />
				</td>
			</tr>
			<tr>
				<td width="120">
					<label for="password"><?php echo JText::_('Password'); ?>:</label>
				</td>
				<td>
					<input type="password" id="password" name="password" class="input_box" size="70" value="" />
				</td>
			</tr>
		</tbody>
	</table>

</fieldset>
<?php endif; ?>