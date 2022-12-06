<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use SaasReady\Http\Requests\CurrencyIndexRequest;
use SaasReady\Http\Requests\CurrencyShowRequest;
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

    public function store(): JsonResponse
    {
        return new JsonResponse();
    }

    public function update(): JsonResponse
    {
        return new JsonResponse();
    }

    public function destroy(): JsonResponse
    {
        return new JsonResponse();
    }
}
