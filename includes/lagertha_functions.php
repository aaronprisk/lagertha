<?php 
// Lagertha
// Copyright Aaron J Prisk


function hostPull($link,$terms) {

   if (isset($_GET['terms']))	{ 
   	$query = "SELECT * FROM hosts WHERE hostname LIKE '%" . $terms . "%' LIMIT "; }
	else {
   	$query = "SELECT * FROM hosts ORDER BY hostname LIMIT "; }	
   	
	// Pagination variables 
	$perpage = 15;
	if(isset($_GET["page"])){
		$page = intval($_GET["page"]);}
	else {
		$page = 1;}
	$calc = $perpage * $page;
	$start = $calc - $perpage;
	// Query the database for the results
	$result = $link->query($query . $start . "," . $perpage);
	
	// Get host count numbers
	$count_query = "SELECT * FROM hosts";	
	$count_result = $link->query($count_query);
   $count_total = $count_result->num_rows;

	if ($result->num_rows > 0) {
	
		// Display User Container and table
		echo "$count_total Total Hosts\n";
		echo "
   	<div class='row'>
  		<div class='col-md-12'>
  	 	<table class='table table-striped table-hover'>	
		<thead>
		<tbody>
		<th></th>
		<th></th>
		<th>HostID</th>
		<th>Hostname</th>
		<th>MAC</th>
		<th>OS</th>
		<th>Last Check</th>
		<th></th>
		</thead>";

    while($row = $result->fetch_assoc()) {
    		// Check current time and time of task
			$tasktime = strtotime($row['last_check']);
			$curtime = time();	
			// Create  table row and populate with data
    		echo "<tr><td><form action='view_host.php'><input type='hidden' name='host_id' value='" . $row['hostid'] . "'/><button type='submit' class='btn btn-xs btn-default'>View</button></form></td><td>"; 		
  		   // Check and display if task is active
			if(($curtime-$tasktime) > 900) { 
				echo "<span title='Client NOT ACTIVE within last 15 minutes'><img src='images/nonactive.png' width='16' /></span>";}	
			else {
				echo "<span title='Client ACTIVE within last 15 minutes'><img src='images/active.png'  width='16' /></span>";}
			echo "</td> 
			<td>" . $row['hostid'] . "</td>
			<td>" . $row['hostname'] . "</td>
			<td>" . $row['mac'] . "</td>
			<td>" . $row['os'] . "</td>
			<td>" . $row['last_check'] . "</td>
			<td><form action='quick_task.php'><input type='hidden' name='host_id' value='" . $row['hostid'] . "'/><input type='hidden' name='host_name' value='" . $row['hostname'] . "'/><input type='hidden' name='mac_addr' value='" . $row['mac'] . "'/><button type='submit' class='btn btn-xs btn-info'>Create Task</button></form></td>    
			</tr>";	
    }
    // PAGINATION IN FOOTER
	echo "<tfoot><tr><td colspan=8>";
	if(isset($page))	{
	$result = mysqli_query($link,"select Count(*) As Total from hosts");
	$rows = mysqli_num_rows($result);
		if($rows) {
			$rs = mysqli_fetch_assoc($result);
			$total = $rs["Total"]; }
			$totalPages = ceil($total / $perpage);
			echo "<strong>Page:</strong>" . $page . "/" . $totalPages . "<br />";
		if($page <=1 ){
			echo ""; }
		else {
		$j = $page - 1;
		echo "<span class='btn btn-xs btn-default'><a id='page_a_link' href='host_list.php?page=$j'>< Prev</a></span>";}
		
		for($i=1; $i <= $totalPages; $i++){
			if($i<>$page){
				echo "<span><a id='page_a_link' href='host_list.php?page=$i'> $i</a></span>";
				}
			else {
				echo "<span id='page_links' style='font-weight: bold;'> $i</span>";}}
		if($page == $totalPages ){
			echo "";}
		else {
			$j = $page + 1;
			echo "<span class='btn btn-xs btn-default'><a id='page_a_link' href='host_list.php?page=$j'> Next ></a></span>";}
	}
	echo "</td></tr></tfoot></tbody></table>";
   mysqli_close($link); 
	} else {
    echo "<h3>No Hosts Found</h3>";
	}	
} // End of hostPull function




