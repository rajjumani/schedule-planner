<?php
include 'commonhead.php';
?>
	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->

				<br />
				<br />
				<br />
				<br />

				<form class="form-horizontal" role="form" name="centreform" action="new_centre.php" method="post">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Centre Name: </label>

						<div class="col-sm-9">
							<input type="text" name="centre_name" id="centre_name" class="col-xs-10 col-sm-5" />
						</div>
					</div>

					<div class="form-group">

							<div class="checkbox">
							
								<label class="col-sm-3 control-label no-padding-right">
									<input name="days[]" type="checkbox" class="ace" value="SU" />
									<span class="lbl"> Sunday</span>
								</label>
								
								<label class="col-sm-3 control-label no-padding-right">
									<input name="days[]" type="checkbox" class="ace" value="WE" />
									<span class="lbl"> Wednesday</span>
								</label>
								
								<label class="col-sm-3 control-label no-padding-right">
									<input name="days[]" type="checkbox" class="ace" value="TH" />
									<span class="lbl"> Thursday</span>
								</label>
							</div>
						</div>

					<div class="clearfix form-actions">
						<div class="col-md-offset-6 col-md-6">
							<button class="btn btn-info" type="submit">
								<i class="ace-icon fa fa-check bigger-110"></i>
								Submit
							</button>
						</div>
					</div>
				</form>

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
