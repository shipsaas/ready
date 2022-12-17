<?php

namespace SaasReady\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use SaasReady\Http\Requests\Event\EventIndexRequest;
use SaasReady\Http\Requests\Event\EventShowRequest;
use SaasReady\Http\Responses\EventResource;
use SaasReady\Models\Event;

class EventController extends Controller
{
    public function index(EventIndexRequest $request): JsonResponse
    {
        $countries = Event::orderBy('created_at', 'DESC')
            ->where([
                'model_id' => $request->getRelatedModel()->getKey(),
                'model_type' => $request->getRelatedModel()->getMorphClass(),
            ])
            ->when($request->getUserId(), fn ($builder) => $builder->whereUserId($request->getUserId()))
            ->when($request->input('load_related_model'), fn ($builder) => $builder->with(['model']));

        return EventResource::collection($countries->paginate($request->getLimit()))
            ->toResponse($request);
    }

    public function show(EventShowRequest $request, Event $country): JsonResponse
    {
        if ($request->input('load_related_model')) {
            $country->load(['model']);
        }

        return (new EventResource($country))->toResponse($request);
    }
}
