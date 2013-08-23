<?php

class Zend_View_Helper_PrepareConcertDate extends Zend_View_Helper_Abstract
{
	public function prepareConcertDate($date)
	{
		$months = array(
			1 => 'января',
			2 => 'февраля',
			3 => 'марта',
			4 => 'апреля',
			5 => 'мая',
			6 => 'июня',
			7 => 'июля',
			8 => 'августа',
			9 => 'сентября',
			10 => 'октября',
			11 => 'ноября',
			12 => 'декабря'
		);

		$date = DateTime::createFromFormat('Y-m-d', $date);
		return $this->view->escape(sprintf("%d %s",$date->format('d'), $months[$date->format('n')]));
	}
}