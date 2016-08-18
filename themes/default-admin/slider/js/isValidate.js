function add_validate(f){
	if( f.slider_picture.value == '' ){
		alert('Select image');
		f.slider_picture.focus();
		return false;
	} else if ( f.slider_title.value == '' ){
		alert('Enter title');
		f.slider_title.focus();
		return false;
	} else {
		f.command.value='add-slide';
		return true;
	}
}
function edit_validate(f){
	if( f.slider_title.value == '' ){
		alert('Enter title');
		f.slider_title.focus();
		return false;
	} else {
		f.command.value='edit-slide';
		return true;
	}
}
function del( id ){
	if(confirm("Do you really want to delete?")){
		var f=document.option;
		f.id.value = id;
		f.command.value = "delete";
		f.submit();
		return false;
	}
}
function preferences_validate(f){
	if( f.slider_width.value == 0 || f.slider_width.value == '' ){
		alert("Enter correct value of width here");
		f.slider_width.focus();
		return false;
	}else if( f.slider_height.value == 0 || f.slider_height.value == '' ){
		alert("Enter correct value of height here");
		f.slider_height.focus();
		return false;
	}else{
		f.command.value = "slider_preferences";
		return true;
	}
}