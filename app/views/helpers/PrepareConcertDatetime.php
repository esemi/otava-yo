<?php

class Zend_View_Helper_PrepareConcertDatetime extends Zend_View_Helper_Abstract
{
	public function prepareConcertDatetime($date, $time=null)
	{
		$dateString = $date;
		if( !empty($time) )
			$dateString .= "Т{$time}";

		return $dateString;
	}
}