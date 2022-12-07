<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use SaasReady\Http\Requests\CurrencyDestroyRequest;
use SaasReady\Http\Requests\CurrencyIndexRequest;
use SaasReady\Http\Requests\CurrencyShowRequest;
use SaasReady\Http\Requests\CurrencyStoreRequest;
use SaasReady\Http\Requests\CurrencyUpdateRequest;
use SaasReady\Http\Responses\CurrencyResource;
use SaasReady\Models\Currency;

class CurrencyController extends Controller
{
    public function index(CurrencyIndexRequest $request): JsonResponse
    {
        $currencies = Currency::orderBy('name');

        return CurrencyResource::collection(
            $request->wantsPagination()
                ? $currencies->paginate()
                : $currencies->get()
        )->toResponse($request);
    }

    public function show(CurrencyShowRequest $request, Currency $currency): JsonResponse
    {
        return (new CurrencyResource($currency))->toResponse($request);
    }

    public function store(CurrencyStoreRequest $request): JsonResponse
    {
        $currency = Currency::create($request->validated());

        return new JsonResponse([
            'uuid' => $currency->uuid,
        ], 201);
    }

    public function update(CurrencyUpdateRequest $request, Currency $currency): JsonResponse
    {
        $currency->update($request->validated());

        return new JsonResponse([
            'uuid' => $currency->uuid,
        ]);
    }

    public function destroy(CurrencyDestroyRequest $request, Currency $currency): JsonResponse
    {
        $currency->delete();

        return new JsonResponse();
    }
}
