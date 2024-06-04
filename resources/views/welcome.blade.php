<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - Sistema de Alumnos</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body,
        html {
            font-family: 'Nunito', sans-serif;
            height: 100%;
            margin: 0;
            background: url('https://img.freepik.com/fotos-premium/panaderia-cafeteria-rosquillas_1015293-9875.jpg?w=740') no-repeat center center fixed; /* Imagen de fondo */
            background-size: cover; /* Ajuste de tamaño de la imagen de fondo */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hover:transform {
            transition: transform .2s ease-in-out;
        }

        .card {
            transition: box-shadow .3s, transform .3s;
            box-shadow: 0 2px 4px #eb8034;
            cursor: pointer;
            border-radius: 15px; /* Esquinas más redondeadas */
            overflow: hidden; /* Para que el contenido no se salga del borde redondeado */
        }

        .card:hover {
            box-shadow: 0 5px 15px #fff;
            transform: translateY(-5px);
        }

        .animate {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 10;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .login-container,
        .register-container {
            max-width: 400px;
            background-color: #d2b48c; /* Color café claro */
            border-radius: 15px; /* Esquinas más redondeadas */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
            animation: scaleIn .3s ease-in-out;
        }
        
        .login-title,
        .register-title {
            font-size: 24px;
            font-weight: bold;
            color: #8A492B;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
        }

        .form-control:focus {
            border-color: #8e2de2;
        }

        .btn-primary {
            background-color: #8B4513;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #A0522D;
        }

        .btn-secondary {
            background-color: #ccc;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #999;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            transform: scale(1.05);
        }

        /* New Style for PANADERÍA EL TRIUNFO */
        .title {
            font-size: 3rem;
            font-family: 'Great Vibes', cursive; /* Elegant script font */
            color: #8B4513; /* SaddleBrown color */
            text-shadow: 4px 4px 6px rgba(0, 0, 0, 0.3); /* Deeper shadow */
        }

        .rotating-image {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 100px; /* Ajusta el tamaño de la imagen según sea necesario */
            height: 100px; /* Ajusta el tamaño de la imagen según sea necesario */
            animation: rotate 4s linear infinite;
        }
        
        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="background-animate">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 flex animate">
        <div class="mr-8 hidden md:block">
            <img src="https://i.ibb.co/D5sLS9N/baker-817282.png" alt="Imagen de alumnos" class="rounded-lg">
        </div>
        <div class="card w-full md:w-4/5 lg:w-3/4 md:px-12 text-center">
            <h1 class="title">PANADERÍA EL TRIUNFO</h1>
            <p style="font-size: 1.2rem; color: #666;">Bienvenido al sistema de la Panadería El Triunfo</p>
            <div class="mb-4 flex justify-center space-x-4">
                <a href="#"
                   class="btn btn-primary btn-lg btn-block"
                   onclick="showLoginForm()">Iniciar sesión</a>
                <a href="#"
                   class="inline-block bg-gray-300 text-gray-800 font-semibold rounded-lg py-4 px-8 hover:bg-gray-400 transition-all duration-300"
                   onclick="showRegisterForm()">Registrarse</a>
            </div>
        </div>
    </div>

    <img src="https://i.ibb.co/7Q462yH/pngegg.png" alt="Imagen rotando" class="rotating-image"> <!-- Cambia URL_DE_LA_IMAGEN por la URL de tu imagen -->

    <!-- Overlay -->
    <div class="overlay" id="overlay">
        <div class="login-container">
            <div class="login-title">Inicio de Sesión</div>
            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->any())
                <div class="alert alert-danger">
                    <p>Por favor, corrige los siguientes errores:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        name="email" placeholder="Ingresa tu correo" tabindex="1"
                        value="{{ old('email', Cookie::get('email')) }}" autofocus required>
                    @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">Contraseña</label>
                    <a href="#" class="text-[#8B4513] hover:text-[#A0522D]"
                        onclick="event.preventDefault(); showPasswordResetForm();">¿Olvidaste tu contraseña?</a>
                    <input id="password" type="password" placeholder="Ingresa tu contraseña"
                        class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password"
                        tabindex="2" required>
                    @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="form-checkbox h-5 w-5 text-purple-600" {{ old('remember', Cookie::get('remember'))
                            ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 text-gray-700">Recuérdame</label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Iniciar Sesión
                    </button>
                    <button type="button" class="btn btn-secondary btn-lg btn-block" onclick="hideLoginForm()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="overlay" id="registerOverlay">
        <div class="register-container bg-white rounded-lg shadow-lg p-8">
            <div class="register-title">Registro de Usuario</div>
            <form id="registerForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstName">Nombre Completo:</label><span class="text-danger">*</span>
                            <input id="firstName" type="text"
                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                tabindex="1" placeholder="Ingresa tu nombre completo" value="{{ old('name') }}" required
                                autofocus>
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label><span class="text-danger">*</span>
                            <input id="email" type="email"
                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                placeholder="Ingresa tu dirección de correo" name="email" tabindex="1"
                                value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">Contraseña:</label><span
                                class="text-danger">*</span>
                            <input id="password" type="password"
                                class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}"
                                placeholder="Establece una contraseña" name="password" tabindex="2" required>
                            @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="control-label">Confirmar Contraseña:</label><span
                                class="text-danger">*</span>
                            <input id="password_confirmation" type="password" placeholder="Confirma tu contraseña"
                                class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                name="password_confirmation" tabindex="2">
                            @if ($errors->has('password_confirmation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Registrarse
                            </button>
                            <button type="button" class="btn btn-secondary btn-lg btn-block"
                                onclick="hideRegisterForm()">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="overlay fixed inset-0 z-50 flex items-center justify-center hidden" id="registerErrorModal">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="fas fa-user-times fa-3x text-red-500"></i>
            <h2 class="text-xl font-bold text-gray-800 mt-4">Error al Registrarse</h2>
            <p id="errorText" class="text-gray-600"></p> <!-- Aquí se mostrará el mensaje de error -->
            <button type="button" class="btn btn-secondary mt-4" onclick="hideRegisterErrorModal()">Aceptar</button>
        
        </div>
    </div>

    <div class="overlay fixed inset-0 z-50 flex items-center justify-center hidden" id="loginErrorModal">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="fas fa-user-times fa-3x text-red-500"></i>
            <h2 class="text-xl font-bold text-gray-800 mt-4">Error al Iniciar Sesión</h2>
            <p id="loginErrorText" class="text-gray-600"></p> <!-- Aquí se mostrará el mensaje de error -->
            <button type="button" class="btn btn-secondary mt-4" onclick="hideLoginErrorModal()">Aceptar</button>
        </div>
    </div>

    <!-- Overlay para recuperar contraseña -->
    <div class="overlay fixed inset-0 z-50 flex items-center justify-center" id="passwordResetOverlay"
        style="display: none;">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Recuperar Contraseña</h2>
                <p class="text-gray-600">Ingresa tu correo electrónico para recibir instrucciones para restablecer
                    tu contraseña.</p>
            </div>
            <form id="passwordResetForm" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="text-gray-700">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control" name="email" placeholder="Ingresa tu correo"
                        required>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                    <button type="button" class="btn btn-secondary"
                        onclick="hidePasswordResetForm()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="overlay fixed inset-0 z-50 flex items-center justify-center hidden" id="successModal">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="fas fa-check-circle fa-3x text-green-500"></i>
            <h2 class="text-xl font-bold text-gray-800 mt-4">Correo Enviado Correctamente</h2>
            <p class="text-gray-600">Recibirás un correo con las instrucciones para restablecer tu contraseña.</p>
        </div>
    </div>

    <div class="overlay fixed inset-0 z-50 flex items-center justify-center hidden" id="errorModal">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="fas fa-times-circle fa-3x text-red-500"></i>
            <h2 class="text-xl font-bold text-gray-800 mt-4">Error al Enviar el Correo</h2>
            <p class="text-gray-600">No se pudo enviar el correo de recuperación. Por favor, inténtalo de nuevo más
                tarde.</p>
        </div>
    </div>

    <!-- Fondo desenfocado -->
    <div class="overlay-blur fixed inset-0 bg-black bg-opacity-50 hidden" id="overlayBlur"></div>

    
    <script>
        document.getElementById('passwordResetForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            // Simulación de envío AJAX al servidor
            fetch('{{ route('password.email') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    // Aquí más cabeceras si es necesario
                }
            }).then(response => {
                if (response.ok) {
                    // Muestra el modal de éxito
                    document.getElementById('successModal').style.display = 'flex';
                    document.getElementById('overlayBlur').style.display = 'block';
                    setTimeout(function() {
                        document.getElementById('successModal').style.display = 'none';
                        document.getElementById('overlayBlur').style.display = 'none';
                    }, 2000);
                } else {
                    // Muestra el modal de error
                    document.getElementById('errorModal').style.display = 'flex';
                    document.getElementById('overlayBlur').style.display = 'block';
                    setTimeout(function() {
                        document.getElementById('errorModal').style.display = 'none';
                        document.getElementById('overlayBlur').style.display = 'none';
                    }, 2000);
                }
            }).catch(error => {
                // Muestra el modal de error en caso de falla de conexión
                document.getElementById('errorModal').style.display = 'flex';
                document.getElementById('overlayBlur').style.display = 'block';
                setTimeout(function() {
                    document.getElementById('errorModal').style.display = 'none';
                    document.getElementById('overlayBlur').style.display = 'none';
                }, 2000);
                console.error('Error de conexión:', error);
            });
        });

        function showLoginForm() {
            var registerOverlay = document.getElementById('registerOverlay');
            registerOverlay.style.display = 'none'; // Oculta el formulario de registro

            var passwordResetOverlay = document.getElementById('passwordResetOverlay');
            passwordResetOverlay.style.display = 'none'; // Oculta el formulario de recuperación de contraseña

            var overlay = document.getElementById('overlay');
            overlay.style.display = 'flex'; // Muestra el formulario de inicio de sesión

            hideBackgroundBlur(); // Oculta el fondo desenfocado
        }

        function hideLoginForm() {
            var overlay = document.getElementById('overlay');
            overlay.style.display = 'none';
            hideBackgroundBlur(); // Oculta el fondo desenfocado
        }

        function showRegisterForm() {
            var overlay = document.getElementById('overlay');
            overlay.style.display = 'none'; // Oculta el formulario de inicio de sesión

            var passwordResetOverlay = document.getElementById('passwordResetOverlay');
            passwordResetOverlay.style.display = 'none'; // Oculta el formulario de recuperación de contraseña

            var registerOverlay = document.getElementById('registerOverlay');
            registerOverlay.style.display = 'flex'; // Muestra el formulario de registro

            hideBackgroundBlur(); // Oculta el fondo desenfocado
        }

        function hideRegisterForm() {
            var registerOverlay = document.getElementById('registerOverlay');
            registerOverlay.style.display = 'none'; // Oculta el formulario de registro
            hideBackgroundBlur(); // Oculta el fondo desenfocado
        }

        function showPasswordResetForm() {
            var overlay = document.getElementById('overlay');
            overlay.style.display = 'none'; // Oculta el formulario de inicio de sesión

            var registerOverlay = document.getElementById('registerOverlay');
            registerOverlay.style.display = 'none'; // Oculta el formulario de registro

            var passwordResetOverlay = document.getElementById('passwordResetOverlay');
            passwordResetOverlay.style.display = 'flex'; // Muestra el formulario de recuperación de contraseña

            showBackgroundBlur(); // Muestra el fondo desenfocado
        }

        function hidePasswordResetForm() {
            var passwordResetOverlay = document.getElementById('passwordResetOverlay');
            passwordResetOverlay.style.display = 'none'; // Oculta el formulario de recuperación de contraseña
            hideBackgroundBlur(); // Oculta el fondo desenfocado
        }

        function showBackgroundBlur() {
            var overlayBlur = document.getElementById('overlayBlur');
            overlayBlur.style.display = 'block';
        }

        function hideBackgroundBlur() {
            var overlayBlur = document.getElementById('overlayBlur');
            overlayBlur.style.display = 'none';
        }

        function showRegisterErrorModal(errorMessage) {
            document.getElementById('registerErrorModal').style.display = 'flex';
            document.getElementById('errorText').innerText = errorMessage; // Mostrar el mensaje de error
            document.getElementById('overlayBlur').style.display = 'block'; // Mostrar el fondo desenfocado
        }

        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('{{ route('register') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    // Aquí más cabeceras si es necesario
                }
            }).then(response => {
                if (response.ok) {
                    exito();
                    // Si el registro es exitoso, puedes redirigir al usuario o mostrar un mensaje de éxito
                    window.location.reload(); // Esto recargará la página
                } else {
                    response.json().then(data => {
                        if (data.errors) {
                            var errorMessage = '';
                            for (const [key, value] of Object.entries(data.errors)) {
                                errorMessage += value + '\n';
                            }
                            showRegisterErrorModal(errorMessage.trim()); // Mostrar los mensajes de error
                        } else {
                            showRegisterErrorModal(data.message); // Mostrar el mensaje de error devuelto por el servidor
                        }
                    });
                }
            }).catch(error => {
                console.error('Error al registrar:', error);
                showRegisterErrorModal('Hubo un error al intentar registrarte. Por favor, intenta de nuevo más tarde.'); // Mensaje genérico en caso de error de conexión
            });
        });

        function exito() {
            Swal.fire({
                title: "Usuario Registrado!",
                text: "Usted ha sido registrado!",
                icon: "success"
            });
        }

        function hideRegisterErrorModal() {
            document.getElementById('registerErrorModal').style.display = 'none';
            document.getElementById('overlayBlur').style.display = 'none'; // Oculta el fondo desenfocado
        }

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('{{ route('login') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    // Aquí más cabeceras si es necesario
                }
            }).then(response => {
                if (response.ok) {
                    // Si el inicio de sesión es exitoso, puedes redirigir al usuario o hacer otras acciones necesarias
                    window.location.reload(); // Esto recargará la página
                } else {
                    response.json().then(data => {
                        if (data.errors) {
                            var errorMessage = '';
                            for (const [key, value] of Object.entries(data.errors)) {
                                errorMessage += value + '\n';
                            }
                            showLoginErrorModal(errorMessage.trim()); // Mostrar los mensajes de error
                        } else {
                            showLoginErrorModal(data.message); // Mostrar el mensaje de error devuelto por el servidor
                        }
                    });
                }
            }).catch(error => {
                console.error('Error al iniciar sesión:', error);
                showLoginErrorModal('Hubo un error al intentar iniciar sesión. Por favor, intenta de nuevo más tarde.'); // Mensaje genérico en caso de error de conexión
            });
        });

        function showLoginErrorModal(errorMessage) {
            document.getElementById('loginErrorModal').style.display = 'flex';
            document.getElementById('loginErrorText').innerText = errorMessage; // Mostrar el mensaje de error
            document.getElementById('overlayBlur').style.display = 'block'; // Mostrar el fondo desenfocado
        }

        function hideLoginErrorModal() {
            document.getElementById('loginErrorModal').style.display = 'none';
            document.getElementById('overlayBlur').style.display = 'none'; // Oculta el fondo desenfocado
        }
    </script>
</body>

</html>
