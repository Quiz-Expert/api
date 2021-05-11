<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Quiz\Http\Requests\MistakeRequest;
use Quiz\Http\Resources\Mistake\MistakeCollection;
use Quiz\Http\Resources\Mistake\MistakeResource;
use Quiz\Models\Mistake;
use Quiz\Notifications\MistakeClosed;

class MistakeController extends Controller
{
    public function index(): ResourceCollection
    {
        $mistakes = Mistake::query()
            ->with("question")
            ->paginate();

        return new MistakeCollection($mistakes);
    }

    public function store(MistakeRequest $request): Response
    {
        $request->user()
            ->mistakes()
            ->create($request->getData());

        return response()->noContent();
    }

    public function show(Mistake $mistake): JsonResource
    {
        return new MistakeResource($mistake->load(["user", "question"]));
    }

    public function close(Mistake $mistake): Response
    {
        if ($mistake->is_active) {
            $mistake->close();

            $mistake->user->notify(new MistakeClosed($mistake));
        }

        return response()->noContent();
    }
}
