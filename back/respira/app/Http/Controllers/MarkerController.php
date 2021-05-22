<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coordenada;

class MarkerController extends Controller
{

    /**
     * The attributes that are mass assignable.
     * Agno de contaminacion
     * @var array
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByCity($agno)
    {
        return response()->json(Coordenada::where('agno', '=', $agno)->get());
    }

}