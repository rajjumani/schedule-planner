<?php
include 'commonhead.php';
include 'dbcontroller.php';

	if (isset($_GET['master']) && isset($_GET['master'])) {
		$row = $_GET['row'];
		$col = $_GET['col'];
		$master = $_GET['master'];
	}
?>

<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
						
		<form class="form-horizontal" role="form" name="centreform" method="post">

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sewadar Name: </label>

				<div class="col-sm-3">
					<input type="text" name="sewadar_name" id="sewadar_name" class="col-ms-2" autocomplete="off" placeholder="SK/SR"/>
					<br/>
				</div>

				
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sewa 1: </label>

				<div class="col-sm-2">
					<input type="text" name="pathi_name1" id="pathi_name1" class="col-ms-2" autocomplete="off" placeholder="PATHI"/>
				</div>

				<div class="col-sm-2">
					<input type="text" name="ground_name1" id="ground_name1" class="col-ms-2" autocomplete="off" placeholder="GROUND"/>
				</div>
				<div class="col-xs-4">
					<input type="text" name="centre_name1" id="centre_name1" placeholder="Centre Name" class="col-ms-2" autocomplete="off"/>
				</div>

				<div class="col-xs-2">
					<input type="date" name="date1" id="date1" class="col-ms-2"/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sewa 2: </label>

				<div class="col-sm-2">
					<input type="text" name="pathi_name2" id="pathi_name2" class="col-ms-2" autocomplete="off" placeholder="PATHI"/>
				</div>

				<div class="col-sm-2">
					<input type="text" name="ground_name2" id="ground_name2" class="col-ms-2" autocomplete="off" placeholder="GROUND"/>
				</div>
				<div class="col-xs-4">
					<input type="text" name="centre_name2" id="centre_name2" placeholder="Centre Name" class="col-ms-2" autocomplete="off"/>
				</div>

				<div class="col-xs-2">
					<input type="date" name="date2" id="date2" class="col-ms-2"/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sewa 3: </label>

				<div class="col-sm-2">
					<input type="text" name="pathi_name3" id="pathi_name3" class="col-ms-2" autocomplete="off" placeholder="PATHI"/>
				</div>

				<div class="col-sm-2">
					<input type="text" name="ground_name3" id="ground_name3" class="col-ms-2" autocomplete="off" placeholder="GROUND"/>
				</div>
				<div class="col-xs-4">
					<input type="text" name="centre_name3" id="centre_name3" placeholder="Centre Name" class="col-ms-2" autocomplete="off"/>
				</div>

				<div class="col-xs-2">
					<input type="date" name="date3" id="date3" class="col-ms-2"/>
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

