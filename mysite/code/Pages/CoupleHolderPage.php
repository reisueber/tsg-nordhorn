<?php

use SilverStripe\View\Requirements;
use SilverStripe\Security\Member;
use SilverStripe\ORM\ArrayList;

class CoupleHolderPage extends Page{

	public function getCouples()
	{
		$Members = Member::get()->filter(['profilActive' => true, 'isInactive' => isset($_GET['inactive'])]);
		$Couples = new ArrayList();

		foreach($Members as $Member){
			$Member->PartnerFirstName = $this->getPartnerFirstName($Member->ID);
			$Couples->push($Member);
		}

		return $Couples;
	}

	public function getPartnerFirstName($MemberID)
	{
		if($currentPartnerID = Member::get()->filter(['ID' => $MemberID])->First()->dancePartnerID){
			return Member::get()->filter(['ID' => $currentPartnerID])->First()->FirstName;
		}
	}

	public function inactivePage(){
		return isset($_GET['inactive']);
	}

}

class CoupleHolderPageController extends PageController{
	protected function init()
	{
		parent::init();
		Requirements::themedJavascript("clickableRow");
	}
}