<div id="footer">
	<div class="container">
		<p align="center">&copy; 2000 - 2015. <?php echo APP_TITLE; ?>.</p>
	</div>
</div>
<?php echo $this->msg; ?>
<script language="javascript" src="<?php echo $this->get_theme_name_with_http(); ?>/js/bootstrap.min.js" type="text/javascript"></script> 
<script type="text/javascript">
	$(document).ready(function(){
		setInterval(function(){
			$('.notification').fadeOut('slow');
		},5000);
		<?php if ( $user_row['auto_logout'] == 'yes' ){ ?>
		 var countdown = {
			startInterval : function() {
				var count = <?php echo $this->expire_session; ?>;
				var currentId = setInterval(function(){
					$('#currentSeconds').html(count);
					if(count == 120) {
						$('#expireDiv').slideDown().click(function() {
							clearInterval(countdown.intervalId);
							$('#expireDiv').slideUp();
						});
					}
					if (count == 0) {
						window.location.href = '<?php echo BASE_URL_ADMIN; ?>logout.php';
						clearInterval(countdown.intervalId);
					}
					--count;
				}, 1000);
				countdown.intervalId = currentId;
			}
		};
	    countdown.startInterval();
		if(typeof countdown.oldIntervalId != 'undefined') {
			countdown.oldIntervalId = countdown.intervalId;
			clearInterval(countdown.oldIntervalId);
			countdown.startInterval();
			$('#expireDiv').slideUp();
		} else {
			countdown.oldIntervalId = 0;
		}
		<?php } ?>
	});
</script>