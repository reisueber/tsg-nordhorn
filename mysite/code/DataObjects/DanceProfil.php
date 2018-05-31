<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Security\Member;

class DanceProfil extends DataObject{

	private static $db = [
		'danceTogetherSince'	=> 'Varchar(255)',
		'danceGroup'			=> 'Varchar(255)',
		'danceClass'			=> 'Varchar(255)',
		'successes'				=> 'Text',
		'description'			=> 'Text'
	];

	private static $has_one = [
		'danceProfilImage'		=> Image::class
	];

	private static $has_many = [
		'Members'				=> 	Members::class
	];
	
	public function getPartners(){
		$id = $this->ID;
		$partnerOne = Member::get()->filter(['DanceProfilID' => $id])->First();
		$partnerTwo = Member::get()->filter(['DanceProfilID' => $id])->Last();
		if($partnerOne && $partnerTwo){
			return $partnerOne->FirstName . " " . $partnerOne->Surname . " - " . $partnerTwo->FirstName . " " . $partnerTwo->Surname;
		}else{
			return $id;
		}
	}
}