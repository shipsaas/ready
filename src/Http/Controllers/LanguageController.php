<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use SaasReady\Http\Requests\Language\LanguageDestroyRequest;
use SaasReady\Http\Requests\Language\LanguageIndexRequest;
use SaasReady\Http\Requests\Language\LanguageShowRequest;
use SaasReady\Http\Requests\Language\LanguageStoreRequest;
use SaasReady\Http\Requests\Language\LanguageUpdateRequest;
use SaasReady\Http\Responses\LanguageResource;
use SaasReady\Models\Language;

class LanguageController extends Controller
{
    public function index(LanguageIndexRequest $request): JsonResponse
    {
        $languages = Language::orderBy('name');

        return LanguageResource::collection(
            $request->wantsPagination()
                ? $languages->paginate($request->getLimit())
                : $languages->get()
        )->toResponse($request);
    }

    public function show(LanguageShowRequest $request, Language $language): JsonResponse
    {
        return (new LanguageResource($language))->toResponse($request);
    }

    public function store(LanguageStoreRequest $request): JsonResponse
    {
        $currency = Language::create($request->validated());

        return new JsonResponse([
            'uuid' => $currency->uuid,
        ], 201);
    }

    public function update(LanguageUpdateRequest $request, Language $language): JsonResponse
    {
        $language->update($request->validated());

        return new JsonResponse([
            'uuid' => $language->uuid,
        ]);
    }

    public function destroy(LanguageDestroyRequest $request, Language $language): JsonResponse
    {
        $language->delete();

        return new JsonResponse();
    }
}
