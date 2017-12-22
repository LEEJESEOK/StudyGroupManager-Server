<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once '../includes/DBOperations.php';

$response = array();
$posts = array();

if($_SERVER['REQUEST_METHOD']=='POST') {
  if(isset($_POST['value'])) {
    $db = new DBOperations();

    // $db->getGroupByQuery($_POST['query']);
    $result = $db->getGroupByAdvertised($_POST['value']);

    $response['error'] = false;

    while($row = $result->fetch_assoc()){
      $studygroup_num = $row['id'];
      $studygroup_name = $row['name'];
      $studygroup_host = $row['host'];

      $posts[] = array('studygroup_num'=>$studygroup_num, 'studygroup_name'=>$studygroup_name, 'studygroup_host'=>$studygroup_host);
    }

    $response['posts'] = $posts;

  } else {
    $response['error'] = true;
    $response['message'] = "Required fields are missing";
  }
} else {
  $response['error'] = true;
  $response['message'] = "Invalid Request";
}

echo json_encode($response);
