<?php
include 'commonhead.php';
include 'dbcontroller.php';
?>
	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->

				<br />
				<br />
				<br />
				<br />
				<?php
					$db_handle = new DBController();
					if (isset($_GET['id'])) {
						$sewadar_list = $db_handle->runQuery("SELECT * FROM `sewadars` WHERE id = ".$_GET['id']);
						foreach ($sewadar_list as $sewadar) {
							$id = $sewadar['id'];
							$sewadar_name = $sewadar['sewadar_name'];
							$short_name = $sewadar['short_name'];
							$type = $sewadar['type'];
						}
					}
				?>

					<form class="form-horizontal" role="form" name="centreform" action="" method="post">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sewadar Name: </label>

						<div class="col-sm-9">
							<input type="text" name="sewadar_name" id="sewadar_name" class="col-xs-10 col-sm-5" value= "<?php echo $sewadar_name?>" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Short Name: </label>

						<div class="col-sm-9">
							<input type="text" name="short_name" id="short_name" class="col-xs-10 col-sm-5" value= "<?php echo $short_name?>" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Type</label>

						<div class="col-sm-9">

							<select class="col-xs-10 col-sm-5" id="form-field-select-2" multiple="multiple" name="type">
								<option value="SK" <?php echo ($type == 'SK' ? 'selected' : '');?>>SK</option>
								<option value="SR" <?php echo ($type == 'SR' ? 'selected' : '');?>>SR</option>
								<option value="Pathi" <?php echo ($type == 'Pathi' ? 'selected' : '');?>>Pathi</option>
							</select>
						</div>
						
					</div>

					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info" type="submit" name="Submit">
								<i class="ace-icon fa fa-check bigger-110"></i>
								Update
							</button>
						</div>
				</div>
				</form>

<?php
	if(isset($_POST['Submit'])){
	
		if(isset($_POST['sewadar_name'])&&!empty($_POST['sewadar_name'])){
			$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
			fwrite($myfile, "UPDATE `sewadars` set sewadar_name = '".$_POST['sewadar_name']."', short_name = '".$_POST['short_name']."', type = '".$_POST['type']."'WHERE  id=".$id);
			fclose($myfile);
			$result = $db_handle->executeUpdate("UPDATE `sewadars` set sewadar_name = '".$_POST['sewadar_name']."', short_name = '".$_POST['short_name']."', type = '".$_POST['type']."'WHERE  id=".$id);
		}
	}

?>
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
						

			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->

	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
		<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
	</a>
</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 var $sidebar = $('.sidebar').eq(0);
			 if( !$sidebar.hasClass('h-sidebar') ) return;
			
			 $(document).on('settings.ace.top_menu' , function(ev, event_name, fixed) {
				if( event_name !== 'sidebar_fixed' ) return;
			
				var sidebar = $sidebar.get(0);
				var $window = $(window);
			
				//return if sidebar is not fixed or in mobile view mode
				var sidebar_vars = $sidebar.ace_sidebar('vars');
				if( !fixed || ( sidebar_vars['mobile_view'] || sidebar_vars['collapsible'] ) ) {
					$sidebar.removeClass('lower-highlight');
					//restore original, default marginTop
					sidebar.style.marginTop = '';
			
					$window.off('scroll.ace.top_menu')
					return;
				}
			
			
				 var done = false;
				 $window.on('scroll.ace.top_menu', function(e) {
			
					var scroll = $window.scrollTop();
					scroll = parseInt(scroll / 4);//move the menu up 1px for every 4px of document scrolling
					if (scroll > 17) scroll = 17;
			
			
					if (scroll > 16) {			
						if(!done) {
							$sidebar.addClass('lower-highlight');
							done = true;
						}
					}
					else {
						if(done) {
							$sidebar.removeClass('lower-highlight');
							done = false;
						}
					}
			
					sidebar.style['marginTop'] = (17-scroll)+'px';
				 }).triggerHandler('scroll.ace.top_menu');
			
			 }).triggerHandler('settings.ace.top_menu', ['sidebar_fixed' , $sidebar.hasClass('sidebar-fixed')]);
			
			 $(window).on('resize.ace.top_menu', function() {
				$(document).triggerHandler('settings.ace.top_menu', ['sidebar_fixed' , $sidebar.hasClass('sidebar-fixed')]);
			 });
			
			
			});
		</script>
	</body>
</html>
