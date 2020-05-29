<?php


namespace PF;


class BowlingGame
{
    private const MAX_ROLL_AMOUNT = 10;
    private const MAX_SCORE = 300;
    private const MAX_NORMAL_GAME_ROLLS = 20;
    private const MAX_PERFECT_GAME_ROLLS = 12;

    private array $rolls = [];

    /**
     * @param int $points
     * @throws \Exception
     */
    public function roll(int $points): void
    {
        if ($points < 0) {
            throw new \Exception('Roll cannot be negative');
        }

        if ($points > self::MAX_ROLL_AMOUNT) {
            throw new \Exception('Roll cannot be more than ' . self::MAX_ROLL_AMOUNT);
        }

        $currentScore = $this->getScore();
        if (
            ($currentScore === self::MAX_SCORE && count($this->rolls) === self::MAX_PERFECT_GAME_ROLLS) ||
            ($currentScore !== self::MAX_SCORE && count($this->rolls) === self::MAX_NORMAL_GAME_ROLLS)
        ) {
            throw new \Exception('Too much rolls');
        }

        $this->rolls[] = $points;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        $score = 0;
        $roll = 0;

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($roll)) {
                $score += $this->getStrikePoints($roll);
                ++$roll;
                continue;
            }

            if ($this->isSpare($roll)) {
                $spareBonus = $this->getSpareBonus($roll);
                if ($spareBonus) {
                    $score += $spareBonus;
                }
            }

            $score += $this->getNormalScore($roll);
            $roll += 2;
        }

        return $score;
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getNormalScore(int $roll): int
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    /**
     * @param int $roll
     * @return int
     */
    private function isSpare(int $roll): int
    {
        return $this->getNormalScore($roll) === 10;
    }

    /**
     * @param $roll
     * @return int|null
     */
    private function getSpareBonus($roll): ?int
    {
        return $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     * @return int
     */
    private function isStrike(int $roll): int
    {
        return $this->rolls[$roll] === 10;
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getStrikePoints(int $roll): int
    {
        return 10 + $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }
}