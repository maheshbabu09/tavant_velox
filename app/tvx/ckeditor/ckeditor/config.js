/**

 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.

 * For licensing, see LICENSE.html or http://ckeditor.com/license

 */



CKEDITOR.editorConfig = function( config ) {

	// Define changes to default configuration here. For example:

	// config.language = 'fr';

	// config.uiColor = '#AADC6E';

	config.width=810;

    config.height=500;

	config.resize_enabled = false;

	config.removePlugins = 'elementspath';

	config.enterMode = CKEDITOR.ENTER_BR;
	
	CKEDITOR.dtd.$removeEmpty['i'] = false;
	
	CKEDITOR.dtd.$removeEmpty['span'] = false;

};

