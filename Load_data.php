<?php 
if($_POST['page']) 
{ 
$page = $_POST['page']; 
$cur_page = $page; 
$page -= 1; 
$per_page = 2; 
$previous_btn = true; 
$next_btn = true; 
$first_btn = true; 
$last_btn = true; 
$start = $page * $per_page; 
include"dbconfig.php"; 
$query_pag_data = "SELECT * from records LIMIT $start, $per_page"; 
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error()); 
$msg = ""; 
while ($row = mysql_fetch_array($result_pag_data)) { 
$htmlmsg=htmlentities($row['message']); 
$msg .= "<li><b><img src='".$row['img']."'/></b> " . $htmlmsg . "</li>"; 
} 
$msg = "<div class='data'><ul>" . $msg . "</ul></div>"; // Content for Data 


/* --------------------------------------------- */ 
$query_pag_num = "SELECT COUNT(*) AS count FROM records"; 
$result_pag_num = mysql_query($query_pag_num); 
$row = mysql_fetch_array($result_pag_num); 
$count = $row['count']; 
$no_of_paginations = ceil($count / $per_page); 

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */ 
if ($cur_page >= 7) { 
$start_loop = $cur_page - 3; 
if ($no_of_paginations > $cur_page + 3) 
$end_loop = $cur_page + 3; 
else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) { 
$start_loop = $no_of_paginations - 6; 
$end_loop = $no_of_paginations; 
} else { 
$end_loop = $no_of_paginations; 
} 
} else { 
$start_loop = 1; 
if ($no_of_paginations > 7) 
$end_loop = 7; 
else 
$end_loop = $no_of_paginations; 
} 
/* ----------------------------------------------------------------------------------------------------------- */ 
$msg .= "<div class='pagination'><ul>"; 

// FOR ENABLING THE FIRST BUTTON 
if ($first_btn && $cur_page > 1) { 
$msg .= "<li p='1' class='active'>First</li>"; 
} else if ($first_btn) { 
$msg .= "<li p='1' class='inactive'>First</li>"; 
} 

// FOR ENABLING THE PREVIOUS BUTTON 
if ($previous_btn && $cur_page > 1) { 
$pre = $cur_page - 1; 
$msg .= "<li p='$pre' class='active'>Previous</li>"; 
} else if ($previous_btn) { 
$msg .= "<li class='inactive'>Previous</li>"; 
} 
for ($i = $start_loop; $i <= $end_loop; $i++) { 

if ($cur_page == $i) 
$msg .= "<li p='$i' style='color:#fff;background-color:#006699;' class='active'>{$i}</li>"; 
else 
$msg .= "<li p='$i' class='active'>{$i}</li>"; 
} 

// TO ENABLE THE NEXT BUTTON 
if ($next_btn && $cur_page < $no_of_paginations) { 
$nex = $cur_page + 1; 
$msg .= "<li p='$nex' class='active'>Next</li>"; 
} else if ($next_btn) { 
$msg .= "<li class='inactive'>Next</li>"; 
} 

// TO ENABLE THE END BUTTON 
if ($last_btn && $cur_page < $no_of_paginations) { 
$msg .= "<li p='$no_of_paginations' class='active'>Last</li>"; 
} else if ($last_btn) { 
$msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>"; 
} 
$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>"; 
$total_string = "<span class='total' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span>"; 
$msg = $msg . "</ul>" . $goto . $total_string . "</div>"; // Content for pagination 
echo $msg; 
} 
