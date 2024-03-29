<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author       Yannick Gaultier
 * @copyright    (c) Yannick Gaultier - Weeblr llc - 2018
 * @package      sh404SEF
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version      4.14.0.3812
 * @date        2018-05-16
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC'))
{
	die('Direct Access to this location is not allowed.');
}

/**
 * Implement wizard based exportation of pageids data
 *
 * @author shumisha
 *
 */
class Sh404sefAdapterImportpageids extends Sh404sefClassImportgeneric
{

	/**
	 * Parameters for current adapter, to be used by parent controller
	 *
	 */
	public function setup()
	{
		// let parent do their job
		$properties = parent::setup();

		// set context record
		$this->_context = 'pageids';

		// setup a few custom properties
		$properties['_returnController'] = 'pageids';
		$properties['_returnTask'] = '';
		$properties['_returnView'] = 'pageids';
		$properties['_returnLayout'] = 'default';

		// and return the whole thing
		return $properties;
	}

	/**
	 * Creates a record in the database, based
	 * on data read from import file
	 *
	 * @param array  $header an array of fields, as built from the header line
	 * @param string $line   raw record obtained from import file
	 */
	protected function _createRecord($header, $line)
	{
		// extract the record
		$line = $this->_lineToArray($line);

		// get table object to store record
		jimport('joomla.database.table');
		$table = JTable::getInstance('pageids', 'Sh404sefTable');

		// bind table to current record
		$record = array();
		$record['newurl'] = $line[3];
		if ($record['newurl'] == '__ Homepage __')
		{
			$record['newurl'] = sh404SEF_HOMEPAGE_CODE;
		}
		$record['pageid'] = $line[1];
		$record['type'] = $line[4];

		// save record
		if (!$table->save($record))
		{
			throw new Sh404sefExceptionDefault(JText::sprintf('COM_SH404SEF_IMPORT_ERROR_INSERTING_INTO_DB', $line[0]) . ' <small>(' . $table->getError() . ')</small>');
		}
	}
}
