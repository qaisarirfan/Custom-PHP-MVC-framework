function add_sub_cat_validate(f){
	if(f.name.value==''){
		alert('Enter Name');
		f.name.focus();
		return false;
	}else{
		f.command.value='add-sub-cat';
		return true;
	}
}
function edit_sub_cat_validate(f){
	if(f.name.value==''){
		alert('Enter Name');
		f.name.focus();
		return false;
	}else{
		f.command.value='edit-sub-cat';
		return true;
	}
}
function del_sub_category(id, name){
	if(confirm("Do you really want to delete this ("+name+")")){
		var f=document.option;
		f.pscid.value=id;
		f.command.value="delete-sub-category";
		f.submit();
		return true;
	}
}
function del_category(id,name){
	if(confirm("Do you really want to delete this ("+name+")")){
		var f=document.option;
		f.pcid.value=id;
		f.command.value="delete-category";
		f.submit();
		return true;
	}
}

function add_cat_validate(){
	var f=document.addCategory;
	if(f.name.value==''){
		alert('Please Enter Category Name');
		f.name.focus();
		return false;
	}else{
		f.command.value="add-category";
		f.submit();
		return true;
	}
}
function edit_cat_validate(){
	var f=document.editCategory;
	if(f.name.value==''){
		alert('Please Enter Category Name');
		f.name.focus();
		return false;
	}else{
		f.command.value="edit-category";
		f.submit();
		return true;
	}
}
