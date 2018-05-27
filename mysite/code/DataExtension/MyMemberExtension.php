<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Security\Member;
use SilverStripe\Control\Email\Email;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\ReadonlyField;
use SGN\HasOneEdit\UpdateFormExtension;

class MyMemberExtension extends DataExtension{

	private static $db = [
		'hobbies' 				=> 'Text',
		'danceSince' 			=> 'Varchar(255)',
		'favDances' 			=> 'Varchar(255)',
		'danceGroup' 			=> 'Varchar(255)',
		'danceClass' 			=> 'Varchar(255)',
		'successes' 			=> 'Text',
		'description' 			=> 'Text',
		'isInCommittee'			=> 'Boolean',
		'isInactive'			=> 'Boolean',
		'committeePosition'		=> 'Varchar(255)',
		'committeeDescription'	=> 'Text',
		'dancePartnerID'		=> 'Int',
		'profilActive'			=> 'Boolean',
		'profilImageX'			=> 'Varchar(3)',
		'profilImageY'			=> 'Varchar(3)'
	];

	private static $has_one = [
		'profilImage' 			=> Image::class,
		'DanceProfil'			=> DanceProfil::class
	];

	private static $owns = [
		'profilImage'
	];

	private static $has_many = [
		'Images'				=> Image::class,
		'Tournaments'			=> TournamentReport::class
	];

	public function getFullName(){
		return $this->owner->FirstName . " " . $this->owner->Surname;
	}

	public function getPartnerFirstName()
	{
		if($Partner = $this->getPartner())
		{
			return $Partner->FirstName;
		}
	}

	public function getPartnerHobbies()
	{
		if($Partner = $this->getPartner())
		{
			return $Partner->hobbies;
		}
	}

	public function getPartnerDanceSince()
	{
		if($Partner = $this->getPartner())
		{
			return $Partner->danceSince;
		}
	}

	public function getPartnerFavDances()
	{
		if($Partner = $this->getPartner())
		{
			return $Partner->favDances;
		}
	}

	public function getPartnerProfilImage()
	{
		if($Partner = $this->getPartner())
		{
			return $Partner->profilImage();
		}
	}

	public function getPartnerProfilImageX()
	{
		if($Partner = $this->getPartner())
		{
			return $Partner->profilImageX;
		}
	}

	public function getPartnerProfilImageY()
    	{
    		if($Partner = $this->getPartner())
    		{
    			return $Partner->profilImageY;
    		}
    	}
	
	private function getPartner()
	{
		if($dancePartnerID = $this->owner->dancePartnerID){
			return Member::get()->filter(['ID' => $dancePartnerID])->First();	
		}
	}

	public function numberOfIncompleteTournaments(){
		$tournaments = $this->owner->Tournaments()->filter([
			'Platzierung' => null
		]);
		return $tournaments->Count();
	}

	public function profilIsOutdated(){
		$oneYear = strtotime( '-1 year' );
        $lastYear = date( 'Y-m-d H:i:s', $oneYear );
		return $this->owner->LastEdited < $lastYear;
	}

	public function updateCMSFields(FieldList $fields)
    {
        $Members = Member::get()->map('ID', 'FullName');

        $fields->removeByName('DanceProfilID');

        $danceTogetherSinceValue = $this->owner->DanceProfil()->danceTogetherSince;

        $fields->addFieldsToTab('Root.Tanzprofil', array (
        	DropdownField::create('dancePartnerID', 'Tanzpartner', $Members)->setEmptyString('(Auswählen)'),
            TextareaField::create('hobbies', 'Hobbies'),
			TextField::create('danceSince', 'tanzt seit'),
			TextField::create('favDances', 'Lieblingstänze'),
			CheckboxField::create('isInactive', 'ist inaktives Tanzpaar'),
			CheckboxField::create('profilActive', 'Profil ist aktiv'),
			TextField::create('myDanceTogetherSince', 'tanzen seit zusammen')->setValue($danceTogetherSinceValue),
        ));

        $fields->addFieldsToTab('Root.Vorstand', array (
            CheckboxField::create('isInCommittee', 'ist im Vorstand'),
			TextField::create('committeePosition', 'Position im Vorstand'),
			TextareaField::create('committeeDescription', 'Beschreibung'),
        ));
    }

	public function onBeforeWrite()
    {		
    		//set dancePartnerID
			if($dancePartner = $this->getPartner()){
				if($dancePartner->DanceProfilID != $this->owner->DanceProfilID){
					$dancePartner->DanceProfilID = $this->owner->DanceProfilID;
					$dancePartner->write();
				}
			}

			//publish profilImage
            if($this->owner->profilImage() && $this->owner->profilImage()->exists()) {
                $this->owner->profilImage()->publishSingle();
            }

            //send E-Mail
            if(!$this->owner->ID){
            	$from = "pressewart@tsg-nordhorn.de";
            	$to = $this->owner->Email;
            	$subject = "TSG Website";
            	$firstName = $this->owner->FirstName ? $this->owner->FirstName : "";
            
                $email = Email::create()
                    ->setHTMLTemplate('Email\email_Zugangsdaten')
                    ->setData([
                        'FirstName' => $firstName,
                        'Email'	=> $to
                    ])
                    ->setFrom($from)
                    ->setTo($to)
                    ->setSubject($subject);
                $email->send();
            }

            parent::onBeforeWrite();
    }

	
}