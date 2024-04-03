<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstimationVoitureRequest;
use App\Models\Voiture;
use Illuminate\Http\Request;

class VoitureController extends Controller
{
    public function index()
    {
        $voitures = Voiture::all();
        return response()->json($voitures, 201);
    }
    public function estimation(EstimationVoitureRequest $request)
    {
        $voitures = Voiture::where('marque', $request->marque)->where('modele', $request->modele)->get();
        $CountVoitures = $voitures->count();
        $totalPrix = 0;
        foreach ($voitures as $voiuturePrix) {
            $totalPrix = $totalPrix + $voiuturePrix->prix;
        }
        if ($CountVoitures == 0) {
            return response()->json(['error' => 'No Voiture found'], 404);
        }
        $MoyannePrix = $totalPrix / $CountVoitures;
        return response()->json(['success' => 'the estimation price is:  ' . $MoyannePrix . ' DH'], 202);
    }
}