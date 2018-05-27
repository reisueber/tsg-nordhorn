<?php

use SilverStripe\Security\Member;
use SilverStripe\View\Requirements;

class CouplePage extends Page{

	public function getSelectedMember(){
		$MemberID = isset($_GET['id']) ? $_GET['id'] : "";
		return Member::get()->filter(['ID' => $MemberID])->First();
	}

}


class CouplePageController extends PageController{
	protected function init()
	{
		parent::init();
		Requirements::themedCSS("couple");
	}
}