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
}