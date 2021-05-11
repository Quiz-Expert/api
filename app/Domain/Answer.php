<?php

declare(strict_types=1);

namespace Quiz\Domain;

use Illuminate\Contracts\Support\Arrayable;

class Answer implements Arrayable
{
    protected int $user;
    protected int $question;
    protected bool $isCorrect;

    public function __construct(int $user, int $question, bool $isCorrect)
    {
        $this->user = $user;
        $this->question = $question;
        $this->isCorrect = $isCorrect;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function getUser(): int
    {
        return $this->user;
    }

    public function getQuestion(): int
    {
        return $this->question;
    }

    public function toArray(): array
    {
        return [
            "user" => $this->user,
            "question" => $this->question,
            "isCorrect" => $this->isCorrect,
        ];
    }
}
