<?php
include 'session.php'; 
include 'commonhead.php';
//include 'dbcontroller.php';
require 'conn.php';

if (isset($_GET['NoIconDemo'])) {
	$month_year = $_GET['NoIconDemo'];
} else {
	$month_year = $_POST['NoIconDemo'];
}

if($month_year !=''){
	$month_years = explode("/", $month_year);
	$month = $month_years[0];
	$year = $month_years[1];
}
else{
echo "<p>Insertion Failed <br/> Some Fields are Blank....!!</p>";
}
$m = "";
function get_centres($weekdays)
{
	require 'conn.php';
	$runz = mysqli_query($con,"SELECT * FROM `centres`");

	$weekday = substr($weekdays, 0, 2);
	$centre_list = array();
	$centres = array();
	while($object = mysqli_fetch_array($runz))
	{
		$centre_list[] = $object;
	}

	foreach ($centre_list as $centre) {
		$day = explode(",", $centre['days']);
		foreach ($day as $d) {
			if(strcmp($d, $weekday) == 0)
			{
				array_push($centres, $centre['name']);
			}
		}
	}
	mysqli_close($con);
	return $centres;
}

function get_table($weekday) 
{
	require 'conn.php';
	$db_handle = new DBController();
	$table_str = '<table class= "beta" border = 1 width="100%" style = "margin = 0px;padding = 0px;height=100%">';
	$centres = get_centres($weekday);

	global $year, $month;

	$monthObj   = DateTime::createFromFormat('!m', $month);
	$monthName = $monthObj->format('M');

	$year_short = substr($year, 2, 4);

	$master_list = array();
	$runz = mysqli_query($con,"SHOW TABLES FROM `".$db_handle->getDatabase()."`");
	while ($row = mysqli_fetch_row($runz)) {
		$table_list = explode("-", $row[0]);
		if(strcmp($table_list[0], "master") == 0)
		{
			array_push($master_list, $row[0]);
		}
	}
	$master_table = "";
	$current_master = "master"."-".$monthName."-".$year_short;
	global $m;
	$m = $current_master;
	foreach ($master_list as $master) {

		if (strcmp(strtoupper($master), strtoupper($current_master)) == 0) 
		{
		$master_table = $master;
		}
	}

	if ($master_table == '') {

		$sql = "CREATE TABLE `".$current_master."` (
		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		row INT(11) NULL,
		col INT(11) NOT NULL,
		centre_name VARCHAR(255) NULL,
		date DATE NULL,
		day VARCHAR(255) NULL,
		sk_sr VARCHAR(255) NULL,
		pathi VARCHAR(255) NULL,
		ground VARCHAR(255) NULL,
		baani VARCHAR(255) NULL,
		satsang_no VARCHAR(50) NULL
		)";

		$table_query = $db_handle->executeUpdate($sql);
		$master_table = $current_master;

		$weekday_list = array("SUNDAY", "WEDNESDAY", "THURSDAY");

		foreach ($weekday_list as $weekday_name) {

			$week_dates = array();
			foreach (getWeekdays($year, $month, $weekday_name) as $w) {
				$wed = $w->format("Y.m.d\n");
				array_push($week_dates, $wed);
			}

			$centre_names = get_centres($weekday_name);
			$j = 1;
			foreach ($week_dates as $week_date) {
				$i = 2;
				foreach ($centre_names as $single_centre) {
					$query = $db_handle->executeUpdate("INSERT INTO `".$current_master."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`, `baani`) VALUES ('', '$i', '$j', '$single_centre', '$week_date', '$weekday_name', '', '', '', '')");

					$i =$i+4;
				}
				$j++;
			}
		}
		
	}
	$centre_count = $db_handle->numRows("SELECT DISTINCT `centre_name` FROM `".$master_table."` WHERE `day`='".$weekday."'");
	$count = 5;
	$rowcount = $centre_count;
	$newarray = [[]];
	$weekday_count = iterator_count(getWeekdays($year, $month, $weekday));
	$n = 1;
	$col_width = (100/($weekday_count+1)).'%';
	/*$query = mysqli_query($con,"SELECT * FROM sewadars");
	while($object = mysqli_fetch_array($query))
	{
		$sewadar_list[] = $object;
	}
	$select = '<select id="select-yourself" class="demo-default" placeholder="Type your name...">';
			    foreach ($sewadar_list as $sewadar) {
			    	$select .= '<option value="'.$sewadar['type'].": ".$sewadar['sewadar_name'].'">'.$sewadar['type'].": ".$sewadar['sewadar_name'].'</option>';
			    }
	$select .= '</select>';*/
	for ($row = 1; $row <= $rowcount * 4 +1; $row++) 
	{

		if ($count == 0) {
			$count = 4;
		}
		$table_str .= '<tr>';
		for ($col=1; $col <= $weekday_count+1; $col++) {

			if ($row == 1 && $col == 1) 
			{
				$table_str .= '<th class = "omega" height = 7% width = '.$col_width.' style="text-align: center; font-family:arial;">'.$weekday.'</th>';
			}
			elseif ($row == 1 && $col ==2) 
			{
				foreach (getWeekdays($year, $month, $weekday) as $wee) {
					$table_str .= '<th height = 7% width = '.$col_width.' style="text-align: center; font-family:arial;">'.$wee->format("d.m.Y\n").'</th>';
					$col++;
				}
				break;
			}

			else
			{
				$r = $row;
				if($row % 4 == 3)
				{
					$r = $row -1;
				}
				elseif($row % 4 == 0)
				{
					$r = $row - 2;
				}
				elseif($row % 4 == 1)
				{
					$r = $row - 3;
				}
				$runz = mysqli_query($con,"SELECT * FROM `".$master_table."` WHERE row = $r AND col = $col AND day = '".$weekday."'");

				$sewa = array();
				while($object = mysqli_fetch_array($runz))
				{
					$sewa_list[] = $object;
				}
				foreach ($sewa_list as $sewa) {
					if($row % 4 == 0)
					{
						$empty = $sewa['ground'];
					}
					elseif($row % 4 == 1)
					{
						$empty = $sewa['baani'];
					}
					elseif($row % 4 == 2)
					{
						$empty = $sewa['sk_sr'].$sewa['satsang_no'];
					}
					elseif($row % 4 == 3)
					{
						$empty = $sewa['pathi'];
					}
					$formatted_date = $sewa['date'];
				}

				 if ($empty == '') {
				 	$cell_value = /*$select*/"";
				 } else {
				 	$cell_value = $empty;
				 }
				 
				if ($col == 1 && $count == 4) 
				{
					$centre_name = $sewa['centre_name'];
					$table_str .= '<th width =5% rowspan  = 4 style="text-align: center; font-family:arial;">'.$centre_name.'</th>';
					/*$table_str .= '<td>'.$cell_value.'</td>';*/
					/*$table_str .= '<td width = '.$col_width.' style="font-family:arial;" contenteditable="true" onBlur="saveToDatabase(this,'.$row.', '.$col.', ';
					$table_str .= "'".$master_table."', '".$weekday."'";
					$table_str .= ")";
					$table_str .= '" onClick="showEdit(this)">'.$cell_value.'</td>';*/

					$table_str .= '<td height = "20px" width = '.$col_width.' style="font-family:arial;" onClick="sendVal('.$row.', '.$col.', ';
					$table_str .= "'".$centre_name."', ";
					$table_str .= "'".$formatted_date."', ";
					$table_str .= "'".$weekday."', ";
					$table_str .= "'".$master_table."'";
					$table_str .= ')">'.$cell_value.'</td>';

					$newarray[$row][$col] = $centre_name;
				}
				else
				{	
					if ($col != $weekday_count+1) {
						/*$table_str .= '<td>'.$cell_value.'</td>';*/
						$table_str .= '<td height = "20px" width = '.$col_width.' style="font-family:arial;" onClick="sendVal('.$row.', '.$col.', ';
						$table_str .= "'".$centre_name."', ";
						$table_str .= "'".$formatted_date."', ";
						$table_str .= "'".$weekday."', ";
						$table_str .= "'".$master_table."'";
						$table_str .= ')">'.$cell_value.'</td>';
					}
					$newarray[$row][$col] = "";
				}
			}
		}
		$count--;
		
		$table_str .= '</tr>';

	}

	$table_str .= '</table><br>';
	return $table_str;
}

