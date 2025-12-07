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
                            <i class="bi bi-pc-display-horizontal me-2 fs-5"></i>
                            <strong>APLICACIÓN DE ESCRITORIO: TODOS LOS DATOS SE ALMACENAN LOCALMENTE</strong>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">1. Introducción</h2>
                        <p>Bienvenido a la Política de Privacidad de Finance Desktop. <strong>Esta aplicación funciona exclusivamente como una aplicación de escritorio donde todos los datos se almacenan localmente en su dispositivo.</strong> Esta política explica cómo manejamos su información personal.</p>
                        <p>En Finance Desktop, su privacidad es nuestra prioridad absoluta. A diferencia de otras aplicaciones, <strong>nosotros no recopilamos, almacenamos ni procesamos sus datos en ningún servidor remoto</strong> - toda su información permanece exclusivamente en su dispositivo. Esta política está diseñada para proporcionarle información clara sobre cómo funciona nuestra aplicación respetando al máximo su privacidad.</p>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Importante:</strong> Al ser una aplicación de escritorio local, sus datos financieros nunca salen de su dispositivo a menos que usted específicamente decida exportarlos.
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">2. Datos almacenados localmente</h2>
                        <p>Finance Desktop <strong>NO recopila ningún dato en servidores remotos</strong>. Toda la información que usted introduce se almacena exclusivamente en su dispositivo local:</p>
                        <ul>
                            <li><strong>Información de cuenta local:</strong> Cuando crea una cuenta, el nombre de usuario y contraseña se almacenan únicamente en su dispositivo para el acceso local a la aplicación.</li>
                            <li><strong>Datos financieros locales:</strong> Todas sus transacciones, ingresos, gastos, presupuestos y categorías financieras se almacenan exclusivamente en la base de datos local de su dispositivo.</li>
                            <li><strong>Configuraciones de la aplicación:</strong> Sus preferencias de visualización y configuración de la aplicación se guardan localmente para personalizar su experiencia.</li>
                        </ul>
                        <div class="alert alert-success">
                            <div class="d-flex">
                                <i class="bi bi-shield-check me-3 fs-3"></i>
                                <div>
                                    <strong>Compromiso de privacidad:</strong> Nuestra aplicación no envía ningún dato a servidores externos, no realiza análisis de comportamiento y no incluye rastreadores de ningún tipo. Todos sus datos permanecen en su dispositivo en todo momento.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">3. Cómo funciona nuestra aplicación de escritorio</h2>
                        <p>Al tratarse de una aplicación 100% local, su información se utiliza exclusivamente dentro de su dispositivo para:</p>
                        <ul>
                            <li>Procesar y mostrar sus datos financieros en la interfaz de la aplicación.</li>
                            <li>Generar estadísticas, informes y visualizaciones de sus finanzas personales.</li>
                            <li>Almacenar sus preferencias y configuraciones para personalizar la experiencia de usuario.</li>
                            <li>Gestionar la autenticación local para proteger el acceso a sus datos financieros.</li>
                        </ul>
                        <div class="alert alert-warning">
                            <i class="bi bi-lightbulb-fill me-2"></i>
                            <strong>Nota importante:</strong> A diferencia de las aplicaciones web o móviles convencionales, Finance Desktop NO:
                            <ul class="mb-0 mt-2">
                                <li>Recopila datos de análisis sobre su uso</li>
                                <li>Envía información a servidores remotos</li>
                                <li>Comparte información con terceros bajo ninguna circunstancia</li>
                                <li>Requiere conexión a Internet para funcionar</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">4. Seguridad del almacenamiento local</h2>
                        <p>La seguridad de sus datos locales es nuestra prioridad:</p>
                        <ul>
                            <li><strong>Almacenamiento 100% local:</strong> Todos sus datos financieros se almacenan exclusivamente en el disco duro de su dispositivo.</li>
                            <li><strong>Base de datos encriptada:</strong> La base de datos local utiliza encriptación para proteger la información almacenada en su dispositivo.</li>
                            <li><strong>Autenticación local:</strong> El sistema de inicio de sesión protege el acceso a sus datos financieros en el dispositivo.</li>
                        </ul>
                        <div class="bg-light p-3 border rounded">
                            <div class="d-flex">
                                <i class="bi bi-hdd-fill fs-4 me-3 text-primary"></i>
                                <div>
                                    <h5 class="mb-1">Ubicación exacta de sus datos</h5>
                                    <p class="mb-0 small">
                                        Sus datos financieros se almacenan en la carpeta local de la aplicación dentro de su dispositivo. Esta aplicación no tiene capacidad de enviar datos a través de Internet.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">5. Ausencia total de compartición de datos</h2>
                        <p><strong>Finance Desktop NO comparte ningún dato con terceros</strong> bajo ninguna circunstancia, ya que la aplicación funciona completamente en modo local:</p>
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="d-flex">
                                    <i class="bi bi-x-circle-fill text-danger me-3 fs-4"></i>
                                    <div>
                                        <h5>No hay comunicación con servidores</h5>
                                        <p class="mb-0">Esta aplicación de escritorio no tiene capacidad de enviar datos a ningún servidor externo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="d-flex">
                                    <i class="bi bi-x-circle-fill text-danger me-3 fs-4"></i>
                                    <div>
                                        <h5>No hay terceros involucrados</h5>
                                        <p class="mb-0">No utilizamos servicios externos, análisis, rastreadores ni ningún otro componente que comparta datos.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex">
                                    <i class="bi bi-x-circle-fill text-danger me-3 fs-4"></i>
                                    <div>
                                        <h5>No hay anuncios ni telemetría</h5>
                                        <p class="mb-0">La aplicación no incluye anuncios, no recopila telemetría y no utiliza ningún tipo de rastreador.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">6. Control total sobre sus datos</h2>
                        <p>Al utilizar una aplicación de escritorio local, usted tiene <strong>control total sobre sus datos</strong> en todo momento:</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-trash me-2 text-primary"></i>
                                            <h5 class="mb-0">Eliminación total</h5>
                                        </div>
                                        <p class="small mb-0">Puede eliminar sus datos en cualquier momento desde la aplicación o eliminando los archivos de la base de datos local.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-pencil-square me-2 text-primary"></i>
                                            <h5 class="mb-0">Modificación directa</h5>
                                        </div>
                                        <p class="small mb-0">Tiene capacidad para modificar cualquier información financiera desde la interfaz de la aplicación.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-box-arrow-down me-2 text-primary"></i>
                                            <h5 class="mb-0">Portabilidad completa</h5>
                                        </div>
                                        <p class="small mb-0">Puede exportar sus datos financieros en diversos formatos para su uso personal.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-shield-lock me-2 text-primary"></i>
                                            <h5 class="mb-0">Privacidad garantizada</h5>
                                        </div>
                                        <p class="small mb-0">Nadie más que usted puede acceder a sus datos, ya que permanecen exclusivamente en su dispositivo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">7. Actualizaciones de la aplicación</h2>
                        <p>Podemos actualizar la aplicación y esta política de privacidad para mejorar la experiencia de usuario. Cualquier actualización seguirá manteniendo el principio fundamental de privacidad y almacenamiento local de datos. Las actualizaciones de la aplicación siempre se descargarán e instalarán manualmente, lo que le permite revisar los cambios antes de aceptarlos.</p>

                        <div class="alert alert-info">
                            <div class="d-flex">
                                <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                                <div>
                                    <h5>Compromiso permanente</h5>
                                    <p class="mb-0">Nunca cambiaremos nuestro enfoque fundamental de almacenamiento local. Todas las versiones futuras de esta aplicación seguirán funcionando sin enviar datos a servidores externos.</p>
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
                                    <i class="bi bi-envelope-fill me-3 text-primary fs-4"></i>
                                    <div>
                                        <h5 class="mb-0">Contacto</h5>
                                        <p class="mb-0">support@financedesktop.app</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light p-4 rounded border mt-5">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0"><i class="bi bi-shield-check me-2 text-success"></i> Aplicación 100% local</h5>
                                <p class="text-muted mb-0 small">Tus datos financieros nunca salen de tu dispositivo</p>
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