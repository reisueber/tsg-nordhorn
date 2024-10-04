<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TimeField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Control\Email\Email;

class TournamentReport extends DataObject{
	//db fields
	private static $db = array (
		'Datum' => 'Date',
		'Uhrzeit' => 'Time',
		'Turniernummer' => 'Text',
		'Ausrichter' => 'Text',
		'Startgruppe' => 'Text',
		'Klasse' => 'Text',
		'Standard' => 'Boolean',
		'Latein' => 'Boolean',
		'Type'	=> 'Varchar(10)',
		'Taenze' => 'Text',
		'LW' => 'Boolean',
		'T' => 'Boolean',
		'Q' => 'Boolean',
		'Cha' => 'Boolean',
		'R' => 'Boolean',
		'J' => 'Boolean',
		'Status' => 'Text',
		'Platzierung' => 'Varchar(10)',
		'Gesamtplatzierungen' => 'Varchar(10)',
		'Tanzpartner' => 'Varchar(255)'
	);

	//Relations
	private static $has_one = array (
		'ReportListPage' => ReportListPage::class,
		'Author' => Member::class
	);

	//Fields to show in the DOM table
	private static $summary_fields = array(
		'Author.Name',
		'Tanzpartner',
		'Datum',
		'Uhrzeit',
		'Turniernummer',
		'Ausrichter',
		'Startgruppe',
		'Klasse',
		'Type',
		'Status',
		'Platzierung',
		'Gesamtplatzierungen'
	);

	private static $field_labels = array(
		'Author.FirstName' => 'Name',
		'Turniernummer' => 'Turniernr',
		'Startgruppe' => 'Gruppe',
		'Standard' => 'STD',
		'Latein' => 'LAT',
		'Platzierung' => 'Platz',
		'Gesamtplatzierungen' => 'von'
	);

	private static $default_sort = "Datum ASC, Turniernummer ASC";

	private static $searchable_fields = array (
		'Datum',
		'Author.FirstName',
		'Turniernummer',
		'Ausrichter',
		'Startgruppe',
		'Klasse'
	);

	private static $extensions = [
		Versioned::class
	];

	public function IsOurEntry() {
		$currentUser = Security::getCurrentUser();
		$dancePartnerID = $currentUser->dancePartnerID;
		if($Partner = Member::get()->filter(['ID' => $dancePartnerID])->First()){
			return ($currentUser->ID == $this->AuthorID || $Partner->ID == $this->AuthorID);
		};

		return $currentUser->ID == $this->AuthorID;
	}
	
	public function foo(){
		$currentUser = Security::getCurrentUser();
		return $this->AuthorID;
	}
	