function taskPull($link,$host_id) {
		
	if ($host_id == NULL){
   	$query = "SELECT * FROM tasks WHERE pending = 1 ORDER BY taskid LIMIT "; 
   	}
	else {
		$query = "SELECT * FROM tasks WHERE hostid = " . $host_id; 	
		}	
	
	// Pagination variables 
	$perpage = 15;
	if(isset($_GET["page"])){
		$page = intval($_GET["page"]);}
	else {
		$page = 1;}
	$calc = $perpage * $page;
	$start = $calc - $perpage;
	// Query the database for the results
	$result = $link->query($query . $start . "," . $perpage);

	if ($result->num_rows > 0) {
	
	// Display User Container and table
	echo "
   <div class='row'>
   <div class='col-md-12'>
   <table class='table table-striped'>	
	<thead>
	<tbody>
	<th></th>
	<th>TaskID</th>
	<th>Task Type</th>
	<th>Host</th>
	<th>Status</th>
	<th>User</th>
	<th></th>
	</thead>
	";

    while($row = $result->fetch_assoc()) {
		echo "<tr><td><form action='view_task.php'><input type='hidden' name='task_id' value='" . $row['taskid'] . "'/> 	<button type='submit' class='btn btn-xs btn-default'>View</button></form></td>      
		<td>" . $row['taskid'] . "</td>";
		if ($row['tasktype'] == 0){
		echo "<td><i class='fa fa-download' aria-hidden='true'></i> System Update</td>";} 
		if ($row['tasktype'] == 1){
		echo "<td><i class='fa fa-archive' aria-hidden='true'></i> Package Install</td>";} 		
		if ($row['tasktype'] == 2){
		echo "<td><i class='fa fa-trash' aria-hidden='true'></i> Package Remove</td>";} 	
		if ($row['tasktype'] == 3){
		echo "<td><i class='fa fa-picture-o' aria-hidden='true'></i> Wallpaper</td>";} 	
		echo "<td>" . $row['host'] . "</td>";
		if ($row['status'] == 0){
		echo "<td><i class='fa fa-spinner fa-pulse' aria-hidden='true'></i> In Progress</td>";} 
		if ($row['status'] == 1){
		echo "<td><i class='fa fa-check-circle' aria-hidden='true'></i> Completed</td>";} 
		if ($row['status'] == 2){
		echo "<td><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Failed</td>";} 
		if ($row['status'] == 3){
		echo "<td><i class='fa fa-ban' aria-hidden='true'></i> Canceled</td>";} 
		echo "<td>" . $row['user'] . "</td>
		<td><form action '' method='POST'><input type='hidden' name='taskid' value='" . $row['taskid'] . "'/><button type='submit' class='btn btn-xs btn-danger' name='cancel'>Cancel Task</button></form></td>   </tr>";
	}
	

    // PAGINATION IN FOOTER
	echo "<tfoot><tr><td colspan=8>";
	if(isset($page))	{
	$result = mysqli_query($link,"select Count(*) As Total from tasks WHERE pending = 1");
	$rows = mysqli_num_rows($result);
		if($rows) {
			$rs = mysqli_fetch_assoc($result);
			$total = $rs["Total"]; }
			$totalPages = ceil($total / $perpage);
			echo "<strong>Page:</strong>" . $page . "/" . $totalPages . "<br />";
		if($page <=1 ){
			echo ""; }
		else {
		$j = $page - 1;
		echo "<span class='btn btn-xs btn-default'><a id='page_a_link' href='task_list.php?page=$j'>< Prev</a></span>";}
		
		for($i=1; $i <= $totalPages; $i++){
			if($i<>$page){
				echo "<span><a id='page_a_link' href='task_list.php?page=$i'> $i</a></span>";
				}
			else {
				echo "<span id='page_links' style='font-weight: bold;'> $i</span>";}}
		if($page == $totalPages ){
			echo "";}
		else {
			$j = $page + 1;
			echo "<span class='btn btn-xs btn-default'><a id='page_a_link' href='task_list.php?page=$j'> Next ></a></span>";}
	}
	echo "</td></tr></tfoot></tbody></table>";
	} else {
    echo "<h3>No Active Tasks</h3>";
	}
	
	if(isset($_POST['cancel'])){
	$taskid = $_POST['taskid'];
	if (!mysqli_query($link, "UPDATE tasks SET pending = 0, status = 3 WHERE taskid='$taskid'"))
		{
			echo "There was an error canceling the task!";	}
	else {			
			mysqli_close($link);
   		echo"<script>window.location.href = 'task_list.php';</script>";}			
		} 	
mysqli_close($link);
} // End of taskPull function






