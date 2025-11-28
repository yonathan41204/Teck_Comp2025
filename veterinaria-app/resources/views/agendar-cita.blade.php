<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita - Veterinaria Patitas Felices</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles-expediente.css') }}">
    <style>
        .form-check-card {
            cursor: pointer;
            transition: all 0.3s;
        }
        .form-check-card:hover {
            background-color: #f8f9fa;
            border-color: #28a745 !important;
        }
        .form-check-input:checked + .form-check-label {
            color: #28a745;
        }
        .form-check-card .form-check-input {
            margin-top: 0.5rem;
        }
    </style>
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
            <h1 class="fw-bold"><i class="fas fa-calendar-check me-3"></i>Agendar Cita</h1>
            <p class="lead">Reserva tu cita para {{ $servicio->nombre }} 📅</p>
        </div>
    </header>

    <!-- Formulario de Cita -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <div class="mb-4 p-3 bg-light rounded">
                            <h5 class="mb-2"><i class="fas fa-info-circle me-2"></i>Servicio seleccionado</h5>
                            <h4 class="text-primary mb-1">{{ $servicio->nombre }}</h4>
                            <p class="text-muted mb-2">{{ $servicio->descripcion }}</p>
                            @if($servicio->precio > 0)
                                <p class="text-success fw-bold mb-0">
                                    <i class="fas fa-tag me-1"></i>Precio: ${{ number_format($servicio->precio, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('cita.guardar') }}">
                            @csrf
                            <input type="hidden" name="id_servicio" value="{{ $servicio->id_servicio }}">

                            <div class="mb-4">
                                <label for="fecha_cita" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Fecha y hora de la cita *
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('fecha_cita') is-invalid @enderror" 
                                       id="fecha_cita" 
                                       name="fecha_cita" 
                                       min="{{ date('Y-m-d\TH:i') }}"
                                       required>
                                @error('fecha_cita')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Selecciona una fecha y hora disponible para tu cita
                                </small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-credit-card me-2"></i>Método de pago *
                                </label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-check form-check-card p-3 border rounded">
                                            <input class="form-check-input" type="radio" name="metodo_pago" id="efectivo" value="efectivo" required>
                                            <label class="form-check-label w-100" for="efectivo">
                                                <i class="fas fa-money-bill-wave fa-2x text-success d-block mb-2"></i>
                                                <strong>Efectivo</strong>
                                                <small class="d-block text-muted">Pagar en sucursal</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-check-card p-3 border rounded">
                                            <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta">
                                            <label class="form-check-label w-100" for="tarjeta">
                                                <i class="fas fa-credit-card fa-2x text-primary d-block mb-2"></i>
                                                <strong>Tarjeta</strong>
                                                <small class="d-block text-muted">Débito o crédito</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-check-card p-3 border rounded">
                                            <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="transferencia">
                                            <label class="form-check-label w-100" for="transferencia">
                                                <i class="fas fa-exchange-alt fa-2x text-info d-block mb-2"></i>
                                                <strong>Transferencia</strong>
                                                <small class="d-block text-muted">Bancaria</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('metodo_pago')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Nota:</strong> Recibirás un recordatorio antes de tu cita agendada. El proceso de pago se realizará de forma segura.
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                <a href="{{ route('services') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Volver
                                </a>
                                <button type="submit" class="btn boton-verde">
                                    <i class="fas fa-check me-2"></i>Confirmar Cita
                                </button>
                            </div>
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
    
    <script>
        // Simulación de proceso de pago
        document.querySelector('form').addEventListener('submit', function(e) {
            const metodoPago = document.querySelector('input[name="metodo_pago"]:checked');
            
            if (!metodoPago) {
                alert('Por favor selecciona un método de pago');
                e.preventDefault();
                return;
            }

            // Prevenir envío inicial
            e.preventDefault();
            
            const metodo = metodoPago.value;
            const form = this;

            // Mostrar formulario de pago según método
            if (metodo === 'tarjeta') {
                mostrarFormularioTarjeta(form);
            } else if (metodo === 'transferencia') {
                mostrarFormularioTransferencia(form);
            } else if (metodo === 'efectivo') {
                mostrarConfirmacionEfectivo(form);
            }
        });

        function mostrarFormularioTarjeta(form) {
            const modal = document.createElement('div');
            modal.className = 'modal fade show';
            modal.style.display = 'block';
            modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
            modal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fas fa-credit-card me-2"></i>Datos de Tarjeta</h5>
                            <button type="button" class="btn-close" onclick="this.closest('.modal').remove()"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formTarjeta">
                                <div class="mb-3">
                                    <label class="form-label">Número de tarjeta</label>
                                    <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nombre en la tarjeta</label>
                                    <input type="text" class="form-control" placeholder="NOMBRE APELLIDO" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Fecha de expiración</label>
                                        <input type="text" class="form-control" placeholder="MM/AA" maxlength="5" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">CVV</label>
                                        <input type="text" class="form-control" placeholder="123" maxlength="3" required>
                                    </div>
                                </div>
                                <div class="alert alert-info small">
                                    <i class="fas fa-lock me-1"></i> Tus datos están protegidos con cifrado SSL
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').remove()">Cancelar</button>
                            <button type="button" class="btn boton-verde" onclick="procesarPagoTarjeta(this)">
                                <i class="fas fa-check me-2"></i>Pagar
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            window.procesarPagoTarjeta = function(btn) {
                const formTarjeta = document.getElementById('formTarjeta');
                if (!formTarjeta.checkValidity()) {
                    formTarjeta.reportValidity();
                    return;
                }
                modal.remove();
                procesarPago(form, 'tarjeta', '💳 Procesando pago con tarjeta...\n\nConectando con el procesador de pagos seguro...');
            };
        }

        function mostrarFormularioTransferencia(form) {
            const modal = document.createElement('div');
            modal.className = 'modal fade show';
            modal.style.display = 'block';
            modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
            modal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fas fa-university me-2"></i>Datos de Transferencia</h5>
                            <button type="button" class="btn-close" onclick="this.closest('.modal').remove()"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formTransferencia">
                                <div class="mb-3">
                                    <label class="form-label">Banco</label>
                                    <select class="form-select" required>
                                        <option value="">Selecciona tu banco</option>
                                        <option>Banco Nacional</option>
                                        <option>Banco Popular</option>
                                        <option>Banco Crédito</option>
                                        <option>Banco Santander</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Número de cuenta</label>
                                    <input type="text" class="form-control" placeholder="0000-0000-0000-0000" maxlength="19" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nombre del titular</label>
                                    <input type="text" class="form-control" placeholder="Nombre completo" required>
                                </div>
                                <div class="alert alert-info small">
                                    <i class="fas fa-info-circle me-1"></i> La transferencia será verificada automáticamente
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').remove()">Cancelar</button>
                            <button type="button" class="btn boton-verde" onclick="procesarPagoTransferencia(this)">
                                <i class="fas fa-exchange-alt me-2"></i>Realizar Transferencia
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            window.procesarPagoTransferencia = function(btn) {
                const formTransferencia = document.getElementById('formTransferencia');
                if (!formTransferencia.checkValidity()) {
                    formTransferencia.reportValidity();
                    return;
                }
                modal.remove();
                procesarPago(form, 'transferencia', '🏦 Procesando transferencia bancaria...\n\nVerificando información de la cuenta...');
            };
        }

        function mostrarConfirmacionEfectivo(form) {
            const modal = document.createElement('div');
            modal.className = 'modal fade show';
            modal.style.display = 'block';
            modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
            modal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fas fa-money-bill-wave me-2"></i>Pago en Efectivo</h5>
                            <button type="button" class="btn-close" onclick="this.closest('.modal').remove()"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center py-3">
                                <i class="fas fa-store fa-3x text-success mb-3"></i>
                                <h5>Instrucciones de pago</h5>
                                <p class="text-muted">Deberás realizar el pago en cualquiera de nuestras sucursales antes de tu cita.</p>
                                <div class="alert alert-warning">
                                    <strong>Código de referencia:</strong><br>
                                    <h4 class="mb-0">${Math.random().toString(36).substr(2, 9).toUpperCase()}</h4>
                                </div>
                                <p class="small text-muted">Presenta este código en caja para completar tu pago</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').remove()">Cancelar</button>
                            <button type="button" class="btn boton-verde" onclick="procesarPagoEfectivo(this)">
                                <i class="fas fa-check me-2"></i>Confirmar
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            window.procesarPagoEfectivo = function(btn) {
                modal.remove();
                procesarPago(form, 'efectivo', '💵 Procesando reserva con pago en efectivo...\n\nGenerando código de confirmación...');
            };
        }

        function procesarPago(form, metodo, mensaje) {
            // Deshabilitar botón de envío
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';

            // Mostrar modal de procesamiento
            const processingModal = document.createElement('div');
            processingModal.className = 'modal fade show';
            processingModal.style.display = 'block';
            processingModal.style.backgroundColor = 'rgba(0,0,0,0.5)';
            processingModal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center py-5">
                            <div class="spinner-border text-success mb-3" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Procesando...</span>
                            </div>
                            <h5 class="mb-3">Procesando Pago</h5>
                            <p class="text-muted" style="white-space: pre-line;">${mensaje}</p>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(processingModal);

            // Simular delay de procesamiento (2 segundos)
            setTimeout(() => {
                document.body.removeChild(processingModal);
                
                // Mostrar confirmación de pago exitoso
                const successModal = document.createElement('div');
                successModal.className = 'modal fade show';
                successModal.style.display = 'block';
                successModal.style.backgroundColor = 'rgba(0,0,0,0.5)';
                successModal.innerHTML = `
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body text-center py-5">
                                <i class="fas fa-check-circle text-success mb-3" style="font-size: 4rem;"></i>
                                <h4 class="mb-3">¡Pago Exitoso!</h4>
                                <p class="text-muted mb-4">Tu pago ha sido procesado correctamente.</p>
                                <div class="alert alert-success mx-4">
                                    <strong>Método:</strong> ${metodo === 'efectivo' ? 'Efectivo' : metodo === 'tarjeta' ? 'Tarjeta' : 'Transferencia'}<br>
                                    <strong>Monto:</strong> $${document.querySelector('.text-success.fw-bold').textContent.split('$')[1]}<br>
                                    <strong>Estado:</strong> Completado ✓
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(successModal);

                // Después de 2 segundos, enviar el formulario real
                setTimeout(() => {
                    document.body.removeChild(successModal);
                    form.submit();
                }, 2000);
            }, 2000);
        }
    </script>
</body>
</html>
