<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use SaasReady\Events\ReleaseNote\ReleaseNoteCreated;
use SaasReady\Events\ReleaseNote\ReleaseNoteDeleted;
use SaasReady\Events\ReleaseNote\ReleaseNoteUpdated;
use SaasReady\Http\Requests\ReleaseNote\ReleaseNoteDestroyRequest;
use SaasReady\Http\Requests\ReleaseNote\ReleaseNoteIndexRequest;
use SaasReady\Http\Requests\ReleaseNote\ReleaseNoteShowRequest;
use SaasReady\Http\Requests\ReleaseNote\ReleaseNoteStoreRequest;
use SaasReady\Http\Requests\ReleaseNote\ReleaseNoteUpdateRequest;
use SaasReady\Http\Responses\ReleaseNoteResource;
use SaasReady\Models\ReleaseNote;

class ReleaseNoteController extends Controller
{
    public function index(ReleaseNoteIndexRequest $request): JsonResponse
    {
        $releaseNotes = ReleaseNote::latest();

        return ReleaseNoteResource::collection($releaseNotes->paginate($request->getLimit()))
            ->toResponse($request);
    }

    public function show(ReleaseNoteShowRequest $request, ReleaseNote $releaseNote): JsonResponse
    {
        return (new ReleaseNoteResource($releaseNote))->toResponse($request);
    }

    public function store(ReleaseNoteStoreRequest $request): JsonResponse
    {
        $releaseNote = ReleaseNote::create($request->validated());

        Event::dispatch(new ReleaseNoteCreated($releaseNote));

        return new JsonResponse([
            'uuid' => $releaseNote->uuid,
        ], 201);
    }

    public function update(ReleaseNoteUpdateRequest $request, ReleaseNote $releaseNote): JsonResponse
    {
        $releaseNote->update($request->validated());

        Event::dispatch(new ReleaseNoteUpdated($releaseNote));

        return new JsonResponse([
            'uuid' => $releaseNote->uuid,
        ]);
    }

    public function destroy(ReleaseNoteDestroyRequest $request, ReleaseNote $releaseNote): JsonResponse
    {
        $releaseNote->delete();

        Event::dispatch(new ReleaseNoteDeleted($releaseNote));

        return new JsonResponse();
    }
}
