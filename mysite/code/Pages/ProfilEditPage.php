<?php

use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\ConfirmedPasswordField;
use SilverStripe\Security\Security;
use SilverStripe\Security\Member;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;


class ProfilEditPage extends Page{

}

class ProfilEditPageController extends PageController{

	private $userFirstName;
	private $userLastName;
	private $userEmail;
	private $hobbies;
	private $danceSince;
	private $favDances;
	private $committeePosition;
	private $committeeDescription;
	private $profilActive;
	private $profilImageX;
	private $profilImageY;
	private $danceProfilImageX;
	private $danceProfilImageY;
	private $danceTogetherSince;
	private $danceGroup;
	private $danceClass;
	private $successes;
	private $description;
	private $dancePartnerName;


	private static $allowed_actions = [
		'EditForm',
		'EditUser'
	];

	public function EditForm(){

		if(isset($_GET['id'])){
			if($selectedMember = Member::get()->filter(['ID' => $_GET['id']])->First()){
				if($existingProfil = $selectedMember->DanceProfil()){
					$this->loadDanceProfilData($existingProfil);
				}

				$this->loadUserData($selectedMember);	
			}

		}elseif ( $user = Security::getCurrentUser() ) {

			if($existingProfil = $user->DanceProfil()){
				$this->loadDanceProfilData($existingProfil);
			}

			$this->loadUserData($user);	
		}

		$isInCommittee = $this->isInCommittee();
		$Members = Member::get()->map('ID', 'FullName');
		//->map('ID', "Foo");

		$editForm = Form::create(
			$this,
			'EditForm',
			FieldList::create(
				TextField::create('FirstName', 'FirstName')->setValue($this->userFirstName)
					->setReadonly(isset($_GET['id'])),
				TextField::create('Surname', 'Surname')->setValue($this->userLastName),
				TextField::create('Email', 'Email')->setValue($this->userEmail),
				TextField::create('hobbies', 'Hobbies')->setValue($this->hobbies),
				TextField::create('danceSince', 'tanzt seit')->setValue($this->danceSince),
				ReadonlyField::create('dancePartnerID', 'Tanzpartner')->setValue($this->dancePartnerName),
				TextField::create('danceTogetherSince', 'tanzen zusammen seit')->setValue($this->danceTogetherSince),
				TextField::create('favDances', 'Lieblingstänze')->setValue($this->favDances),
				TextField::create('danceGroup', 'Gruppe')->setValue($this->danceGroup),
				TextField::create('danceClass', 'Klasse')->setValue($this->danceClass),
				TextareaField::create('successes', 'Erfolge')->setValue($this->successes),
				TextareaField::create('description', 'Ein paar kurze Worte')->setValue($this->description),
				TextField::create('committeePosition', 'Stellung:')->setValue($this->committeePosition),
				TextareaField::create('committeeDescription', 'Text Vorstand')->setValue($this->committeeDescription),
				FileField::create('profilImage', 'Profilbild'),
				HiddenField::create('profilImageX', 'X')->setValue($this->profilImageX),
				HiddenField::create('profilImageY', 'Y')->setValue($this->profilImageY),
				FileField::create('danceProfilImage', 'Tanzpaarbild'),
				HiddenField::create('danceProfilImageX', 'X')->setValue($this->danceProfilImageX),
				HiddenField::create('danceProfilImageY', 'Y')->setValue($this->danceProfilImageY),
				FileField::create('Images', 'Images'),
				CheckboxField::create('profilActive', 'Profil aktiv')->setValue($this->profilActive)->setTemplate('MyCheckboxSlider')
			),
			FieldList::create(
				FormAction::create('EditUser','Änderungen speichern')->addExtraClass('button button-pill button-primary')
			)
		);

		$editForm->customise(new ArrayData([
			'isInCommittee' => $isInCommittee
		]))->setTemplate('ProfilFormTemplate');
		$editForm->disableSecurityToken();

		return $editForm;
	}
	
	private function getPartner()
	{
		if( $user = Security::getCurrentUser() ) {
			if($dancePartnerID = $user->dancePartnerID){
				return Member::get()->filter(['ID' => $dancePartnerID])->First();	
			}
		}
	}


	public function EditUser($data, $form){
		if($data['profilImage']){
			$file = $data['profilImage'];
			if($file['error'] == 0){
				$content = file_get_contents($file['tmp_name']);
			}
		}

		if( $user = Security::getCurrentUser() ) {

			$form->saveInto($user);

			if($dancePartner = $this->getPartner()){
				if($user->DanceProfilID == $dancePartner->DanceProfilID &&
					$user->DanceProfilID != 0){
					$danceProfilID = $user->DanceProfilID;
					$danceProfil = DanceProfil::get()->filter(['ID' => $danceProfilID])->First();
					$form->saveInto($danceProfil);
					$danceProfil->write();
				}else{
					$danceProfil = new DanceProfil;
					$form->saveInto($danceProfil);
					$danceProfil->write();
					
					$user->DanceProfilID = $danceProfil->ID;
					
					$dancePartner->DanceProfilID = $danceProfil->ID;
					$dancePartner->write();
				}
				
				
				
			}
			
			$user->write();

			$form->sessionMessage('Erfolgreich gespeichert', 'success');
			$this->redirect("/profil-edit");
		}else{
			die("Konnte Report nicht finden");
		}
	}

	public function isInCommittee(){
		if( $user = Security::getCurrentUser() )
		{
			return $user->inGroup('Vorstand');
		}
	}

	private function loadUserData($user){
		$this->userFirstName 		= $user->FirstName;
		$this->userLastName 		= $user->Surname;
		$this->userEmail			= $user->Email;
		$this->hobbies 				= $user->hobbies;
		$this->danceSince 			= $user->danceSince;
		$this->favDances 			= $user->favDances;
		$this->committeePosition	= $user->committeePosition;
		$this->committeeDescription	= $user->committeeDescription;
		$this->profilActive			= $user->profilActive;
		$this->profilImageX			= $user->profilImageX;
		$this->profilImageY			= $user->profilImageY;
		$this->dancePartnerName		= $this->getPartner()->fullName;
	}

	private function loadDanceProfilData($profil){
		$this->danceTogetherSince 	= $profil->danceTogetherSince;
		$this->danceGroup 			= $profil->danceGroup;
		$this->danceClass 			= $profil->danceClass;
		$this->successes 			= $profil->successes;
		$this->description 			= $profil->description;
		$this->danceProfilImageX	= $profil->danceProfilImageX;
		$this->danceProfilImageY	= $profil->danceProfilImageY;
	}

	protected function init()
	{
		parent::init();
		Requirements::themedCSS("profiledit");
		Requirements::css("https://unpkg.com/element-ui/lib/theme-chalk/index.css");
		Requirements::javascript("https://code.jquery.com/ui/1.12.1/jquery-ui.js");
		Requirements::javascript("https://unpkg.com/element-ui/lib/index.js");
		Requirements::themedJavascript("profilEdit");
	}
}
