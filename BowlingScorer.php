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

	/** @var int 合計でピンが倒れた数 */
	private $fall_pin_num_total = 0;

	/** @var int 次の何投分が加算対象か */
	private $next_add_count = 0;

	/** @var int ストライク数を計測 */
	private $strike_count = 0;



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
			$this->strikeProcess();
		} elseif ($this->isSpare()) {
			$this->spareProcess();
		} else {
			$this->score = $this->now_fall_pin_num;
			$this->strike_count = 0;
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
	 * @return int 倒れたピン数
	 */
	public function getTotal()
	{
		return $this->fall_pin_num_total;
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

		$this->fall_pin_num_total += $this->fall_pin_num;

		if (0 < $this->strike_count) {
			for ($i = 0; $i < $this->strike_count; $i++) {
				$this->fall_pin_num_total += $this->fall_pin_num;
			}
			$this->next_add_count--;
		} else {
			if (0 < $this->next_add_count) {
				$this->fall_pin_num_total += $this->fall_pin_num;
				$this->next_add_count--;
			}
		}
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



	/**
	 * ストライク時の処理
	 */
	public function strikeProcess()
	{
		$this->score = 'Strike!!';
		$this->initTurn();
		$this->next_add_count = 2;
		$this->strike_count++;
	}



	/**
	 * ストライク時の処理
	 */
	public function spareProcess()
	{
		$this->score = 'Spare!';
		$this->next_add_count = 1;
		$this->strike_count = 0;
	}
}
