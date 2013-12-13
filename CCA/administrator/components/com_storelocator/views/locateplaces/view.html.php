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


class LocatePlacesViewLocatePlaces extends JView
{
	/**
	 * LocatePlaces view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option');
		
		$db		=& JFactory::getDBO();
		$uri	=& JFactory::getURI();
		
		JToolBarHelper::title(   JText::_( 'Location Manager' ), 'sysgen.png' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::preferences('com_storelocator', 350);
		JToolBarHelper::help('help', true);		
		
		$filter_featured	= $mainframe->getUserStateFromRequest( $option.'filter_featured',	'filter_featured',		'',		'word' );
		$filter_state		= $mainframe->getUserStateFromRequest( $option.'filter_state',		'filter_state',		'',				'word' );
		$filter_catid		= $mainframe->getUserStateFromRequest( $option.'filter_catid',		'filter_catid',		0,				'int' );
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'lp.id',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );
		

		// Get data from the model
		$items		= & $this->get( 'Data');
		$total		= & $this->get( 'Total');
		$pagination = & $this->get( 'Pagination' );
		$categories	= & $this->get( 'Categories' );
		array_unshift($categories, JHTML::_('select.option', 0, JText::_('- Select a Category -' ), 'id', 'name'));
		

		// build list of categories
		$javascript 	= 'onchange="document.adminForm.submit();"';
		$lists['catid'] = JHTML::_('select.genericlist',   $categories, 'filter_catid', $javascript, 'id', 'name', intval( $filter_catid ), 'filter_catid');

		
		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;
		
		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );
		
		// Feature Filter
		$features = array();
		
		$features[] = (object) array('id'=>'','name'=>'- Select Featured -');
		$features[] = (object) array('id'=>'U','name'=>'Unfeatured');
		$features[] = (object) array('id'=>'F','name'=>'Featured');

		$lists['featured'] = JHTML::_('select.genericlist',  $features, 'filter_featured', $javascript, 'id', 'name', $filter_featured, 'filter_featured');

		$version = (StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17());
		
		// search filter
		$lists['search']= $search;

		$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('version',		$version);


		parent::display($tpl);
	}
}