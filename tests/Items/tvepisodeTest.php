<?php

namespace vfalies\tmdb\Items;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

/**
 * @cover TVEpisode
 */
class TVEpisodeTest extends TestCase
{
    protected $tmdb           = null;
    protected $TVEpisode      = null;
    protected $tv_id          = 11;
    protected $season_number  = 1;
    protected $episode_number = 1;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function setRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVEpisodeOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestTVEpisodeEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVEpisodeEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestConfigurationEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVEpisodeOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals('Winter Is Coming', $TVEpisode->getName());
    }

    /**
     * @test
     */
    public function testGetNameEmpty()
    {
        $this->setRequestTVEpisodeEmpty();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEmpty($TVEpisode->getName());
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertStringStartsWith('Jon Arryn, the Hand of the King, is dead.', $TVEpisode->getOverview());
    }

    /**
     * @test
     */
    public function testGetOverviewEmpty()
    {
        $this->setRequestTVEpisodeEmpty();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEmpty($TVEpisode->getOverview());
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals(63056, $TVEpisode->getId());
    }

    /**
     * @test
     */
    public function testGetIdEmpty()
    {
        $this->setRequestTVEpisodeEmpty();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals(0, $TVEpisode->getId());
    }

    /**
     * @test
     */
    public function testGetAirDate()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals("2011-04-17", $TVEpisode->getAirDate());
    }

    /**
     * @test
     */
    public function testGetAirDateEmpty()
    {
        $this->setRequestTVEpisodeEmpty();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals('', $TVEpisode->getAirDate());
    }

    /**
     * @test
     */
    public function testGetSeasonNumber()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals(1, $TVEpisode->getSeasonNumber());
    }

    /**
     * @test
     */
    public function testGetSeasonNumberEmpty()
    {
        $this->setRequestTVEpisodeEmpty();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals(0, $TVEpisode->getSeasonNumber());
    }

    /**
     * @test
     */
    public function testGetEpisodeNumber()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals(1, $TVEpisode->getEpisodeNumber());
    }

    /**
     * @test
     */
    public function testGetEpisodeNumberEmpty()
    {
        $this->setRequestTVEpisodeEmpty();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals(0, $TVEpisode->getEpisodeNumber());
    }

    /**
     * @test
     */
    public function testGetNote()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertInternalType('double', $TVEpisode->getNote());
        $this->assertEquals('7.11904761904762', $TVEpisode->getNote());
    }

    /**
     * @test
     */
    public function testGetNoteEmpty()
    {
        $this->setRequestTVEpisodeEmpty();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals(0, $TVEpisode->getNote());
    }

    /**
     * @test
     */
    public function testGetNoteCount()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals(21, $TVEpisode->getNoteCount());
    }

    /**
     * @test
     */
    public function testGetNoteCountEmpty()
    {
        $this->setRequestTVEpisodeEmpty();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals(0, $TVEpisode->getNoteCount());
    }

    /**
     * @test
     */
    public function testGetProductionCode()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals('101', $TVEpisode->getProductionCode());
    }

    /**
     * @test
     */
    public function testGetProductionCodeEmpty()
    {
        $this->setRequestTVEpisodeEmpty();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEmpty($TVEpisode->getProductionCode());
    }

    /**
     * @test
     */
    public function testGetStillPath()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEquals('/wrGWeW4WKxnaeA8sxJb2T9O6ryo.jpg', $TVEpisode->getStillPath());
    }

    /**
     * @test
     */
    public function testGetStillPathEmpty()
    {
        $this->setRequestTVEpisodeEmpty();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $this->assertEmpty($TVEpisode->getStillPath());
    }

    /**
     * @test
     */
    public function testGetCrew()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);
        $Crew      = $TVEpisode->getCrew();

        $this->assertInstanceOf(\Generator::class, $Crew);
        foreach ($Crew as $c) {
            $this->assertInstanceOf(\vfalies\tmdb\Results\Crew::class, $c);
        }
    }

    public function testGetPosters()
    {
        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $json_object = json_decode(file_get_contents('tests/json/imagesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $posters = $TVEpisode->getPosters();

        $this->assertInstanceOf(\Generator::class, $posters);

        foreach ($posters as $p) {
            $this->assertInstanceOf(\vfalies\tmdb\Results\Image::class, $p);
        }
    }

    /**
     * @test
     */
    public function testGetGuestStars()
    {
        $this->setRequestOk();

        $TVEpisode = new TVEpisode($this->tmdb, $this->tv_id, $this->season_number, $this->episode_number);

        $stars = $TVEpisode->getGuestStars();
        $i = 0;
        foreach ($stars as $star) {
            if ($i == 0) {
                $this->assertEquals(117642, $star->getId());
            }
            $i++;
        }
    }
}
