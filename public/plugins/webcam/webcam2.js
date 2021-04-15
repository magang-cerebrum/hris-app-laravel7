
    function take_snapshot() {
        Webcam.snap(function(data_uri) {
        document.getElementById('results').innerHTML = '<img id="base64image" src="'+data_uri+'"/><button onclick="SaveSnap();">Save Snap</button>';
    });
    }
    function ShowCam(){
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 100
        });
        Webcam.attach('#my_camera');
    }
    function SaveSnap(){
        document.getElementById("loading").innerHTML="Saving, please wait...";
        var file =  document.getElementById("base64image").src;
        var formdata = new FormData();
        formdata.append("base64image", file);
        var ajax = new XMLHttpRequest();
        ajax.addEventListener("load", function(event) { uploadcomplete(event);}, false);
        ajax.open("POST", "upload.php");
        ajax.send(formdata);
    }
    function uploadcomplete(event){
        document.getElementById("loading").innerHTML="";
        var image_return=event.target.responseText;
        var showup=document.getElementById("uploaded").src=image_return;
    }
    window.onload= ShowCam;