<?php

/**
 * Class BowlingScorer
 */
class BowlingScorer
{
	/** @var string スコア */
	private $score;

	/** @var int 現在倒れてるピンの数 */
	private $now_fall_pin_num = 0;



	/**
	 * 結果のスコアを計算する
	 *
	 * @param int $fall_pin_num 倒れたピンの数
	 */
	public function calc(int $fall_pin_num)
	{
		$this->now_fall_pin_num += $fall_pin_num;

		if (10 === $fall_pin_num) {
			$this->score = 'Strike!!';
		} elseif (10 === $this->now_fall_pin_num) {
			$this->score = 'Spare!';
		}
	}



	/**
	 * @return string スコア
	 */
	public function getScore()
	{
		return $this->score;
	}
}
