<?php

declare(strict_types=1);

namespace Quiz\Domain;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Turn implements Arrayable
{
    protected int $id;
    protected int $question;

    /**
     * @var Collection|Answer[]
     */
    protected Collection $answers;

    public function __construct(int $id, int $question)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answers = new Collection();
    }

    public function getQuestion(): int
    {
        return $this->question;
    }

    public function addAnswer(Answer $answer): void
    {
        $this->answers->add($answer);
    }

    public function findUserAnswer(int $user): Answer
    {
        return $this->answers->first(fn (Answer $answer) => $answer->getUser() === $user);
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "question" => $this->question,
            "answers" => $this->answers,
        ];
    }
}
