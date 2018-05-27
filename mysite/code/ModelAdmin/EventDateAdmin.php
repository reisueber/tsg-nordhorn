<?php

use SilverStripe\Admin\ModelAdmin;

class EventDateAdmin extends ModelAdmin
{

	private static $menu_title = 'EventDate';

	private static $url_segment = 'EventDate';

	private static $managed_models = [
		EventDate::class,
	];
}