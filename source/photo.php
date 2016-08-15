<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>face-z</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
<button id="take">click photo</button><br />
<video id="v"></video>
<canvas id="canvas" style="display:none;"></canvas>
<img src="http://placehold.it/300&text=Your%20image%20here%20..." id="photo" alt="photo" />
<script>
    ;(function(){
        function userMedia(){
            return navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia || null;

        }


        // Now we can use it
        if( userMedia() ){
            var videoPlaying = false;
            var constraints = {
                //video: true,
				video: {
					mandatory:{
						minWidth: 1280,
						minHeight: 720
					}
				},
                audio:false
            };
            var video = document.getElementById('v');

            var media = navigator.getUserMedia(constraints, function(stream){

                // URL Object is different in WebKit
                var url = window.URL || window.webkitURL;

                // create the url and set the source of the video element
                video.src = url ? url.createObjectURL(stream) : stream;

                // Start the video
                video.play();
				video.width = 0;		//here is the size of video.
				video.height = 0;
                videoPlaying  = true;
            }, function(error){
                console.log("ERROR");
                console.log(error);
            });
			
			$(document).ready(setInterval(function(){
				$("#take").trigger('click');
			},10000));


            // Listen for user click on the "take a photo" button
            document.getElementById('take').addEventListener('click', function(){
                if (videoPlaying){
                    var canvas = document.getElementById('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    canvas.getContext('2d').drawImage(video, 0, 0);
                    var data = canvas.toDataURL('image/webp');
                    document.getElementById('photo').setAttribute('src', data);
					//convert canvas to base64
					var base64 = canvas.toDataURL("image/jpeg");
					$.post("uploadFile.php",{data:base64},function(response,status){console.log(response);});
					if(response=="image mismatch!"){
						
					}
                }
            }, false);



        } else {
            alert("you browser does not support getUserMedia.");
        }
    })();
</script>
</body>
</html>

<?php
	
?>

<!--

$base64 =  "<script>document.writeln(base64);</script>";
$username = "user";
$filename = $username.date('YmdHis') . '.jpg';
function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen($output_file, "wb"); 
    $data = explode(',', $base64_string);
    fwrite($ifp, base64_decode($data[0])); 
    fclose($ifp); 
    return $output_file; 
}
$base64 = str_replace("data:image/jpeg;base64,","",$base64);
echo $base64;
$my_base64_string = $base64;
echo $base64;
echo $my_base64_string;
$image = base64_to_jpeg( $my_base64_string, "uploads/".$filename );


--------------------------------------------

data:image/jpeg;base64,


-------------------------------------------------
	
	$(document).ready(setInterval(function(){
				$("#take").trigger('click');
			},10000));
			
			$(document).ready(function(){
				$("#take").click(function(){
						if (videoPlaying){
						var canvas = document.getElementById('canvas');
						canvas.width = video.videoWidth;
						canvas.height = video.videoHeight;
						canvas.getContext('2d').drawImage(video, 0, 0);
						var data = canvas.toDataURL('image/webp');
						document.getElementById('photo').setAttribute('src', data);
						//convert canvas to base64
						var base64 = canvas.toDataURL("image/jpeg");
						$.post("uploadFile.php",{data:base64},function(response,status){alert(response);});
						//window.location="uploadFile.php";
						//alert(base64);
					}
				});
			});

-->