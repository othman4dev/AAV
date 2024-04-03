<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Voiture;

class EstimationTest extends TestCase
{
    public function test_cars_can_be_estimated() {
        $carData =[
            'marque' => 'hyundai',
            'modele' => 'accent',
        ];
        $response = $this->postJson('/api/Estimation-Voitures', $carData);
        $response->assertStatus(202);
        $this->assertGreaterThanOrEqual(1, count($response->json()));
    }
}

