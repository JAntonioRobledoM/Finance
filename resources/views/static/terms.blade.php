@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h1 class="card-title text-center mb-3">Términos y Condiciones</h1>
                    <p class="text-muted text-center">Última actualización: {{ date('d/m/Y') }}</p>
                    <div class="alert alert-primary text-center mb-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-laptop me-2 fs-5"></i>
                            <strong>APLICACIÓN DE ESCRITORIO CON ALMACENAMIENTO LOCAL</strong>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">1. Introducción</h2>
                        <p>Bienvenido a Finance Desktop. Esta es una <strong>aplicación de escritorio con almacenamiento 100% local</strong> para gestionar sus finanzas personales. Al utilizar nuestra aplicación, usted acepta estos Términos y Condiciones.</p>
                        <p>Estos Términos y Condiciones, junto con nuestra Política de Privacidad, rigen su uso de Finance Desktop, una aplicación desarrollada para funcionar exclusivamente en su dispositivo local sin enviar datos a servidores externos. Al registrarse y utilizar nuestra aplicación, usted confirma que comprende y acepta estos términos.</p>
                        <div class="alert alert-light border">
                            <div class="d-flex">
                                <i class="bi bi-info-circle-fill me-3 text-primary fs-4"></i>
                                <div>
                                    <h5>Funcionamiento como aplicación de escritorio</h5>
                                    <p class="mb-0">Finance Desktop funciona íntegramente en su ordenador. Todos los datos que usted introduce y gestiona a través de la aplicación se almacenan exclusivamente en su dispositivo local y nunca son enviados a servidores externos.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">2. Definiciones</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="bi bi-pc-display me-2 text-primary"></i>Aplicación</h5>
                                        <p class="card-text">Se refiere a Finance Desktop, una aplicación de escritorio que funciona exclusivamente en el dispositivo local del usuario.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="bi bi-tools me-2 text-primary"></i>Servicios</h5>
                                        <p class="card-text">Se refiere a las características y funcionalidades proporcionadas por la aplicación para gestión financiera, todas ellas ejecutadas localmente en su dispositivo.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="bi bi-person me-2 text-primary"></i>Usuario</h5>
                                        <p class="card-text">"Usuario", "usted" o "su" se refiere a cualquier persona que utilice la aplicación Finance Desktop en su dispositivo local.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="bi bi-building me-2 text-primary"></i>Nosotros</h5>
                                        <p class="card-text">"Nosotros", "nuestro" o "nos" se refiere a Finance Desktop y a su equipo de desarrollo.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="bi bi-database me-2 text-primary"></i>Contenido</h5>
                                        <p class="card-text">Se refiere a la información financiera que usted proporciona e introduce en la aplicación, la cual se almacena exclusivamente en su dispositivo local.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="bi bi-hdd-fill me-2 text-primary"></i>Almacenamiento local</h5>
                                        <p class="card-text">Significa que todos los datos se guardan exclusivamente en el dispositivo del usuario y no se envían a servidores externos bajo ninguna circunstancia.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">3. Cuentas Locales</h2>
                        <p>Para utilizar la aplicación, debe crear una cuenta local en su dispositivo. Es importante entender que:</p>
                        <div class="alert alert-success mb-3">
                            <div class="d-flex">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <div>
                                    <strong>Cuenta 100% local:</strong> Su registro e información de cuenta se almacenan exclusivamente en su dispositivo y no se sincronizan con ningún servidor externo.
                                </div>
                            </div>
                        </div>

                        <p>Al crear una cuenta local, usted es responsable de:</p>
                        <ul>
                            <li>Proporcionar la información necesaria para crear su cuenta local en su dispositivo.</li>
                            <li>Mantener la confidencialidad de su contraseña local.</li>
                            <li>Asegurarse de mantener respaldos de sus datos si lo considera necesario, ya que todos los datos permanecen exclusivamente en su dispositivo.</li>
                        </ul>

                        <div class="bg-light p-3 rounded border mb-3">
                            <div class="d-flex">
                                <i class="bi bi-shield-lock me-3 fs-4 text-primary"></i>
                                <div>
                                    <h5 class="mb-1">Seguridad de su cuenta local</h5>
                                    <p class="mb-0">
                                        Su cuenta está protegida mediante autenticación local. Esto significa que sus credenciales nunca se envían a servidores externos y que usted tiene control total sobre su acceso a la aplicación.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">4. Uso de la Aplicación</h2>
                        <p>Al utilizar nuestra aplicación, usted acepta:</p>
                        <ul>
                            <li>No utilizar la aplicación para fines ilegales o no autorizados.</li>
                            <li>No intentar acceder a áreas del sistema a las que no se le ha concedido acceso específicamente.</li>
                            <li>No interferir con la seguridad o el rendimiento de la aplicación.</li>
                            <li>No distribuir virus, malware o cualquier otro código diseñado para dañar o alterar el funcionamiento de la aplicación.</li>
                        </ul>
                        <p>Nos reservamos el derecho de suspender o terminar su acceso a la aplicación si viola estos términos.</p>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">5. Control Total de sus Datos</h2>
                        <p>Al utilizar una aplicación de escritorio con almacenamiento local:</p>
                        <div class="card border-success mb-3">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="bi bi-check-circle me-2"></i>Propiedad Total de sus Datos</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Usted mantiene la <strong>propiedad total y exclusiva</strong> de sus datos financieros. A diferencia de las aplicaciones web o en la nube, Finance Desktop no almacena, procesa ni accede a sus datos en servidores remotos. Todos los datos permanecen exclusivamente en su dispositivo.</p>
                                <div class="alert alert-light border">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-info-circle me-3 fs-4"></i>
                                        <p class="mb-0">Al funcionar como una aplicación de escritorio local, <strong>no se requiere ningún tipo de licencia para el procesamiento de datos</strong> ya que todos los datos permanecen exclusivamente bajo su control en su dispositivo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>Usted es el único responsable de mantener respaldos de los datos si lo considera necesario, ya que toda la información reside exclusivamente en su dispositivo local.</p>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">6. Limitación de Responsabilidad</h2>
                        <p>En la medida máxima permitida por la ley aplicable:</p>
                        <ul>
                            <li>Proporcionamos la aplicación "tal cual" y "según disponibilidad", sin garantías de ningún tipo.</li>
                            <li>No garantizamos que la aplicación sea ininterrumpida, segura o libre de errores.</li>
                            <li>No somos responsables de decisiones financieras que usted tome basándose en la información proporcionada por la aplicación.</li>
                            <li>La aplicación es una herramienta de gestión financiera personal y no constituye asesoramiento financiero profesional.</li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">7. Cambios en los Términos</h2>
                        <p>Nos reservamos el derecho de modificar estos Términos y Condiciones en cualquier momento. Le notificaremos cualquier cambio material a través de la aplicación o por correo electrónico.</p>
                        <p>El uso continuado de la aplicación después de tales cambios constituye su aceptación de los nuevos términos.</p>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">8. Terminación</h2>
                        <p>Podemos terminar o suspender su acceso a nuestra aplicación inmediatamente, sin previo aviso ni responsabilidad, por cualquier razón, incluyendo, sin limitación, si usted incumple los Términos y Condiciones.</p>
                        <p>Usted puede cancelar su cuenta en cualquier momento a través de la configuración de su cuenta o contactándonos directamente.</p>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">9. Ley Aplicable</h2>
                        <p>Estos Términos y Condiciones se regirán e interpretarán de acuerdo con las leyes de España, sin tener en cuenta sus conflictos de disposiciones legales.</p>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">10. Contacto</h2>
                        <p>Si tiene alguna pregunta sobre estos Términos y Condiciones, no dude en contactarnos a través de:</p>
                        <ul>
                            <li>Correo electrónico: terms@finanzaspersonales.app</li>
                        </ul>
                    </div>

                    <div class="bg-light p-4 rounded border mt-5">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0"><i class="bi bi-pc-display me-2 text-primary"></i> Aplicación de Escritorio</h5>
                                <p class="text-muted mb-0 small">Todos los datos permanecen en tu dispositivo local</p>
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