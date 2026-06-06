<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BladeTemplateTest extends TestCase
{
    public function testName()
    {
        $this->get('/hello')->assertSeeText("Dwi Premayasa");
    }

    public function testHelloView()
    {
        $this->view("blade-template.hello", ["name" => "Dwi"])->assertSeeText("Dwi");
    }
}
