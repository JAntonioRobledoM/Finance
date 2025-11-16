@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h1 class="card-title text-center mb-4">Términos y Condiciones</h1>
                    <p class="text-muted text-center mb-5">Última actualización: {{ date('d/m/Y') }}</p>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">1. Introducción</h2>
                        <p>Bienvenido a Finanzas Personales. Al acceder o utilizar nuestra aplicación, usted acepta estar sujeto a estos Términos y Condiciones. Por favor, léalos detenidamente.</p>
                        <p>Estos Términos y Condiciones, junto con nuestra Política de Privacidad, rigen su uso de la aplicación Finanzas Personales, operada por nuestro equipo. Al registrarse y utilizar nuestra aplicación, usted confirma que comprende y acepta estos términos.</p>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">2. Definiciones</h2>
                        <ul>
                            <li><strong>"Aplicación"</strong> se refiere a Finanzas Personales, tanto en su versión web como en su versión de escritorio.</li>
                            <li><strong>"Servicios"</strong> se refiere a las características y funcionalidades proporcionadas por nuestra aplicación para la gestión financiera personal.</li>
                            <li><strong>"Usuario"</strong>, "usted" o "su" se refiere a cualquier persona que acceda o utilice nuestra aplicación.</li>
                            <li><strong>"Nosotros"</strong>, "nuestro" o "nos" se refiere a Finanzas Personales y a sus desarrolladores.</li>
                            <li><strong>"Contenido"</strong> se refiere a la información que usted proporciona, incluyendo datos financieros, transacciones, categorías, y cualquier otro dato que ingrese en la aplicación.</li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">3. Registro y Cuentas</h2>
                        <p>Para utilizar la aplicación, debe registrarse y crear una cuenta. Usted es responsable de:</p>
                        <ul>
                            <li>Proporcionar información precisa y completa durante el proceso de registro.</li>
                            <li>Mantener la confidencialidad de su contraseña.</li>
                            <li>Todas las actividades que ocurren bajo su cuenta.</li>
                        </ul>
                        <p>Nos reservamos el derecho de rechazar el servicio, eliminar cuentas o cancelar pedidos a nuestra discreción.</p>
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
                        <h2 class="h4 mb-3">5. Contenido del Usuario</h2>
                        <p>Usted mantiene la propiedad de sus datos financieros personales. Al utilizar nuestra aplicación, nos otorga una licencia limitada para almacenar, procesar y mostrar su contenido únicamente con el propósito de proporcionarle nuestros servicios.</p>
                        <p>No reclamamos ninguna propiedad sobre su contenido, pero usted reconoce que es responsable de todos los datos que ingresa en la aplicación.</p>
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

                    <div class="text-center mt-5">
                        <a href="{{ route('welcome') }}" class="btn btn-outline-primary">Volver al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection