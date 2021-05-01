<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Quiz\Http\Requests\QuestionRequest;
use Quiz\Http\Resources\QuestionCollection;
use Quiz\Http\Resources\QuestionResource;
use Quiz\Models\Question;

class QuestionController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $questionQuery = Question::query();

        if ($request->has("category")) {
            $questionQuery->where("category_id", $request->get("category"));
        }

        return new QuestionCollection($questionQuery->paginate());
    }

    public function create(QuestionRequest $request): JsonResource
    {
        $question = Question::query()->create($request->getData());

        return new QuestionResource($question->load("category"));
    }

    public function show(Question $question): JsonResource
    {
        return new QuestionResource($question->load("category"));
    }

    public function update(Question $question, QuestionRequest $request): JsonResource
    {
        $question->update($request->getData());

        return new QuestionResource($question->load("category"));
    }

    /**
     * @throws Exception
     */
    public function delete(Question $question): Response
    {
        $question->delete();

        return response()->noContent();
    }
}
