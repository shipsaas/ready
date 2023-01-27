<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use SaasReady\Events\Language\LanguageCreated;
use SaasReady\Events\Language\LanguageDeleted;
use SaasReady\Events\Language\LanguageUpdated;
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
        $languages = Language::orderBy('name')
            ->when($request->wantsActiveLanguages(), fn ($query) => $query->whereNotNull('activated_at'));

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
        $language = Language::create([
            ...$request->validated(),
            'activated_at' => $request->boolean('is_active') ? now() : null,
        ]);

        Event::dispatch(new LanguageCreated($language));

        return new JsonResponse([
            'uuid' => $language->uuid,
        ], 201);
    }

    public function update(LanguageUpdateRequest $request, Language $language): JsonResponse
    {
        $language->update([
            ...$request->validated(),
            'activated_at' => $request->boolean('is_active') ? now() : null,
        ]);

        Event::dispatch(new LanguageUpdated($language));

        return new JsonResponse([
            'uuid' => $language->uuid,
        ]);
    }

    public function destroy(LanguageDestroyRequest $request, Language $language): JsonResponse
    {
        $language->delete();

        Event::dispatch(new LanguageDeleted($language));

        return new JsonResponse();
    }
}
