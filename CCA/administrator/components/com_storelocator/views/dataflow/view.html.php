<?php
/**
 * Store Locator default view Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );


class LocatePlacesViewDataFlow extends JView
{
	/**
	 * LocatePlaces view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'CSV Import / Export' ), 'impexp.png' );
		JToolBarHelper::help('help', true);
		

		$categories		=& $this->get('Categories');
		$categoriesList = JHTML::_('select.genericlist',   $categories, 'exportcats[]', 'class="inputbox" size="6" multiple="multiple" style="width:180px;" ', 'id', 'name');
		$this->assignRef('categories',		$categoriesList);

		parent::display($tpl);
	}
}