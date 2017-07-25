<?php

/**
 * Class BowlingScorer
 */
class BowlingScorer
{
	/** @var string|int スコア */
	private $score;

	/** @var int 現在倒れてるピンの数 */
	private $now_fall_pin_num = 0;

	/** @var int 投げとる */
	private $now_throw_num = 0;

	/** @var int 倒れた */
	private $fall_pin_num = 0;



	/**
	 * 結果のスコアを計算する
	 *
	 * @param int $fall_pin_num 倒れたピンの数
	 */
	public function calc(int $fall_pin_num)
	{
		$this->fall_pin_num = $fall_pin_num;

		if (2 > $this->now_throw_num) {
			$this->recordTurn();
		} else {
			$this->initTurn();
			$this->recordTurn();
		}

		if ($this->isStrike()) {
			$this->score = 'Strike!!';
		} elseif ($this->isSpare()) {
			$this->score = 'Spare!';
		} else {
			$this->score = $this->now_fall_pin_num;
		}
	}



	/**
	 * @return string スコア
	 */
	public function getScore()
	{
		return $this->score;
	}



	/**
	 * ターンを最初に戻す
	 */
	public function initTurn()
	{
		$this->now_fall_pin_num = 0;
		$this->now_throw_num = 0;
	}



	/**
	 * ターン毎のピン数を保存
	 *
	 */
	public function recordTurn()
	{
		$this->now_fall_pin_num += $this->fall_pin_num;
		$this->now_throw_num++;
	}



	/**
	 * ストライクか
	 *
	 * @return bool ストライク
	 */
	public function isStrike()
	{
		return (10 === $this->fall_pin_num);
	}



	/**
	 * スペアか
	 *
	 * @return bool スペア
	 */
	public function isSpare()
	{
		return (10 === $this->now_fall_pin_num);
	}
}