// Pull groups from DB

function groupPull($link) {
	
   $query = "SELECT * FROM groups ORDER BY groupid LIMIT "; 
	// Pagination variables 
	$perpage = 10;
	if(isset($_GET["page"])){
		$page = intval($_GET["page"]);}
	else {
		$page = 1;}
	$calc = $perpage * $page;
	$start = $calc - $perpage;
	// Query the database for the results
	$result = $link->query($query . $start . "," . $perpage);

	if ($result->num_rows > 0) {
		echo "
   	<div class='row'>
   	<div class='col-md-12'>
  	 	<table class='table table-striped'>	
		<thead>
		<tbody>
		<th></th>
		<th>GroupID</th>
		<th>Group Name</th>
		<th>Owner</th>
		<th>Info</th>
		<th></th>
		</thead>";

    while($row = $result->fetch_assoc()) {
		echo "<tr><td><form action='view_group.php'><input type='hidden' name='group_id' value='" . $row['groupid'] . "'/><button type='submit' class='btn btn-xs btn-default'>View</button></form></td>      
		<td>" . $row['groupid'] . "</td>
		<td>" . $row['name'] . "</td>
		<td>" . $row['owner'] . "</td>
		<td>" . $row['info'] . "</td>
		<td>
		<form action='quick_task.php'>
		<input type='hidden' name='group_id' value='" . $row['groupid'] . "'/>
		<input type='hidden' name='group_name' value='" . $row['name'] . "'/>
      <button type='submit' class='btn btn-xs btn-info'>Create Group Task</button>
		</form>
		</td>   
		</tr>
		";
	}
	
  // PAGINATION IN FOOTER
	echo "<tfoot><tr><td colspan=8>";
	if(isset($page))	{
	$result = mysqli_query($link,"select Count(*) As Total from groups");
	$rows = mysqli_num_rows($result);
		if($rows) {
			$rs = mysqli_fetch_assoc($result);
			$total = $rs["Total"]; }
			$totalPages = ceil($total / $perpage);
			echo "<strong>Page:</strong>" . $page . "/" . $totalPages . "<br />";
		if($page <=1 ){
			echo ""; }
		else {
		$j = $page - 1;
		echo "<span class='btn btn-xs btn-default'><a id='page_a_link' href='groups.php?page=$j'>< Prev</a></span>";}
		
		for($i=1; $i <= $totalPages; $i++){
			if($i<>$page){
				echo "<span><a id='page_a_link' href='groups.php?page=$i'> $i</a></span>";
				}
			else {
				echo "<span id='page_links' style='font-weight: bold;'> $i</span>";}}
		if($page == $totalPages ){
			echo "";}
		else {
			$j = $page + 1;
			echo "<span class='btn btn-xs btn-default'><a id='page_a_link' href='groups.php?page=$j'> Next ></a></span>";}
	}
	echo "</td></tr></tfoot></tbody></table>";
	} else {
    echo "<h3>No Groups Found</h3>";
	}
mysqli_close($link);
} // end of groupPull function







