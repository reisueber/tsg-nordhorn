<?php

use SilverStripe\Admin\ModelAdmin;

class PropertyAdmin extends ModelAdmin
{

	private static $menu_title = 'TournamentReport';

	private static $url_segment = 'TournamentReport';

	private static $managed_models = [
		TournamentReport::class,
	];
}