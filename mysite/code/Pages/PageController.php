<?php

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\View\Requirements;

class PageController extends ContentController
{

    private static $allowed_actions = [];

    protected function init()
    {
        parent::init();
		Requirements::css("/themes/mytheme/thirdparty/bootstrap-4.0.0-dist/css/bootstrap.min.css");
		Requirements::themedCSS("material_icons");
		Requirements::css("/themes/mytheme/thirdparty/fontawesome-free-5.0.8/web-fonts-with-css/css/fontawesome-all.min.css");
		Requirements::css("/themes/mytheme/thirdparty/buttons/css/buttons.css");

		Requirements::themedJavascript("jquery-3.3.1.min");
		Requirements::javascript("/themes/mytheme/thirdparty/vue/vue.js");
//		Requirements::javascript("/themes/mytheme/thirdparty/vue-2.6.10/dist/vue.min.js");
		Requirements::javascript("https://unpkg.com/popper.js/dist/umd/popper.min.js");
		Requirements::javascript("/themes/mytheme/thirdparty/bootstrap-4.0.0-dist/js/bootstrap.min.js");
		Requirements::javascript("/themes/mytheme/thirdparty/buttons/js/buttons.js");
    }
}


