<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\View\View;

class NoticiaController extends Controller
{
    public function show(Noticia $noticia): View
    {
        abort_unless($noticia->estaPublicada(), 404);
        $otras = Noticia::publicadas()->whereKeyNot($noticia->id)->latest('publicada_en')->take(3)->get();
        return view('publico.noticia', compact('noticia', 'otras'));
    }
}