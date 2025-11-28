<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expediente - Veterinaria Patitas Felices</title>
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
    <header class="encabezado-expediente text-white text-center">
        <div class="container py-5">
            <h1 class="fw-bold"><i class="fas fa-file-medical me-3"></i>Expediente Médico</h1>
            <p class="lead">Registra y mantén actualizada la información médica de tu mascota 🐾</p>
        </div>
    </header>

    <!-- Formulario de Expediente -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Tabs para Nuevo Expediente y Ver Expedientes -->
                <ul class="nav nav-tabs mb-4" id="expedienteTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ver-tab" data-bs-toggle="tab" data-bs-target="#ver-expedientes" type="button" role="tab">
                            <i class="fas fa-list me-2"></i>Mis Expedientes
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nuevo-tab" data-bs-toggle="tab" data-bs-target="#nuevo-expediente" type="button" role="tab">
                            <i class="fas fa-plus me-2"></i>Nuevo Expediente
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="expedienteTabContent">
                    <!-- Tab: Ver Expedientes -->
                    <div class="tab-pane fade" id="ver-expedientes" role="tabpanel">
                        @if($mascotas->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>Aún no tienes expedientes registrados. Crea uno en la pestaña "Nuevo Expediente".
                            </div>
                        @else
                            <div class="row g-4">
                                @foreach($mascotas as $mascota)
                                    <div class="col-md-6">
                                        <div class="card shadow-sm h-100">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0"><i class="fas fa-paw me-2"></i>{{ $mascota->nombre_mascota }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-muted mb-3">Datos de la Mascota</h6>
                                                <ul class="list-unstyled mb-3">
                                                    <li><strong>Especie:</strong> {{ ucfirst($mascota->especie) }}</li>
                                                    <li><strong>Raza:</strong> {{ $mascota->raza ?? 'No especificada' }}</li>
                                                    <li><strong>Edad:</strong> {{ $mascota->edad ? $mascota->edad . ' años' : 'No especificada' }}</li>
                                                </ul>

                                                @if($mascota->historialMedico)
                                                    <hr>
                                                    <h6 class="text-muted mb-3">Historial Médico</h6>
                                                    <ul class="list-unstyled mb-0">
                                                        <li><strong>Alergias:</strong> {{ $mascota->historialMedico->alergias ?? 'No' }}</li>
                                                        <li><strong>Condiciones crónicas:</strong> {{ $mascota->historialMedico->condiciones_cronicas ?? 'Ninguna' }}</li>
                                                        <li><strong>Vacunas:</strong> {{ $mascota->historialMedico->vacunas ?? 'No especificadas' }}</li>
                                                        @if($mascota->historialMedico->notas)
                                                            <li><strong>Notas:</strong> {{ $mascota->historialMedico->notas }}</li>
                                                        @endif
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="card-footer text-muted small">
                                                Registro #{{ $mascota->id_registro }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Tab: Nuevo Expediente -->
                    <div class="tab-pane fade show active" id="nuevo-expediente" role="tabpanel">
                        <div class="card shadow-lg">
                            <div class="card-body p-4">
                                <form id="formularioExpediente" method="POST" action="{{ route('expediente.guardar') }}">
                                    @csrf
                            <!-- Datos de la Mascota (sencillo) -->
                            <div class="seccion-formulario mb-4">
                                <h4 class="titulo-seccion mb-3">
                                    <i class="fas fa-dog me-2"></i>Datos de la mascota
                                </h4>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="nombre_mascota" class="form-label">Nombre de la mascota *</label>
                                        <input type="text" class="form-control" id="nombre_mascota" name="nombre_mascota" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="especie" class="form-label">Especie *</label>
                                        <select class="form-select" id="especie" name="especie" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="perro">Perro</option>
                                            <option value="gato">Gato</option>
                                            <option value="ave">Ave</option>
                                            <option value="conejo">Conejo</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="raza" class="form-label">Raza</label>
                                        <input type="text" class="form-control" id="raza" name="raza">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="edad" class="form-label">Edad</label>
                                        <input type="text" class="form-control" id="edad" name="edad" placeholder="Ej: 2 años">
                                    </div>
                                </div>
                            </div>

                            <!-- Estado sanitario compacto -->
                            <div class="seccion-formulario mb-4">
                                <h4 class="titulo-seccion mb-3"><i class="fas fa-heartbeat me-2"></i>Estado sanitario</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="alergias" class="form-label">Alergias</label>
                                        <select class="form-select" id="alergias" name="alergias">
                                            <option value="no">No</option>
                                            <option value="si">Sí</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="condiciones_cronicas" class="form-label">Condiciones crónicas (breve)</label>
                                        <input type="text" class="form-control" id="condiciones_cronicas" name="condiciones_cronicas" placeholder="Ej: Diabetes">
                                    </div>
                                </div>
                            </div>

                            <!-- Vacunas simplificadas -->
                            <div class="seccion-formulario mb-4">
                                <h4 class="titulo-seccion mb-3"><i class="fas fa-syringe me-2"></i>Vacunas</h4>
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="vac_rabia" name="vac_rabia" value="1">
                                            <label class="form-check-label" for="vac_rabia">Rabia</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="vac_parvovirus" name="vac_parvovirus" value="1">
                                            <label class="form-check-label" for="vac_parvovirus">Parvovirus</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="vac_triple" name="vac_triple" value="1">
                                            <label class="form-check-label" for="vac_triple">Triple</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="vac_otras" class="form-label">Otras vacunas / fechas (opcional)</label>
                                        <input type="text" class="form-control" id="vac_otras" name="vac_otras" placeholder="Ej: VacunaX:dd/mm/aaaa">
                                    </div>
                                </div>
                            </div>

                            <!-- Notas -->
                            <div class="seccion-formulario mb-4">
                                <h4 class="titulo-seccion mb-3"><i class="fas fa-info-circle me-2"></i>Notas</h4>
                                <textarea class="form-control" id="notas_adicionales" name="notas_adicionales" rows="3" placeholder="Observaciones relevantes"></textarea>
                            </div>

                            <!-- Botones -->
                            <div class="cuadricula-botones d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-secondary me-md-2">Limpiar</button>
                                <button type="submit" class="btn boton-verde"><i class="fas fa-save me-1"></i>Guardar expediente</button>
                            </div>
                        </form>
                    </div>
                </div>
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