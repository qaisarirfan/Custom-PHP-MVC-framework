function add_allbum_validate(){
	var f=document.add;
	if(f.category.value==0){
		alert('Select Category');
		f.category.focus();
		return false;
	}else if(f.album_name.value==''){
		alert('Enter Name');
		f.album_name.focus();
		return false;
	}
	else if(f.album_description.value==''){
		alert('Enter Description');
		f.album_description.focus();
		return false;
	}
	else if(f.album_keywords.value==''){
		alert('Enter Keywords');
		f.album_keywords.focus();
		return false;
	}
	else{
		f.command.value='add-album-save';
		return true;
	}
}

function edit_allbum_validate(){
	var f=document.edit;
	if(f.category.value==0){
		alert('Select Category');
		f.category.focus();
		return false;
	}else if(f.album_name.value==''){
		alert('Enter Name');
		f.album_name.focus();
		return false;
	}
	else if(f.album_description.value==''){
		alert('Enter Description');
		f.album_description.focus();
		return false;
	}
	else if(f.album_keywords.value==''){
		alert('Enter Keywords');
		f.album_keywords.focus();
		return false;
	}
	else{
		f.command.value='edit-album-save';
		return true;
	}
}



function album_del(albumid,name){
	var f = document.allbums;
	if(confirm('Do you realy want to delete this ('+name+') album.')){
		f.id.value=albumid;
		f.command.value='delete-album';
		f.submit();
		return false;
	}
}
	


function photo_del(photoid,allbums_id,pic_name){
	var f=document.album_photo;
	if(confirm('Do you realy want to delete this photo.')){
		f.photo_id.value=photoid;
		f.album_id.value=allbums_id;
		f.name.value=pic_name;
		f.command.value='delete-photo';
		f.submit();
		return false;
	}
}

function add_images_validate(){
	var f=document.add_images;
	if(f.photo_name.value==''){
		alert('Select Image');
		f.photo_name.focus();
		return false;
	} else if (f.photo_title.value==''){
		alert('Enter Title');
		f.photo_title.focus();
		return false;
	} else if (f.photo_reference.value==''){
		alert('Enter image reference');
		f.photo_reference.focus();
		return false;
	} else {
		f.command.value='add-photo-save';
		return true;
	}
}

function edit_images_validate(){
	var f=document.edit_images;
	if(f.photo_name.value==''){
		alert('Select Image');
		f.photo_name.focus();
		return false;
	} else if (f.photo_title.value==''){
		alert('Enter Title');
		f.photo_title.focus();
		return false;
	} else if (f.photo_reference.value==''){
		alert('Enter image reference');
		f.photo_reference.focus();
		return false;
	} else {
		f.command.value='edit-photo-save';
		return true;
	}
}

$(document).ready(function (){
	var $element = [];
	var $element_file = $('#photo_name');
	var $valid_size = 3072;
	$('#valid-size').html($valid_size);
	$($element_file).on('change', function(){
		var $current_size = Math.round($(this)[0]['files'][0]['size']/1024);
		if( $current_size <= $valid_size ){
			$( '#size' ).html( "Your file size is " + $current_size+" KB" ).removeClass('overload').addClass( "valid" );
		}else{
			$( '#size' ).html( "Your file size is " + $current_size+" KB" ).removeClass('valid').addClass( "overload" );
		}
	})
})
