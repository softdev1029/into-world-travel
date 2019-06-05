<?php
defined( '_JEXEC' ) or die();
jimport( 'joomla.plugin.plugin' );

class plgSystemPricetour extends JPlugin {

	function __construct(&$subject, $config) {
		parent::__construct($subject, $config);
	}

	// Prepare the form
	function onAfterRender() {
		$app = JFactory::getApplication();

		// check if this is a front-end
		if ($app->getName() != 'site') {
			return true;
		}

		$db = JFactory::getDBO();
		$buffer = $app->getBody();
		$regex = '/{pricetour\s(.*?)}/i';

		preg_match_all($regex, $buffer, $matches, PREG_SET_ORDER);
		if ($matches) {
			foreach ($matches as $match) {
				$id = $match[1];

				// Выбираем тур --------------->
				$query = "SELECT i.*"
					.",c.title AS category"
					." FROM #__dacatalog_main AS i"
					." LEFT JOIN #__categories AS c ON i.catid = c.id"
					." WHERE i.id = ".$db->q($id);
				$db->setQuery( $query );
				$tour = $db->loadObject();

				if($tour->flightId) {
					$query = "SELECT * FROM #__dacatalog_flights WHERE id IN(" . $tour->flightId . ")";
					$db->setQuery($query);
					$tour->flights = $db->loadObjectList();
				}

				if($tour->hotels) {
					$tour->hotelsDates = json_decode($tour->hotels);
					if($tour->hotelsDates->hotelId) {
						$query = "SELECT * FROM #__dacatalog_hotels WHERE id IN(".implode(',', $tour->hotelsDates->hotelId).")";
						$db->setQuery( $query );
						$tour->hotels = $db->loadObjectList('id');
					}
				}

				if($tour->trainId) {
					$query = "SELECT * FROM #__dacatalog_trains WHERE id IN(" . $tour->trainId . ")";
					$db->setQuery($query);
					$tour->trains = $db->loadObjectList();
				}

				if($tour->excursionId) {
					$query = "SELECT * FROM #__dacatalog_excursions WHERE id IN(".$tour->excursionId.")";
					$db->setQuery( $query );
					$tour->excursions = $db->loadObjectList();
				}

				if($tour->visaId) {
					$query = "SELECT * FROM #__dacatalog_visa WHERE id IN(".$tour->visaId.")";
					$db->setQuery( $query );
					$tour->visa = $db->loadObjectList();
				}
				// Выбираем тур <--------------

				if(!$tour->published) {
					$buffer = str_replace($match[0], '', $buffer);
					continue;
				}

				$currency = array();

				$cacheCurrency = json_decode(file_get_contents('plugins/system/pricetour/currency.json'), true);
				if($cacheCurrency && $cacheCurrency['date'] == date('Y-m-d H')) {
					$currency = $cacheCurrency;
				} else {
					$xml = simplexml_load_file('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
					$xml = $xml->Cube->Cube;

					$currency['date'] = date('Y-m-d H');
					foreach($xml->Cube AS $attr) {
						$currency['currency'][(string)$attr->attributes()->currency] = (string)$attr->attributes()->rate;
					}
					$currency['currency']['EUR'] = 1;
				}

				// Записываем во временный файл
				if($xml) {
					file_put_contents('plugins/system/pricetour/currency.json', json_encode($currency));
				}

				$price = 0;
				if($tour->flights)  {
					foreach($tour->flights AS $flight) {
						$price += $flight->price / $currency['currency'][$flight->currency] * $currency['currency']['GBP'];
					}
				}
				if($tour->hotels)  {
					foreach($tour->hotelsDates->hotelId AS $i => $hotelId) {
						//if(!$tour->hotelsDates->dateFrom[$i] || !$tour->hotelsDates->dateTo[$i]) continue;

						$dateFrom = strtotime($tour->hotelsDates->dateFrom[$i]);
						$dateTo = strtotime($tour->hotelsDates->dateTo[$i]);

						$hotelPrices = json_decode($tour->hotels[$hotelId]->price);

						foreach(range($dateFrom, $dateTo, 86400) AS $date) {
							if($date == $dateTo) break;
							//echo date("d.m.Y", $date)."\n";
							foreach($hotelPrices->price AS $a => $roomPrice) {
								$priceDateFrom = strtotime($hotelPrices->dateFrom[$a]);
								$priceDateTo = strtotime($hotelPrices->dateTo[$a]);

								if($date >= $priceDateFrom && $date <= $priceDateTo) {
									$price += $roomPrice / $currency['currency'][$tour->hotels[$hotelId]->currency] * $currency['currency']['GBP'];
								}
							}
						}
					}
				}

				if($tour->excursions)  {
					foreach($tour->excursions AS $excursion) {
						$price += $excursion->price / $currency['currency'][$excursion->currency] * $currency['currency']['GBP'];
					}
				}
				if($tour->trains)  {
					foreach($tour->trains AS $train) {
						$price += $train->price / $currency['currency'][$train->currency] * $currency['currency']['GBP'];
					}
				}
				if($tour->price) {
					$price += $tour->price / $currency['currency'][$tour->currency] * $currency['currency']['GBP'];
				}

				//@file_put_contents('test.txt', date('Y-m-d H:i:s')."\t" .$id.' / '. $price . "\n\n", FILE_APPEND);

				if($tour->commission) {
					if (strpos($tour->commission, '%') !== false) {
						$tour->commission = trim(str_replace('%', '', $tour->commission)) / 100;
						$price += $price * $tour->commission;
					} else {
						$price += $tour->commission;
					}
				}

				if($tour->visa)  {
					foreach($tour->visa AS $visa) {
						$price += $visa->price / $currency['currency'][$visa->currency] * $currency['currency']['GBP'];
					}
				}
				
				if($tour->tax) {
					$price += $tour->tax;
				}

				$price = round($price, 2);

				if($tour->discount) {
					$discountPrice = round($price - $price / 100 * $tour->discount, 2);

					$price = '
					<span class="priceact discount">
						<span data-moneyid="2" data-value="'.$price.'" data-currency="gbp" data-showplus="0" class="jsMoney jbcartvalue">
							<span class="jbcurrency-value">'.$price.'</span> <span class="jbcurrency-symbol">£</span>
						</span>
					</span>
					<span class="priceact">
						<span data-moneyid="2" data-value="'.$discountPrice.'" data-currency="gbp" data-showplus="0" class="jsMoney jbcartvalue">
							<span class="jbcurrency-value">'.$discountPrice.'</span> <span class="jbcurrency-symbol">£</span>
						</span>
					</span>';
				} else {
					$price = '
					<span class="priceact">
						<span data-moneyid="2" data-value="'.$price.'" data-currency="gbp" data-showplus="0" class="jsMoney jbcartvalue">
							<span class="jbcurrency-value">'.$price.'</span> <span class="jbcurrency-symbol">£</span>
						</span>
					</span>';
				}

				$buffer = str_replace($match[0], $price, $buffer);
			}
		}

		$app->setBody($buffer);

		return true;
	}
}