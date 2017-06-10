/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here.
    // For complete reference see:
    // http://docs.ckeditor.com/#!/api/CKEDITOR.config

     var server = window.location.href;
     var host = window.location.host;
     var server = window.location.pathname;
     server1 = server.replace(server, VARS_AMBIENTE['caminho_servidor']); 
     config.filebrowserBrowseUrl = server1+'kcfinder/browse.php?type=files';
     config.filebrowserImageBrowseUrl = server1+'kcfinder/browse.php?type=images';
     config.filebrowserFlashBrowseUrl = server1+'kcfinder/browse.php?type=flash';
     config.filebrowserUploadUrl = server1+'kcfinder/upload.php?type=files';
     config.filebrowserImageUploadUrl = server1+'kcfinder/upload.php?type=images';
     config.filebrowserFlashUploadUrl = server1+'kcfinder/upload.php?type=flash';
config.enterMode = CKEDITOR.ENTER_BR;

    // The toolbar groups arrangement, optimized for two toolbar rows.
    config.toolbarGroups = [
            { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
            { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker', 'Image' ] },
            { name: 'links' },
            { name: 'insert' },
            { name: 'forms' },
            { name: 'tools' },
            { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'others' },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
            { name: 'styles' },
            { name: 'colors' },
            { name: 'about' }
    ];

         config.codeSnippet_theme = 'pojoaque';
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
