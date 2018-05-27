<?php

use SilverStripe\Assets\Image;

class PressImage extends Image{
	private static $has_one = [
		'PressPage' => 'PressPage'
	];
}