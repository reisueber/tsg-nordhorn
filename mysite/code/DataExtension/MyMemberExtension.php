<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\Control\Email\Email;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\ORM\Queries\SQLUpdate;


use SGN\HasOneEdit\UpdateFormExtension;

class MyMemberExtension extends DataExtension{

	private static $db = [
		'hobbies' 				=> 'Text',
		'danceSince' 			=> 'Varchar(255)',
		'favDances' 			=> 'Varchar(255)',
		'isInCommittee'			=> 'Boolean',
		'isInactive'			=> 'Boolean',
		'committeePosition'		=> 'Varchar(255)',
        'committeeEmail'        => 'Varchar(255)',
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
	
	private $unsaved_relation_DanceProfil;
	
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

    private function getDanceProfil()
    {
        if($danceProfileID = $this->owner->DanceProfilID){
            return DanceProfil::get()->filter(['ID' => $danceProfileID])->First();
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
        $danceProfils = DanceProfil::get()->map('ID', 'Partners');

        $danceTogetherSinceValue = $this->owner->DanceProfil()->danceTogetherSince;
        $DanceProfilID = $this->owner->DanceProfilID;
        
        $fields->addFieldsToTab('Root.Tanzprofil', array (
        	DropdownField::create('dancePartnerID', 'Tanzpartner', $Members)->setEmptyString('(Auswählen)'),
            TextareaField::create('hobbies', 'Hobbies'),
			TextField::create('danceSince', 'tanzt seit'),
			TextField::create('favDances', 'Lieblingstänze'),
			CheckboxField::create('isInactive', 'ist inaktives Tanzpaar'),
			CheckboxField::create('profilActive', 'Profil ist aktiv'),
			DropdownField::create('DanceProfilID', 'Tanzprofil', $danceProfils)->setEmptyString('(Auswählen)'),
			$grid = GridField::create('DanceProfil', null, DanceProfil::get()->filter(['ID' => $DanceProfilID]))
        ));
        
        
        $config = $grid->getConfig();
        $config->addComponent(new GridFieldEditButton());
        $config->addComponent(new GridFieldDetailForm());
        $dataColumns = $config->getComponentByType(GridFieldDataColumns::class);
        $dataColumns->setDisplayFields([
            'danceTogetherSince' => 'danceTogetherSince',
            'danceGroup'=> 'danceGroup',
            'danceClass' => 'danceClass'
        ]);

        $fields->addFieldsToTab('Root.Vorstand', array (
            CheckboxField::create('isInCommittee', 'ist im Vorstand'),
			TextField::create('committeePosition', 'Position im Vorstand'),
			TextField::create('committeeEmail', 'E-Mail im Vorstand'),
			TextareaField::create('committeeDescription', 'Beschreibung'),
        ));
    }

	public function onBeforeWrite()
    {		
    		//publish profilImage
            if($this->owner->profilImage() && $this->owner->profilImage()->exists()) {
                $this->owner->profilImage()->publishSingle();
            }
            
            //dancePartner is changed
            if($this->owner->isChanged('dancePartnerID')){
           			
           			//reset dancePartners->dancePartnerID = null
            		$currentID = $this->owner->ID;
            		$sqlQuery = new SQLSelect();
					$sqlQuery->setFrom('Member');
					$sqlQuery->selectField('dancePartnerID');
					$sqlQuery->addWhere(array('ID' => $currentID));
					$result = $sqlQuery->execute();
					foreach($result as $row) {
						$oldPartnerID = $row['dancePartnerID'];
    					$update = SQLUpdate::create('"Member"')->addWhere(['ID' => $oldPartnerID]);
    					$update->assign('"dancePartnerID"', null);
    					$update->execute();
					}
					
					
					if($dancePartner = $this->getPartner())
					{
    					//set currentUserID to new dancePartner->dancePartnerID
    					if($dancePartner->dancePartnerID != $this->owner->dancePartnerID)
    					{
		    				$dancePartnerID = $dancePartner->ID;
		    				$currentUserID = $this->owner->ID;
		    				$update = SQLUpdate::create('"Member"')->addWhere(['ID' => $dancePartnerID]);
    						$update->assign('"dancePartnerID"', $currentUserID);
    						$update->execute();
		    			}
		    			
		    			//PROFILE
		    			//check if old profil exist
		    			$ID_partner1 = $currentID < $dancePartner->ID ? $currentID : $dancePartner->ID;
		    			$ID_partner2 = $currentID > $dancePartner->ID ? $currentID : $dancePartner->ID;
		    			$oldProfil = DanceProfil::get()->filter(['ID_partner1' => $ID_partner1, 'ID_partner2' => $ID_partner2])->First();
		    				
		    			if($this->getDanceProfil() && !$oldProfil)
		    			{	
		    				$danceProfile = new DanceProfil;
		    				$danceProfile->ID_partner1 = $ID_partner1;
		    				$danceProfile->ID_partner2 = $ID_partner2;
							$danceProfile->write();
							
							$this->owner->DanceProfilID = $danceProfile->ID;
							$dancePartner->DanceProfilID = $danceProfile->ID;
						
							$dancePartner->write();
		    			}
		    			else
		    			{
		    				if($oldProfil)
		    				{
		    					$this->owner->DanceProfilID = $oldProfil->ID;
								$dancePartner->DanceProfilID = $oldProfil->ID;
								$dancePartner->write();
		    				}
		    			
		    				//create new Profil
		    				else
		    				{
		    					$danceProfile = new DanceProfil;
		    					$danceProfile->ID_partner1 = $ID_partner1;
		    					$danceProfile->ID_partner2 = $ID_partner2;
								$danceProfile->write();
						
								$this->owner->DanceProfilID = $danceProfile->ID;
								$dancePartner->DanceProfilID = $danceProfile->ID;
						
								$dancePartner->write();
		    				}
		    			}
		    			
    				}	
    				
    				
    				
				
			}
			
			//write in danceProfil partner1ID and partner2ID to find the old profil

            //check danceProfil
			/*if($dancePartner = $this->getPartner())
			{
                if($danceProfil = $this->getDanceProfil()){
					if($danceProfil->ID != $dancePartner->DanceProfilID){
						$dancePartner->DanceProfilID = $danceProfil->ID;
						$dancePartner->write();
					}
				}else{
				
					if($dancePartnerProfilID = $dancePartner->DanceProfilID && 
						$dancePartner->dancePartnerID == $this->owner->dancePartnerID)
					{
						$this->owner->DanceProfilID = $dancePartnerProfilID;
					}
					else
					{
						$danceProfile = new DanceProfil;
						$danceProfile->write();
						
						$this->owner->DanceProfilID = $danceProfile->ID;
						$dancePartner->DanceProfilID = $danceProfile->ID;
						
						$dancePartner->write();
					}

				}

	        }*/
            

            //send E-Mail
            if(!$this->owner->ID){
            	$from = "website@tsg-nordhorn.de";
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