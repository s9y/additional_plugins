<?php

namespace Tests;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    public function testAuthenticate()
    {
        $store = $this->prophesize(\Portier\Client\StoreInterface::class);
        $store->createNonce('johndoe@example.com')
            ->willReturn('foobar')
            ->shouldBeCalled();

        $client = new \Portier\Client\Client(
            $store->reveal(),
            'https://example.com/callback'
        );

        $this->assertEquals(
            $client->authenticate('johndoe@example.com'),
            'https://broker.portier.io/auth?' . http_build_query([
                'login_hint' => 'johndoe@example.com',
                'scope' => 'openid email',
                'nonce' => 'foobar',
                'response_type' => 'id_token',
                'response_mode' => 'form_post',
                'client_id' => 'https://example.com',
                'redirect_uri' => 'https://example.com/callback',
            ])
        );
    }

    public function testVerify()
    {
        $this->markTestIncomplete();
    }
}