function viewHost($link,$host_id) {
	$query = "SELECT * FROM hosts WHERE hostid = " . $host_id; 
	$groupquery = "SELECT groupid, name FROM groups";
	$result = $link->query($query);
	$groupresult = $link->query($groupquery);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$hostid = $row['hostid'];
			$hostname = $row['hostname'];
			$hostmac = $row['mac'];	
			// Check current time and time of task
			$tasktime = strtotime($row['last_check']);
			$curtime = time();	
	
			echo "
			<h4>Basic Info</h4>
			<strong>Hostname: </strong>" . $row['hostname'] . "<br />
	 		<strong>Operating System: </strong>" . $row['os'] . "<br />
			<strong>MAC Address: </strong>" . $row['mac'] . "<br />
			<strong>Details: </strong>" . $row['details'] . "<br />
			<hr>
			<h4>Group Membership</h4>
	  		<div class='btn-group'><a aria-expanded='false' href='#' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>ADD TO GROUP<span class='caret'></span></a>
     		<ul class='dropdown-menu'>"; 
     		
			// Loop through the group results
			while($grouprow = $groupresult->fetch_assoc()) {
				echo "<form action '' method='POST'>
				<input type='hidden' name='group_id' value='" . $grouprow['groupid'] . "'/>
		      <input type='hidden' name='host_id' value='" . $hostid . "'/>
	       	<input type='hidden' name='host_name' value='" . $hostname . "'/>
		      <input type='hidden' name='mac_addr' value='" . $hostmac . "'/>		
				<button type='submit' class='btn btn-xs btn-default' name='groupadd'>" . $grouprow['groupid'] . "-" . $grouprow['name'] . "</button></form>";
			}
			echo "</ul></div>
			
	 		<hr><h4>Task Info</h4>";
 			if(($curtime-$tasktime) > 900) { 
				echo "<span title='Client NOT ACTIVE within last 15 minutes'><img src='images/nonactive.png' width='16' /></span>";}	
			else {
				echo "<span title='Client ACTIVE within last 15 minutes'><img src='images/active.png'  width='16' /></span>";}	
		 	echo "
 	 		<strong>Last Task Check: </strong>" . $row['last_check'] . "<br /><br />
 	 		<h4>Create New task</h4>";
	}	
	
	
		echo"
	 	<form action='quick_task.php'>
		<input type='hidden' name='host_id' value='" . $hostid . "'/>
		<input type='hidden' name='host_name' value='" . $hostname . "'/>
		<input type='hidden' name='mac_addr' value='" . $hostmac . "'/>
      <button type='submit' class='btn btn-info'>Create Task</button>
		</form>";
		
		echo "
		<hr>
		<h4>Remove Host</h4>
		<form action '' method='POST'><input type='hidden' name='hostmac' value='" . $hostmac . "'/><button type='submit' class='btn btn-danger' name='remove'>Remove Host</button></form></td>
		<strong>WARNING!</strong> Removing a host is permanent. Host will need to be registered again for management.";
	}
	
	// query to add to group
	if(isset($_POST['groupadd'])){
	$groupid = $_POST['group_id'];
	$hostmac = $_POST['mac_addr'];
	$hostid = $_POST['host_id'];
	$hostname = $_POST['host_name'];
	if (!mysqli_query($link, "INSERT INTO group_members (group_mem_num, hostid, mac, hostname, groupid) VALUES ('', '$hostid', '$hostmac', '$hostname', '$groupid')"))
		{
			echo "<br><hr><h4><i class='fa fa-exclamation-triangle' aria-hidden='true'>Unable to add host to group. Host may already belong to group.</i></h4>";	}
	else {			
			mysqli_close($link);
   		echo"<script>window.location.href = 'view_group.php?group_id=" . $groupid . "';</script>";}		
		} 	

   // query to remove host
	if(isset($_POST['remove'])){
	$hostmac = $_POST['hostmac'];
	if (!mysqli_query($link, "DELETE FROM hosts WHERE mac = '$hostmac'"))
		{
			echo "<br><hr><h4><i class='fa fa-exclamation-triangle' aria-hidden='true'>Unable to remove host!</i></h4>";	}
	else {			
			mysqli_close($link);
   		echo"<script>window.location.href = 'host_list.php';</script>";}			
		} 	
	
	
	
} //end of viewHost function








