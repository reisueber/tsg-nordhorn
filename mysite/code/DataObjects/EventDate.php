<?php

use SilverStripe\ORM\DataObject;

class EventDate extends DataObject{

	private static $db = [
		'Date'	=> 'Date',
		'Description' => 'Text'
	];

	private static $summary_fields = [
		'Date',
		'Description'
	];

	private static $default_sort = "Date ASC";
}