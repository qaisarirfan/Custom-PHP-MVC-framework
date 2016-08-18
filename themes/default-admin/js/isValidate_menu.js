//		menu list		//
function add_menu_item_validate(f){
	if(f.name.value==''){
		alert('Enter Name');
		f.name.focus();
		return false;
	} else{
		f.command.value='add';
		return true;
	}
}
function update_menu_item_validate(f){
	if(f.name.value==''){
		alert('Enter Name');
		f.name.focus();
		return false;
	} else{
		f.command.value='update';
		return true;
	}
}
function menu_del(id,name){
	var f=document.menu_list;
	if(confirm('Do you realy want to delete this ('+name+').')){
		f.id.value=id;
		f.name.value=name;
		f.command.value='delete';
		f.submit();
		return false;
	}
}
