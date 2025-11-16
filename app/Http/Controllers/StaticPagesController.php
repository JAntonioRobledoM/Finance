<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    /**
     * Mostrar la página de términos y condiciones.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function terms()
    {
        return view('static.terms');
    }

    /**
     * Mostrar la página de política de privacidad.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function privacy()
    {
        return view('static.privacy');
    }
}
