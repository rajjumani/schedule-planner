<?php
include 'commonhead.php';
include 'dbcontroller.php';
?>

	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<table id="simple-table" class="table  table-bordered table-hover">
						<thead>
							<tr>
								<th>Sewadar Name</th>
								<th>From Date</th>
								<th>To Date</th>
								<th></th>
							</tr>
						</thead>

						<tbody>

						<?php
							$month_year = $_POST['NoIconDemo'];

							if($month_year !=''){
								$month_years = explode("/", $month_year);
								$month = $month_years[0];
								$year = $month_years[1];
								$day = 01;

								$full_date = $year.'-'.$month.'-'.$day;
							}

							$db_handle = new DBController();
							$sewadar_list = $db_handle->runQuery("SELECT * FROM `leaves` WHERE `month` ='".$full_date."'");

							foreach ($sewadar_list as $sewadar) {
						?>
							<tr>

								<td><?php echo $sewadar['sewadar_name']?></td>
								<td><?php echo date("d-m-Y", strtotime($sewadar['from_date']));?></td>
								<td><?php echo date("d-m-Y", strtotime($sewadar['to_date']))?></td>
								<td>
									<div class="hidden-sm hidden-xs btn-group">
										<button class="btn btn-xs btn-danger">
											<a style="color: white;" onClick = "delVal('<?php echo "leaves/".$sewadar['id'];?>')">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>
											</a>
										</button>
									</div>
								</td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>
					<div class="clearfix form-actions">
						<div class="col-md-6">
							<button class="btn btn-info" type="submit" onClick = "window.location = 'add_leave.php';">
								<i class="ace-icon fa fa-plus bigger-110"></i>
								Add More
							</button>
						</div>
					</div>
				</div><!-- /.span -->
			</div><!-- /.row -->
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->

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
		<script>
		function delVal(abx) {
			window.location = 'delete_query.php?id='+abx;
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
