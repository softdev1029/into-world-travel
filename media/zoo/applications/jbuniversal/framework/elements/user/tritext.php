<?php
// Запрещаем прямой доступ к файлу
defined('_JEXEC') or die('Restricted access');

class JBCSVItemUserTriText extends JBCSVItem 
{
	
 	public function toCSV()
    {
        $result = array();
		
		if (!empty($this->_value)) {
            foreach ($this->_value as $self) {

                $resTmp = $self['level1'];
				$resTmp .= JBCSVItem::SEP_CELL . $self['level2'];
				$resTmp .= JBCSVItem::SEP_CELL . $self['level3'];	

                $result[] = $resTmp;
            }
        }

        if ((int)$this->_exportParams->get('merge_repeatable')) {
            return implode(JBCSVItem::SEP_ROWS, $result);
        } else {
            return $result;
        }
    }
   
   
    public function fromCSV($value, $position = null)
    {
        $data = ($position == 1) ? array() : $this->_element->data();

        if (strpos($value, JBCSVItem::SEP_ROWS)) {
            foreach (explode(JBCSVItem::SEP_ROWS, $value) as $val) {
                if (strpos($value, JBCSVItem::SEP_CELL) === false) {
                    $level1 = '';
					$level2 = '';
                    $level3 = '';
                } else {
                    list($level1, $level2, $level3) = explode(JBCSVItem::SEP_CELL, $val);
                }

                $values[] = array(
                    'level1' => $this->_getString($level1),
                    'level2'  => $this->_getString($level2),
					'level3'  => $this->_getString($level3),
                );
            }
            $data = $values;
        } else {
            if (strpos($value, JBCSVItem::SEP_CELL) === false) {
                $level1 = '';
				$level2 = '';
                $level3 = '';
            } else {
                list($level1, $level2, $level3) = explode(JBCSVItem::SEP_CELL, $value);
            }

            if (!empty($file)) {
                $values = array(
                    'level1' => $this->_getString($level1),
                    'level2'  => $this->_getString($level2),
					'level3'  => $this->_getString($level3),
                );

                $data[] = $values;
            }
        }
        $this->_element->bindData($data);

        return $this->_item;
    }

}