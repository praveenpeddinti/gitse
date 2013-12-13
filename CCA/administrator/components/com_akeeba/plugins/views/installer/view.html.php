<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: view.html.php 747 2011-06-19 22:18:02Z nikosdion $
 * @since 3.3
 */

defined( '_JEXEC' ) or die();

jimport('joomla.application.component.view');

class AkeebaViewInstaller extends JView
{
    public function __construct( $config = array() )
	{
		parent::__construct( $config );
		$tmpl_path = dirname(__FILE__).'/tmpl';
		$this->addTemplatePath($tmpl_path);
	}
    
	function display($tpl=null)
	{
		$paths = new stdClass();
		$paths->first = '';

		// Get data from the model
		$state		= &$this->get('State');


		// Are there messages to display ?
		$showMessage	= false;
		if ( is_object($state) )
		{
			$message1		= $state->get('message');
			$message2		= $state->get('extension.message');
			$message2_16	= $state->get('extension_message');
			$showMessage	= ( $message1 || $message2 || $message2_16 );
		}
		
		$jconfig = JFactory::getConfig();
		$tmpPath = $jconfig->getValue('config.tmp_path', JPATH_ROOT.'/tmp');

		$this->assign('showMessage',	$showMessage);
		$this->assignRef('paths',		$paths);
		$this->assignRef('state',		$state);
		$this->assign('install.directory', $tmpPath);

		JHTML::_('behavior.tooltip');
		$this->addToolbar();
		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
			$this->_addToolbar16();
		} else {
			$this->_addToolbar15();
		}
	}
	
	private function _addToolbar15()
	{
		$subMenus = array(
			'Components' => 'components',
			'Modules' => 'modules',
			'Plugins' => 'plugins',
			'Languages' => 'languages',
			'Templates' => 'templates');
		
		JSubMenuHelper::addEntry(JText::_( 'Install' ), '#" onclick="javascript:document.adminForm.type.value=\'\';submitbutton(\'installer\');', true);
		foreach ($subMenus as $name => $extension) {
			JSubMenuHelper::addEntry(JText::_( $name ), '#" onclick="javascript:document.adminForm.type.value=\''.$extension.'\';submitbutton(\'manage\');', false);
		}
		JToolBarHelper::help( 'screen.installer' );
			
		JToolBarHelper::title( JText::_( 'Extension Manager'), 'install.png' );

		// Document
		$document = & JFactory::getDocument();
		$document->setTitle(JText::_('Extension Manager').' : '.JText::_( $this->getName() ));
	}
	
	private function _addToolbar16()
	{
		$canDo	= InstallerHelper::getActions();
		JToolBarHelper::title(JText::_('COM_INSTALLER_HEADER_INSTALL'), 'install.png');

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_installer');
			JToolBarHelper::divider();
		}

		// Document
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_INSTALLER_HEADER_INSTALL'));
		
		JToolBarHelper::help('JHELP_EXTENSIONS_EXTENSION_MANAGER_INSTALL');
	}
}