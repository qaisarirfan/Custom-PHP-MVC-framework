function del(id,file){
	if(confirm("Do you really want to delete?")){
		var f = document.option;
		f.id.value = id;
		f.file.value = file;
		f.command.value = "delete";
		f.submit();
		return false;
	}
}

function add_validate(f){
  	if( f.file_type.value == '' ){
		alert('Select file type..');
		f.file_type.focus();
		return false;
	}else if( f.file_title.value == '' ){
		alert('Enter file name..');
		f.file_title.focus();
		return false;
	}else if( f.file_name.value == '' ){
		alert('Select file..');
		f.file_name.focus();
		return false;
	}else{
		f.command.value = 'add';
		return true;
	}
}