@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h1 class="card-title text-center mb-3">Política de Privacidad</h1>
                    <p class="text-muted text-center">Última actualización: {{ date('d/m/Y') }}</p>
                    <div class="alert alert-success text-center mb-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-shield-lock me-2 fs-5"></i>
                            <strong>APLICACIÓN CON PRIVACIDAD GARANTIZADA</strong>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">1. Introducción</h2>
                        <p>Bienvenido a la Política de Privacidad de Finance Desktop. Esta política explica cómo manejamos su información personal y por qué puede confiar en nuestra aplicación.</p>
                        <p>En Finance Desktop, su privacidad es nuestra prioridad absoluta. A diferencia de otras aplicaciones, nosotros no recopilamos, almacenamos ni procesamos sus datos en servidores remotos - toda su información permanece en su dispositivo.</p>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Privacidad por diseño:</strong> Sus datos financieros nunca salen de su dispositivo a menos que usted decida exportarlos.
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">2. Datos gestionados</h2>
                        <p>La información que usted introduce se almacena en su dispositivo:</p>
                        <ul>
                            <li><strong>Información de cuenta:</strong> Su nombre de usuario y contraseña para acceder a la aplicación.</li>
                            <li><strong>Datos financieros:</strong> Sus transacciones, ingresos, gastos, presupuestos y categorías.</li>
                            <li><strong>Configuraciones:</strong> Sus preferencias de visualización y configuración de la aplicación.</li>
                        </ul>
                        <div class="alert alert-success">
                            <div class="d-flex">
                                <i class="bi bi-shield-check me-3 fs-3"></i>
                                <div>
                                    <strong>Compromiso de privacidad:</strong> Nuestra aplicación no envía datos a servidores externos, no realiza análisis de comportamiento y no incluye rastreadores de ningún tipo.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">3. Funcionalidad de la aplicación</h2>
                        <p>Su información se utiliza dentro de la aplicación para:</p>
                        <ul>
                            <li>Mostrar sus datos financieros en la interfaz.</li>
                            <li>Generar estadísticas e informes de sus finanzas personales.</li>
                            <li>Personalizar la experiencia según sus preferencias.</li>
                            <li>Proteger el acceso a sus datos mediante autenticación.</li>
                        </ul>
                        <div class="alert alert-warning">
                            <i class="bi bi-lightbulb-fill me-2"></i>
                            <strong>A diferencia de otras aplicaciones, Finance no:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Recopila datos de análisis sobre su uso</li>
                                <li>Comparte información con terceros</li>
                                <li>Requiere conexión a Internet</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">4. Seguridad de datos</h2>
                        <p>Protegemos sus datos financieros mediante:</p>
                        <ul>
                            <li><strong>Almacenamiento local:</strong> Sus datos se guardan en su propio dispositivo.</li>
                            <li><strong>Encriptación:</strong> La base de datos utiliza encriptación para proteger su información.</li>
                            <li><strong>Autenticación:</strong> El sistema de inicio de sesión protege el acceso a sus datos.</li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">5. Privacidad garantizada</h2>
                        <p>Finance Desktop <strong>no comparte datos con terceros</strong> bajo ninguna circunstancia:</p>
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="d-flex">
                                    <i class="bi bi-shield-lock text-success me-3 fs-4"></i>
                                    <div>
                                        <h5>Sin comunicación externa</h5>
                                        <p class="mb-0">No enviamos datos a servidores externos, no usamos rastreadores ni recopilamos telemetría.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">6. Control total sobre sus datos</h2>
                        <p>Usted tiene <strong>control total sobre sus datos</strong> en todo momento:</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-trash me-2 text-primary"></i>
                                            <h5 class="mb-0">Eliminación</h5>
                                        </div>
                                        <p class="small mb-0">Elimine sus datos en cualquier momento desde la aplicación.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-pencil-square me-2 text-primary"></i>
                                            <h5 class="mb-0">Modificación</h5>
                                        </div>
                                        <p class="small mb-0">Modifique su información financiera cuando lo necesite.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-box-arrow-down me-2 text-primary"></i>
                                            <h5 class="mb-0">Exportación</h5>
                                        </div>
                                        <p class="small mb-0">Exporte sus datos financieros en diversos formatos.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-shield-lock me-2 text-primary"></i>
                                            <h5 class="mb-0">Acceso exclusivo</h5>
                                        </div>
                                        <p class="small mb-0">Solo usted puede acceder a sus datos financieros.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">7. Actualizaciones de la aplicación</h2>
                        <p>Podemos actualizar la aplicación y esta política de privacidad para mejorar la experiencia de usuario. Las actualizaciones siempre se descargarán e instalarán manualmente, permitiéndole revisar los cambios antes de aceptarlos.</p>

                        <div class="alert alert-info">
                            <div class="d-flex">
                                <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                                <div>
                                    <h5>Compromiso permanente</h5>
                                    <p class="mb-0">Mantendremos nuestro compromiso con la privacidad y seguridad de sus datos en todas las actualizaciones futuras.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">8. Información de contacto</h2>
                        <p>Si tiene alguna pregunta sobre cómo funciona la aplicación de escritorio o sobre esta política de privacidad, puede contactarnos a través de:</p>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-linkedin me-3 text-primary fs-4"></i>
                                    <div>
                                        <h5 class="mb-0">Contacto</h5>
                                        <p class="mb-0"><a href="https://www.linkedin.com/in/jantoniorm/" target="_blank" rel="noopener noreferrer">LinkedIn: jantoniorm</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light p-4 rounded border mt-5">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0"><i class="bi bi-shield-check me-2 text-success"></i> Privacidad y seguridad</h5>
                                <p class="text-muted mb-0 small">Tus datos financieros están protegidos</p>
                            </div>
                            <a href="{{ route('welcome') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left me-1"></i> Volver al inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection