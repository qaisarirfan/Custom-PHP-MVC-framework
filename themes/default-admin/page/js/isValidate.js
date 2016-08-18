function add_validate( ){
	var f=document.add;
	if( f.page_name.value == '' ){
		alert( 'Enter Name' );
		f.page_name.focus( );
		return false;
	}
	if( f.page_description.value == '' ){
		alert( 'Enter Description' );
		f.page_description.focus( );
		return false;
	}
	else if( f.page_keywords.value == '' ){
		alert( 'Enter Keywords' );
		f.page_keywords.focus( );
		return false;
	}
	else{
		f.command.value='add-page';
		return true;
	}
}

function edit_validate( ){
	var f=document.edit;
	if( f.page_name.value == '' ){
		alert( 'Enter Name' );
		f.page_name.focus( );
		return false;
	}
	if( f.page_description.value == '' ){
		alert( 'Enter Description' );
		f.page_description.focus( );
		return false;
	}
	else if( f.page_keywords.value == '' ){
		alert( 'Enter Keywords' );
		f.page_keywords.focus( );
		return false;
	}
	else{
		f.command.value='edit-page';
		return true;
	}
}

function del( pageid ){
	if( confirm( "Do you really want to delete this page?")){
		var f=document.option;
		f.id.value=pageid;
		f.command.value="delete";
		f.submit( );
		return false;
	}
}