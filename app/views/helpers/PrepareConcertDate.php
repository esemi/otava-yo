<?php

class Zend_View_Helper_PrepareConcertDate extends Zend_View_Helper_Abstract
{
	public function prepareConcertDate(DateTime $date, $printYear = false, $time = '')
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

		$out = sprintf("%d<br>%s",$date->format('d'), $months[$date->format('n')]);
		if( $printYear ){
			$out .= sprintf('<div class="time">%s</div>', $date->format('Y'));
		}else{
			$out .= sprintf('<div class="time">%s</div>', $this->view->escape($time));
		}
		
		return $out;
	}
}