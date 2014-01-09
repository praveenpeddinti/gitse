<?php
/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class MapLocationsController extends JControllerLegacy
{
  function display($cachable = false, $urlparams = false) {
    if (!isset($this->input)) $this->input = JFactory::getApplication()->input;

    $view = $this->input->get('view', 'Places');
    $this->input->set('view', $view);

    parent::display($cachable);
  }
}
