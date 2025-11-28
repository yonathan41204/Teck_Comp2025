<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Servicios - Veterinaria Patitas Felices</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/styles-services.css') }}">
</head>
<body class="pagina-servicios">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark barra-nav">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40" class="me-2">
        Pawsitive Care
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navegacion" aria-controls="navegacion" aria-expanded="false" aria-label="Menú">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navegacion">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ route('services') }}">Servicios</a></li>
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

  <!-- Encabezado -->
  <header class="encabezado-servicios text-white text-center">
    <div class="container py-5">
      <h1 class="fw-bold">Nuestros Servicios</h1>
      <p class="lead">Cuidamos de tus mascotas con amor y profesionalismo 🐾</p>
    </div>
  </header>

  <!-- Lista de Servicios -->
  <main class="container my-5">
    @if($servicios->isEmpty())
      <div class="alert alert-info text-center">
        <i class="fas fa-info-circle me-2"></i>No hay servicios disponibles en este momento.
      </div>
    @else
      <div class="row g-4">
        @foreach($servicios as $servicio)
          <div class="col-md-4">
            <div class="card h-100 shadow-sm">
              <img src="{{ asset('images/servicios/servicio_' . $servicio->id_servicio . '.jpg') }}" 
                   class="card-img-top" 
                   alt="{{ $servicio->nombre }}"
                   onerror="this.src='{{ asset('images/servicios/default.jpg') }}'">
              <div class="card-body">
                <h5 class="card-title">{{ $servicio->nombre }}</h5>
                <p class="card-text">{{ $servicio->descripcion }}</p>
                @if($servicio->precio > 0)
                  <p class="text-success fw-bold mb-0">
                    <i class="fas fa-tag me-1"></i>${{ number_format($servicio->precio, 0, ',', '.') }}
                  </p>
                @endif
              </div>
              <div class="card-footer bg-white border-0 pb-3">
                <a href="{{ route('agendar.cita', $servicio->id_servicio) }}" class="btn boton-verde w-100">
                  <i class="fas fa-calendar-plus me-2"></i>Agendar Cita
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </main>

  <!-- Footer -->
  <footer class="text-center py-3 text-white pie-pagina">
    <p class="mb-0">&copy; 2025 Veterinaria Patitas Felices - Todos los derechos reservados</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- JavaScript Simple -->
  <script>
    // Función simple para cerrar sesión
    function cerrarSesion() {
      if (confirm('¿Cerrar sesión?')) {
        location.reload();
      }
    }
  </script>
</body>
</html>
