<?php

namespace Tests\Feature\Api;

use App\Models\Evaluation;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EvaluationTest extends TestCase
{
    private $endpoint = '/evaluations';

    public function test_it_can_list_evaluations()
    {
        Evaluation::factory()->count(3)->create();

        $response = $this->getJson($this->endpoint);

        $response
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['comment' , 'stars' , 'date']
                ]
            ])
            ->assertOk();
    }

    public function test_it_can_list_evaluations_from_company()
    {
        Evaluation::factory()->count(5)->create([
            'company' => 1
        ]);

        $response = $this->getJson($this->endpoint . '?company=1');

        $response
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['comment' , 'stars' , 'date']
                ]
            ])
            ->assertOk();
    }

    public function test_it_cant_create_a_evaluation_with_nonexistent_company()
    {
        $response = $this->postJson($this->endpoint);

        $response
            ->assertStatus(422);
    }

    public function test_it_can_create_a_evaluation()
    {
        $response = $this->postJson($this->endpoint, [
            'company' => 99999,
            'comment' => 'fake comment',
            'stars' => 2,
        ]);

        $response
            ->assertNotFound();
    }
}
