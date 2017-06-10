/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

//CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
//};



CKEDITOR.editorConfig = function( config ) {
	  var server = window.location.href;
		 var host = window.location.host;
		
				 var server = window.location.pathname;
		         server1 = server.replace(server, VARS_AMBIENTE['caminho_servidor']); 
		         config.extraPlugins = 'justify';
              
     config.filebrowserBrowseUrl = server1+'kcfinder/browse.php?type=files';
     config.filebrowserImageBrowseUrl = server1+'kcfinder/browse.php?type=images';
     config.filebrowserFlashBrowseUrl = server1+'kcfinder/browse.php?type=flash';
     config.filebrowserUploadUrl = server1+'kcfinder/upload.php?type=files';
     config.filebrowserImageUploadUrl = server1+'kcfinder/upload.php?type=images';
     config.filebrowserFlashUploadUrl = server1+'kcfinder/upload.php?type=flash';
    
    
    

/*config.filebrowserBrowseUrl = server1+'ckfinder/ckfinder.html',
config.filebrowserImageBrowseUrl = server1+'ckfinder/ckfinder.html?type=Images',
config.filebrowserFlashBrowseUrl = server1+'ckfinder/ckfinder.html?type=Flash',
config.filebrowserUploadUrl = server1+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Fil­es',
config.filebrowserImageUploadUrl = server1+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Ima­ges',
config.filebrowserFlashUploadUrl = server1+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

*/
    
     
     
     
     
     
     
     config.enterMode = CKEDITOR.ENTER_BR;
	
	/*config.toolbar = [
	                  { name: 'document', items: [ 'Source', '-', 'Preview', '-', 'Templates' ] },
	                  { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	                  '/',
	                  { name: 'basicstyles', items: ['Font' ,'FontSize', 'TextColor','BGColor', 'Bold', 'Italic', 'JustifyLeft','JustifyCenter','JustifyRight', 'Blockquote','JustifyBlock', 'Image','Table', 'Maximize' ] }, '/',
	               
	              ];*/
	
	
	config.toolbar = [
	                  { name: 'document', items: [ 'Source', '-'] },
	                  { name: 'clipboard', items: [ 'Cut', 'Copy', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	                  '/',
	                  { name: 'basicstyles', items: ['Font' ,'FontSize', 'TextColor','BGColor', 'Bold', 'Italic', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'Table', 'Maximize', 'Image' ] }, '/',
	               
	              ];
	
	
	
	
};

