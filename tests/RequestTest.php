<?php


use valentinbv\Jooble\Exception\JoobleRequestException;
use valentinbv\Jooble\Request;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Client;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class RequestTest extends TestCase
{
    private $source;
    private $token;
    private $testApiUrl = 'example.com';
    private $dataSuccess = '';

    protected function setUp(): void
    {
        $this->testApiUrl = 'example.com';
        $this->token = 'testToken';
        $this->dataSuccess = json_encode(['result' => 'success']);

        //stubs
        $stubClient = $this->createMock(Client::class);
        $stubResultQueryBody = $this->createMock(MessageInterface::class);
        $stubResultQueryContents = $this->createMock(StreamInterface::class);

        $stubClient->method('request')
            ->willReturn($stubResultQueryBody);
        $stubResultQueryBody->method('getBody')
            ->willReturn($stubResultQueryContents);
        $stubResultQueryContents->method('getContents')
            ->willReturn($this->dataSuccess);

        $this->source = new Request($stubClient, $this->testApiUrl);
        $this->source->setAccessToken($this->token);
    }

    public function testDecodeBodySuccess()
    {
        $this->assertEquals(
            $this->source->decodeBody($this->dataSuccess),
            \json_decode($this->dataSuccess, true)
        );
    }

    public function testDecodeBodyError()
    {
        $this->assertEquals($this->source->decodeBody('error string'), []);
    }

    public function testGetAccessToken()
    {
        $this->assertEquals($this->source->getAccessToken(), $this->token);
    }

    public function testSearchSuccess()
    {
        $this->assertEquals($this->source->search(['result' => 'success']), \json_decode($this->dataSuccess, true));
    }

    public function testSearchException()
    {
        $stubClient = $this->createMock(Client::class);
        $stubClient->method('request')
            ->will($this->throwException(new TransferException));
        $this->source = new Request($stubClient, $this->testApiUrl);

        try {
            $this->source->search();
        } catch (JoobleRequestException $e) {
            $this->assertInstanceOf(JoobleRequestException::class, $e);
        }
    }
}
