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

    public function testDisabledBlade()
    {
        $this->get('/disabled-blade')->assertDontSee("Prema")->assertSeeText('Hello {{$name}}');
    }

    public function testIfStatement()
    {
        $this->view("blade-template.if-statement", ["hobbies" => []])->assertSeeText("I don't have any hobbies!");

        $this->view("blade-template.if-statement", ["hobbies" => ["playing guitar"]])->assertSeeText("I have one hobby!");

        $this->view("blade-template.if-statement", ["hobbies" => ["playing guitar", "coding"]])->assertSeeText("I have multiple hobbies!");
    }
}
