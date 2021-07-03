<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EvaluationFormRequest;
use App\Http\Resources\EvaluationResource;
use App\Services\CompanyService;
use App\Services\EvaluationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvaluationController extends Controller
{
    private $evaluationService;
    private $companyService;

    public function __construct(EvaluationService $evaluationService, CompanyService $companyService)
    {
        $this->evaluationService = $evaluationService;
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $evaluations = $this->evaluationService->getEvaluationsByCompany($request->query('company'));

        return EvaluationResource::collection($evaluations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EvaluationFormRequest $request)
    {
        $response = $this->companyService->getCompany($request->input('company', null));
        $status = $response->status();
        if ($status !== 200) {
            return response()->json(['msg' => 'Invalid company.'], $status);
        }
        $evaluation = $this->evaluationService->save($request->all());

        return new EvaluationResource($evaluation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
