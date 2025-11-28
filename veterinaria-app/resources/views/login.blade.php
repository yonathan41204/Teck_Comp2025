<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login / Registro - Veterinaria Patitas Felices</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/styles-login.css') }}">
</head>
<body class="pagina-login">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark barra-nav">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40" class="me-2">
        Pawsitive Care
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navegacion"
        aria-controls="navegacion" aria-expanded="false" aria-label="Menú">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navegacion">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Servicios</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('tienda') }}">Productos</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('expediente') }}">Expediente</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#blog">Blog</a></li>
          <li class="nav-item" id="menu-usuario">
            @guest
              <a class="btn boton-verde ms-2" href="{{ route('login') }}">Ingresar</a>
            @else
              <div class="dropdown">
                <button class="btn boton-verde ms-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ Auth::user()->nombre }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="{{ route('expediente') }}">Mi Expediente</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                    </form>
                  </li>
                </ul>
              </div>
            @endguest
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Contenedor -->
  <main class="contenedor-login">
    <!-- Imagen -->
    <div class="imagen-login"></div>

    <!-- Formulario -->
    <div class="formulario-login">
      <div class="caja-formulario shadow-lg">
        <h2 class="mb-4 text-center fw-bold">Bienvenido</h2>

        <ul class="nav nav-pills nav-justified mb-4" id="pestanas-auth" role="tablist">
          <li class="nav-item">
            <button class="nav-link active" id="tab-login" data-bs-toggle="tab" data-bs-target="#iniciar-sesion" type="button">Login</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="tab-registro" data-bs-toggle="tab" data-bs-target="#registro" type="button">Registro</button>
          </li>
        </ul>

        <div class="tab-content">
          <!-- Login -->
          <div class="tab-pane fade show active" id="iniciar-sesion" role="tabpanel">
<form method="POST" action="{{ route('procesar.login') }}">
    @csrf
    <div class="mb-3 input-group">
        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
    </div>
    <div class="mb-3 input-group">
        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
    </div>
    <button type="submit" class="btn boton-verde w-100">Ingresar</button>
</form>
          </div>

          <!-- Registro -->
          <div class="tab-pane fade" id="registro" role="tabpanel">
<form method="POST" action="{{ route('procesar.registro') }}">
    @csrf
    <div class="mb-3 input-group">
        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
        <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
    </div>
    <div class="mb-3 input-group">
    <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
    <input type="text" name="apellido" class="form-control" placeholder="Apellidos">
</div>
    <div class="mb-3 input-group">
        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
    </div>
    <div class="mb-3 input-group">
        <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
        <input type="tel" name="telefono" class="form-control" placeholder="Número telefónico" required>
    </div>
    <div class="mb-3 input-group">
        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
    </div>
    <button type="submit" class="btn boton-verde w-100">Registrarse</button>
</form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="text-center py-3 text-white pie-pagina">
    <p class="mb-0">&copy; 2025 Veterinaria Patitas Felices - Todos los derechos reservados</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>
