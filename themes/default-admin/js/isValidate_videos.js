	function add_video_validate(f){
		if(f.type.value == 'dailymotion'){
			if(f.video_category.value=='0'){
				alert("Please select Video Category");
				f.video_category.focus();
				return false;
			}else if(f.url.value==''){
				alert("Please entered Dailymotion Video URL");
				f.url.focus();
				return false;
			}else{
				f.command.value = 'add';
				f.submit();
				return true;
			}
		}else if(f.type.value == 'vimeo'){
			if(f.url.value==''){
				alert("Please entered Vimeo Video URL");
				f.url.focus();
				return false;
			}else{
				f.command.value = 'add';
				f.submit();
				return true;
			}
		}else if(f.type.value == 'youtube'){
			if(f.video_category.value=='0'){
				alert("Please select Video Category");
				f.video_category.focus();
				return false;
			}else if(f.title.value==''){
				alert("Please entered Youtube Video Title");
				f.title.focus();
				return false;
			}else if(f.author_name.value==''){
				alert("Please entered Youtube Video Author Name");
				f.author_name.focus();
				return false;
			}else if(f.url.value==''){
				alert("Please entered Youtube Video URL");
				f.url.focus();
				return false;
			}else if(f.author_url.value==''){
				alert("Please entered Youtube Video Author URL");
				f.author_url.focus();
				return false;
			}else if(f.author_url.value==''){
				alert("Please entered Youtube Video Author URL");
				f.author_url.focus();
				return false;
			}else{
				f.command.value = 'add';
				f.submit();
				return true;
			}
		}
	}

	function edit_video_validate(f){
		if(f.title.value == ''){
			alert('Enter Title');
			f.title.focus();
			return false;
		}else if(f.author_name.value == ''){
			alert('Enter Author Name');
			f.author_name.focus();
			return false;
		}else if(f.url.value == ''){
			alert('Enter Video URL');
			f.url.focus();
			return false;
		}else if(f.provider_url.value == ''){
			alert('Enter Provider URL');
			f.provider_url.focus();
			return false;
		}else if(f.author_url.value == ''){
			alert('Enter Author URL');
			f.author_url.focus();
			return false;
		}else{
			f.command.value = 'edit';
			f.submit();
			return true;
		}
	}

	function delete_video(id){
		var f = document.video;
		if(confirm('Do you realy want to delete this.')){
			f.id.value = id;
			f.command.value = 'delete';
			f.submit();
			return false;
		}
	}

	function delete_permanent_video(id){
		var f = document.video;
		if(confirm('Do you realy want to delete this.')){
			f.id.value = id;
			f.command.value = 'delete_permanent';
			f.submit();
			return false;
		}
	}
	
	function isVlidate_category(f){
		if(f.name.value == ''){
			alert("Enter Category Name");
			f.name.focus();
			return false;
		}else{
			f.command.value = "addsubcategory";
			f.submit();
			return true;
		}
	}

	function isVlidate_edit_category(f){
		if(f.name.value == ''){
			alert("Enter Category Name");
			f.name.focus();
			return false;
		}else{
			f.command.value = "editsubcategory";
			f.submit();
			return true;
		}
	}
	function add_video_cat_validate(f){
		if(f.parent.value==''){
			alert('Select Parent');
			f.parent.focus();
			return false;
		}else if (f.name.value==''){
			alert('Enter Name');
			f.name.focus();
			return false;
		}else{
			f.command.value='add';
			return true;
		}
	}
	function edit_video_cat_validate(f){
		if(f.parent.value==''){
			alert('Select Parent');
			f.parent.focus();
			return false;
		}else if (f.name.value==''){
			alert('Enter Name');
			f.name.focus();
			return false;
		}else{
			f.command.value='edit';
			return true;
		}
	}

/**/

	function add_cat_validate(){
		var f=document.addCategory;
		if(f.name.value==''){
			alert('Please Enter Category Name');
			f.name.focus();
			return false;
		}else{
			f.command.value="add";
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
			f.command.value="edit";
			f.submit();
			return true;
		}
	}

	function del_category(id,name){
		if(confirm("Do you really want to delete this ("+name+")")){
			var f = document.option;
			f.id.value = id;
			f.command.value = "delete";
			f.submit();
			return true;
		}
	}

	function add_subcategory (f){
		if(f.name.value == '' ){
			alert("Enter name");
			f.name.focus();
			return false;
		}else{
			f.command.value="addsubcategory";
			f.submit();
			return true;
		}
	}

	function edit_subcategory (f){
		if(f.name.value == '' ){
			alert("Enter name");
			f.name.focus();
			return false;
		}else{
			f.command.value="editsubcategory";
			f.submit();
			return true;
		}
	}

	function del_sub_category(id, name){
		if(confirm("Do you really want to delete this ("+name+")")){
			var f=document.option;
			f.id.value=id;
			f.command.value="sub_delete";
			f.submit();
			return true;
		}
	}
	
