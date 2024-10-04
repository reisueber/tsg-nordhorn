<?php

use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TimeField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\View\Requirements;
use SilverStripe\Security\Security;
use SilverStripe\Security\Member;
use SilverStripe\Security\Group;

class ReportEditPage extends Page{

}

class ReportEditPageController extends PageController{
	private static $allowed_actions = [
		'EditForm',
		'EditReport'
	];

	public function EditForm(){
		$id = isset($_GET['id']) ? $_GET['id'] : "";

		if($currentReport = TournamentReport::get()->filter(array( 'ID' => $id ))->first()) {
			$foundReport = true;
		}else{
			$foundReport = false;
		}
		
		$readonly = !$this->isSportwart();
		
		$myDatum = $foundReport ? $currentReport->Datum : "";
		$myUhrzeit = $foundReport ? $currentReport->Uhrzeit : "";
		$myTurniernummer = $foundReport ? $currentReport->Turniernummer : "";
		$myAusrichter = $foundReport ? $currentReport->Ausrichter : "";
		$myStartgruppe = $foundReport ? $currentReport->Startgruppe : "";
		$myKlasse = $foundReport ? $currentReport->Klasse : "";
		$myStandard = $foundReport ? $currentReport->Standard : "";
		$myLatein = $foundReport ? $currentReport->Latein : "";
		$myStatus = $foundReport ? $currentReport->Status : "";
		$platzierung = $foundReport ? $currentReport->Platzierung : "";
		$gesamtPlatzierung = $foundReport ? $currentReport->Gesamtplatzierungen : "";
		
		$StatusField = $this->isSportwart() ? 
				DropdownField::create('Status', 'Status', array(
					'Meldung erhalten' 				=> 'Meldung erhalten',
					'Auslandsgenehmigung beantragt'	=> 'Auslandsgenehmigung beantragt',
					'gemeldet' 						=> 'gemeldet',
					'Paar abgemeldet' 				=> 'Paar abgemeldet',
					'Turnier abgesagt' 				=> 'Turnier abgesagt',
					'Meldung abgelehnt'				=> 'Meldung abgelehnt',
                    'Turnier löschen'               => 'Turnier löschen'
				))->setValue($myStatus) :
				HiddenField::create('Status', 'Status')->setValue($myStatus)->setReadonly($readonly);
		$PlatzierungenField = ($this->isSportwart() || !$this->isOld($id)) ?
				HiddenField::create('Platzierung', 'Platzierung') :
				TextField::create('Platzierung', 'Platzierung')->setValue($platzierung);
		$Gesamtplatzierungen = ($this->isSportwart() || !$this->isOld($id)) ?
				HiddenField::create('Gesamtplatzierungen', 'Gesamtplatzierungen') :
				TextField::create('Gesamtplatzierungen', 'Gesamtplatzierungen')->setValue($gesamtPlatzierung);
		
		$editForm = Form::create(
			$this,
			'EditForm',
			FieldList::create(
				HiddenField::create('ReportId', 'ReportId')->setValue($id),
				DateField::create('Datum', 'Datum')->addExtraClass('col-md-4')->setValue($myDatum)->setReadonly($readonly),
				TimeField::create('Uhrzeit', 'Uhrzeit')->addExtraClass('col-md-4')->setValue($myUhrzeit)->setReadonly($readonly),
				NumericField::create('Turniernummer', 'Turniernummer')->addExtraClass('col-md-4')->setValue($myTurniernummer)->setReadonly($readonly),
				TextField::create('Ausrichter', 'Ausrichter')->addExtraClass('col-md-4')->setValue($myAusrichter)->setReadonly($readonly),
				TextField::create('Startgruppe', 'Gruppe')->addExtraClass('col-md-4')->setValue($myStartgruppe)->setReadonly($readonly),
				TextField::create('Klasse', 'Klasse')->addExtraClass('col-md-4')->setValue($myKlasse)->setReadonly($readonly),
				CheckboxField::create('Standard', 'Standard')->setValue($myStandard)->setReadonly($readonly),
				CheckboxField::create('Latein', 'Latein')->setValue($myLatein)->setReadonly($readonly),
				HiddenField::create('Type', 'Type'),
				$StatusField,
				$PlatzierungenField,
				$Gesamtplatzierungen
			),
			FieldList::create(
				FormAction::create('EditReport','Änderungen speichern')
			)
		);
		$editForm->setTemplate('ReportFormTemplate');
		$editForm->disableSecurityToken();

		return $editForm;
	}

	public function EditReport($data, $form){
		if($report = TournamentReport::get()->filter(array( 'ID' => $data['ReportId'] ))->first()){
			$form->saveInto($report);
			$report->write();

			$this->redirect("/meldeliste/");
		}else{
			die("Konnte Report nicht finden");
		}
	}
	
	public function isSportwart(){
		return Security::getCurrentUser()->inGroup('Sportwart');
    }

    public function isOld($id) {
        if(isset($id) && $report = TournamentReport::get()->filter(array( 'ID' => $id ))->first()){
            return $report->isOld();
        }
    }


	protected function init()
	{
		parent::init();
		Requirements::themedCSS("profiledit");
		Requirements::css("https://unpkg.com/element-ui/lib/theme-chalk/index.css");
		Requirements::javascript("https://code.jquery.com/ui/1.12.1/jquery-ui.js");
		Requirements::javascript("https://unpkg.com/element-ui/lib/index.js");
	}
}