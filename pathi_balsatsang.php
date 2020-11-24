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

function get_centres()
{
	$db_handle = new DBController();
	$centres = $db_handle->runQuery("SELECT * FROM `centres` WHERE balsatsang = 1");
	return $centres;
}

function get_bsc_table() 
{
	$db_handle = new DBController();

	$table_str = '<table class= "beta" border = 1 width="100%" style = "margin = 0px;padding = 0px;height=100%">';
	$centre_list = get_centres();
	$centre_name = array();
	foreach ($centre_list as $centres) {
		array_push($centre_name, $centres['name']);
	}

	global $year, $month, $month_year;

	$monthObj   = DateTime::createFromFormat('!m', $month);
	$monthName = $monthObj->format('M');

	$year_short = substr($year, 2, 4);

	$master_table = "master"."-".$monthName."-".$year_short;

	$date_array[][] = array();

	$row_count = $db_handle->numRows("SELECT * FROM `".$master_table."` WHERE `row` = 703 AND `col` = 702");
	if ($row_count == 0) {
		$week_dates = array();
		foreach (getWeekdays($year, $month, "SUNDAY") as $w) {
			$wed = $w->format("Y-m-d\n");
			array_push($week_dates, $wed);
		}

		$row = 703;
		$col = 702;

		foreach ($centre_list as $single_centre) {
			foreach ($week_dates as $week_date) {
				$query = $db_handle->executeUpdate("INSERT INTO `".$master_table."` (`id`, `row`, `col`, `centre_name`, `date`, `day`, `sk_sr`, `pathi`, `ground`) VALUES ('', '".$row."', '".$col."', '".$single_centre['name']."', '".$week_date."', 'SUNDAY', 'BALSATSANG', '', '')");
				$col++;
			}
			$col = 702;
			$row++;
		}
	}
	

	$centre_count = sizeof($centre_list);
	$weekday_count = iterator_count(getWeekdays($year, $month, "SUNDAY"));
	$col_width = (100/($weekday_count+1)).'%';
	
	for ($row = 1; $row <= $centre_count+2; $row++) 
	{
		$table_str .= '<tr>';
		for ($col=1; $col <= $weekday_count+1; $col++) {
			if ($row == 1) 
			{	
				if ($col == 1) {
					$table_str .= '<th colspan='.($weekday_count+1).' class = "omega" height = 7% width = '.$col_width.' style="text-align: center; font-family:arial; font-size:18px;">BAL SATSANG COORDINATORS</th>';
				}	
			}
			elseif ($row == 2) 
			{	
				if ($col ==1) {
					$table_str .= '<th class = "omega" height = 7% width = '.$col_width.' style="text-align: center; font-family:arial;">SUNDAY</th>';
				} 
				elseif ($col ==2) {
					foreach (getWeekdays($year, $month, "SUNDAY") as $wee) {
						$table_str .= '<th height = 7% width = '.$col_width.' style="text-align: center; font-family:arial;">'.$wee->format("d.m.Y\n").'</th>';
						$col++;
					}
					break;
				}
			}
			else
			{	
				if ($col ==1) {
					$table_str .= '<th class = "omega" height = 7% width = '.$col_width.' style="text-align: center; font-family:arial;">'.$centre_name[$row-3].'</th>';
				}
				else
				{
					$result = $db_handle->runQuery("SELECT * FROM `".$master_table."` WHERE row = 70".$row." AND col =70".$col);	
					foreach ($result as $r) {
						if (strcmp($r['pathi'], '') != 0) {
							$cell_value = explode(":", $r['pathi'])[1];
						} else {
							$cell_value = '';
						}
					}		
					$table_str .= '<td height = "20px" width = '.$col_width.' style="font-family:arial;" onClick="sendVal(70'.$row.', 70'.$col.', ';
					$table_str .= "'".$master_table."'";
					$table_str .= ')">'.$cell_value.'</td>';
				}
			}
			/*else 
			{	
				if ($col ==1) {		
					$table_str .= '<th height = "20px" width = '.$col_width.' style="font-family:arial; text-align: center;">BSC</th>';
				} 
				else{
					$result = $db_handle->runQuery("SELECT * FROM `".$master_table."` WHERE col =".$col);
					foreach ($result as $r) {
						$cell_value = $r['bsc'];
					}				

					$table_str .= '<td height = "20px" width = '.$col_width.' style="font-family:arial;" onClick="sendBsc('.$row.', '.$col.', ';
					$table_str .= "'".$r['centre_name']."', ";
					$table_str .= "'".$r['date']."', ";
					$table_str .= "'".$master_table."'";
					$table_str .= ')">'.$cell_value.'</td>';
				}
			}*/
		}
		$table_str .= '</tr>';

	}

	$table_str .= '</table><br>';
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
		<h5 style="text-align: center; font-family:arial;"><b><?php $monthObj   = DateTime::createFromFormat('!m', $month);
			 														$monthName = $monthObj->format('F');
			  														echo $monthName." - ".$year;?> 
			  														(SCHEDULE)</b></h5>
		<?php echo get_bsc_table();
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
		function sendVal(row, col, master) {
			window.open("select_balpathi.php?row="+row+'&col='+col+'&master='+master,"demo","width=450,height=400,left=150,top=200,toolbar=0,status=0,");
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

		.beta tr:nth-of-type(3n+1) td,th {
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
		.omega th,td {
		    border-top: 2px solid;
		    border-bottom: 2px solid;
		    text-align: center;
		}
	</style>
</html>