function get_remarks() 
{
	require 'conn.php';
	global $m;
	$db_handle = new DBController();
	$table_str = '<table class = "alpha" border = 1 width="100%" style = "margin = 0px;padding = 0px;height=100%">';
	$cell_value = "";
	for ($i=1; $i <= 14; $i++) { 
		$table_str .= '<tr>';
		for ($j=1; $j <= 3; $j++) { 
			$cell_value = "";
			$runz = mysqli_query($con,"SELECT * FROM `".$m."` WHERE row = 40$i AND col = 40$j");

			$sewa = array();
			while($object = mysqli_fetch_array($runz))
			{
				$sewa[] = $object;
			}
			foreach ($sewa as $s) {
				$cell_value = $s['ground'];
			}
			
			if ($i == 1 && $j == 1) {
				$table_str .= '<th class = "omega" rowspan = 14 width = 20% style="text-align: center; font-family:arial;">'."REMARKS".'</th>';
				/*$table_str .= '<td width = 30% style="font-family:arial;" contenteditable="true" onBlur="saveToDatabase(this,40'.$i.', 40'.$j.', ';
				$table_str .= "'".$m."', ''";
				$table_str .= ")";
				$table_str .= '" onClick="showEdit(this)">'.$cell_value.'</td>';*/
				$table_str .= '<td height = "20px" width = "30%" style="font-family:arial;" onClick="sendRemarks('.$i.', '.$j.', ';
				$table_str .= "'".$m."'";
				$table_str .= ')">'.$cell_value.'</td>';
			} 
			elseif ($i == 1 && $j == 3) {
				$table_str .= '<th class = "omega" width = 20% style="text-align: center; font-family:arial;">'."IMP. NOTE:".'</th>';
			} 
			elseif ($i == 2 && $j == 3) {
				$table_str .= '<td rowspan = 13 style="font-family:arial;" contenteditable="true" onBlur="saveNotes(this,'.$i.', '.$j.', ';
				$table_str .= "'".$m."', ''";
				$table_str .= ")";
				$table_str .= '" onClick="showEdit(this)">'.$cell_value.'</td>';
				/*$table_str .= '<td  rowspan  = 7 height = "20px" width = "30%" style="font-family:arial;" onClick="sendRemarks(40'.$i.', 40'.$j.', ';
				$table_str .= "'".$m."'";
				$table_str .= ')">'.$cell_value.'</td>';*/
			} 
			elseif($j != 3) {
				/*$table_str .= '<td>'.$cell_value.'</td>';*/
				/*$table_str .= '<td width = 30% style="font-family:arial;" contenteditable="true" onBlur="saveToDatabase(this,40'.$i.', 40'.$j.', ';
				$table_str .= "'".$m."', ''";
				$table_str .= ")";
				$table_str .= '" onClick="showEdit(this)">'.$cell_value.'</td>';*/
				$table_str .= '<td width = 30% height = "20px" width = "30%" style="font-family:arial;" onClick="sendRemarks('.$i.', '.$j.', ';
				$table_str .= "'".$m."'";
				$table_str .= ')">'.$cell_value.'</td>';
			}
		}
		$table_str .= '</tr>';
	}

	for ($i=1; $i <= 2; $i++) { 
		$table_str .= '<tr>';
		for ($j=1; $j < 2; $j++) { 
			if ($i == 1) {
				$table_str .= '<th colspan = 4 style="text-align: center; font-family:arial;">'."NO CHANGE IN THE SCHEDULE SHOULD BE MADE WITHOUT PERMISSION OF AREA SECRETARY".'</th>';
			} else {
				$table_str .= '<th colspan = 4 style="text-align: right; font-family:arial;">'."AREA SECRETARY, AHMEDABAD".'</th>';
			}
		}
		$table_str .= '</tr>';
	}

	$table_str .= '</table>';
	return $table_str;
}