function logPull($link, $host_id) {

   if ($host_id == NULL){
   	$query = "SELECT * FROM tasks WHERE pending = 0 ORDER BY taskid DESC LIMIT "; 
   	}
	else {
		$query = "SELECT * FROM tasks WHERE hostid = " . $host_id . "DESC LIMIT "; 	
		}	
	$perpage = 10;
	if(isset($_GET["page"])){
		$page = intval($_GET["page"]);}
	else {
		$page = 1;}
	$calc = $perpage * $page;
	$start = $calc - $perpage;
	// Query the database for the results
	$result = $link->query($query . $start . "," . $perpage);

	if ($result->num_rows > 0) {
		echo "
   	<div class='row'>
   	<div class='col-md-12'>
   	<table class='table table-striped'>	
		<thead>
		<tbody>
		<th></th>
		<th>TaskID</th>
		<th>Task Type</th>
		<th>Host</th>
		<th>Status</th>
		<th>User</th>
		<th>Time Stamp</th>
		</thead>";

    while($row = $result->fetch_assoc()) {
		// Display the records from the database
		echo "<tr>
     	<td>
     		<form action='view_task.php'>
     		<input type='hidden' name='task_id' value='" . $row['taskid'] . "'/>    		
      		<button type='submit' class='btn btn-xs btn-default'>View</button>
         </form>
		</td>   
		<td>" . $row['taskid'] . "</td>";
		
		if ($row['tasktype'] == 0){
		echo "<td><i class='fa fa-download' aria-hidden='true'></i> System Update</td>";
		} 
		if ($row['tasktype'] == 1){
		echo "<td><i class='fa fa-archive' aria-hidden='true'></i> Package Install</td>";
		} 		
		if ($row['tasktype'] == 2){
		echo "<td><i class='fa fa-trash' aria-hidden='true'></i> Package Remove</td>";
		} 	
		if ($row['tasktype'] == 3){
		echo "<td><i class='fa fa-picture-o' aria-hidden='true'></i> Wallpaper</td>";
		} 	
		
		echo "
		<td>" . $row['host'] . "</td>";
		if ($row['status'] == 0){
		echo "<td><i class='fa fa-spinner fa-pulse' aria-hidden='true'></i> In Progress</td>";
		} 
		if ($row['status'] == 1){
		echo "<td><i class='fa fa-check-circle' aria-hidden='true'></i> Completed</td>";
		} 
		if ($row['status'] == 2){
		echo "<td><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Failed</td>";
		} 
		if ($row['status'] == 3){
		echo "<td><i class='fa fa-ban' aria-hidden='true'></i> Canceled</td>";
		} 
		echo "
		<td>" . $row['user'] . "</td>
		<td>" . $row['timestamp'] . "</td>   
		</tr>";
	}
	
	 // PAGINATION IN FOOTER
	echo "<tfoot><tr><td colspan=8>";
	if(isset($page))	{
	$result = mysqli_query($link,"select Count(*) As Total from tasks");
	$rows = mysqli_num_rows($result);
		if($rows) {
			$rs = mysqli_fetch_assoc($result);
			$total = $rs["Total"]; }
			$totalPages = ceil($total / $perpage);
			echo "<strong>Page:</strong>" . $page . "/" . $totalPages . "<br />";
		if($page <=1 ){
			echo ""; }
		else {
		$j = $page - 1;
		echo "<span class='btn btn-xs btn-default'><a id='page_a_link' href='logs.php?page=$j'>< Prev</a></span>";}
		
		for($i=1; $i <= $totalPages; $i++){
			if($i<>$page){
				echo "<span><a id='page_a_link' href='logs.php?page=$i'> $i</a></span>";
				}
			else {
				echo "<span id='page_links' style='font-weight: bold;'> $i</span>";}}
		if($page == $totalPages ){
			echo "";}
		else {
			$j = $page + 1;
			echo "<span class='btn btn-xs btn-default'><a id='page_a_link' href='logs.php?page=$j'> Next ></a></span>";}
	}
	echo "</td></tr></tfoot></tbody></table>";
	} else {
    echo "<h3>No Logged Tasks Found</h3>";
	}
mysqli_close($link);
}








// Create a quick task from host list


