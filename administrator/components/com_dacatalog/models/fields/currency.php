<?php
defined('JPATH_BASE') or die;

class JFormFieldCurrency extends JFormField
{
	protected $type = 'Currency';

	protected function getInput()
	{
		$currency = array(
			'EUR',
			'USD',
			'JPY',
			'BGN',
			'CZK',
			'DKK',
			'GBP',
			'HUF',
			'PLN',
			'RON',
			'SEK',
			'CHF',
			'NOK',
			'HRK',
			'RUB',
			'TRY',
			'AUD',
			'BRL',
			'CAD',
			'CNY',
			'HKD',
			'IDR',
			'ILS',
			'INR',
			'KRW',
			'MXN',
			'MYR',
			'NZD',
			'PHP',
			'SGD',
			'THB',
			'ZAR',
		);

		$toSelect = array();
		foreach($currency AS $cur) {
			$toSelect[] = array('value' => $cur, 'text' => $cur);
		}

		if(!$this->value)
			$this->value = $this->default;


		$html[] = JHTML::_("select.genericlist", $toSelect, $this->name, '', $key= 'value', $text='text', $this->value);

		return implode("\n", $html);
	}
}
