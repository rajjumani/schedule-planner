<?php
include 'session.php'; 
include 'commonhead.php';
?>

<div class="row">
	 <!--<div class="col-xs-12">
		<!- PAGE CONTENT BEGINS -->
		<!--<form style="background-color: white; padding-top: 0px; padding-left: 0px;" action="month_selector.php" method="post">	
			<h3 class="header smaller lighter green">Select Month</h3>

			<div class="input-group">
				<input class="form-control date-picker" name="NoIconDemo" id="NoIconDemo" type="text" autocomplete="off"/>
			</div>
			<br />
			<button class="btn btn-info" type="submit">
				<i class="ace-icon fa fa-check bigger-110"></i>
				Submit
			</button>
		</form>
	</div>-->
			
			<div class="col-xs-12">
			<?php
			$display_count = 4;
			/*require 'dbcontroller.php';

			$db_handle = new DBController();*/
			$current_month = date("M-y");

			$next_month = date('M-y',strtotime('first day of +1 month'));
			
			$next_master = "master"."-".$next_month;
			
			$master_tables = array();
			$display_list = array();
			$master_list = $db_handle->runQuery("SHOW TABLES FROM `".$db_handle->getDatabase()."`");
			
			foreach ($master_list as $master_month) {
				array_push($master_tables, $master_month['Tables_in_schegvrq_rssb']);
			}

			array_push($display_list, $next_month);
			for ($i=0; $i < $display_count; $i++) { 
				$last_month = date('M-y',strtotime('first day of -'.$i.' month'));
				array_push($display_list, $last_month);
			}
			
			?>
				<h3 class="header smaller lighter green">Master List</h3>

					<?php
					foreach ($display_list as $display_month) {
						$format_month = date('m/Y', strtotime("01-".$display_month));
					?>
						<a class="btn btn-app btn-success" onClick = "sendVal('<?php echo $format_month;?>')">
							<i class="ace-icon fa fa-calendar bigger-230"></i>
							<?php
							echo $display_month;
							?>
						</a>
					<?php
					}
					?>
			</div>

			<div class="col-xs-12">

				<h3 class="header smaller lighter green">Add New...</h3>

					<a href="add_centre.php" class="btn btn-app btn-success">
						<i class="ace-icon fa fa-plus-square-o bigger-230"></i>
						Centre
					</a>

					<a href="add_sewadar.php" class="btn btn-app btn-success">
						<i class="ace-icon fa fa-plus-square-o bigger-230"></i>
						Sewadar
					</a>

					<a href="add_baani.php" class="btn btn-app btn-success">
						<i class="ace-icon fa fa-plus-square-o bigger-230"></i>
						Baani
					</a>
			</div>

			<div class="col-xs-12">

				<h3 class="header smaller lighter green">Edit...</h3>

					<a href="edit_centre.php" class="btn btn-app btn-success">
						<i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
						Centre
					</a>

					<a href="edit_sewadar.php" class="btn btn-app btn-success">
						<i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
						Sewadar
					</a>

					<a href="edit_baani.php" class="btn btn-app btn-success">
						<i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
						Baani
					</a>

					<!--<a href="edit_master.php" class="btn btn-app btn-success">
						<i class="ace-icon fa fa-calendar bigger-230"></i>
						Master
					</a>-->
			</div>
		</div>
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

		<link href="assets/css/monthselector.css" rel="stylesheet" type="text/css" />
	    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />

	    <link href="assets/css/MonthPicker.min.css" rel="stylesheet" type="text/css" />
	    <link rel="stylesheet" type="text/css" href="assets/css/examples.css" />

	    <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
	    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	    <script src="https://cdn.rawgit.com/digitalBush/jquery.maskedinput/1.4.1/dist/jquery.maskedinput.min.js"></script>

	    <script src="assets/js/MonthPicker.min.js"></script>
	    <script src="assets/js/examples.js"></script>

		<script>
		function sendVal(abx) {
			window.location = 'master.php?NoIconDemo='+abx;
		} 
		</script>
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
