function add_post_validate(f){
	if(f.post_thumb.value==''){
		alert('Select picture');
		f.post_thumb.focus();
		return false;
	} else if (f.category.value==''){
		alert('Select post category');
		f.category.focus();
		return false;
	} else if(f.post_title.value==''){
		alert('Enter Title');
		f.post_title.focus();
		return false;
	} else if (f.post_description.value==''){
		alert('Enter Description');
		f.post_description.focus();
		return false;
	}
	else{
		f.command.value="add-post";
		return true;
	}
}
/**/
function save_post_validate(){
	var f = document.edit_post;

	if( f.post_thumb.value == '' ){
		alert('Select post pic');
		f.post_thumb.focus();
		return false;
	}else if( f.category.value == '0' ){
		alert('Select post category');
		f.category.focus();
		return false;
	}else if( f.post_title.value == '' ){
		alert('Enter Title');
		f.post_title.focus();
		return false;
	}else if( f.post_description.value == '' ){
		alert('Enter Description');
		f.post_description.focus();
		return false;
	}else{
		f.command.value = 'save-post';
		return true;
	}
}
/**/
function del(postid,name){
	if(confirm("Do you really want to delete this (" + name + ") Post?")){
		var f = document.option;
		f.post_id.value = postid;
		f.command.value = "delete";
		f.submit();
		return true;
	}
}
/**/
function value_counter(field,maxlenght,id){
	if(field.value.length > maxlenght){
		field.value = field.value.substring(0,maxlenght);
	}else{
		$(id).html(maxlenght-field.value.length);
	}
}