<?php
require_once 'HTTP/Request2.php';

$request1 = new Http_Request2('https://api.projectoxford.ai/face/v1.0/detect');
$url1 = $request1->getUrl();

$headers1 = array(
    // Request headers
    'Content-Type' => 'application/octet-stream',
    'Ocp-Apim-Subscription-Key' => '59878476b7cc4004a58499dac7c8c5fc',
);

$request1->setHeader($headers1);

$parameters1 = array(
    // Request parameters
    'returnFaceId' => 'true',
    'returnFaceLandmarks' => 'false',
    //'returnFaceAttributes' => 'age,gender',
);

$url1->setQueryVariables($parameters1);

$request1->setMethod(HTTP_Request2::METHOD_POST);

$data1=file_get_contents('uploads/user20160812071616.jpg');

//$data1 = array('url'=>'http://www.permanentmakeup-london.co.uk/images/diffeyebrows/perfect-shaped-brows-for-this-face-yours-will-be-created-to-suit-you.jpg');
//$data1 = json_encode($data1);

// Request body
$request1->setBody($data1);

try
{
    $response1 = $request1->send();
	//echo $response1->getBody()."<br>";
	$dataArray1 = json_decode($response1->getBody(),true);
	$ID1 = $dataArray1[0]['faceId'];
	echo $ID1."<br>";
}
catch (HttpException $ex)
{
    echo $ex;
}
?>