function quickTask($link,$host_id, $host_name, $mac_addr, $group_id, $group_name) {
	
// Pull logged in user ID
$user_id=$_SESSION['user_name'];

// Check if task is Group Task

if($group_id) {
		echo "<h4>Task for group: <strong>" . $group_name . "</strong></h4>";
		echo "<hr>";
		echo "<h3><i class='fa fa-archive' aria-hidden='true'></i> Add/Remove Packages</h3>
		<form action '' method='POST'>
   		<input type='radio' name='type' value='1' checked> <i class='fa fa-archive' aria-hidden='true'></i>Install Package &nbsp; &nbsp; &nbsp;
   		<input type='radio' name='type' value='2'> <i class='fa fa-minus-circle' aria-hidden='true'></i>Remove Package<br>
			<input id='login_input_username' class='form-control login_input' type='text' name='pkg' style='width: 50%;' required />
			<br />
			<input type='submit' class='btn btn-lg btn-info' name='package' value='CREATE TASK' />
		</form>
		<br />
		<div class='alert alert-dismissible alert-danger'>
  		<button type='button' class='close' data-dismiss='alert'>&times;</button>
   	<strong>WARNING!</strong> Be very careful when creating Add/Remove Package tasks. Incorrect values can damage systems and result in loss of data.
		</div>
		<hr>
		<h3><i class='fa fa-upload' aria-hidden='true'></i> Update Packages</h3>
		<p>An Update Task will schedule a full package update on host. Be aware that some updates may require a reboot or user interaction to fully comlpete. 
		<form action '' method='POST'>
			<br />
			<input type='submit' class='btn btn-lg btn-info' name='update' value='CREATE TASK' />
		</form>	
		<hr>
		<h3><i class='fa fa-image' aria-hidden='true'></i> Visual Task</h3>
		<form action '' method='POST'>
 		  <p>Choose uploaded image to be used in task. To add more images, visit the Media page.</p>
			<br />
		<select name='wallpaper'>";			
			$dirname = "uploads/";
			$images = glob($dirname."*.*");
			foreach($images as $image) {
			echo "<option value=".$image.">".$image."</option>";
			}			
		echo 
		"</select>
		<br /><br />
		<input type='submit' class='btn btn-lg btn-info' name='visual' value='CREATE TASK' />
		</form>
		";
		
		
		// Pull all group members for task creation
		$memquery = "SELECT * FROM group_members WHERE groupid = " . $group_id; 
		// Query the database for the results
		$memresult = $link->query($memquery);
		if($memresult->num_rows <= 0) {
			echo "<br /><h1>No hosts in selected group</h1><br />";
		} else {
			while($row = $memresult->fetch_assoc()) {
				// Get hostname and hostid from group member and set variables
				$mem_hostid = $row['hostid'];
				$mem_host_name = $row['hostname'];	
				$mem_mac_addr = $row['mac'];	

				//GROUP ADD REMOVE TASK	
				if(isset($_POST['package'])){
				$pkg = $_POST['pkg'];
				$type = $_POST['type'];		
				$query = "INSERT INTO tasks (taskid, host, mac, hostid, tasktype, pending, package, status, info, user, log, timestamp) VALUES ('', '$mem_host_name', '$mem_mac_addr', '$mem_hostid', '$type', '1', '$pkg', '0', 'quick task', '$user_id', '', now())";
				echo $query;
					if ($link->query($query) === TRUE) {
    						echo"<script>window.location.href = 'task_list.php';</script>";
						} else {
   							echo "Error: " . $query . "<br>" . $link->error;}
				}
						

				// GROUP UPDATE TASK
				if(isset($_POST['update'])){
				$type = 0;
				$query = "INSERT INTO tasks (taskid, host, mac, hostid, tasktype, pending, package, status, info, user, log, timestamp) VALUES ('', '$mem_host_name', '$mem_mac_addr', '$mem_hostid', '$type', '1', '', '0', 'quick task', '$user_id', '', now())";
					if ($link->query($query) === TRUE) {
    						echo"<script>window.location.href = 'task_list.php';</script>";
						} else {
   							echo "Error: " . $query . "<br>" . $link->error;}
				}
				 

				// GROUP VISUAL TASK
				if(isset($_POST['visual'])){
				$selectwall = $_POST['wallpaper'];
				$type = 3;
				$query = "INSERT INTO tasks (taskid, host, mac, hostid, tasktype, pending, package, status, info, user, log, timestamp) VALUES ('', '$mem_host_name', '$mem_mac_addr', '$mem_hostid', '$type', '1', '$selectwall', '0', 'quick task', '$user_id', '', now())";
					if ($link->query($query) === TRUE) {
    						echo"<script>window.location.href = 'task_list.php';</script>";
						} else {
   							echo "Error: " . $query . "<br>" . $link->error;}
				}
			}
		} 
	} // END OF GROUP TASK

elseif($host_id) {
		echo "<h4>Task for host: <strong>" . $host_name . "</strong></h4>";
		echo "<hr>";
		echo "<h3><i class='fa fa-archive' aria-hidden='true'></i> Add/Remove Packages</h3>
		<form action '' method='POST'>
   		<input type='radio' name='type' value='1' checked> <i class='fa fa-archive' aria-hidden='true'></i>Install Package &nbsp; &nbsp; &nbsp;
 	  	<input type='radio' name='type' value='2'> <i class='fa fa-minus-circle' aria-hidden='true'></i>Remove Package<br>
		<input id='login_input_username' class='form-control login_input' type='text' name='pkg' style='width: 50%;' required />
			<br />
			<input type='submit' class='btn btn-lg btn-info' name='package' value='CREATE TASK' />
		</form>
		<br />
		<div class='alert alert-dismissible alert-danger'>
  		<button type='button' class='close' data-dismiss='alert'>&times;</button>
   	<strong>WARNING!</strong> Be very careful when creating Add/Remove Package tasks. Incorrect values can damage systems and result in loss of data.
		</div>
		<hr>
		<h3><i class='fa fa-upload' aria-hidden='true'></i> Update Packages</h3>
		<p>An Update Task will schedule a full package update on host. Be aware that some updates may require a reboot or user interaction to fully comlpete. 
		<form action '' method='POST'>
			<br />
			<input type='submit' class='btn btn-lg btn-info' name='update' value='CREATE TASK' />
		</form>		
		<hr>
		<h3><i class='fa fa-image' aria-hidden='true'></i> Visual Task</h3>
		<form action '' method='POST'>
 		  <p>Choose uploaded image to be used in task. To add more images, visit the Media page.</p>
			<br />
			<select name='wallpaper'>";			
			$dirname = "uploads/";
			$images = glob($dirname."*.*");
			foreach($images as $image) {
			echo "<option value=".$image.">".$image."</option>";
			}			
		echo 
		"</select>
		<br /><br />
			<input type='submit' class='btn btn-lg btn-info' name='visual' value='CREATE TASK' />
		</form>";

		//HOST ADD REMOVE TASK	
		if(isset($_POST['package'])){
			$pkg = $_POST['pkg'];
			$type = $_POST['type'];
			$query = "INSERT INTO tasks (taskid, host, mac, hostid, tasktype, pending, package, status, info, user, log, timestamp) VALUES ('','$host_name', '$mac_addr', '$host_id', '$type', '1', '$pkg', '0', 'quick task', '$user_id', '', now())";
					if ($link->query($query) === TRUE) {
    						echo"<script>window.location.href = 'task_list.php';</script>";
						} else {
   							echo "Error: " . $query . "<br>" . $link->error;}
				}
				
			// HOST UPDATE TASK
			if(isset($_POST['update'])){
			$type = 0;
			$query = "INSERT INTO tasks (taskid, host, mac, hostid, tasktype, pending, package, status, info, user, log, timestamp) VALUES ('', '$host_name', '$mac_addr', '$host_id', '$type', '1', '', '0', 'quick task', '$user_id', '', now())";
					if ($link->query($query) === TRUE) {
    						echo"<script>window.location.href = 'task_list.php';</script>";
						} else {
   							echo "Error: " . $query . "<br>" . $link->error;}
				}


		// HOST VISUAL TASK
		if(isset($_POST['visual'])){
			$selectwall = $_POST['wallpaper'];
			$type = 3;
			$query = "INSERT INTO tasks (taskid, host, mac, hostid, tasktype, pending, package, status, info, user, log, timestamp) VALUES ('', '$host_name', '$mac_addr', '$host_id', '$type', '1', '$selectwall', '0', 'quick task', '$user_id', '', now())";
					if ($link->query($query) === TRUE) {
    						echo"<script>window.location.href = 'task_list.php';</script>";
						} else {
   							echo "Error: " . $query . "<br>" . $link->error;}
				}
		} // END OF HOST TASK
} // end of quickTask Function









