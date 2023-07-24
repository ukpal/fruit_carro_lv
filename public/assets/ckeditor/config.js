/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	var file_upload_url = "http://localhost/thesatyanweshi/pits-admin-panel/settings/upload_editor_file";
	config.filebrowserImageUploadUrl = file_upload_url;
	config.extraAllowedContent = 'iframe[*]'
	/*config.toolbar = [
	['Bold','Italic','Underline'],
	['Table','Source'],
	['Link', 'Unlink', 'Anchor']
	] ;*/
};
