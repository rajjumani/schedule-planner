<?php
include 'commonhead.php';
?>

	<div class="row">
		<div class="col-xs-3">
			<!-- PAGE CONTENT BEGINS -->
			
			<form class="form-horizontal" role="form" name="master_form" action="pathi_balsatsang.php" method="post">				
				<div class="widget-body">
					<div class="widget-main">
						<label for="id-date-picker-1">Select Month:</label>

						<div class="row">
							<div class="col-xs-8 col-sm-11">
								<div class="input-group">
									<input class="form-control date-picker" name="NoIconDemo" id="NoIconDemo" type="text" autocomplete="off"/>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" type="submit">
							<i class="ace-icon fa fa-check bigger-110"></i>
							Submit
						</button>
					</div>
				</div>
			</form>

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
		<link href="assets/css/monthselector.css" rel="stylesheet" type="text/css" />
	    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />

	    <link href="assets/css/MonthPicker.min.css" rel="stylesheet" type="text/css" />
	    <link rel="stylesheet" type="text/css" href="assets/css/examples.css" />

	    <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
	    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	    <script src="https://cdn.rawgit.com/digitalBush/jquery.maskedinput/1.4.1/dist/jquery.maskedinput.min.js"></script>

	    <script src="assets/js/MonthPicker.min.js"></script>
	    <script src="assets/js/examples.js"></script>

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