function getWeekdays($y, $m, $w)
{
    return new DatePeriod(
        new DateTime("first ".$w." of $y-$m"),
        DateInterval::createFromDateString('next '.$w),
        new DateTime("next month $y-$m-01")
    );
}
?>

<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<h5 style="text-align: center; font-family:arial;"><b>RADHA SOAMI SATSANG BEAS - AHMEDABAD AREA</b></h5>
		<h5 style="text-align: center; font-family:arial;"><b>SATSANG PLANNING - <?php $monthObj   = DateTime::createFromFormat('!m', $month);
			 																		   $monthName = $monthObj->format('F');
			  																		   echo $monthName." - ".$year;?></b></h5>
		<?php echo get_table("SUNDAY");
			  echo get_table("WEDNESDAY");
			  echo get_table("THURSDAY");
			  echo get_remarks();				
		?>

		<!--<div class="clearfix form-actions">
			<div class="col-md-offset-3 col-md-9">
				<button id="printButton" class="btn btn-info" onclick="printFunction()">
					<i class="ace-icon fa fa-check bigger-110"></i>
					Print
				</button>
			</div>
		</div>-->

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
		<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script>
		function showEdit(editableObj) {
			$(editableObj).css("background","#FFF");
		} 
		
		function saveNotes(editableObj, row, col, master) {
			console.log('row='+row+'&editval='+editableObj.innerHTML+'&col='+col+'&master='+master);

			$(editableObj).css("background","#FFF url(assets/images/loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "saveedit.php",
				type: "POST",
				data:'row='+row+'&editval='+editableObj.innerHTML+'&col='+col+'&master='+master,
				success: function(data){
					$(editableObj).css("background","#FDFDFD");
				}        
		   });
		}

		function saveToDatabase(editableObj, row, col, master, weekday) {
			console.log('row='+row+'&editval='+editableObj.innerHTML+'&col='+col+'&master='+master+'&weekday='+weekday);

			$(editableObj).css("background","#FFF url(assets/images/loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "saveedit.php",
				type: "POST",
				data:'row='+row+'&editval='+editableObj.innerHTML+'&col='+col+'&master='+master+'&weekday='+weekday,
				success: function(data){
					$(editableObj).css("background","#FDFDFD");
				}        
		   });
		}

		function getValue(data)
            {
             var myDiv = document.getElementById( data.id + '-value' );
             myDiv.innerHTML = data.value;
         }
		</script>

		<script>
		function printFunction() {
		    var printButton = document.getElementById("printButton");
	        printButton.style.visibility = 'hidden';
	        window.print();
	        printButton.style.visibility = 'visible';
		}
		</script>

		<!--<script type="text/javascript">
			$('#select-yourself').selectize({
		    valueField: 'name',
		    labelField: 'name',
		    searchField: 'name',
		    options: [],
		    create: false,
		    load: function(query, callback) {
		        if (!query.length) return callback();
		        $.ajax({
		            url: 'http://127.0.0.1:8080/getnames.php',
		            type: 'GET',
		            dataType: 'json',
		            data: {
		                name: query,
		            },
		            error: function() {
		                callback();
		            },
		            success: function(res) {
		                callback(res);
		            }
		        });
		    }
		</script>-->
		<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				var country = ["Australia", "Bangladesh", "Denmark", "Hong Kong", "Indonesia", "Netherlands", "New Zealand", "South Africa"];
				$("#country").select2({
				  data: country
				});
			});
		</script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script>
		function sendVal(row, col, centre, date, day, master) {
			window.open("select.php?row="+row+'&col='+col+'&centre='+centre+'&date='+date+'&day='+day+'&master='+master,"demo","width=450,height=400,left=150,top=200,toolbar=0,status=0,");
		} 

		function sendRemarks(row, col, master) {
			window.open("select_remarks.php?row="+row+'&col='+col+'&master='+master,"demo","width=600,height=600,left=150,top=200,toolbar=0,status=0,");
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

		.beta tr:nth-of-type(4n+1) td,th {
		    border-bottom: 2px solid;
		}

		.beta td,th {
		    border-right: 2px solid;
		    border-left: 2px solid;
		}
		
		.alpha td,th {
		    border-right: 2px solid;
		    border-left: 2px solid;
		}

		.alpha tr:nth-of-type(1) td,th {
		    border-top: 2px solid;
		}
		.omega th {
		    border-top: 2px solid;
		}
	</style>
</html>