<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio - Veterinaria Patitas Felices</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/styles-home.css') }}">
</head>

<body>

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
          <li class="nav-item"><a class="nav-link" href="#blog">Blog</a></li>
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
                  <li><a class="dropdown-item" href="{{ route('mis-citas') }}">Mis Citas</a></li>
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

  <!-- Hero con Carrusel -->
  <header class="banner position-relative text-center text-white">
    <!-- Carrusel de fondo -->
    <div id="carruselHero" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" class="d-block w-100 hero-img" alt="Veterinario con perro">
        </div>
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" class="d-block w-100 hero-img" alt="Gato en consulta">
        </div>
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" class="d-block w-100 hero-img" alt="Perro feliz">
        </div>
      </div>
    </div>
    
    <!-- Overlay y contenido -->
    <div class="hero-overlay"></div>
    <div class="hero-content d-flex align-items-center justify-content-center">
      <div class="container">
        <h1 class="display-4 fw-bold">Cuidamos a tus mascotas como parte de la familia</h1>
        <p class="lead">Servicios veterinarios de confianza para perros, gatos y más ...</p>
        <a href="#seccion-servicios" class="btn boton-verde btn-lg mt-3">Ver servicios</a>
      </div>
    </div>
  </header>

  <!-- Servicios -->
  <section id="seccion-servicios" class="py-5">
    <div class="container text-center">
      <h2 class="mb-4">Nuestros Servicios</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="{{ asset('images/imagenes_index/veterinaria.jpeg') }}" class="card-img-top" alt="Consulta General">
            <div class="card-body">
              <h5 class="card-title">Consulta General</h5>
              <p class="card-text">Revisiones completas para asegurar la salud de tu mascota.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="{{ asset('images/imagenes_index/respeta.png') }}" class="card-img-top" alt="Vacunación">
            <div class="card-body">
              <h5 class="card-title">Vacunación</h5>
              <p class="card-text">Vacunas esenciales para prevenir enfermedades comunes.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="{{ asset('images/imagenes_index/hola.png') }}" class="card-img-top" alt="Estética Canina">
            <div class="card-body">
              <h5 class="card-title">Estética Canina</h5>
              <p class="card-text">Baños, cortes y cuidados para que tu mascota luzca genial.</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Botón Ver más -->
      <div class="mt-4">
        <a href="{{ route('services') }}" class="btn boton-verde btn-lg">Ver más servicios</a>
      </div>
    </div>
  </section>

  <!-- Contacto -->
  <section id="seccion-contacto" class="py-5 text-center text-white seccion-contacto">
    <div class="container">
      <h2>¿Tienes dudas o quieres agendar una cita?</h2>
      <p class="mb-4">Estamos aquí para ayudarte a cuidar a tu mejor amigo 🐾</p>
      <a href="mailto:info@patitasfelices.com" class="btn btn-light btn-lg">Escríbenos</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-3 text-white pie-pagina">
    <p class="mb-0">&copy; 2025 Veterinaria Patitas Felices - Todos los derechos reservados</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>