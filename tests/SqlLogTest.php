<?php

use PHPUnit\Framework\TestCase;

class SqlLogTest extends TestCase
{
    public function test_request_does_not_trust()
    {
        $req = $this->createProxiedRequest();
        $this->assertEquals('192.168.10.10', $req->getClientIp(), 'Assert untrusted proxy x-forwarded-for header not used');
        $this->assertEquals('http', $req->getScheme(), 'Assert untrusted proxy x-forwarded-proto header not used');
        $this->assertEquals('localhost', $req->getHost(), 'Assert untrusted proxy x-forwarded-host header not used');
        $this->assertEquals(8888, $req->getPort(), 'Assert untrusted proxy x-forwarded-port header not used');
    }
}