if(isset($_POST['sewadar_name'])&&!empty($_POST['sewadar_name'])){
	$sewadar_name = $_POST['sewadar_name'];
	$sewadar_list = $db_handle->runQuery("SELECT * FROM sewadars WHERE sewadar_name = '".$sewadar_name."'");
	foreach ($sewadar_list as $sewadar) {
		$sewadar_type = $sewadar["type"];
	}

	$pathi_name1 = $_POST['pathi_name1'];
	$pathi_name2 = $_POST['pathi_name2'];
	$pathi_name3 = $_POST['pathi_name3'];

	$ground_name1 = $_POST['ground_name1'];
	$ground_name2 = $_POST['ground_name2'];
	$ground_name3 = $_POST['ground_name3'];

	$centre_name1 = $_POST['centre_name1'];
	$centre_name2 = $_POST['centre_name2'];
	$centre_name3 = $_POST['centre_name3'];

	$date1 = $_POST['date1'];
	$date2 = $_POST['date2'];
	$date3 = $_POST['date3'];

	if(isset($pathi_name1) && !empty($pathi_name1)) {
		$pathi1 = "PA: ".$pathi_name1;
	}
	else{
		$pathi1 = '';
	}
	$pathi_list1 = $db_handle->runQuery("SELECT * FROM sewadars WHERE sewadar_name = '".$pathi_name1."'");
	foreach ($pathi_list1 as $pathi_sewadar) {
		$pathi_short1 = $pathi_sewadar["short_name"];
	}

	if(isset($pathi_name2) && !empty($pathi_name2)) {
		$pathi2 = "PA: ".$pathi_name2;
	}
	else{
		$pathi2 = '';
	}
	$pathi_list2 = $db_handle->runQuery("SELECT * FROM sewadars WHERE sewadar_name = '".$pathi_name2."'");
	foreach ($pathi_list2 as $pathi_sewadar) {
		$pathi_short2 = $pathi_sewadar["short_name"];
	}

	if(isset($pathi_name3) && !empty($pathi_name3)) {
		$pathi3 = "PA: ".$pathi_name3;
	}
	else{
		$pathi3 = '';
	}
	$pathi_list3 = $db_handle->runQuery("SELECT * FROM sewadars WHERE sewadar_name = '".$pathi_name3."'");
	foreach ($pathi_list3 as $pathi_sewadar) {
		$pathi_short3 = $pathi_sewadar["short_name"];
	}



	if(isset($ground_name1) && !empty($ground_name1)) {
		$ground1 = "SS: ".$ground_name1;
	}
	else{
		$ground1 = '';
	}
	$ground_list1 = $db_handle->runQuery("SELECT * FROM sewadars WHERE sewadar_name = '".$ground_name1."'");
	foreach ($ground_list1 as $ground_sewadar) {
		$ground_short1 = $ground_sewadar["short_name"];
	}

	if(isset($ground_name2) && !empty($ground_name2)) {
		$ground2 = "SS: ".$ground_name2;
	}
	else{
		$ground2 = '';
	}
	$ground_list2 = $db_handle->runQuery("SELECT * FROM sewadars WHERE sewadar_name = '".$ground_name2."'");
	foreach ($ground_list2 as $ground_sewadar) {
		$ground_short2 = $ground_sewadar["short_name"];
	}

	if(isset($ground_name3) && !empty($ground_name3)) {
		$ground3 = "SS: ".$ground_name3;
	}
	else{
		$ground3 = '';
	}
	$ground_list3 = $db_handle->runQuery("SELECT * FROM sewadars WHERE sewadar_name = '".$ground_name3."'");
	foreach ($ground_list3 as $ground_sewadar) {
		$ground_short3 = $ground_sewadar["short_name"];
	}

	if ($centre_name1 != "") {

		$count = $db_handle->numRows("SELECT * FROM `".$master."` WHERE `row`= 50".$row[2]." AND `col`= 50".$col[2]);

		if ($count == 0) {
			$result = $db_handle->executeUpdate("INSERT INTO `".$master."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '50".$row[2]."', '50".$col[2]."', '".$centre_name1."', '".$date1."', '', '".$sewadar_type.": ".$sewadar_name."', '".$pathi1."', '".$ground1."')");
		}
		else {
			$result = $db_handle->executeUpdate("UPDATE `".$master."` set sk_sr = '".$sewadar_type.": ".$sewadar_name."', pathi = '".$pathi1."',  ground = '".$ground1."', centre_name = '".$centre_name1."', date = '".$date1."' WHERE row=50".$row[2]." AND `col`= 50".$col[2]);
		}

		if ($col == 401) {
			$sr_no = $row[2];
		} 
		else {
			$sr_no = $row[2] +8;
		}
		$f_date1 = date('jS', strtotime($date1));
		$remark = $sr_no.') '.$sewadar_name;

		if ($pathi_short1 != '') {
			$remark .= ','.$pathi_short1;
		}
		if ($ground_short1 != '') {
			$remark .= ','.$ground_short1;
		}
		$remark .= ' @ '.$centre_name1.' on '.$f_date1;
	}

	if ($centre_name2 != "") {

		$count = $db_handle->numRows("SELECT * FROM `".$master."` WHERE `row`= 60".$row[2]." AND `col`= 60".$col[2]);

		if ($count == 0) {
			$result = $db_handle->executeUpdate("INSERT INTO `".$master."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '60".$row[2]."', '60".$col[2]."', '".$centre_name2."', '".$date2."', '', '".$sewadar_type.": ".$sewadar_name."', '".$pathi2."', '".$ground2."')");
		}
		else {
			$result = $db_handle->executeUpdate("UPDATE `".$master."` set sk_sr = '".$sewadar_type.": ".$sewadar_name."', pathi = '".$pathi2."',  ground = '".$ground2."', centre_name = '".$centre_name2."', date = '".$date2."' WHERE row=60".$row[2]." AND `col`= 60".$col[2]);
		}

		$f_date2 = date('jS', strtotime($date2));
		if ($pathi_short2 != '') {
			$remark .= '; '.$pathi_short2;
		}
		if ($ground_short2 != '') {
			$remark .= ','.$ground_short2.' @';
		}
		$remark .= ', '.$centre_name2.' on '.$f_date2;
	}

	if ($centre_name3 != "") {

		$count = $db_handle->numRows("SELECT * FROM `".$master."` WHERE `row`= 70".$row[2]." AND `col`= 70".$col[2]);

		if ($count == 0) {
			$result = $db_handle->executeUpdate("INSERT INTO `".$master."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '70".$row[2]."', '70".$col[2]."', '".$centre_name3."', '".$date3."', '', '".$sewadar_type.": ".$sewadar_name."', '".$pathi."', '".$ground."')");
		}
		else {
			$result = $db_handle->executeUpdate("UPDATE `".$master."` set sk_sr = '".$sewadar_type.": ".$sewadar_name."', pathi = '".$pathi3."',  ground = '".$ground3."', centre_name = '".$centre_name3."', date = '".$date3."' WHERE row=70".$row[2]." AND `col`= 70".$col[2]);
		}

		$f_date3 = date('jS', strtotime($date3));
		if ($pathi_short3 != '') {
			$remark .= '; '.$pathi_short3;
		}
		if ($ground_short3 != '') {
			$remark .= ','.$ground_short3.' @';
		}
		$remark .= ', '.$centre_name3.' on '.$f_date3;
	}

	$row_cnt = $db_handle->numRows("SELECT * FROM `".$master."` WHERE `row`=".$row." AND `col`=".$col);

	if ($row_cnt == 0) {
		$result = $db_handle->executeUpdate("INSERT INTO `".$master."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '".$row."', '".$col."', '', '', '', '', '', '".$remark."')");
	}
	else {
		$result = $db_handle->executeUpdate("UPDATE `".$master."` set ground = '".$remark."' WHERE row=".$row." AND col=".$col);;
	}
	
	echo "<script>
	    	window.opener.location.reload();
			window.close();
		</script>";

	/*foreach ($centre_list as $centre) {
		$count = $db_handle->numRows("SELECT * FROM `".$master."` WHERE `sk_sr` = 'SK: ".$sewadar_name."' AND date = '".$date."'");

		if ($count == 0) {	
		}
		else{
			echo "<script>
				    alert('Sewadar Already Alloted');
				  </script>";
		}
	}*/
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

		$(document).ready(function(){
		 
		 $('#pathi_name1').typeahead({
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

		$(document).ready(function(){
		 
		 $('#pathi_name2').typeahead({
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

		$(document).ready(function(){
		 
		 $('#pathi_name3').typeahead({
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

		$(document).ready(function(){
		 
		 $('#ground_name1').typeahead({
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

		$(document).ready(function(){
		 
		 $('#ground_name2').typeahead({
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

		$(document).ready(function(){
		 
		 $('#ground_name3').typeahead({
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

		$(document).ready(function(){
		 
		 $('#centre_name1').typeahead({
		  source: function(query, result)
		  {
		   $.ajax({
		    url:"fetch_centre.php",
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

		$(document).ready(function(){
		 
		 $('#centre_name2').typeahead({
		  source: function(query, result)
		  {
		   $.ajax({
		    url:"fetch_centre.php",
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

		$(document).ready(function(){
		 
		 $('#centre_name3').typeahead({
		  source: function(query, result)
		  {
		   $.ajax({
		    url:"fetch_centre.php",
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