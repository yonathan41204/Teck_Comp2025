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
                <select class="form-select" id="filtroCategoria">
                    <option value="todos">Todas las categorías</option>
                    <option value="alimentos">Alimentos</option>
                    <option value="juguetes">Juguetes</option>
                    <option value="accesorios">Accesorios</option>
                    <option value="higiene">Higiene</option>
                    <option value="salud">Salud</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Productos -->
    <section class="container my-5">
        <div class="row g-4" id="contenedorProductos">
            <!-- Alimentos -->
            <div class="col-md-6 col-lg-4 producto-item" data-categoria="alimentos">
                <div class="card h-100 shadow-sm">
                    <div class="badge-categoria badge-alimentos">Alimentos</div>
                    <img src="https://via.placeholder.com/350x250/4CAF50/white?text=Alimento+Premium" class="card-img-top" alt="Alimento Premium">
                    <div class="card-body">
                        <h5 class="card-title">Alimento Premium para Perros</h5>
                        <p class="card-text texto-descripcion">Comida balanceada de alta calidad para perros adultos.</p>
                        <div class="precio-container">
                            <span class="precio">$25.990</span>
                            <span class="precio-anterior">$30.990</span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-agregar flex-grow-1"><i class="fas fa-cart-plus me-1"></i>Agregar</button>
                            <button class="btn btn-detalle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 producto-item" data-categoria="alimentos">
                <div class="card h-100 shadow-sm">
                    <div class="badge-categoria badge-alimentos">Alimentos</div>
                    <img src="https://via.placeholder.com/350x250/4CAF50/white?text=Alimento+Gatos" class="card-img-top" alt="Alimento para Gatos">
                    <div class="card-body">
                        <h5 class="card-title">Alimento Premium para Gatos</h5>
                        <p class="card-text texto-descripcion">Nutrición completa para gatos de todas las edades.</p>
                        <div class="precio-container">
                            <span class="precio">$22.990</span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-agregar flex-grow-1"><i class="fas fa-cart-plus me-1"></i>Agregar</button>
                            <button class="btn btn-detalle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Juguetes -->
            <div class="col-md-6 col-lg-4 producto-item" data-categoria="juguetes">
                <div class="card h-100 shadow-sm">
                    <div class="badge-categoria badge-juguetes">Juguetes</div>
                    <img src="https://via.placeholder.com/350x250/2196F3/white?text=Pelota+Interactiva" class="card-img-top" alt="Pelota Interactiva">
                    <div class="card-body">
                        <h5 class="card-title">Pelota Interactiva</h5>
                        <p class="card-text texto-descripcion">Pelota con sonido para mantener a tu mascota activa.</p>
                        <div class="precio-container">
                            <span class="precio">$8.990</span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-agregar flex-grow-1"><i class="fas fa-cart-plus me-1"></i>Agregar</button>
                            <button class="btn btn-detalle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 producto-item" data-categoria="juguetes">
                <div class="card h-100 shadow-sm">
                    <div class="badge-categoria badge-juguetes">Juguetes</div>
                    <img src="https://via.placeholder.com/350x250/2196F3/white?text=Hueso+Masticable" class="card-img-top" alt="Hueso Masticable">
                    <div class="card-body">
                        <h5 class="card-title">Hueso Masticable</h5>
                        <p class="card-text texto-descripcion">Juguete resistente ideal para la dentadura de tu perro.</p>
                        <div class="precio-container">
                            <span class="precio">$5.990</span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-agregar flex-grow-1"><i class="fas fa-cart-plus me-1"></i>Agregar</button>
                            <button class="btn btn-detalle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesorios -->
            <div class="col-md-6 col-lg-4 producto-item" data-categoria="accesorios">
                <div class="card h-100 shadow-sm">
                    <div class="badge-categoria badge-accesorios">Accesorios</div>
                    <img src="https://via.placeholder.com/350x250/FF9800/white?text=Collar+Ajustable" class="card-img-top" alt="Collar Ajustable">
                    <div class="card-body">
                        <h5 class="card-title">Collar Ajustable</h5>
                        <p class="card-text texto-descripcion">Collar cómodo y resistente con diseños variados.</p>
                        <div class="precio-container">
                            <span class="precio">$6.990</span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-agregar flex-grow-1"><i class="fas fa-cart-plus me-1"></i>Agregar</button>
                            <button class="btn btn-detalle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 producto-item" data-categoria="accesorios">
                <div class="card h-100 shadow-sm">
                    <div class="badge-categoria badge-accesorios">Accesorios</div>
                    <img src="https://via.placeholder.com/350x250/FF9800/white?text=Correa+Retractil" class="card-img-top" alt="Correa Retráctil">
                    <div class="card-body">
                        <h5 class="card-title">Correa Retráctil</h5>
                        <p class="card-text texto-descripcion">Correa extendible de 5 metros para paseos cómodos.</p>
                        <div class="precio-container">
                            <span class="precio">$12.990</span>
                            <span class="precio-anterior">$15.990</span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-agregar flex-grow-1"><i class="fas fa-cart-plus me-1"></i>Agregar</button>
                            <button class="btn btn-detalle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Higiene -->
            <div class="col-md-6 col-lg-4 producto-item" data-categoria="higiene">
                <div class="card h-100 shadow-sm">
                    <div class="badge-categoria badge-higiene">Higiene</div>
                    <img src="https://via.placeholder.com/350x250/9C27B0/white?text=Shampoo+Mascotas" class="card-img-top" alt="Shampoo para Mascotas">
                    <div class="card-body">
                        <h5 class="card-title">Shampoo para Mascotas</h5>
                        <p class="card-text texto-descripcion">Shampoo hipoalergénico con aroma suave.</p>
                        <div class="precio-container">
                            <span class="precio">$7.990</span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-agregar flex-grow-1"><i class="fas fa-cart-plus me-1"></i>Agregar</button>
                            <button class="btn btn-detalle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 producto-item" data-categoria="higiene">
                <div class="card h-100 shadow-sm">
                    <div class="badge-categoria badge-higiene">Higiene</div>
                    <img src="https://via.placeholder.com/350x250/9C27B0/white?text=Cepillo+Dental" class="card-img-top" alt="Cepillo Dental">
                    <div class="card-body">
                        <h5 class="card-title">Kit de Cepillo Dental</h5>
                        <p class="card-text texto-descripcion">Cepillo y pasta dental para la higiene bucal.</p>
                        <div class="precio-container">
                            <span class="precio">$9.990</span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-agregar flex-grow-1"><i class="fas fa-cart-plus me-1"></i>Agregar</button>
                            <button class="btn btn-detalle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salud -->
            <div class="col-md-6 col-lg-4 producto-item" data-categoria="salud">
                <div class="card h-100 shadow-sm">
                    <div class="badge-categoria badge-salud">Salud</div>
                    <img src="https://via.placeholder.com/350x250/F44336/white?text=Vitaminas" class="card-img-top" alt="Vitaminas">
                    <div class="card-body">
                        <h5 class="card-title">Vitaminas Multivitamínicas</h5>
                        <p class="card-text texto-descripcion">Suplemento vitamínico para fortalecer la salud.</p>
                        <div class="precio-container">
                            <span class="precio">$14.990</span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-agregar flex-grow-1"><i class="fas fa-cart-plus me-1"></i>Agregar</button>
                            <button class="btn btn-detalle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-3 text-white pie-pagina">
        <p class="mb-0">&copy; 2025 Veterinaria Patitas Felices - Todos los derechos reservados</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript básico para filtros -->
    <script>
        // Filtro por categoría
        document.getElementById('filtroCategoria').addEventListener('change', function() {
            const categoria = this.value;
            const productos = document.querySelectorAll('.producto-item');
            
            productos.forEach(producto => {
                if (categoria === 'todos' || producto.dataset.categoria === categoria) {
                    producto.style.display = 'block';
                } else {
                    producto.style.display = 'none';
                }
            });
        });

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

        // Simulación de agregar al carrito (solo alerta por ahora)
        document.querySelectorAll('.btn-agregar').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.card');
                const titulo = card.querySelector('.card-title').textContent;
                alert(`"${titulo}" agregado al carrito`);
            });
        });

        // Simulación de ver detalles
        document.querySelectorAll('.btn-detalle').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.card');
                const titulo = card.querySelector('.card-title').textContent;
                alert(`Ver detalles de: "${titulo}"`);
            });
        });
    </script>
</body>
</html>
