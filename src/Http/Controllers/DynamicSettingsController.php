<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use SaasReady\Events\DynamicSetting\DynamicSettingCreated;
use SaasReady\Events\DynamicSetting\DynamicSettingDeleted;
use SaasReady\Events\DynamicSetting\DynamicSettingUpdated;
use SaasReady\Http\Requests\DynamicSetting\DynamicSettingIndexRequest;
use SaasReady\Http\Requests\DynamicSetting\DynamicSettingStoreRequest;
use SaasReady\Http\Requests\DynamicSetting\DynamicSettingUpdateRequest;
use SaasReady\Http\Responses\DynamicSettingResource;
use SaasReady\Models\DynamicSetting;

class DynamicSettingsController extends Controller
{
    public function index(DynamicSettingIndexRequest $request): JsonResponse
    {
        $dynamicSettings = DynamicSetting::orderBy('created_at', 'DESC')
            ->when($request->input('source_type'), fn ($q) => $q->where([
                'model_type' => $request->input('source_type'),
            ]))
            ->paginate($request->integer('limit') ?: 10);

        return DynamicSettingResource::collection($dynamicSettings)->response();
    }

    public function show(DynamicSetting $dynamicSetting): JsonResponse
    {
        return (new DynamicSettingResource($dynamicSetting))->response();
    }

    public function store(DynamicSettingStoreRequest $request): JsonResponse
    {
        $relatedModel = $request->getRelatedModel();

        $dynamicSetting = DynamicSetting::create([
            ...$request->validated(),
            'model_id' => $relatedModel->getKey(),
            'model_type' => $relatedModel->getMorphClass(),
        ]);

        Event::dispatch(new DynamicSettingCreated($dynamicSetting));

        return new JsonResponse([
            'uuid' => $dynamicSetting->uuid,
        ], 201);
    }

    public function update(
        DynamicSettingUpdateRequest $request,
        DynamicSetting $dynamicSetting
    ): JsonResponse {
        $relatedModel = $request->getRelatedModel();

        $dynamicSetting->update([
            ...$request->validated(),
            'model_id' => $relatedModel?->getKey() ?? $dynamicSetting->model_id,
            'model_type' => $relatedModel?->getMorphClass() ?? $dynamicSetting->model_type,
        ]);

        Event::dispatch(new DynamicSettingUpdated($dynamicSetting));

        return new JsonResponse([
            'uuid' => $dynamicSetting->uuid,
        ]);
    }

    public function destroy(DynamicSetting $dynamicSetting): JsonResponse
    {
        if ($dynamicSetting->model_id === null && $dynamicSetting->model_type === null) {
            return new JsonResponse([
                'error' => 'Global dynamic setting can not be deleted',
            ], 400);
        }

        $dynamicSetting->delete();

        Event::dispatch(new DynamicSettingDeleted($dynamicSetting));

        return new JsonResponse();
    }
}
