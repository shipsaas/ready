<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use SaasReady\Models\File;

class FileController extends Controller
{
    /**
     * Get a list of files
     */
    public function index(): JsonResponse
    {
        // TODO: implements
        return new JsonResponse();
    }

    public function show(File $file): JsonResponse
    {
        // TODO: implements
        return new JsonResponse();
    }

    /**
     * Upload a file
     */
    public function store(): JsonResponse
    {
        // TODO: implements
        return new JsonResponse();
    }

    public function destroy(File $file): JsonResponse
    {
        $file->delete();

        // TODO: implements
        return new JsonResponse();
    }
}
