<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas - Veterinaria Patitas Felices</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles-expediente.css') }}">
</head>
<body class="pagina-expediente">

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
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Encabezado -->
    <header class="encabezado-expediente text-white text-center">
        <div class="container py-5">
            <h1 class="fw-bold"><i class="fas fa-calendar-alt me-3"></i>Mis Citas</h1>
            <p class="lead">Revisa y gestiona tus citas agendadas 📋</p>
        </div>
    </header>

    <!-- Lista de Citas -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mb-3 text-end">
                    <a href="{{ route('services') }}" class="btn boton-verde">
                        <i class="fas fa-plus me-2"></i>Agendar Nueva Cita
                    </a>
                </div>

                @if($citas->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>Aún no tienes citas agendadas. 
                        <a href="{{ route('services') }}" class="alert-link">Agenda tu primera cita aquí</a>.
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($citas as $cita)
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-calendar-check me-2"></i>
                                            {{ $cita->servicio->nombre }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2">
                                            <i class="fas fa-info-circle me-2 text-muted"></i>
                                            <strong>Descripción:</strong> {{ $cita->servicio->descripcion }}
                                        </p>
                                        <p class="mb-2">
                                            <i class="fas fa-calendar me-2 text-primary"></i>
                                            <strong>Fecha:</strong> {{ $cita->fecha_cita->format('d/m/Y') }}
                                        </p>
                                        <p class="mb-2">
                                            <i class="fas fa-clock me-2 text-success"></i>
                                            <strong>Hora:</strong> {{ $cita->fecha_cita->format('H:i') }}
                                        </p>
                                        @if($cita->servicio->precio > 0)
                                            <p class="mb-0">
                                                <i class="fas fa-tag me-2 text-warning"></i>
                                                <strong>Precio:</strong> ${{ number_format($cita->servicio->precio, 0, ',', '.') }}
                                            </p>
                                        @endif
                                        @if($cita->pago)
                                            <hr>
                                            <div class="mt-2">
                                                <p class="mb-1">
                                                    <i class="fas fa-credit-card me-2 text-info"></i>
                                                    <strong>Método de pago:</strong> {{ ucfirst($cita->pago->metodo_pago) }}
                                                </p>
                                                <p class="mb-0">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    <strong>Estado del pago:</strong> 
                                                    @if($cita->pago->estado == 'pendiente')
                                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                                    @elseif($cita->pago->estado == 'completado')
                                                        <span class="badge bg-success">Completado</span>
                                                    @elseif($cita->pago->estado == 'pagado')
                                                        <span class="badge bg-success">Pagado</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($cita->pago->estado) }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer text-muted small d-flex justify-content-between align-items-center">
                                        <span>Cita #{{ $cita->id_cita }}</span>
                                        @if($cita->fecha_cita->isFuture())
                                            <span class="badge bg-success">Próxima</span>
                                        @else
                                            <span class="badge bg-secondary">Pasada</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
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
