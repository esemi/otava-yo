<?php

class Zend_View_Helper_PrepareConcertDate extends Zend_View_Helper_Abstract
{
	public function prepareConcertDate($date)
	{
		$months = array(
			1 => 'янв',
			2 => 'фев',
			3 => 'март',
			4 => 'апр',
			5 => 'мая',
			6 => 'июня',
			7 => 'июля',
			8 => 'авг',
			9 => 'сент',
			10 => 'окт',
			11 => 'нояб',
			12 => 'дек'
		);

		$date = DateTime::createFromFormat('Y-m-d', $date);
		return sprintf("%d<br>%s",$date->format('d'), $months[$date->format('n')]);;
	}
}