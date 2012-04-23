

<?php 
$html = file_get_contents("http://www.atlantaallergy.com/");

preg_match_all(
    '/<h3>.*?<span class="pollenTotalNumber">(.*?)<\/span>.*?<\/h3>/s',
    $html,
    $posts, // will contain the blog posts
    PREG_SET_ORDER // formats data into an array of posts
);

$address='localhost';
$user='publicdesign';
$password='F4epvo17';

$connect=mysql_connect($address, $user, $password);
if(!$connect){
	die('error: could not connect to sql server: '.mysql_error());
	
}

$db_select=mysql_select_db('pollensurveys',$connect);
if(!$db_select){
	die('error: could not get table: '.mysql_error());
}
	
foreach ($posts as $post) {
    $count = $post[1];
    $date = date('F j, Y');
   
	$query ="INSERT INTO Count (count_id, date, count) VALUES ('', '$date', '$count')";
	if(mysql_query($query)) {
		echo "
		<p>count recorded</p>";}
	else{
		echo "<p>no". mysql_error() ."</p><p>The query being run was: ". $query ."</p>";
	}
}

mysql_close($connect);

?>