<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Quiz\Http\Requests\SuggestionRequest;
use Quiz\Http\Resources\Suggestion\SuggestionCollection;
use Quiz\Http\Resources\Suggestion\SuggestionResource;
use Quiz\Models\Question;
use Quiz\Models\Suggestion;

class SuggestionController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $suggestionQuery = Suggestion::query()->with("category");

        if ($request->has("category")) {
            $suggestionQuery->where("category_id", $request->get("category"));
        }

        if ($request->has("status")) {
            $suggestionQuery->status($request->get("status"));
        }

        return new SuggestionCollection($suggestionQuery->paginate());
    }

    public function store(SuggestionRequest $request): Response
    {
        $request->user()
            ->suggestions()
            ->create($request->getData());

        return response()->noContent();
    }

    public function show(Suggestion $suggestion): JsonResource
    {
        return new SuggestionResource($suggestion->load(["user", "category"]));
    }

    public function accept(Suggestion $suggestion): Response
    {
        if (!$suggestion->isAccepted()) {
            $suggestion->accept();

            Question::createFromSuggestion($suggestion);
        }

        return response()->noContent();
    }

    public function reject(Suggestion $suggestion): Response
    {
        $suggestion->reject();

        return response()->noContent();
    }
}