	//Fields for the DOM Popup
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab('Root.Main', array(
			DateField::create('Datum', 'Datum'),
			TimeField::create('Uhrzeit', 'Uhrzeit'),
			TextField::create('Turniernummer', 'Turniernummer'),
			TextField::create('Ausrichter'),
			TextField::create('Startgruppe'),
			TextField::create('Klasse'),
			OptionsetField::create('Type', 'Typ', ['Std' => 'Std', 'Lat' => 'Lat']),
			TextField::create('Taenze'),
			CheckboxField::create('LW', 'LW'),
			CheckboxField::create('T', 'T'),
			CheckboxField::create('Q', 'Q'),
			CheckboxField::create('Cha', 'Cha'),
			CheckboxField::create('R', 'R'),
			CheckboxField::create('J', 'J'),
			DropdownField::create(
				'Status',
				'Status',
				array(
					'Meldung erhalten' => 'Meldung erhalten',
					'Auslandsgenehmigung beantragt' => 'Auslandsgenehmigung beantragt',
					'gemeldet' => 'gemeldet',
					'Paar abgemeldet', 'Paar abgemeldet',
					'TURNIER ABGESAGT' => 'TURNIER ABGESAGT',
					'Meldung abglehnt' => 'Meldung abgelehnt'
				)),
			TextField::create('Tanzpartner', 'Tanzpartner'),
			TextField::create('Platzierung', 'Platz (XX.)'),
			TextField::create('Gesamtplatzierungen', 'von')
		));
		return $fields;
	}

	/*public function getType(){
		return $this->convertOldType();
	}*/

	public function convertOldType(){
		$type = "";
		if(empty($this->Type)){
			if($this->Standard)$type = "Std";
			if($this->Latein)$type = "Lat";
		}else{
			$type = $this->Type;
		}
		return $type;		
	}

    private function convertToNewStartgruppe($startgruppe) {
        return str_replace("SEN", "MASTER", $startgruppe);
    }

	public function getTournamentType(){
		return $this->convertToNewStartgruppe($this->Startgruppe) . " " . $this->Klasse . " " . $this->convertOldType();
	}

	public function getStatusTagColor(){
		switch ($this->Status) {
			case 'Meldung erhalten':
				return 'yellow';
				break;
			case 'Auslandsgenehmigung beantragt':
				return 'yellow';
				break;
			case 'gemeldet':
				return 'green';
				break;
			case 'Paar abgemeldet':
				return 'red';
				break;
			case 'Turnier abgesagt':
				return 'red';
				break;
			case 'Meldung abglehnt':
				return 'red';
				break;
            case 'Vom Paar storniert':
                return 'red';
                break;
			
			default:
				# code...
				break;
		}
	}

    public function isOld(){
		$oneday = strtotime( '-1 days' );
		$today = date('Y-m-d', $oneday);
		return $this->Datum < $today;
	}

	public function isReportLibrary(){
		return (!empty($_GET['show']) == "reportLibrary");
	}

	private function sendReportCreate(){
		$currentMember = Security::getCurrentUser();
		$from = "sportwart@tsg-nordhorn.de";
		$to = $currentMember->Email;
		//$to = "bereusei@gmail.com";
		$ausrichter = $this->Ausrichter;
		$subject = "Meldung $ausrichter";
		$firstName = $currentMember->FirstName ? $currentMember->FirstName : "";
		$fullName = $currentMember->fullName ? $currentMember->fullName : "";
		$date = $this->Datum;
		$time = $this->Uhrzeit;
		$turniernummer = $this->Turniernummer;
		$type = $this->Startgruppe . " " . $this->Klasse . " " . $this->Type;

		//Email User
		$email_user = Email::create()
			->setHTMLTemplate('Email\email_Turniermeldung')
			->setData([
				'FirstName'		=> $firstName,
				'Date'			=> $date,
				'Time' 			=> $time,
				'Turniernummer' => $turniernummer,
				'Ausrichter'	=> $ausrichter,
				'Type' 			=> $type
			])
			->setFrom($from)
			->setTo($to)
			->setSubject($subject);
		$email_user->send();

		//Email Sportwart
		$email_sportwart = Email::create()
			->setHTMLTemplate('Email\email_Turniermeldung_Sportwart')
			->setData([
				'Fullname'		=> $fullName,
				'Date'			=> $date,
				'Time' 			=> $time,
				'Turniernummer' => $turniernummer,
				'Ausrichter'	=> $ausrichter,
				'Type' 			=> $type
			])
			->setFrom($from)
			->setTo("sportwart@tsg-nordhorn.de")
//			->setTo("sascha@reisueber.de")
			->setSubject($subject . " - " . $fullName);
		$email_sportwart->send();
	}

	public function sendReportUpdate(){
		$authorId = $this->AuthorID;
		$author = Member::get()->filter(['ID' => $authorId])->First();
		$from = "noreply@tsg-nordhorn.de";
		$to = $author->Email;
		//$to = "bereusei@gmail.com";
		$ausrichter = $this->Ausrichter ? $this->Ausrichter : "";
		$subject = "Status Update: Turnier $ausrichter";
		$firstName = $author->FirstName ? $author->FirstName : "";
		//$firstName = $author->Email;
		$date = $this->Datum ? $this->Datum : "";
		$time = $this->Uhrzeit ? $this->Uhrzeit : "";
		$turniernummer = $this->Turniernummer ? $this->Turniernummer : "";
		$type = $this->Type ? $this->Startgruppe . " " . $this->Klasse . " " . $this->Type : "";
		$status = $this->Status ? $this->Status : "";

		$email = Email::create()
			->setHTMLTemplate('Email\email_Turniermeldung_update')
			->setData([
				'FirstName'		=> $firstName,
				'Date'			=> $date,
				'Time' 			=> $time,
				'Turniernummer' => $turniernummer,
				'Ausrichter'	=> $ausrichter,
				'Type' 			=> $type,
				'Status'		=> $status
			])
			->setFrom($from)
			->setTo($to)
			->setSubject($subject);
		if($this->Status == "gemeldet"){
			$email->send();
		}	
	}

	function onBeforeWrite(){
		if(!$this->ID){
			$currentMember = Security::getCurrentUser();
			if($currentMember){
				$this->AuthorID = $currentMember->ID;
			}

			$this->Status = "in Bearbeitung";
			$this->sendReportCreate();	
		}

		if($this->isChanged('Status')){
			$this->sendReportUpdate();
		}

		$wrongdate = $this->dbObject("Datum")->InPast();


		parent::onBeforeWrite();
	}
}