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



	/**
	 * スペアをとった場合、次の１投分のスコアを足せる
	 *
	 * @test
	 */
	public function spareScore()
	{
		$this->bowling_scorer->calc(4);
		$this->bowling_scorer->calc(6);

		$this->bowling_scorer->calc(1);
		$this->bowling_scorer->calc(3);

		$this->assertEquals(15, $this->bowling_scorer->getTotal());
	}



	/**
	 * ストライクを取った場合、次の２投分のスコアを足せる
	 *
	 * @test
	 */
	public function strikeScore()
	{
		$this->bowling_scorer->calc(10);

		$this->bowling_scorer->calc(6);
		$this->bowling_scorer->calc(3);

		$this->assertEquals(28, $this->bowling_scorer->getTotal());
	}



	/**
	 * ストライクとスペアの複合スコア計算
	 *
	 * @test
	 */
	public function spareAndStrikeScore()
	{
		// ストライクからのスペア
		$this->bowling_scorer->calc(10);
		$this->bowling_scorer->calc(3);
		$this->assertEquals(16, $this->bowling_scorer->getTotal());

		$this->bowling_scorer->calc(7);
		$this->assertEquals(30, $this->bowling_scorer->getTotal());

		$this->bowling_scorer->calc(1);
		$this->assertEquals(32, $this->bowling_scorer->getTotal());

		$this->bowling_scorer->calc(2);
		$this->assertEquals(34, $this->bowling_scorer->getTotal());

		// スペアからのストライク
		$this->bowling_scorer->calc(2);
		$this->bowling_scorer->calc(8); // 20
		$this->assertEquals(44, $this->bowling_scorer->getTotal());

		$this->bowling_scorer->calc(10); // 17
		$this->assertEquals(64, $this->bowling_scorer->getTotal());

		$this->bowling_scorer->calc(3);
		$this->assertEquals(70, $this->bowling_scorer->getTotal());

		$this->bowling_scorer->calc(4);
		$this->assertEquals(78, $this->bowling_scorer->getTotal());
	}



	/**
	 * ストライクが連続したときのスコア計算
	 *
	 * @test
	 */
	public function twoStrikeScore()
	{
		$this->bowling_scorer->calc(10); // 23
		$this->bowling_scorer->calc(10); // 18
		$this->assertEquals(30, $this->bowling_scorer->getTotal());

		$this->bowling_scorer->calc(3);
		$this->assertEquals(39, $this->bowling_scorer->getTotal());

		$this->bowling_scorer->calc(5);
		$this->assertEquals(49, $this->bowling_scorer->getTotal());
	}



	/**
	 * ストライクが３連続したときのスコア計算
	 *
	 * @test
	 */
	public function threeStrikeScore()
	{
		$this->bowling_scorer->calc(10); // 30
		$this->bowling_scorer->calc(10); // 21
		$this->bowling_scorer->calc(10); // 13
		$this->assertEquals(60, $this->bowling_scorer->getTotal());

		$this->bowling_scorer->calc(1);
		$this->assertEquals(63, $this->bowling_scorer->getTotal());

		$this->bowling_scorer->calc(2);
		$this->assertEquals(67, $this->bowling_scorer->getTotal());
	}
}
