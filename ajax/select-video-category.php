<?php 
	include("../../core/config.php");
	include(SITE_PATH."/core/classes/class.db.php");
	include(SITE_PATH."/core/models/class.videos.php");
	$parentid=intval($_REQUEST['video_categories_id']);
?>
<div class="control-group">
	<label class="control-label" for="video_sub_category">Video Sub Category:</label>
	<div class="controls">
		<select name="video_sub_category" id="video_sub_category">
			<option value="0">-select-</option>
			<?php foreach($video->get_sub_category($parentid) as $sub_category){ ?>
			<option value="<?php echo $sub_category['id'] ?>"><?php echo $sub_category['name'] ?></option>
			<?php } ?>
		</select>
	</div>
</div>