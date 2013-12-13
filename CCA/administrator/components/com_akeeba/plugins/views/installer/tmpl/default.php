<?php // no direct access
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: view.html.php 747 2011-06-19 22:18:02Z nikosdion $
 * @since 3.3
 */

defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<div id="akeeba-container" style="width:100%">
<?php if ($this->showMessage) : ?>
<?php echo $this->loadTemplate('message'); ?>
<?php endif; ?>
<?php echo $this->loadTemplate('form'); ?>
</div>