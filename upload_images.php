                <?php
					$server = 	'Host Url';
					$username = 'database username';
					$password = 'database password';
					$database = 'database name';
					
					// Connect to Database
					$link = @mysql_connect($server, $username, $password) or die ("Could not connect to server ... \n" . mysql_error ());	
					$db = @mysql_select_db($database, $link) or die ("Could not connect to database ... \n" . mysql_error ());
					
				if(isset($_POST) && array_key_exists('service_name', $_POST))
				{
					     	//upload images start here
							$current_image = $_FILES['photo']['name'];
							$extension = substr(strrchr($current_image, '.'), 1);
							if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "gif") && ($extension != "png")) 
							{
								die('Please select a valid image extension');	
							}
							$time = date("fYhis");
							$new_image = $time . "." . $extension;
							$destination="serviceimages/".$new_image;
							$fullpath = "http://apollo.10summer.com/".$destination;
							$action = copy($_FILES['photo']['tmp_name'], $destination);
							if (!$action) 
							{
								die('Record not saved. Please try again later.');
							}
				
				
							//insert into service_description table
							$query = "INSERT INTO `service_description`(`service_name`, `service_cost`, `service_image`, `service_description`, `service_video_url`, `service_avg_time`, `service_technician`) VALUES ('$service_name','$service_cost','$fullpath','$service_description','$service_video_url','$service_avg_time','$service_technician')";	
							
				}
				else
				{
				?>
                <!--Form for adding new services-->              
                <div id="edit-form" style="margin:5px 0 0 200px;">              
                    <form id="frm1" name="new_service" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onsubmit="return check();">                        
                  		<table>                           
                          
                            <tr>
                            	<td><span>service image url  </span></td>
                                <td><input type="hidden" name="size" value="350000"><input type="file" name="photo"><br /></td>
                            </tr>
                           
                   <tr><td></td><td><br /><input type="submit" name="submit" value="Add Service" class="button orange" style="margin:0 0 0 110px; width:100px;" /></td><td></td></tr>
                        </table>          
                    </form>                    
                  </div>
                	<br /><br />
                <?php 
					}
				?>
		