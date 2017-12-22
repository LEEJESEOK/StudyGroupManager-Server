<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once '../includes/DBOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST') {
	$db = new DBOperations();

	//$db->advertisingGroup();

	$response['error'] = false;
	$response['num'] = $result['studygroup_num'];
	$response['name'] = $result['studygroup_name'];
	$response['purpose'] = $result['purpose'];
	$response['host'] = $result['studygrouphost_email'];
	$response['contents'] = $result['studygroup_contents'];
} else {
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}
echo json_encode($response);
