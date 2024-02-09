<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy New Year 3D Model</title>
    <style>
        body { margin: 0; overflow: hidden; }
        canvas { width: 100%; height: 100%; display: block; }
    </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>

<script>
    var scene = new THREE.Scene();
    var ambientLight = new THREE.AmbientLight(0xffffff, 1);
    scene.add(ambientLight);

    var directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(10, 10, 10);
    scene.add(directionalLight);

    var directionalLight2 = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight2.position.set(-10, -10, -10);
    scene.add(directionalLight2);

    var camera = new THREE.PerspectiveCamera(90, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 6;

    var renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setClearColor("black");
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    var video = document.createElement('video');
    video.src = '{{asset('images/Y2meta.mp4')}}';
    video.crossOrigin = 'anonymous';
    video.loop = true;
    video.muted = true;
    video.play();

    var texture = new THREE.VideoTexture(video);
    var material = new THREE.MeshBasicMaterial({ map: texture });
    var planeGeometry = new THREE.PlaneGeometry(53, 30);
    var plane = new THREE.Mesh(planeGeometry, material);
    plane.position.z = -6;
    scene.add(plane);

    var geometry = new THREE.SphereGeometry(1.8, 23, 23);
    var material = new THREE.MeshBasicMaterial({ color: "#68C0E8", wireframe: true });
    var sphere = new THREE.Mesh(geometry, material);
    scene.add(sphere);

    var loader = new THREE.FontLoader();
    loader.load('https://threejs.org/examples/fonts/helvetiker_regular.typeface.json', function(font) {
        var path = window.location.pathname; // Phần đường dẫn sau host
        var search = window.location.search; // Chuỗi truy vấn, bắt đầu bằng ?
        var hash = window.location.hash; // Phần hash, bắt đầu bằng #

        // Ghép chúng lại với nhau để tạo thành chuỗi đầy đủ
        var textToShow = path + search + hash;

        // Loại bỏ các dấu gạch chéo đầu tiên nếu có
        textToShow = textToShow.startsWith('/') ? textToShow.substr(1) : textToShow;

        // Decode chuỗi để chuyển đổi các kí tự mã hóa thành kí tự thường
        textToShow = decodeURIComponent(textToShow);

        var textGeometry = new THREE.TextGeometry(textToShow, {
            font: font,
            size: 0.5,
            height: 0.3,
            curveSegments: 15,
            bevelEnabled: false,
            letterSpacing: 1
        });

        var metalMaterial = new THREE.MeshStandardMaterial({
            color: "#68C0E8",
            metalness: 0,
            roughness: 0.4,
            opacity: 1,
            transparent: true,
        });

        var textureLoader = new THREE.TextureLoader();
        textureLoader.load('{{asset('images/Aluminium 6_roughness.jpeg')}}', function(texture) {
            metalMaterial.map = texture;
            metalMaterial.needsUpdate = true;
        });

        var text = new THREE.Mesh(textGeometry, metalMaterial);
        text.position.set(-2.5, 2, 2);
        scene.add(text);


        animateText(text);

        function animateText(text) {
            // Đặt biến để lưu trữ hướng di chuyển và vị trí ban đầu của văn bản
            var direction = 1; // 1 cho di chuyển sang phải, -1 cho di chuyển sang trái
            var initialPosition = text.position.x;

            // Hàm vòng lặp để thực hiện chuyển động liên tục
            function move() {
                // Thay đổi vị trí của văn bản theo hướng hiện tại
                text.position.x += direction * 0.05; // Điều chỉnh tốc độ di chuyển theo ý muốn

                // Kiểm tra nếu văn bản đã đạt tới ranh giới, thay đổi hướng di chuyển
                if (Math.abs(text.position.x - initialPosition) > 4) { // Điều chỉnh khoảng cách giữa các chuyển động
                    direction *= -1; // Đảo hướng di chuyển
                }

                // Gọi lại hàm move() sau một khoảng thời gian ngắn để tạo hiệu ứng liên tục
                requestAnimationFrame(move);
            }

            // Bắt đầu hiệu ứng chuyển động
            move();
        }
    });

    function animate() {
        requestAnimationFrame(animate);
        sphere.rotation.x += 0.01;
        sphere.rotation.y += 0.01;
        renderer.render(scene, camera);
    }

    animate();
</script>
</body>
</html>
