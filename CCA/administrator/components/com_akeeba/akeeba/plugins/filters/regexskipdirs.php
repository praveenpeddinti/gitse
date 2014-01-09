<?php
/**
 * Akeeba Engine
 * The modular PHP5 site backup engine
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU GPL version 3 or, at your option, any later version
 * @package akeebaengine
 * @version $Id$
 */

// Protection against direct access
defined('AKEEBAENGINE') or die('Restricted access');

/**
 * Subdirectories exclusion filter based on regular expressions
 */
class AEFilterRegexskipdirs extends AEAbstractFilter
{
	function __construct()
	{
		$this->object	= 'dir';
		$this->subtype	= 'children';
		$this->method	= 'regex';

		if(empty($this->filter_name)) $this->filter_name = strtolower(basename(__FILE__,'.php'));
		parent::__construct();
	}
}