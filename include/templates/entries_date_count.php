<?php
	$get_form_id = $_GET['id'];
	global $wpdb;
	$wpdb_tablename = $wpdb->prefix.'gf_form';
	$wpdb_entries = $wpdb->prefix.'gf_entry';
	$results = $wpdb->get_results("SELECT * FROM ".$wpdb_tablename); 
?>
<div class="gravity_form_title">
<h3 class="title">Gravity Form Entries Date Wise Count</h3>
</div>
<div class="container">
	<div class="row forms">
		<div class="col-md-12">
			<div class="p-1 .selecttitle">
				<form action="" method="post" id="entries_show" class="select_form">
					<!-- This Select is for name  -->
					<select name="namefromtable" class="form-select form-select-sm" aria-label=".form-select-sm example" >
						<option>Select Forms Title</option>
						<?php
						foreach( $results as $value ) { ?>
							<option  <?php if($get_form_id == $value->id){ echo 'selected';}?>  value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
							<?php
						}
						?>
					</select><input type="submit" value="Submit" name="Submit1" class="btn btn-primary submit_form">
				</form>
			</div>
		</div>
	</div>
</div>
<div class="container">
    <div class="row entries" id="entries_table">
		<table id="entries_counter" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>Date</th>
					<th>Active Entries</th>
					<th>Spam Entries</th>
					<th>Trash Entries</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if(!empty($get_form_id))
					{
						$results2 = $wpdb->get_results("SELECT `date_created` as date, COUNT(case when `status` = 'active' then 1 else null end) AS Active_Count, COUNT(case when `status` = 'trash' then 1 else null end) AS Trash_Count, COUNT(case when `status` = 'spam' then 1 else null end) AS Spam_Count from `$wpdb_entries` WHERE `form_id` = '$get_form_id' group by date(`date_created`) ORDER BY `date_created` DESC");
					}
				?>
				<?php
					if(!empty($results2)){
						foreach($results2 as $row => $innerArray){
							$week_name = $innerArray->date;
							$active_count = $innerArray->Active_Count;
							$trash_count = $innerArray->Trash_Count;
							$spam_count = $innerArray->Spam_Count;
							echo "<tr>";
							echo "<td>".date('Y-m-d', strtotime($week_name)).  " | "  .date('l', strtotime($week_name));"</td>";
							echo "<td>".$active_count."</td>";
							echo "<td>".$spam_count."</td>";
							echo "<td>".$trash_count."</td>";
							echo "</tr>";
						}
					}
			?> 
			</tbody>
			<tfoot>
				<tr>
					<th>Date</th>
					<th>Active Entries</th>
					<th>Spam Entries</th>
					<th>Trash Entries</th>
				</tr>
			</tfoot>
		</table>
		<div id="pagination"></div>
	</div>
</div>
