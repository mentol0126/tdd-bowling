<?php

/**
 * Class BowlingScorer
 */
class BowlingScorer
{
	/** @var string スコア */
	private $score;



	/**
	 * 結果のスコアを計算する
	 *
	 * @param int $fall_pin_num 倒れたピンの数
	 */
	public function calc($fall_pin_num)
	{
		if (10 === $fall_pin_num) {
			$this->score = 'Strike!!';
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
