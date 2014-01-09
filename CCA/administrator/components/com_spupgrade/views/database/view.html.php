<?php

/**
 * @package		SP Upgrade
 * @subpackage	Components
 * @copyright	SP CYEND - All rights reserved.
 * @author		SP CYEND
 * @link		http://www.cyend.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * SPUpgrades View
 */
class SPUpgradeViewDatabase extends JView
{
	/**
	 * SPUpgrades view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');  

		$pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;

		// Set the toolbar
		$this->addToolBar();

        //Set JavaScript
        $this->addJS();
        
        // Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		$canDo = SPUpgradeHelper::getActions();
		
		JToolBarHelper::title(JText::_('COM_SPUPGRADE_TABLES_TITLE'), 'install.png');
                
		if ($canDo->get('core.admin')) 
		{
                    $bar = JToolBar::getInstance('toolbar'); 
                    $bar->appendButton('Confirm','COM_SPUPGRADE_CONFIRM_MSG', 'move', 'COM_SPUPGRADE_TRANSFER', 'database.transfer', true);
                    JToolBarHelper::divider();
                    JToolBarHelper::preferences('com_spupgrade');
		}
                $bar=& JToolBar::getInstance( 'toolbar' );
                $bar->appendButton('Help', 'help', 'JTOOLBAR_HELP', 'http://cyend.com/extensions/extensions/components/documentation/24-user-guide-how-to-migrate-to-joomla-16', 640, 480);
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_SPUPGRADE_ADMINISTRATION'));
	}
    private function addJS() {
        //Handle chosed items
        $rows = "";        
        foreach ($this->items as $i => $item) {
            $rows .= "rows[".$item->id."]='".$item->prefix."_".$item->name."';\n";
        }
                 
        //Choose items
		$js = "
		function jSelectItem(prefix, name, id_arr) {

            rows = new Array();
            ".$rows."                
            for(i=0;i<=".count($this->items).";i++) {            
                if (rows[i] == prefix+'_'+name) {
                    id_type = i-1;
                }
            }            
            var chklength = id_arr.length;
            for(k=0;k<chklength;k++) {
                if (input_ids[id_type].value == '') {
                    input_ids[id_type].value = id_arr[k];
                } else {
                    input_ids[id_type].value = input_ids[id_type].value + ',' + id_arr[k];
                }                
            }
            SqueezeBox.close();
    	}";

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);
        
        //Clear selected items
        $js = "
		function jClearItem(prefix, name) {
            rows = new Array();
            ".$rows."
            for(i=0;i<=".count($this->items).";i++) {            
                if (rows[i] == prefix+'_'+name) {
                    id_type = i-1;
                }
            }
            input_ids[id_type].value = '';
    	}";

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);
    }
}
