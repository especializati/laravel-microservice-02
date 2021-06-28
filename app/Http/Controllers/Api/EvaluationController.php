<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluation;
use App\Http\Resources\EvaluationResource;
use App\Jobs\EvaluationCreated;
use App\Models\Evaluation;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    protected $repository;
    protected $companyService;

    public function __construct(Evaluation $model, CompanyService $companyService)
    {
        $this->repository = $model;
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company)
    {
        $evaluations = $this->repository->where('company', $company)->get();

        return EvaluationResource::collection($evaluations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvaluation $request, $company)
    {
        $response = $this->companyService->getCompany($company);
        $status = $response->status();
        if ($status != 200) {
            return response()->json([
                'message' => 'Invalid Company'
            ], $status);
        }
        $company = json_decode($response->body());

        $evaluation = $this->repository->create($request->validated());

        EvaluationCreated::dispatch($company->data->email)->onQueue('queue_email');

        return new EvaluationResource($evaluation);
    }
}
