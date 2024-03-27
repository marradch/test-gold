<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CountriesListResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CountryController extends Controller
{
    public function index(): JsonResponse
    {
        $countries = Country::paginate(2);

        return CountryResource::collection($countries)->response();
    }

    public function list(): JsonResponse
    {
        $countries = Country::all();

        return CountriesListResource::collection($countries)->response();
    }

    public function show(Country $country): JsonResponse
    {
        return (new CountryResource($country))->response();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'plan' => 'required|integer',
            'unit' => 'required|string',
        ]);

        $country = Country::create($request->all());

        return (new CountryResource($country))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Request $request, Country $country): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'plan' => 'required|integer',
            'unit' => 'required|string',
        ]);

        $country->fill($request->all());
        $country->save();

        return (new CountryResource($country))->response();
    }

    public function destroy(Country $country): JsonResponse
    {
        $country->delete();

        return response()->json(['success' => true]);
    }
}
