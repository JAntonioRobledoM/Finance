@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h1 class="card-title text-center mb-4">Política de Privacidad</h1>
                    <p class="text-muted text-center mb-5">Última actualización: {{ date('d/m/Y') }}</p>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">1. Introducción</h2>
                        <p>Bienvenido a la Política de Privacidad de Finanzas Personales. Esta política explica cómo recopilamos, utilizamos, almacenamos y protegemos su información personal cuando utiliza nuestra aplicación de gestión financiera.</p>
                        <p>En Finanzas Personales, nos comprometemos a proteger su privacidad y a asegurar que sus datos personales se manejen con el máximo cuidado y confidencialidad. Esta política está diseñada para proporcionarle información clara sobre nuestras prácticas de privacidad.</p>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">2. Información que recopilamos</h2>
                        <p>La información que recopilamos se limita a lo necesario para proporcionar nuestros servicios:</p>
                        <ul>
                            <li><strong>Información de registro:</strong> Cuando crea una cuenta, recopilamos su nombre y dirección de correo electrónico.</li>
                            <li><strong>Datos financieros:</strong> La información que usted ingresa voluntariamente sobre sus transacciones, ingresos, gastos, presupuestos y categorías financieras.</li>
                            <li><strong>Información de uso:</strong> Datos sobre cómo utiliza la aplicación, para mejorar nuestros servicios.</li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">3. Cómo utilizamos su información</h2>
                        <p>Utilizamos la información que recopilamos para:</p>
                        <ul>
                            <li>Proporcionar, mantener y mejorar nuestros servicios.</li>
                            <li>Personalizar su experiencia con la aplicación.</li>
                            <li>Procesar sus transacciones y gestionar su cuenta.</li>
                            <li>Comunicarnos con usted sobre actualizaciones, características nuevas o cambios en nuestros términos.</li>
                            <li>Analizar el rendimiento de la aplicación y resolver problemas técnicos.</li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">4. Almacenamiento de datos</h2>
                        <p>Su seguridad es importante para nosotros:</p>
                        <ul>
                            <li>Sus datos financieros se almacenan principalmente en su dispositivo local.</li>
                            <li>Si utiliza nuestra aplicación web, los datos se almacenan en servidores seguros con encriptación de última generación.</li>
                            <li>Implementamos medidas de seguridad técnicas y organizativas diseñadas para proteger sus datos personales.</li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">5. Compartir información</h2>
                        <p>No vendemos ni alquilamos su información personal a terceros. Podemos compartir información en las siguientes circunstancias limitadas:</p>
                        <ul>
                            <li>Con su consentimiento explícito.</li>
                            <li>Para cumplir con obligaciones legales.</li>
                            <li>Con proveedores de servicios que nos ayudan a operar la aplicación (siempre con garantías adecuadas de protección de datos).</li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">6. Sus derechos</h2>
                        <p>Como usuario, tiene derecho a:</p>
                        <ul>
                            <li>Acceder a sus datos personales que tenemos almacenados.</li>
                            <li>Corregir cualquier información personal inexacta.</li>
                            <li>Eliminar sus datos personales (derecho al olvido).</li>
                            <li>Restringir u oponerse al procesamiento de sus datos.</li>
                            <li>Solicitar la portabilidad de sus datos.</li>
                            <li>Retirar su consentimiento en cualquier momento.</li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">7. Cambios a esta política</h2>
                        <p>Podemos actualizar esta Política de Privacidad periódicamente para reflejar cambios en nuestras prácticas o por otros motivos operativos, legales o regulatorios. Le notificaremos cualquier cambio material publicando la nueva Política de Privacidad y, cuando sea apropiado, mediante notificaciones dentro de la aplicación o por correo electrónico.</p>
                    </div>

                    <div class="mb-5">
                        <h2 class="h4 mb-3">8. Contacto</h2>
                        <p>Si tiene alguna pregunta sobre esta Política de Privacidad o sobre cómo manejamos sus datos personales, no dude en contactarnos a través de:</p>
                        <ul>
                            <li>Correo electrónico: privacy@finanzaspersonales.app</li>
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