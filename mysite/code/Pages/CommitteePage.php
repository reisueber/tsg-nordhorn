<?php

use SilverStripe\View\Requirements;
use SilverStripe\Security\Member;
use SilverStripe\ORM\ArrayList;

class CommitteePage extends Page{

	private static $owns = [
		'profilImage',
		'committeeImage',
	];

	public function getCommitteeMembers(){
		$Members = Member::get()->filter(['isInCommittee' => true]);

		return $Members->sort('committeePosition ASC');
	}

}

class CommitteePageController extends PageController{
	protected function init()
	{
		parent::init();
		Requirements::themedCSS("committee");
		Requirements::themedJavascript("clickableRow");
	}
}