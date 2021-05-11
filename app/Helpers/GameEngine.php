<?php

declare(strict_types=1);

namespace Quiz\Helpers;

use Illuminate\Support\Collection;
use Quiz\Domain\Answer;
use Quiz\Domain\State;
use Quiz\Domain\Turn;
use Quiz\Events\GameEnded;
use Quiz\Events\GameStarted;
use Quiz\Events\OpponentAnswered;
use Quiz\Events\TurnStarted;
use Quiz\Exceptions\GameException;
use Quiz\Http\Resources\Category\CategoryResource;
use Quiz\Models\Category;
use Quiz\Models\Game;
use Quiz\Models\User;

class GameEngine
{
    /**
     * @throws GameException
     */
    public function createGame(Category $category, Collection $users, int $turns = 6): Game
    {
        $questions = $this->prepareQuestions($category, $turns);
        $users = $users->pluck("id");

        $state = $this->prepareState($questions);

        $game = Game::create([
            "users" => $users,
            "category" => new CategoryResource($category),
            "questions" => $questions,
            "state" => $state,
        ]);

        return $game;
    }

    public function startGame(Game $game): Game
    {
        event(new GameStarted($game));

        return $game;
    }

    public function saveAnwser(Game $game, Answer $answer): void
    {
        $game->state->getCurrentTurn()->addAnswer($answer);

        $game->save();

        event(new OpponentAnswered($game, $answer));
    }

    public function checkIfGameIsShouldBeFinished(Game $game): bool
    {
        return $game->questions->count() <= $game->state->getCurrentTurnNumber();
    }

    public function checkIfAllPlayersAnswered(Game $game): bool
    {
        return $game->users->count() === $game->state->getCurrentTurn()->getAnswers()->count();
    }

    public function nextTurn(Game $game): void
    {
        $game->state->nextTurn();

        $game->save();

        $question = $this->getCurrentQuestion($game);

        event(new TurnStarted($game, $question));
    }

    public function checkUserAnswer(Game $game, User $user, ?string $answer): Answer
    {
        $question = $this->getCurrentQuestion($game);

        if ($answer === null) {
            $isCorrect = false;
        } else {
            $isCorrect = ($question["good_answer"] === $answer);
        }

        return new Answer($user->id, $question["id"], $isCorrect);
    }

    public function endGame(Game $game): Game
    {
        $game->finish();

        event(new GameEnded($game));

        return $game;
    }

    /**
     * @throws GameException
     */
    protected function prepareQuestions(Category $category, int $turns): Collection
    {
        if ($category->questions()->count() < $turns) {
            throw new GameException("The category doesn't have this number of questions");
        }

        $questions = $category->questions()
            ->inRandomOrder()
            ->limit($turns)
            ->get();

        return $questions;
    }

    protected function prepareState(Collection $questions): State
    {
        $state = new State();

        foreach ($questions as $index => $question) {
            $state->addTurn(new Turn($index + 1, $question->id));
        }

        return $state;
    }

    protected function getCurrentQuestion(Game $game): array
    {
        $questionId = $game->state->getCurrentQuestionId();

        return $game->questions->first(fn (array $question) => $question["id"] === $questionId);
    }
}
