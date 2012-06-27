<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');


	if  (!empty($_POST)) 
	{ // if upload automatically by csv file
	  ?> <p>The vendor and menu are updated without problems. <br> 
			<br><a href="admin.php""><input type="button" name="home" value="Home" ></a></p>	 	
			<?
			$fichier = $_FILES ['file'] ['tmp_name'];
			$extension = strrchr($_FILES['file']['name'], '.');				
			if (file_exists ( $fichier )) //check is file selected
			{
				$fp = fopen ( "$fichier", "r" ); //open just for read
			
				if ($extension == '.csv') // check the extension : csv
					{
					$row = 1;
					while (($data = fgetcsv($fp, 1000, ";")) !== FALSE) {
				        $num = count($data); 
				        $row++;
				        for ($c=0; $c < $num; $c++) {    
				        }
				        // collect all the info from the csv file, row by row, line by line
				        $name_v= $data[0];
				        $desc_v= $data[1];
				        $twit_v=$data[2];
				        $fb_v=$data[3];
				        $url_img=$data[4];
				        $entree_v=$data[5];
				        $app_v=$data[6];
				        $dessert_v=$data[7];
				        // collect the url from web to upload the image in our directory
				        $name_temp = $name_v.'_pic.jpg'; 
				    	$name = str_replace(' ','',$name_temp);
						$path = "upload/";
						copy($url_img,$path.'/'.$name);
				
						// insert info into vendor table
						$sql = "INSERT INTO popup(id_popup, name_popup, date_popup, bio_popup, menu_popup, order_popup, id_vendor_p) VALUES ('','$name_p','$date_popup', '$bio','$menu','','')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());						// to know the id from the same vendor
						
				    }
					fclose ( $fp ); // close the file
					}
					else {  echo '<br> You have to upload a .csv, please try again';
						 }	
			} else {
					?> <br><br> <?php  echo "You have to select a file, please try again"; 
					}	
	}				
	else { ?>
    <?
    $template = array(
	'title' => 'Cater2.me | Add PopUp',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Add PopUp '=>'/dashboard/add-popup/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
	
		<script>
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
		});
		
		function deleteResource(res_type, id) {
			document.f.delete_resource.value=res_type;
			document.f.id_resource.value=id;
			document.f.submit();
		}
		</script>
		
		<style>
		
		#tblHTML td {
		  height: 35px;
		  vertical-align: middle;
		}
		#tblHomeSlider {
		border:0;
		width:100%;
		}
		#tblHomeSlider td {
		border:0;
		}
		
		fieldset {
		border:1px #777 solid;
		padding:10px;
		}
		fieldset legend {
		margin-left:2px;
		}
		.del {
		color:red !important;
		}
		</style>
	',
	
	'grey_bar' => 'Add a PopUp'
	);

require 'header.php';
?>    
		<form method="post" action="" enctype="multipart/form-data">
		<p>Upload a CSV file to upload multiple vendors<br><input type="hidden" name="MAX_FILE_SIZE" value="2097152"> <input
					type="file" name="file"></td>
				<input type="submit" value="Upload" /></p>
				</form>	
		<? }
	?>
