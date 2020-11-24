<?php
include 'commonhead.php';
include 'dbcontroller.php';

	if (isset($_GET['row']) && isset($_GET['col'])) {
		$row = $_GET['row'];
		$col = $_GET['col'];
		$col_name = $_GET['col_name'];
	}
?>

<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
						
		<form class="form-horizontal" role="form" name="centreform" method="post">
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Shabad 1: </label>

							<div class="col-sm-9">
								<input type="text" name="shabad1" id="shabad1" class="col-ms-2"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Shabad 2: </label>

							<div class="col-sm-9">
								<input type="text" name="shabad2" id="shabad2" class="col-ms-2"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Shabad 3: </label>

							<div class="col-sm-9">
								<input type="text"  name="shabad3" id="shabad3" class="col-ms-2"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Shabad 4: </label>

							<div class="col-sm-9">
								<input type="text" name="shabad4" id="shabad4" class="col-ms-2"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Extra: </label>

							<div class="col-sm-9">
								<input type="text" name="extra_shabad" id="extra_shabad" class="col-ms-2"/>
							</div>
						</div>

					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-3">
							<button class="btn btn-info" type="submit">
								<i class="ace-icon fa fa-check bigger-110"></i>
								Submit
							</button>

							<button class="btn btn-info" type="button" onClick="self.close();">
								<i class="ace-icon fa fa-close bigger-110"></i>
								Close
							</button>
						</div>
					</div>
				</form>
		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->
<?php
	$db_handle = new DBController();

	if(isset($_POST['shabad1'])&&!empty($_POST['shabad1'])&&
	   isset($_POST['shabad2'])&&!empty($_POST['shabad2'])&&
	   isset($_POST['shabad3'])&&!empty($_POST['shabad3'])&&
	   isset($_POST['shabad4'])&&!empty($_POST['shabad4'])&&
	   isset($_POST['extra_shabad'])&&!empty($_POST['extra_shabad'])){ 

		$shabad1 = $_POST['shabad1'];
		$shabad2 = $_POST['shabad2'];
		$shabad3 = $_POST['shabad3'];
		$shabad4 = $_POST['shabad4'];
		$extra_shabad = $_POST['extra_shabad'];

		$shabads = array();
		for($i=1; $i <= 4; $i++) {
		    if(isset(${'shabad' . $i}) && !empty(${'shabad' . $i})){
		    	array_push($shabads, ${'shabad' . $i});
		    }
		}
		array_push($shabads, $extra_shabad);

		$count = $db_handle->numRows("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$db_handle->getDatabase()."' AND TABLE_NAME = 'shabads-2018' AND COLUMN_NAME = '".$col_name."'");
		
		if ($count == 0) {

			$column_insert_query = $db_handle->executeUpdate("ALTER TABLE `shabads-2018` ADD `".$col_name."` VARCHAR(255) NULL");		
		}
		for ($i=0; $i < 5; $i++) { 
			$result = $db_handle->executeUpdate("UPDATE `shabads-2018` set `". $col_name . "` = '".$shabads[$i]."' WHERE row = '".$row."' AND col ='".$col."'");
			$row++;
		}

		echo "<script>
			    window.opener.location.reload();
				window.close();
			  </script>";

	}

function explodeCheck($str, $del)
{	
	if (strpos($str, $del) != false) {
		return TRIM(explode($del, $str));
	} else {
		return "";
	}
}
?>
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

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
 	 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

 	 	<script>
		$(document).ready(function(){
		 
		 $('#sewadar_name').typeahead({
		  source: function(query, result)
		  {
		   $.ajax({
		    url:"fetch.php",
		    method:"POST",
		    data:{query:query},
		    dataType:"json",
		    success:function(data)
		    {
		     result($.map(data, function(item){
		      return item;
		     }));
		    }
		   })
		  }
		 });
		 
		});
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
	<style type="text/css">
		body {
		width: 100%;
		height: 100%;
		padding: 0px;
		margin: 0px;
		}

		html {
		width: 100%;
		height: 100%;
		padding: 0px;
		margin: 0px;
		}

		table {
		width: 95%;
		height: 95%;
		padding: 0px;
		margin: 0px;
		}

		tr,td {
			border: 1px solid black;
		}

		#col0 {
		float: left;
		width: 50%;
		height: 100%;
		padding: 0px;
		margin: 0px;
		}

		#col1 {
		float: right;
		width: 50%;
		height: 100%;
		padding: 0px;
		margin: 0px;
		}

		#rect0 {
		width: 100%;
		height: 50vh;
		padding: 0px;
		margin: 0px;
		}

		#rect1 {
		width: 100%;
		height: 50vh;
		padding: 0px;
		margin: 0px;
		}

		#rect2 {
		width: 100%;
		height: 50vh;
		padding: 0px;
		margin: 0px;
		}

		#rect3 {
		width: 100%;
		height: 50vh;
		padding: 0px;
		margin: 0px;
		}
	</style>
</html>