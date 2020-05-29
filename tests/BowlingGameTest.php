<?php


use PF\BowlingGame;

class BowlingGameTest extends \PHPUnit\Framework\TestCase
{
    public function testGetScore_withAllZeros_returnsZeroScore()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }

        $score = $game->getScore();

        self::assertEquals(0, $score);
    }

    public function testGetScore_withAllOnes_gets20asScore()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(1);
        }

        $score = $game->getScore();

        self::assertEquals(20, $score);
    }

    public function testGetScore_withASpare_getsSpareBonus()
    {
        $game = new BowlingGame();

        $game->roll(8);
        $game->roll(2);
        $game->roll(5);
        // 8 + 2 + 5 (bonus) + 5 + 17
        for ($i = 0; $i < 17; $i++) {
            $game->roll(1);
        }

        $score = $game->getScore();

        self::assertEquals(37, $score);
    }

    public function testGetScore_withAStrike_getStrikeBonus()
    {
        $game = new BowlingGame();

        $game->roll(10);

        $game->roll(3);
        $game->roll(5);
        // 10 + 2 (bonus) + 5 (bonus) + 2 + 5 + 16
        for ($i = 0; $i < 16; $i++) {
            $game->roll(1);
        }

        $score = $game->getScore();

        self::assertEquals(42, $score);
    }

    public function testGetScore_forAPerfectGame_shouldReturn300()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 12; $i++) {
            $game->roll(10);
        }

        $score = $game->getScore();

        self::assertEquals(300, $score);
    }

    public function testRoll_forMinusOne_shouldReturnException()
    {
        $game = new BowlingGame();

        self::expectException(\Exception::class);

        $game->roll(-1);
    }

    public function testRoll_forLargeRoll_shouldReturnException()
    {
        $game = new BowlingGame();

        self::expectException(\Exception::class);

        $game->roll(11);
    }

    public function testRoll_forRollCount_shouldReturnException()
    {
        $game = new BowlingGame();

        self::expectException(\Exception::class);

        for ($i = 0; $i < 13; $i++) {
            $game->roll(10);
        }
    }

    public function testRoll_forNormalRollCount_shouldReturnException()
    {
        $game = new BowlingGame();

        self::expectException(\Exception::class);

        for ($i = 0; $i < 21; $i++) {
            $game->roll(5);
        }
    }
}