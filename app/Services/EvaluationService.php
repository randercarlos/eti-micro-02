<?php

namespace App\Services;

use App\Models\Evaluation;

class EvaluationService extends AbstractService
{
    protected $model;

    public function __construct() {
        $this->model = new Evaluation();
    }

    public function getEvaluationsByCompany($company) {
        $evaluations = $this->model->where(function($query) use ($company) {
            if ($company) {
                $query->where('company', (int) $company);
            }
        })->get();

        return $evaluations;
    }
}
