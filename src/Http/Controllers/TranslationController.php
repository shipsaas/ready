<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use SaasReady\Http\Requests\Translation\TranslationDestroyRequest;
use SaasReady\Http\Requests\Translation\TranslationIndexRequest;
use SaasReady\Http\Requests\Translation\TranslationShowRequest;
use SaasReady\Http\Requests\Translation\TranslationStoreRequest;
use SaasReady\Http\Requests\Translation\TranslationUpdateRequest;
use SaasReady\Http\Responses\TranslationResource;
use SaasReady\Models\Translation;

class TranslationController extends Controller
{
    public function index(TranslationIndexRequest $request): JsonResponse
    {
        $translations = Translation::query()
            ->when($request->getSearchKeyword(), fn ($q) => $q->filterByKeyword($request->getSearchKeyword()))
            ->paginate($request->getLimit());

        return TranslationResource::collection($translations)
            ->toResponse($request);
    }

    public function show(TranslationShowRequest $request, Translation $translation): JsonResponse
    {
        return (new TranslationResource($translation))->toResponse($request);
    }

    public function store(TranslationStoreRequest $request): JsonResponse
    {
        $translation = Translation::create($request->validated());

        return new JsonResponse([
            'uuid' => $translation->uuid,
        ], 201);
    }

    public function update(TranslationUpdateRequest $request, Translation $translation): JsonResponse
    {
        $translation->update($request->validated());

        return new JsonResponse([
            'uuid' => $translation->uuid,
        ]);
    }

    public function destroy(TranslationDestroyRequest $request, Translation $translation): JsonResponse
    {
        $translation->delete();

        return new JsonResponse();
    }
}
