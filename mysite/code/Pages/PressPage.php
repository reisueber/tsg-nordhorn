<?php

use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLTextField;
use SilverStripe\Forms\HiddenField;
use \SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\View\Requirements;
use SilverStripe\Security\Security;


class PressPage extends Page{
	private static $db = [
		'Date' 				=> 'Date',
		'City'				=> 'Varchar(255)',
		'setOnStartpage' 	=> 'Boolean',
		'MainImageY'		=> 'Varchar(5)',
		'MainImageX'		=> 'Varchar(5)',
		'MainWidth'			=> 'Varchar(5)'
	];

	private static $has_one = [
		'MainImage' 		=> Image::class
	];

	private static $has_many = [
		'Images' 			=> PressImage::class
	];

	public function getCMSFields(){
		$fields = parent::getCMSFields();

		$fields->addFieldsToTab('Root.Main', array(
			DateField::create('Date', 'Date'),
			TextField::create('City', 'Ort'),
			TextField::create('Title', 'Titel'),
			CheckboxField::create('setOnStartpage', 'Auf Startseite stellen', 1)
		));

		$fields->addFieldsToTab('Root.Bilder', array(
			UploadField::create('MainImage', 'Hauptbild')->setFolderName('Uploads/Pressebilder'),
			TextField::create('MainImageX', 'X-Position'),
			TextField::create('MainImageY', 'Y-Position'),
			TextField::create('MainImageWidth', 'Size'),
			UploadField::create('Images', 'Bilder')->setFolderName('Uploads/Pressebilder'),
		));
		return $fields;
	}

	public function isAdmin(){
		/*if( $user = Security::getCurrentUser() )
		{
			return $user->inGroup('Administratoren');
		}*/
		return true;
	}

}

class PressPageController extends PageController{

	private static $allowed_actions = [
		'EditForm',
		'SaveSettings'
	];

	public function EditForm(){

		$editForm = Form::create(
			$this,
			'EditForm',
			FieldList::create(
				HiddenField::create('MainImageX', 'X'),
				HiddenField::create('MainImageY', 'Y'),
				HiddenField::create('MainImageWidth', 'Width')
			),
			FieldList::create(
				FormAction::create('SaveSettings','Speichern')->addExtraClass('button button-pill button-primary')
			)
		);

		return $editForm;
	}

	public function SaveSettings($data, $form){
		$this->MainImageX = $data['MainImageX'];
		$this->MainImageY = $data['MainImageY'];
		$this->MainImageWidth = $data['MainImageWidth'];
		$this->write();
		return $this->redirectBack("?success=1");
	}

	protected function init()
	{
		parent::init();
		Requirements::themedCSS("press");
		Requirements::css("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css");
		Requirements::javascript("https://code.jquery.com/ui/1.12.1/jquery-ui.js");
		Requirements::themedJavascript("pressPage");

	}
}