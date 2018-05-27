<?php

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\View\Requirements;

class MyLoginPage extends Page{

}

class MyLoginPageController extends PageController{
	protected function init()
	{
		parent::init();
		Requirements::css("/themes/mytheme/css/login.css");

	}
}