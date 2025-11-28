<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - Veterinaria Patitas Felices</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles-tienda.css') }}">
</head>
<body class="pagina-tienda">

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
                    <li class="nav-item"><a class="nav-link active" href="{{ route('tienda') }}">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('expediente') }}">Expediente</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#blog">Blog</a></li>
                    
                    @guest
                        <li class="nav-item">
                            <a class="btn boton-verde ms-2" href="{{ route('login') }}">Ingresar</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('carrito.ver') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle" id="badge-carrito" style="font-size: 0.7rem;">0</span>
                            </a>
                        </li>
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
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Encabezado -->
    <header class="encabezado-tienda text-white text-center">
        <div class="container py-5">
            <h1 class="fw-bold"><i class="fas fa-shopping-bag me-3"></i>Tienda de Productos</h1>
            <p class="lead">Todo lo que tu mascota necesita en un solo lugar 🛒</p>
        </div>
    </header>

    <!-- Filtros y búsqueda -->
    <section class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="buscarProducto" placeholder="Buscar productos...">
                </div>
            </div>
            <div class="col-md-4">
                <span class="badge bg-success fs-6">
                    <i class="fas fa-box me-2"></i>{{ $productos->count() }} productos disponibles
                </span>
            </div>
        </div>
    </section>

    <!-- Productos -->
    <section class="container my-5">
        @if($productos->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>No hay productos disponibles en este momento.
            </div>
        @else
            <div class="row g-4" id="contenedorProductos">
                @foreach($productos as $producto)
                    <div class="col-md-6 col-lg-4 producto-item">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('images/productos/producto_' . $producto->id_producto . '.jpg') }}" 
                                 class="card-img-top" 
                                 alt="{{ $producto->nombre }}"
                                 onerror="this.src='https://via.placeholder.com/350x250/28a745/white?text={{ urlencode($producto->nombre) }}'">
                            <div class="card-body">
                                <h5 class="card-title">{{ $producto->nombre }}</h5>
                                <p class="card-text texto-descripcion">{{ Str::limit($producto->descripcion, 80) }}</p>
                                <div class="precio-container">
                                    <span class="precio">${{ number_format($producto->precio, 0, ',', '.') }}</span>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-boxes me-1"></i>Stock: {{ $producto->inventario }} unidades
                                    </small>
                                </div>
                                <div class="d-flex gap-2 mt-3">
                                    <button class="btn btn-agregar flex-grow-1" 
                                            data-id="{{ $producto->id_producto }}"
                                            data-nombre="{{ $producto->nombre }}"
                                            data-precio="{{ $producto->precio }}">
                                        <i class="fas fa-cart-plus me-1"></i>Agregar
                                    </button>
                                    <button class="btn btn-detalle"
                                            data-nombre="{{ $producto->nombre }}"
                                            data-descripcion="{{ $producto->descripcion }}"
                                            data-precio="{{ $producto->precio }}"
                                            data-inventario="{{ $producto->inventario }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Footer -->
    <footer class="text-center py-3 text-white pie-pagina">
        <p class="mb-0">&copy; 2025 Veterinaria Patitas Felices - Todos los derechos reservados</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript básico para filtros -->
    <script>
        // CSRF Token
        const csrfToken = '{{ csrf_token() }}';

        // Actualizar badge del carrito al cargar
        function actualizarBadgeCarrito() {
            @auth
            fetch('{{ route("carrito.total") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('badge-carrito').textContent = data.total;
                });
            @endauth
        }
        actualizarBadgeCarrito();

        // Búsqueda simple
        document.getElementById('buscarProducto').addEventListener('input', function() {
            const busqueda = this.value.toLowerCase();
            const productos = document.querySelectorAll('.producto-item');
            
            productos.forEach(producto => {
                const titulo = producto.querySelector('.card-title').textContent.toLowerCase();
                const descripcion = producto.querySelector('.texto-descripcion').textContent.toLowerCase();
                
                if (titulo.includes(busqueda) || descripcion.includes(busqueda)) {
                    producto.style.display = 'block';
                } else {
                    producto.style.display = 'none';
                }
            });
        });

        // Agregar al carrito
        document.querySelectorAll('.btn-agregar').forEach(btn => {
            btn.addEventListener('click', function() {
                @guest
                    alert('Debes iniciar sesión para agregar productos al carrito');
                    window.location.href = '{{ route("login") }}';
                    return;
                @endguest

                const idProducto = this.dataset.id;
                const nombre = this.dataset.nombre;
                const precio = this.dataset.precio;
                
                fetch('{{ route("carrito.agregar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        id_producto: idProducto,
                        cantidad: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar badge
                        document.getElementById('badge-carrito').textContent = data.total_items;

                        // Modal de confirmación
                        const modal = document.createElement('div');
                        modal.className = 'modal fade show';
                        modal.style.display = 'block';
                        modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
                        modal.innerHTML = `
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body text-center py-4">
                                        <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                                        <h5>Agregado al carrito</h5>
                                        <p class="text-muted mb-0">"${nombre}"</p>
                                        <p class="text-success fw-bold">$${Number(precio).toLocaleString('es-CL')}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').remove()">Seguir comprando</button>
                                        <button type="button" class="btn boton-verde" onclick="location.href='{{ route('carrito.ver') }}'">Ver carrito</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(modal);
                        
                        setTimeout(() => {
                            if (document.body.contains(modal)) {
                                modal.remove();
                            }
                        }, 3000);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al agregar el producto');
                });
            });
        });

        // Modal de detalles del producto
        document.querySelectorAll('.btn-detalle').forEach(btn => {
            btn.addEventListener('click', function() {
                const nombre = this.dataset.nombre;
                const descripcion = this.dataset.descripcion;
                const precio = this.dataset.precio;
                const inventario = this.dataset.inventario;
                
                const modal = document.createElement('div');
                modal.className = 'modal fade show';
                modal.style.display = 'block';
                modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
                modal.innerHTML = `
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${nombre}</h5>
                                <button type="button" class="btn-close" onclick="this.closest('.modal').remove()"></button>
                            </div>
                            <div class="modal-body">
                                <p>${descripcion}</p>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-2"><strong>Precio:</strong></p>
                                        <p class="text-success fs-4 fw-bold">$${Number(precio).toLocaleString('es-CL')}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-2"><strong>Disponibilidad:</strong></p>
                                        <p class="text-muted">
                                            <i class="fas fa-boxes me-1"></i>${inventario} unidades en stock
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').remove()">Cerrar</button>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
            });
        });
    </script>
</body>
</html>
