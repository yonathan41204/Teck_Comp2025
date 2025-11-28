<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Veterinaria</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/styles-tienda.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles-home.css') }}">
    
    <style>
        .texto-verde {
            color: #06B6D4;
        }
        .carrito-item {
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 0;
        }
        .carrito-item:last-child {
            border-bottom: none;
        }
        .producto-imagen {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .cantidad-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .cantidad-control button {
            width: 30px;
            height: 30px;
            padding: 0;
            border-radius: 50%;
        }
        .cantidad-control input {
            width: 60px;
            text-align: center;
        }
        .carrito-vacio {
            text-align: center;
            padding: 3rem 1rem;
        }
        .carrito-vacio i {
            font-size: 5rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }
        .resumen-compra {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            position: sticky;
            top: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark barra-nav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Veterinaria" class="me-2" style="height: 40px;">
                Pawsitive Care
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('services') }}">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tienda') }}">Tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('expediente') }}">Expediente</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#blog">Blog</a>
                    </li>
                    
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
                        <li class="nav-item">
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

    <!-- Contenido Principal -->
    <div class="container" style="margin-top: 30px; margin-bottom: 50px;">
        <h1 class="texto-verde mb-4">
            <i class="fas fa-shopping-cart me-2"></i>Mi Carrito de Compras
        </h1>

        @if($items->isEmpty())
            <div class="carrito-vacio">
                <i class="fas fa-shopping-cart"></i>
                <h3 class="text-muted">Tu carrito está vacío</h3>
                <p class="text-muted">Agrega productos desde nuestra tienda</p>
                <a href="{{ route('tienda') }}" class="btn boton-verde btn-lg mt-3">
                    <i class="fas fa-store me-2"></i>Ir a la Tienda
                </a>
            </div>
        @else
            <div class="row">
                <!-- Lista de productos -->
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            @foreach($items as $item)
                                <div class="carrito-item" data-id="{{ $item->id_carrito }}">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 text-center">
                                            <img src="{{ asset('images/productos/producto_' . $item->id_producto . '.jpg') }}" 
                                                 alt="{{ $item->producto->nombre }}"
                                                 class="producto-imagen"
                                                 onerror="this.src='https://via.placeholder.com/80/28a745/ffffff?text=Producto'">
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="mb-1">{{ $item->producto->nombre }}</h6>
                                            <small class="text-muted">Stock: {{ $item->producto->inventario }} unidades</small>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <p class="mb-0 fw-bold texto-verde">${{ number_format($item->producto->precio, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="cantidad-control">
                                                <button class="btn btn-sm btn-outline-secondary btn-menos" data-id="{{ $item->id_carrito }}">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" class="form-control form-control-sm cantidad-input" 
                                                       value="{{ $item->cantidad }}" 
                                                       min="1" 
                                                       max="{{ $item->producto->inventario }}"
                                                       data-id="{{ $item->id_carrito }}">
                                                <button class="btn btn-sm btn-outline-secondary btn-mas" 
                                                        data-id="{{ $item->id_carrito }}"
                                                        data-max="{{ $item->producto->inventario }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <p class="mb-0 fw-bold subtotal" data-precio="{{ $item->producto->precio }}">
                                                ${{ number_format($item->producto->precio * $item->cantidad, 0, ',', '.') }}
                                            </p>
                                            <button class="btn btn-sm btn-link text-danger p-0 mt-1 btn-eliminar" data-id="{{ $item->id_carrito }}">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('tienda') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Seguir Comprando
                    </a>
                </div>

                <!-- Resumen de compra -->
                <div class="col-lg-4">
                    <div class="resumen-compra">
                        <h5 class="texto-verde mb-3">Resumen de Compra</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Productos ({{ $items->sum('cantidad') }})</span>
                            <span id="subtotal-productos">${{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="texto-verde fs-4" id="total-final">${{ number_format($total, 0, ',', '.') }}</strong>
                        </div>

                        <button class="btn boton-verde w-100 mb-2" onclick="mostrarModalPago()">
                            <i class="fas fa-credit-card me-2"></i>Proceder al Pago
                        </button>

                        <form action="{{ route('carrito.vaciar') }}" method="POST" onsubmit="return confirm('¿Estás seguro de vaciar el carrito?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>Vaciar Carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de Pago -->
    <div class="modal fade" id="modalPago" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Procesar Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <h6 class="text-muted">Selecciona el método de pago</h6>
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <div class="card metodo-pago" onclick="seleccionarMetodo('tarjeta')" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <i class="fas fa-credit-card fa-3x texto-verde mb-2"></i>
                                        <p class="mb-0">Tarjeta</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card metodo-pago" onclick="seleccionarMetodo('transferencia')" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <i class="fas fa-exchange-alt fa-3x texto-verde mb-2"></i>
                                        <p class="mb-0">Transferencia</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card metodo-pago" onclick="seleccionarMetodo('efectivo')" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <i class="fas fa-money-bill-wave fa-3x texto-verde mb-2"></i>
                                        <p class="mb-0">Efectivo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tarjeta -->
    <div class="modal fade" id="modalTarjeta" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pago con Tarjeta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formTarjeta">
                        <div class="mb-3">
                            <label class="form-label">Número de Tarjeta</label>
                            <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Fecha Vencimiento</label>
                                <input type="text" class="form-control" placeholder="MM/AA" maxlength="5" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">CVV</label>
                                <input type="text" class="form-control" placeholder="123" maxlength="3" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre del Titular</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn boton-verde" onclick="procesarPago('tarjeta')">
                        <i class="fas fa-lock me-2"></i>Pagar $<span id="total-tarjeta">{{ number_format($total, 0, ',', '.') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Transferencia -->
    <div class="modal fade" id="modalTransferencia" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pago por Transferencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Realiza la transferencia a la siguiente cuenta:
                    </div>
                    <div class="mb-3">
                        <strong>Banco:</strong> Banco Estado<br>
                        <strong>Tipo:</strong> Cuenta Corriente<br>
                        <strong>Número:</strong> 1234567890<br>
                        <strong>RUT:</strong> 12.345.678-9<br>
                        <strong>Titular:</strong> Veterinaria SERVIN<br>
                        <strong>Email:</strong> pagos@vetservin.cl
                    </div>
                    <form id="formTransferencia">
                        <div class="mb-3">
                            <label class="form-label">Número de Comprobante</label>
                            <input type="text" class="form-control" placeholder="Ej: 123456789" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn boton-verde" onclick="procesarPago('transferencia')">
                        Confirmar Pago $<span id="total-transferencia">{{ number_format($total, 0, ',', '.') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Efectivo -->
    <div class="modal fade" id="modalEfectivo" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pago en Efectivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        El pago se realizará al momento de retirar los productos en nuestra tienda física.
                    </div>
                    <div class="mb-3">
                        <strong>Dirección:</strong> Av. Principal #123, Santiago<br>
                        <strong>Horario:</strong> Lunes a Viernes 9:00 - 18:00<br>
                        <strong>Sábado:</strong> 9:00 - 13:00
                    </div>
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Recibirás un correo con los detalles de tu pedido.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn boton-verde" onclick="procesarPago('efectivo')">
                        Confirmar Pedido $<span id="total-efectivo">{{ number_format($total, 0, ',', '.') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // CSRF Token
        const csrfToken = '{{ csrf_token() }}';
        
        // Actualizar badge del carrito
        function actualizarBadgeCarrito() {
            fetch('{{ route("carrito.total") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('badge-carrito').textContent = data.total;
                });
        }

        // Actualizar totales
        function actualizarTotales() {
            let total = 0;
            document.querySelectorAll('.carrito-item').forEach(item => {
                const subtotalText = item.querySelector('.subtotal').textContent;
                const subtotal = parseInt(subtotalText.replace(/\D/g, ''));
                total += subtotal;
            });

            const totalFormateado = new Intl.NumberFormat('es-CL').format(total);
            document.getElementById('subtotal-productos').textContent = `$${totalFormateado}`;
            document.getElementById('total-final').textContent = `$${totalFormateado}`;
            document.getElementById('total-tarjeta').textContent = totalFormateado;
            document.getElementById('total-transferencia').textContent = totalFormateado;
            document.getElementById('total-efectivo').textContent = totalFormateado;
        }

        // Incrementar cantidad
        document.querySelectorAll('.btn-mas').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const max = parseInt(this.dataset.max);
                const input = document.querySelector(`.cantidad-input[data-id="${id}"]`);
                const cantidad = parseInt(input.value);

                if (cantidad < max) {
                    input.value = cantidad + 1;
                    actualizarCantidad(id, cantidad + 1);
                } else {
                    alert('No hay más stock disponible');
                }
            });
        });

        // Decrementar cantidad
        document.querySelectorAll('.btn-menos').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const input = document.querySelector(`.cantidad-input[data-id="${id}"]`);
                const cantidad = parseInt(input.value);

                if (cantidad > 1) {
                    input.value = cantidad - 1;
                    actualizarCantidad(id, cantidad - 1);
                }
            });
        });

        // Actualizar cantidad manual
        document.querySelectorAll('.cantidad-input').forEach(input => {
            input.addEventListener('change', function() {
                const id = this.dataset.id;
                const cantidad = parseInt(this.value);
                const max = parseInt(this.closest('.col-md-2').querySelector('.btn-mas').dataset.max);

                if (cantidad > max) {
                    alert('No hay suficiente stock');
                    this.value = max;
                    actualizarCantidad(id, max);
                } else if (cantidad < 1) {
                    this.value = 1;
                    actualizarCantidad(id, 1);
                } else {
                    actualizarCantidad(id, cantidad);
                }
            });
        });

        // Actualizar cantidad en el servidor
        function actualizarCantidad(id, cantidad) {
            fetch(`/carrito/${id}/actualizar`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ cantidad: cantidad })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = document.querySelector(`.carrito-item[data-id="${id}"]`);
                    const precio = parseInt(item.querySelector('.subtotal').dataset.precio);
                    const subtotal = precio * cantidad;
                    item.querySelector('.subtotal').textContent = `$${new Intl.NumberFormat('es-CL').format(subtotal)}`;
                    actualizarTotales();
                    actualizarBadgeCarrito();
                } else {
                    alert(data.message);
                }
            });
        }

        // Eliminar producto
        document.querySelectorAll('.btn-eliminar').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!confirm('¿Eliminar este producto del carrito?')) return;

                const id = this.dataset.id;
                fetch(`/carrito/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`.carrito-item[data-id="${id}"]`).remove();
                        actualizarTotales();
                        actualizarBadgeCarrito();

                        // Si no hay más items, recargar página
                        if (document.querySelectorAll('.carrito-item').length === 0) {
                            location.reload();
                        }
                    }
                });
            });
        });

        // Mostrar modal de pago
        function mostrarModalPago() {
            const modal = new bootstrap.Modal(document.getElementById('modalPago'));
            modal.show();
        }

        // Seleccionar método de pago
        function seleccionarMetodo(metodo) {
            const modalPago = bootstrap.Modal.getInstance(document.getElementById('modalPago'));
            modalPago.hide();

            setTimeout(() => {
                const modal = new bootstrap.Modal(document.getElementById(`modal${metodo.charAt(0).toUpperCase() + metodo.slice(1)}`));
                modal.show();
            }, 500);
        }

        // Procesar pago
        function procesarPago(metodo) {
            fetch('/carrito/pagar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ metodo_pago: metodo })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cerrar modal
                    bootstrap.Modal.getInstance(document.querySelector('.modal.show')).hide();

                    // Mostrar mensaje de éxito
                    const modalExito = document.createElement('div');
                    modalExito.className = 'modal fade show';
                    modalExito.style.display = 'block';
                    modalExito.style.backgroundColor = 'rgba(0,0,0,0.5)';
                    modalExito.innerHTML = `
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center py-5">
                                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                                    <h3 class="mt-4 texto-verde">¡Compra Exitosa!</h3>
                                    <p class="text-muted">Tu pedido ha sido procesado correctamente</p>
                                    <p class="fw-bold">Total: $${new Intl.NumberFormat('es-CL').format(data.total)}</p>
                                    <button class="btn boton-verde mt-3" onclick="location.href='{{ route('tienda') }}'">
                                        Seguir Comprando
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modalExito);

                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    alert(data.message);
                }
            });
        }

        // Cargar badge al inicio
        actualizarBadgeCarrito();
    </script>
</body>
</html>
