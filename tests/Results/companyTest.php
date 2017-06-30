<?php

namespace vfalies\tmdb\Results;

use PHPUnit\Framework\TestCase;

/**
 * @cover Company
 */
class CompanyTest extends TestCase
{

    protected $tmdb   = null;
    protected $result = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function sendRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/searchCompanyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search       = new \vfalies\tmdb\Search($this->tmdb);
        $this->result = $search->searchCompany('lucasfilm', array('language' => 'fr-FR'))->current();
    }

    private function sendRequestConfNok()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/searchCompanyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search       = new \vfalies\tmdb\Search($this->tmdb);
        $this->result = $search->searchCompany('lucasfilm', array('language' => 'fr-FR'))->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->sendRequestOk();

        $this->assertInternalType('int', $this->result->getId());
        $this->assertEquals(1, $this->result->getId());
    }

    /**
     * @test
     * @expectedException \vfalies\tmdb\Exceptions\NotFoundException
     */
    public function testContructFailed()
    {
        $result = new \stdClass();
        $result->not_property = 'test';

        new \vfalies\tmdb\Results\Movie($this->tmdb, $result);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->sendRequestOk();

        $this->assertInternalType('string', $this->result->getName());
        $this->assertEquals('Lucasfilm', $this->result->getName());
    }

    /**
     * @test
     */
    public function testGetLogoPath()
    {
        $this->sendRequestOk();

        $this->assertInternalType('string', $this->result->getLogoPath());
        $this->assertEquals('/8rUnVMVZjlmQsJ45UGotD0Uznxj.png', $this->result->getlogoPath());
    }

}