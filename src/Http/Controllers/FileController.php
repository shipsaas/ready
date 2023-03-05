<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use SaasReady\Events\File\FileDeleted;
use SaasReady\Http\Requests\File\FileDestroyRequest;
use SaasReady\Http\Requests\File\FileIndexRequest;
use SaasReady\Http\Requests\File\FileShowRequest;
use SaasReady\Http\Requests\File\FileStoreRequest;
use SaasReady\Models\File;

class FileController extends Controller
{
    public function index(FileIndexRequest $request): JsonResponse
    {
        // TODO: implements
        return new JsonResponse();
    }

    public function show(FileShowRequest $request, File $file): JsonResponse
    {
        // TODO: implements
        return new JsonResponse();
    }

    /**
     * Upload a file
     */
    public function store(FileStoreRequest $request): JsonResponse
    {
        // TODO: implements
        return new JsonResponse();
    }

    public function destroy(FileDestroyRequest $request, File $file): JsonResponse
    {
        $file->delete();

        Event::dispatch(new FileDeleted($file->uuid));

        return new JsonResponse();
    }
}
