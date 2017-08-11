<?php
/**
 * Configuration
 */
$host = 'localhost';
$port = 5432;
$dbname = 'i5kworkspace';
$dbuser = 'postgres';
$dbpassword = 'root';

// function to loop menu array
function loop_array($db, $array = array(), $parent_id = 0) {
	$content = '';
  if(!empty($array[$parent_id])) {
     $content .= $parent_id ? '<ul>' : '<ul class="sf-menu sf-js-enabled sf-arrows" id="example">';
     foreach($array[$parent_id] as $items) {
		 
	   if($items->has_children == 1)  
         $content .= '<li class="has-sub">';
	   else
		 $content .= '<li>';
	 
       $path =  $items->link_path;	  
	   if(!empty($path)) {
         $path_sql = pg_query($db, "select * from url_alias where source='".$path."'"); 	   
	     $path_res = pg_fetch_object($path_sql); 
		 
	     if(!empty($path_res->alias)) 
		   $path = $path_res->alias;   	
	   }	 
	   
	   if($items->link_path == '<front>') 
	     $path = ''; 
	 
	   $current_path = 'https://i5k.nal.usda.gov/'; 
       $content .= "<a href='".$current_path.$path."'>".$items->link_title;	   
	   $content .= "</a>";
       $content .= loop_array($db, $array, $items->mlid);
       $content .= '</li>';
	 } 
     $content .= '</ul>';
  }
  return $content;
}


// main script to connect db and get menu data
$db = pg_connect("host=$host port=$port dbname=$dbname user=$dbuser password=$dbpassword");
if (!$db) {
	echo "An error occurred to connect to database.\n";
	exit;
}
$result = pg_query($db, "select * from menu_links where menu_name='main-menu'  and hidden=0 and module='menu' order by weight asc");
$array = array();
while ($rows = pg_fetch_object($result)) {
	if ($rows->mlid != 694) {
		$array[$rows->plid][] = $rows;
	}
}

$html = '';
$html .= '<link rel="stylesheet" href="css/HeaderFooter.css" media="screen">';
$html .= '<script src="js/jquery.js"></script>';
$html .= '<script src="js/hoverIntent.js"></script>';
$html .= '<script src="js/superfish.min.js"></script>';
$html .= '<script>(function($){$(document).ready(function(){var example = $("#example").superfish({});});})(jQuery);</script>';

$html .= '<div class="container"><div class="header"><div id="sign-lockup"><a class="logo title="United States Department of Agriculture"><img src="../header/usda-logo.svg" alt="Home"></a>

      <a class="name" title="United States Department of Agriculture"><span class="usda-name">United States Department of Agriculture</span>National Agricultural Library</a>
    </div>
    <div class="site-title">i5k Workspace@NAL</div>
  </div>' . loop_array($db, $array) . '
  <div class="i5k-login">
    <a href="https://i5k.nal.usda.gov/user/login">Login</a>
  </div>
</div>';


$myfile = fopen("header.html", "w") or die("Unable to open file!");
fwrite($myfile, $html);
fclose($myfile);
echo $html;
?>
