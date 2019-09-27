<?php


use PHPUnit\Framework\TestCase;

class AvataaarTest extends TestCase
{
    /**
     * @var \Avataaar\Avataaar
     */
    protected $avataaar;

    protected function setUp()
    {
        $this->avataaar = new \Avataaar\Avataaar(['host' => 'https://avataaars.io']);
    }

    public function testAvatarCanGetRandomImg()
    {
        $this->assertRegExp('~^<svg .*~', $this->avataaar->get());
    }

    public function testAvatarGetFailed()
    {
        $this->expectException(\Exception::class);

        $this->avataaar = new \Avataaar\Avataaar(['host' => 'https://avataaars-failed.io']);

        $this->assertTrue($this->avataaar->get());
    }


}