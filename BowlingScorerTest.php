<?php

require_once 'BowlingScorer.php';
use PHPUnit\Framework\TestCase;

/**
 * Class BowlingScorerTest
 */
class BowlingScorerTest extends TestCase
{
	/** @var BowlingScorer */
	private $bowling_scorer;



	/**
	 * 前準備
	 */
	public function setUp()
	{
		$this->bowling_scorer = new BowlingScorer();
	}



	/**
	 * 後処理
	 */
	public function tearDown()
	{
		unset($this->bowling_scorer);
	}



	/**
	 * 10ピン倒すとストライク
	 *
	 * @test
	 */
	public function strike()
	{
		$this->bowling_scorer->calc(10);
		$this->assertEquals('Strike!!', $this->bowling_scorer->getScore());
	}



	/**
	 * 10ピン倒してなければストライクじゃない
	 *
	 * @test
	 */
	public function notStrike()
	{
		$this->bowling_scorer->calc(5);
		$this->assertNotEquals('Strike!!', $this->bowling_scorer->getScore());
	}



	/**
	 * ２投げた結果の合計が10ピンならスペア
	 *
	 * @test
	 */
	public function Spare()
	{
		$this->bowling_scorer->calc(4);
		$this->bowling_scorer->calc(6);
		$this->assertEquals('Spare!', $this->bowling_scorer->getScore());
	}



	/**
	 * ２投げた結果の合計が10でなければスペアではない
	 *
	 * @test
	 */
	public function notSpare()
	{
		$this->bowling_scorer->calc(4);
		$this->bowling_scorer->calc(6);
		$this->assertEquals('Spare!', $this->bowling_scorer->getScore());
	}



	/**
	 * ２投で１０ピン未満の場合倒した数がスコアになる
	 *
	 * @test
	 */
	public function countFall()
	{
		$this->bowling_scorer->calc(3);
		$this->bowling_scorer->calc(4);
		$this->assertEquals(7, $this->bowling_scorer->getScore());
	}



	/**
	 * ２投ごとにターンが変わる
	 *
	 * @test
	 */
	public function turn()
	{
		$this->bowling_scorer->calc(2);
		$this->bowling_scorer->calc(4);
		$this->assertEquals(6, $this->bowling_scorer->getScore());

		$this->bowling_scorer->calc(1);
		$this->bowling_scorer->calc(8);
		$this->assertEquals(9, $this->bowling_scorer->getScore());
	}



	/**
	 * ストライクをとったらターンが切り変わる
	 *
	 * @test
	 */
	public function switchTurn()
	{
		$this->bowling_scorer->calc(10);
		$this->assertEquals('Strike!!', $this->bowling_scorer->getScore());

		$this->bowling_scorer->calc(1);
		$this->bowling_scorer->calc(4);
		$this->assertEquals(5, $this->bowling_scorer->getScore());
	}



	/**
	 * ターン毎に倒れたピン数を取得できる
	 *
	 * @test
	 */
	public function total()
	{
		$this->bowling_scorer->calc(2);
		$this->bowling_scorer->calc(4);

		$this->bowling_scorer->calc(1);
		$this->bowling_scorer->calc(5);

		$this->bowling_scorer->calc(1);
		$this->bowling_scorer->calc(7);

		$this->assertEquals(20, $this->bowling_scorer->getTotal());
	}
}
