<?php

class Zend_View_Helper_PrepareConcertDate extends Zend_View_Helper_Abstract
{
	public function prepareConcertDate(DateTime $date, $printYear = false, $time = '')
	{
		$out = sprintf("%d<br>%s",$date->format('d'), $this->view->translate(sprintf('month.%d', $date->format('n'))) );
		if( $printYear ){
			$out .= sprintf('<div class="time">%s</div>', $date->format('Y'));
		}else{
			$out .= sprintf('<div class="time">%s</div>', $this->view->escape($time));
		}

		return $out;
	}
}