function viewTask($link,$task_id) {
	$query = "SELECT * FROM tasks WHERE taskid = " . $task_id; 
	$result = $link->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo
			"<h4>Task Info</h4>
			<strong>TaskID: </strong>" . $row['taskid'] . "<br />
			<strong>Timestamp: </strong>" . $row['timestamp'] . "<br />
			<strong>Hostname: </strong>" . $row['host'] . "<br />";
			if ($row['tasktype'] == 0){
				echo "<strong>Task Type: </strong><i class='fa fa-download' aria-hidden='true'></i> System Update<br />";} 
			if ($row['tasktype'] == 1){
				echo "<strong>Task Type: </strong><i class='fa fa-archive' aria-hidden='true'></i> Package Install<br />";} 		
			if ($row['tasktype'] == 2){
				echo "<strong>Task Type: </strong><i class='fa fa-trash' aria-hidden='true'></i> Package Remove<br />";} 	
			if ($row['tasktype'] == 3){
				echo "<strong>Task Type: </strong><i class='fa fa-picture-o' aria-hidden='true'></i> Wallpaper<br />";} 	
			if ($row['status'] == 0){
				echo "<strong>Task Status: </strong><i class='fa fa-spinner fa-pulse' aria-hidden='true'></i> In Progress<br />";} 
			if ($row['status'] == 1){
				echo "<strong>Task Status: </strong><i class='fa fa-check-circle' aria-hidden='true'></i> Completed<br />";} 
			if ($row['status'] == 2){
				echo "<strong>Task Status: </strong><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Failed<br />";} 
			if ($row['status'] == 3){
				echo "<strong>Task Status: </strong><i class='fa fa-ban' aria-hidden='true'></i> Canceled<br />";} 
			 echo "
	 		<strong>Package: </strong>" . $row['package'] . "<br />
 	 		<strong>Info: </strong>" . $row['info'] . "<br />
 			<strong>Created By: </strong>" . $row['user'] . "<br />";
			}
		} else {
		echo "<h3>Task not found</h3>";}	
} // end of viewTask function



