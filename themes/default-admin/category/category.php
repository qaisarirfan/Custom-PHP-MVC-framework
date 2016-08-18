<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div class="container">
	<div class="context">
		<div class="page_title ">
			<h1 class="font-share-techregular"><?php echo $this->page_title; ?></h1>
			<div class="btn-group pull-right">
				<button class="btn btn-inverse" data-toggle="dropdown">Action</button>
				<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret">&nbsp;</span></button>
				<ul class="dropdown-menu pull-right">
					<li><a href="javascript:history.go(-1)" title="Back">Back</a></li>
				</ul>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<div class="row">
			<div class="span6">
				<?php if( $_REQUEST['action'] == 'pc-edit' ){ ?>
				<form class="<?php if( $_REQUEST['action'] == 'pc-edit'){ ?>form-inline<?php }else{ ?> form-horizontal<?php } ?>" name="editCategory" onSubmit="return edit_cat_validate()" action="" method="post">
					<input type="hidden" name="command" />
					<label for="name">Category :</label>
					<input type="text" id="name" value="<?php echo stripcslashes($this->category_by_id['name']); ?>" name="name" />				
					<input class="btn btn-primary" type="submit" value="Update" />
				</form>
				<?php }else{ ?>
				<form class="form-horizontal" name="addCategory" onSubmit="return add_cat_validate()" action="" method="post">
					<input type="hidden" name="command" />
					<label for="name">Category :</label>
					<input id="name" type="text" name="name" />
					<input class="btn btn-primary" type="submit" value="Add" />
				</form>
				<?php } ?>
			</div>
			<div class="span6">
				<?php if( $_REQUEST['action'] == 'add-sub-cat' ){ ?>
				<form class="form-horizontal" name="add_post_cat" onSubmit="return add_sub_cat_validate(this)" method="post">
					<input type="hidden" name="command" />
					<label for="parent">Parent Category:</label>
					<select id="parent" name="parent">
						<option value="0">-No Parent-</option>
						<?php foreach( $this->category as $category ){ ?>
						<option value="<?php echo $category['id']; ?>"><?php echo stripcslashes($category['name']); ?></option>
						<?php } ?>
					</select>
					<script>document.add_post_cat.parent.value='<?php echo intval( $_REQUEST['pcid'] ); ?>';</script>
					<label for="sname">Name Sub Category:</label>
					<input id="sname" type="text" name="name" />
					<input class="btn btn-primary" type="submit" value="Add Sub Category" />
				</form>
				<?php }elseif( $_REQUEST['action'] == 'edit-sub-cat' ){ ?>
				<form class="form-horizontal" name="edit_post_cat" onSubmit="return edit_sub_cat_validate(this)" method="post">
					<input type="hidden" name="command" />
					<label for="parent">Parent Category:</label>
					<select id="parent" name="parent">
						<option value="0">No Parent</option>
						<?php foreach( $this->category as $category ){ ?>
						<option value="<?php echo $category['id']; ?>"><?php echo stripcslashes($category['name']); ?></option>
						<?php } ?>
					</select>
					<script>document.edit_post_cat.parent.value='<?php echo $this->sub_category_by_id['post_categories_id']; ?>';</script>
					<label for="sname">Name:</label>
					<input id="sname" type="text" name="name" value="<?php echo stripcslashes($this->sub_category_by_id['name']); ?>" />
					<input class="btn btn-primary" type="submit" value="Update Sub Category" />
				</form>
				<?php } ?>
			</div>
		</div>
		<div>&nbsp;</div>
		<div class="row">
			<?php if( $this->rang_one ){ ?><div class="span4"><?php echo $this->rang_one; ?></div><?php } ?>
			<?php if( $this->rang_two ){ ?><div class="span4"><?php echo $this->rang_two; ?></div><?php } ?>
			<?php if( $this->rang_three ){ ?><div class="span4"><?php echo $this->rang_three; ?></div><?php } ?>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/category/js/isValidate.js?v1.1" type="text/javascript" language="javascript"></script>
<form name="option" action="" method="post">
	<input type="hidden" name="command" />
	<input type="hidden" name="pcid" />
	<input type="hidden" name="pscid" />
</form>
</body>
</html>