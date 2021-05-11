<?php

declare(strict_types=1);

namespace Quiz\Domain;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class State implements Castable, Arrayable
{
    /**
     * @var Collection|Turn[]
     */
    protected Collection $turns;

    protected int $currentTurn;

    public function __construct()
    {
        $this->turns = new Collection();
        $this->currentTurn = 1;
    }

    public function setCurrentTurn(int $number): void
    {
        $this->currentTurn = $number;
    }

    public function nextTurn(): void
    {
        $this->currentTurn++;
    }

    public function getCurrentTurnNumber(): int
    {
        return $this->currentTurn;
    }

    public function getCurrentTurn(): Turn
    {
        return $this->turns->get($this->currentTurn - 1);
    }

    public function getCurrentQuestionId(): int
    {
        return $this->getCurrentTurn()->getQuestion();
    }

    public function addTurn(Turn $turn): void
    {
        $this->turns->add($turn);
    }

    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class() implements CastsAttributes {
            public function get($model, $key, $value, $attributes): ?State
            {
                if ($value === null) {
                    return null;
                }

                $temp = json_decode($value, true);
                $state = new State();

                $state->setCurrentTurn($temp["currentTurn"]);

                foreach ($temp["turns"] as $turnData) {
                    $turn = new Turn($turnData["id"], $turnData["question"]);

                    foreach ($turnData["answers"] as $answerData) {
                        $answer = new Answer($answerData["user"], $answerData["question"], $answerData["isCorrect"]);

                        $turn->addAnswer($answer);
                    }

                    $state->addTurn($turn);
                }

                return $state;
            }

            public function set($model, $key, $value, $attributes): ?string
            {
                if ($value === null) {
                    return null;
                }

                if (is_array($value)) {
                    return json_encode($value, JSON_THROW_ON_ERROR);
                }

                return json_encode($value->toArray(), JSON_THROW_ON_ERROR);
            }
        };
    }

    public function toArray(): array
    {
        return [
            "currentTurn" => $this->currentTurn,
            "turns" => $this->turns,
        ];
    }
}
