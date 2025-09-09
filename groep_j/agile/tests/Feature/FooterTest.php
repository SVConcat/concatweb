<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FooterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_renders_email_link()
    {
        $response = $this->get('/');
        $response->assertSee('info@svconcat.nl');
    }

    /** @test */
    public function it_renders_phone_number()
    {
        $response = $this->get('/');
        $response->assertSee('(0)6 44848495');
    }

    /** @test */
    public function it_renders_social_media_links()
    {
        $response = $this->get('/');
        $response->assertSee('Instagram');
        $response->assertSee('LinkedIn');
        $response->assertSee('Discord');
    }

    /** @test */
    public function it_renders_privacy_statement_and_statutes_links()
    {
        $response = $this->get('/');
        $response->assertSee('Privacyverklaring');
        $response->assertSee('Statuten');
    }

    /** @test */
    public function it_renders_current_year()
    {
        $response = $this->get('/');
        $response->assertSee(date('Y'));
    }
}