function createHost($link,$hostname,$mac) {
	$bytes = str_split($mac, 2);	
	$newmac = implode(':', $bytes);
	$taskid = $_POST['taskid'];
	$query = "INSERT INTO hosts (hostid, mac, hostname, os, details, last_check) VALUES ('', '$newmac', '$hostname', '', '', '')";
	if (!mysqli_query($link,$query))
		{
			echo "<h1>There was an error creating host!</h1><br />";
			mysqli_close($link);	}
	else {			
			mysqli_close($link);
   		echo"<script>window.location.href = 'host_list.php';</script>";}	
   					 			
} 	// end of createHost function






function updateSettings($link,$check_freq) {
	$query = "UPDATE settings SET check_freq = ". $check_freq . " WHERE settings_id=1";
	if (!mysqli_query($link,$query))
		{
			echo "<h1>There was an error updating settings</h1><br />";
			echo $query;
			mysqli_close($link);	}
	else {			
			mysqli_close($link);
   		echo"<script>window.location.href = 'settings.php';</script>";}	
   					 			
} 	// end of createHost function









function viewGroup($link,$group_id) {
		
   $query = "SELECT * FROM group_members WHERE groupid = $group_id LIMIT "; 	
	// Pagination variables 
	$perpage = 10;
	if(isset($_GET["page"])){
		$page = intval($_GET["page"]);}
	else {
		$page = 1;}
	$calc = $perpage * $page;
	$start = $calc - $perpage;
	// Query the database for the results
	$result = $link->query($query . $start . "," . $perpage);

	if ($result->num_rows > 0) {
		echo "
 	 	<div class='row'>
  	 	<div class='col-md-12'>
   	<table class='table table-striped'>	
		<thead>
		<tbody>
		<th>ID</th>
		<th>Hostname</th>
		<th>MAC</th>
		<th></th>
		</thead>";	
	
		   while($row = $result->fetch_assoc()) {
				echo "<tr>  
				<td>" . $row['group_mem_num'] . "</td>  
				<td>" . $row['hostname'] . "</td>
				<td>" . $row['mac'] . "</td> 
				<td>
				<form action '' method='POST'><input type='hidden' name='group_mem_num' value='" . $row['group_mem_num'] . "'/><button type='submit' class='btn btn-xs btn-danger' name='remove'>Remove From Group</button></form>	</td>
				</tr>";
				}
				
 // PAGINATION IN FOOTER
	echo "<tfoot><tr><td colspan=8>";
	if(isset($page))	{
	$result = mysqli_query($link,"select Count(*) As Total from group_members WHERE groupid = " . $group_id);
	$rows = mysqli_num_rows($result);
		if($rows) {
			$rs = mysqli_fetch_assoc($result);
			$total = $rs["Total"]; }
			$totalPages = ceil($total / $perpage);
		if($page <=1 ){
			echo ""; }
		else {
		$j = $page - 1;
		echo "<span class='btn btn-xs btn-default'><a id='page_a_link' href='view_group.php?group_id=$group_id&page=$j'>< Prev</a></span>";}
		
		for($i=1; $i <= $totalPages; $i++){
			if($i<>$page){
				echo "<span><a id='page_a_link' href='view_group.php?group_id=$group_id&page=$i'> $i</a></span>";}
			else {
				echo "<span id='page_links' style='font-weight: bold;'> $i</span>";}}
		if($page == $totalPages ){
			echo "";}
		else {
			$j = $page + 1;
			echo "<span class='btn btn-xs btn-default'><a id='page_a_link' href='view_group.php?group_id=$group_id&page=$j'> Next ></a></span>";}
	}
	echo "</td></tr></tfoot></tbody></table>";

	} else {
    echo "<h3>No Groups Members Found</h3>";
	}	
	
	
	if(isset($_POST['remove'])){
	$group_mem_num = $_POST['group_mem_num'];
	if (!mysqli_query($link, "DELETE FROM group_members WHERE group_mem_num = $group_mem_num"))
		{
			echo "There was an error removing the group member!";	}
	else {			
			mysqli_close($link);
   		echo"<script>window.location.href = 'groups.php';</script>";}			
		} 	
mysqli_close($link);
} // end of viewGroup function

?>
