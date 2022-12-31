<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use SaasReady\Http\Requests\Currency\CurrencyDestroyRequest;
use SaasReady\Http\Requests\Currency\CurrencyIndexRequest;
use SaasReady\Http\Requests\Currency\CurrencyShowRequest;
use SaasReady\Http\Requests\Currency\CurrencyStoreRequest;
use SaasReady\Http\Requests\Currency\CurrencyUpdateRequest;
use SaasReady\Http\Responses\CurrencyResource;
use SaasReady\Models\Currency;

class CurrencyController extends Controller
{
    public function index(CurrencyIndexRequest $request): JsonResponse
    {
        $currencies = Currency::orderBy('name')
            ->when($request->wantsActivated(), fn ($q) => $q->whereNotNull('activated_at'));

        return CurrencyResource::collection(
            $request->wantsPagination()
                ? $currencies->paginate($request->getLimit())
                : $currencies->get()
        )->toResponse($request);
    }

    public function show(CurrencyShowRequest $request, Currency $currency): JsonResponse
    {
        return (new CurrencyResource($currency))->toResponse($request);
    }

    public function store(CurrencyStoreRequest $request): JsonResponse
    {
        $currency = Currency::create([
            ...$request->validated(),
            'activated_at' => $request->boolean('is_active') ? now() : null,
        ]);

        return new JsonResponse([
            'uuid' => $currency->uuid,
        ], 201);
    }

    public function update(CurrencyUpdateRequest $request, Currency $currency): JsonResponse
    {
        $currency->update([
            ...$request->validated(),
            'activated_at' => $request->boolean('is_active') ? now() : null,
        ]);

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
