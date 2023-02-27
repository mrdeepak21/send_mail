<?php
require_once('wp-config.php');

// $submission_ids = [686,687,688,689,690,691,692];
$submission_ids = [54,60];
global $wpdb, $table_prefix;

$to = ['shavee.kapoor@sterlingadministration.com','Duarte.Batista@sterlingadministration.com','fmlasales@sterlingadministration.com','deepak@heigh10.com'];
$headers[] = 'From: FMLA <no-reply@sterlingadministration.com>';
$headers[] = 'Cc:marketing@heigh10.com';

function fetch_value($id){
global $wpdb, $table_prefix;
$values = $wpdb->get_results("SELECT * FROM ".$table_prefix."e_submissions_values WHERE submission_id=".$id);
$prepared = '';
foreach ($values as $data) {
   $prepared.= "<b>".$data->key."</b>: ".$data->value."<br>";
}
return $prepared;
}

function referer($id)
{
    global $wpdb, $table_prefix;
    $referer = $wpdb->get_results("SELECT `referer` FROM ".$table_prefix."e_submissions WHERE id=".$id); 
    return $referer[0]->referer;
}
fetch_value($submission_ids[0]);

referer($submission_ids[0]);

for ($i=0; $i <sizeof($submission_ids) ; $i++) { 
$subject = $submission_ids[$i]==686||$submission_ids[$i]==689?"FMLA - Get A Quote":"FMLA - Call Request";
$message = '<body>'.fetch_value($submission_ids[$i]).'<br><br>Page url:'.referer($submission_ids[$i]).'</body>';

 if(wp_mail($to, $subject,$message,$headers)){

     echo "<br>Success";
 } else {
     echo "<br>Failed";
 }
}