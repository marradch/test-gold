<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        $companies = Company::with('country')->paginate(2);

        return CompanyResource::collection($companies)->response();
    }

    public function show(Company $company): JsonResponse
    {
        return (new CompanyResource($company))->response();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'country_id' => 'required|exists:countries,id',
        ]);

        $company = Company::create($request->all());

        return (new CompanyResource($company))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Request $request, Company $company): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'country_id' => 'required|exists:countries,id',
        ]);

        $company->fill($request->all());
        $company->save();

        return (new CompanyResource($company))->response();
    }

    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json(['success' => true]);
    }
}

