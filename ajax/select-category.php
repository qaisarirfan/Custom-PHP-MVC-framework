<?php 
	include( "../core/config.php" );
	include( "../core/classes/class.db.php" );

	include( "../core/models/class.members.php" );
	include( "../core/models/model.blog.php" );
	include( "../core/models/model.category.php" );

	include( "../core/functions/functions.php" );

	$parentid = intval( $_REQUEST['category'] );
	
	if ( $cate->get_sub_category( $parentid ) ){
?>
<div class="control-group">
	<label class="control-label" for="sub_category">Sub Category:</label>
	<div class="controls">
		<select name="sub_category" id="sub_category">
			<option value="0" selected="selected">Select Sub Category</option>
			<?php foreach( $cate->get_sub_category( $parentid ) as $sub_category ){ ?>
			<option value="<?php echo $sub_category['id'] ?>"><?php echo stripslashes( $sub_category['name'] ); ?></option>
			<?php } ?>
		</select>
	</div>
</div>
<?php } ?>