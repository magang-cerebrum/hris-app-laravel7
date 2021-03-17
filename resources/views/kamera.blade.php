<!doctype html>
<html>
<head>
    <title>WebcamJS Test Page</title>
    <script src="https://s0.2mdn.net/instream/video/client.js" async="" type="text/javascript"></script>
</head>
<body>
    <div class="">
        <video autoplay="true" id="video-webcam">
            Izinkan untuk Mengakses Webcam untuk Demo
        </video>
        <button onclick="takeSnapshot()">Ambil Gambar</button>
    </div>
    <script>
        var video = document.querySelector("#video-webcam");
    
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
    
        if (navigator.getUserMedia) {
            navigator.getUserMedia({ video: true }, handleVideo, videoError);
        }
    
        function handleVideo(stream) {
            video.src = window.URL.createObjectURL(stream);
            console.log(stream);
        }
    
        function videoError(e) {
            // do something
            alert("Izinkan menggunakan webcam untuk demo!")
        }
    
        function takeSnapshot() {
            var img = document.createElement('img');
            var context;
            var width = video.offsetWidth
                    , height = video.offsetHeight;
    
            canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
    
            context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, width, height);
    
            img.src = canvas.toDataURL('image/png');
            document.body.appendChild(img);
        }
    
    </script>
    
</body>
</html>