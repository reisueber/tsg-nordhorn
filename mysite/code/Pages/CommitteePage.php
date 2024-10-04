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
    private static $allowed_actions = ['mailLink'];

    protected function init()
	{
		parent::init();
		Requirements::themedCSS("committee");
		Requirements::themedJavascript("clickableRow");
	}

    public function isAdmin(){
        return Security::getCurrentUser()->inGroup('Administratoren');
    }

    public function mailLink(){
	    $id = $_GET['id'];
        $member = Member::get()->filter(['ID' => $id])->First();
        $email = $member->committeeEmail;
        header("Location: mailto:$email");
    }
}