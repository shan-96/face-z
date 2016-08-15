<?php
// This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
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

$data1=file_get_contents('assets/girl1.jpg');

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
	//echo $ID1."<br>";
}
catch (HttpException $ex)
{
    echo $ex;
}

$request2 = new Http_Request2('https://api.projectoxford.ai/face/v1.0/detect');
$url2 = $request2->getUrl();

$headers2 = array(
    // Request headers
    'Content-Type' => 'application/octet-stream',
    'Ocp-Apim-Subscription-Key' => '59878476b7cc4004a58499dac7c8c5fc',
);

$request2->setHeader($headers2);

$parameters2 = array(
    // Request parameters
    'returnFaceId' => 'true',
    'returnFaceLandmarks' => 'false',
    //'returnFaceAttributes' => 'age,gender',
);

$url2->setQueryVariables($parameters1);

$request2->setMethod(HTTP_Request2::METHOD_POST);

$data2=file_get_contents('assets/girl2.jpg');

//$data2 = array('url'=>'http://www.goldennumber.net/wp-content/uploads/2013/08/florence-colgate-england-most-beautiful-face.jpg');
//$data2 = json_encode($data2);

// Request body
$request2->setBody($data2);

try
{
    $response2 = $request2->send();
	//echo $response2->getBody()."<br>";
	$dataArray2 = json_decode($response2->getBody(),true);
	$ID2 = $dataArray2[0]['faceId'];
	//echo $ID2."<br>";
}
catch (HttpException $ex)
{
    echo $ex;
}

// This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)

$request3 = new Http_Request2('https://api.projectoxford.ai/face/v1.0/verify');
$url3 = $request3->getUrl();
$STATUS = 0;

$headers3 = array(
    // Request headers
    'Content-Type' => 'application/json',
    'Ocp-Apim-Subscription-Key' => '59878476b7cc4004a58499dac7c8c5fc',
);

$request3->setHeader($headers3);

$parameters3 = array(
    // Request parameters
);

$url3->setQueryVariables($parameters3);

$request3->setMethod(HTTP_Request2::METHOD_POST);

// Request body
$data3 = array('faceId1' => $ID1,
			  'faceId2' => $ID2,
);
$data3 = json_encode($data3);
$request3->setBody($data3);

try
{
    $response3 = $request3->send();
	//echo $response3->getBody()."<br>";
    $dataArray3 = json_decode($response3->getBody(),true);
	if(! $dataArray3['isIdentical']){
		echo "image mismatch!";
		$STATUS = 400;
	}else if($dataArray3['confidence'] <= 0.4){
		echo "warning!";
		$STATUS = 600;
	}else{
		echo "success";
		$STATUS = 200;
	}
}
catch (HttpException $ex)
{
    echo $ex;
}


?>