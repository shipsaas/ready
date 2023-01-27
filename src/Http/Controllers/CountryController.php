<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use SaasReady\Events\Country\CountryCreated;
use SaasReady\Events\Country\CountryDeleted;
use SaasReady\Events\Country\CountryUpdated;
use SaasReady\Http\Requests\Country\CountryDestroyRequest;
use SaasReady\Http\Requests\Country\CountryIndexRequest;
use SaasReady\Http\Requests\Country\CountryShowRequest;
use SaasReady\Http\Requests\Country\CountryStoreRequest;
use SaasReady\Http\Requests\Country\CountryUpdateRequest;
use SaasReady\Http\Responses\CountryResource;
use SaasReady\Models\Country;

class CountryController extends Controller
{
    public function index(CountryIndexRequest $request): JsonResponse
    {
        $countries = Country::orderBy('name');

        return CountryResource::collection(
            $request->wantsPagination()
                ? $countries->paginate($request->getLimit())
                : $countries->get()
        )->toResponse($request);
    }

    public function show(CountryShowRequest $request, Country $country): JsonResponse
    {
        return (new CountryResource($country))->toResponse($request);
    }

    public function store(CountryStoreRequest $request): JsonResponse
    {
        $country = Country::create($request->validated());

        Event::dispatch(new CountryCreated($country));

        return new JsonResponse([
            'uuid' => $country->uuid,
        ], 201);
    }

    public function update(CountryUpdateRequest $request, Country $country): JsonResponse
    {
        $country->update($request->validated());

        Event::dispatch(new CountryUpdated($country));

        return new JsonResponse([
            'uuid' => $country->uuid,
        ]);
    }

    public function destroy(CountryDestroyRequest $request, Country $country): JsonResponse
    {
        $country->delete();

        Event::dispatch(new CountryDeleted($country));

        return new JsonResponse();
    }
}
