<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
App::getInstance('zoo')->loader->register('JBCSVItem', 'jbelements:item.php');

/**
 * Class JBCSVItemuserimagebox
 */
class JBCSVItemuserimagebox extends JBCSVItem {

    /**
     * Export data to CSV cell.
     *
     * @return string
     */
    public function toCSV()
    {
        $result = array();
        foreach($this->_value['option'] as $option) {
            $result[] .= $option;
        }
        return implode(',', $result);
    }

    /**
     * Import data from CSV cell.
     *
     * @param $value
     * @param null $position
     * @return Item
     */
    public function fromCSV($value, $position = null)
    {
        $options = explode(',' , $value);
        $this->_element->bindData(array('option' => $options));
        return $this->_item;
    }
}