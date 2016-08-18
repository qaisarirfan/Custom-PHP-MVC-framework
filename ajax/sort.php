<?php
	include("../../core/config.php");
	include("../../core/classes/class.db.php");
	include("../../core/classes/web-pages.php");
	include("../../core/classes/paging.php");

	$sort=$_REQUEST['by_sort'];
	
?>
	
<table border="1" style="border-collapse:collapse" cellpadding="5" width="100%">
	<tr>
		<th width="30">&nbsp;</th>
		<th align="left">Pages</th>
		<th width="100" align="left">Section</th>
		<th width="100">Option</th>
	</tr>
	<?php if($msg!=''){?>
	<tr>
		<td align="center" colspan="8"><?php echo $msg; ?></td>
	</tr>
	<?php } ?>
	<?php 
	$count=1;
	$query="select * from web_pages order by ".$sort;
	$results_per_page=10;
	$page=intval($_REQUEST['page']);
	if($page<1) $page=1;
		$pg=new Paging($db,$query,$page,$results_per_page);
		$start=$pg->get_start();
		$result=$db->query($query." limit $start,$results_per_page");
		while($page_result=$db->fetch_array($result)){ 
		$id=$page_result['id'];
		$db->query("update web_pages set sort=".$count." where id=".$id);
			if($page_result['locked']=='no'){ 
				$lock="Unlock";
			}else{
				$lock="Lock";
			}
	?>
	<tr>
		<td align="center" valign="top"><?php echo $count; ?></td>
		<td valign="top"><div><strong><?php echo $page_result['title']; ?></strong> > <span style="color:#F00"><?php echo $lock; ?></span></div>
			<div><?php echo substr($page_result['description'],0,150); ?>...</div></td>
		<td valign="top"><?php echo $page_result['section']; ?></td>
		<td valign="top" width="80" align="center"><a href="edit-page.php?id=<?php echo $page_result['id'] ?>">Edit</a> | <a href="javascript:del('<?php echo $page_result['id'] ?>');">Delete</a></td>
	</tr>
	<?php 
		$count++;
		}
		if($wp->count_row()==''){
	?>
	<tr>
		<td class="no-found" colspan="8">No Record Found</td>
	</tr>
	<?php } ?>
</table>
<div class="pagingBar" style="margin:10px 0; padding:10px;background-color:#EEE">
	<div style="float:left">
		<table>
			<tr>
				<td>Total Records:</td>
				<td><b><?php echo $pg->get_total_records() ?></b></td>
				<td>Total Pages:</td>
				<td><b><?php echo $pg->get_total_pages() ?></b></td>
			</tr>
		</table>
	</div>
	<div style="float:right">
		<?php $pg->render_pages() ?>
	</div>
	<br style="clear:both" />
</div>
