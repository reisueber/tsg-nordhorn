<?php

use SilverStripe\View\Requirements;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TimeField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Security\Security;
use SilverStripe\View\ArrayData;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\Security\Member;

class ReportListPage extends Page{

	private static $has_many = [
		'TournamentReports' => TournamentReport::class
	];

	private static $owns = [
		'TournamentReport'
	];

	public function getReports(){
		$twoweeks = strtotime( '-1 week' );
		$twoweeksago = date( 'Y-m-d H:i:s', $twoweeks );
		$currentReports = TournamentReport::get()->filter([
			'Datum:GreaterThan' => $twoweeksago
		]);
		$allReports = TournamentReport::get();
		
		return $this->isReportLibrary() ? $allReports : $currentReports;
	}

	public function isReportLibrary(){
		return (!empty($_GET['show']) == "reportLibrary");
	}

}

class ReportListPage_Controller extends PageController{

	private static $allowed_actions = [
		'TournamentForm',
		'updateReport',
		'showReportLibrary'
	];


	public function TournamentForm()
	{
		$tournamentForm = Form::create(
			$this,
			'TournamentForm',
			FieldList::create(
				DateField::create('Datum', 'Datum'),
				TimeField::create('Uhrzeit', 'Uhrzeit'),
				NumericField::create('Turniernummer', 'Turniernummer'),
				TextField::create('Ausrichter', 'Ausrichter'),

				DropdownField::create('Startgruppe', 'Startgruppe', array(
					'HGR' 		=> 'HGR',
					'HGR II' 	=> 'HGR II',
					'SEN I' 	=> 'SEN I',
					'SEN II' 	=> 'SEN II'
				)),
				//->setTemplate("MyDropDownField"),
				DropdownField::create('Klasse', 'Klasse', array(
					'D' => 'D',
					'C' => 'C',
					'B' => 'B',
					'A' => 'A',
					'S' => 'S'
				)),
				//->setTemplate("MyDropDownField"),
				OptionsetField::create('Type', 'Typ', ['Std' => 'Standard', 'Lat' => 'Latein'])
					->addExtraClass("row")
					->addExtraClass("col-md-12")
					//->setTemplate("MyOptionsetField")
			),
			FieldList::create(
				FormAction::create('sendTournamentReport', 'Turnier melden')->addExtraClass('button button-pill button-primary')
			)
		);

		$tournamentForm->setTemplate('ReportFormTemplate');
		$tournamentForm->disableSecurityToken();

		return $tournamentForm;
	}


	public function sendTournamentReport($data, $form){
		$report = TournamentReport::create();
		$report->ReportListPageID = $this->ID;
		$report->Tanzpartner = $this->getPartner()->fullName;
		$form->saveInto($report);
		$report->write();

		$form->sessionMessage('Thanks!', 'good');

		return $this->redirectBack();
	}

	public function updateReport(){
		$type = $_GET['type'];
		$ids = $_GET['ids'];
		$idArray = explode(',', $ids);

		$selectedReports = TournamentReport::get()->filter(array(
			'ID' => $idArray
		));

		foreach ($selectedReports as $Report){
			$Report->Status = $type;
			$Report->sendReportUpdate();
			$Report->write();
		}

		return $this->redirectBack();
	}

	public function showReportLibrary(){
		return $this->redirect('meldeliste?show=reportLibrary');
	}

	private function getPartner()
	{
		if( $user = Security::getCurrentUser() ) {
			if($dancePartnerID = $user->dancePartnerID){
				return Member::get()->filter(['ID' => $dancePartnerID])->First();	
			}
		}
	}

	protected function init()
	{
		parent::init();
		Requirements::themedCSS("reportlist");
		Requirements::themedJavascript("reportlist");
	}
}
