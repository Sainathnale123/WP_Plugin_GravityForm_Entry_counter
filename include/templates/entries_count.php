<?php
	$get_form_id = $_GET['id'];
	global $wpdb;
	$wpdb_tablename = $wpdb->prefix.'gf_form';
	$wpdb_entries = $wpdb->prefix.'gf_entry';
	$results = $wpdb->get_results("SELECT * FROM ".$wpdb_tablename); 
?>
<div class="gravity_form_title">
<h3 class="title">Gravity Form Entries Week Wise Count</h3>
</div>
<div class="container">

	<div class="row">

		<div class="col-md-12">

			<div class="p-1 .selecttitle">
				<form id="entries_show" action="" method="post" class="select_form">

					<select name="namefromtable" class="form-select form-select-sm" aria-label=".form-select-sm example" >
						<option>Select Forms Title</option>
						<?php
						foreach( $results as $value ) { ?>
							<option <?php if($get_form_id == $value->id){ echo 'selected';}?> value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
							<?php
						}
						?>
					</select>
					<input type="submit" value="Submit" name="Submit1" class="btn btn-primary submit_form">
				</form>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row entries">
		<table id="entries_counter" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>Week</th>
					<th>Active Entries</th>
					<th>Spam Entries</th>
					<th>Trash Entries</th>

				</tr>
			</thead>
			<tbody>
				<?php 
				if(!empty($get_form_id))
				{
					$id = $_POST['namefromtable'];
					$results1 = $wpdb->get_results("SELECT CONCAT(YEAR(`date_created`),' | Week-',WEEK(`date_created`)) AS week_name, YEAR(`date_created`) as year, WEEK(`date_created`) as week_no, COUNT(case when `status` = 'active' then 1 else null end) AS Active_Count, COUNT(case when `status` = 'trash' then 1 else null end) AS Trash_Count, COUNT(case when `status` = 'spam' then 1 else null end) AS Spam_Count FROM `$wpdb_entries` WHERE `form_id` = '$get_form_id' GROUP BY week_name ORDER BY YEAR(`date_created`) DESC, WEEK(`date_created`) DESC");
				}
				if(!empty($results1)){
					foreach($results1 as $row => $innerArray){
						$dates=getStartAndEndDate($innerArray->week_no,$innerArray->year);
						$end_date = $dates['end_date'];	
						$week_name = $innerArray->week_name;
						$active_count = $innerArray->Active_Count;
						$trash_count = $innerArray->Trash_Count;
						$spam_count = $innerArray->Spam_Count;
						echo "<tr>";
						echo "<td>Week ".$end_date."</td>";
						echo "<td>".$active_count."</td>";
						echo "<td>".$spam_count."</td>";
						echo "<td>".$trash_count."</td>";
						echo "</tr>";
					}
				}
				function getStartAndEndDate($week, $year){  
			    	$dateTime = new DateTime();  
			    	$dateTime->setISODate($year, $week); 
			    	$dateTime->modify('+6 days'); 
			    	$result['end_date'] = $dateTime->format('m/d/Y'); 
			    	return $result;
			  	}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th>Week</th>
					<th>Active Entries</th>
					<th>Spam Entries</th>
					<th>Trash Entries</th>
				</tr>
			</tfoot>
		</table>
		<div id="pagination"></div>
	</div>
</div>


