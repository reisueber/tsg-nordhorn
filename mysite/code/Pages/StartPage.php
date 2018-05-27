<?php

use SilverStripe\View\Requirements;

class StartPage extends Page{

	public function getStartPageNews(){
		$articles = PressPage::get()->filter(['setOnStartpage' => true]);
		return $articles;
	}

	public function getActiveEvents(){
		$now = date('Y.m.d');
		$events = EventDate::get()->filter([
			'Date:GreaterThanOrEqual' => $now
		]);
		return $events;
	}
}

class StartPageController extends PageController{
	protected function init()
	{
		parent::init();
		Requirements::themedJavascript("clickableRow");
	}
}