<?php

use SilverStripe\View\Requirements;

class PressHolderPage extends Page{
	private static $allowed_children = [
		'PressPage' => 'PressPage'
	];
}

class PressHolderPage_Controller extends PageController{
	protected function init()
	{
		parent::init();
		Requirements::themedCSS("material_icons");
		Requirements::themedJavascript("clickableRow");
	}
}