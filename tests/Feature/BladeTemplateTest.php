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

    public function testUnlessStatement()
    {
        $this->view("blade-template.unless-statement", ["isAdmin" => false])->assertSeeText("You're not admin!");

        $this->view("blade-template.unless-statement", ["isAdmin" => true])->assertDontSeeText("You're not admin!");
    }

    public function testIssetAndEmpty()
    {
        $this->view("blade-template.isset-empty", ["name" => "", "hobbies" => []])->assertSeeText("I don't have any hobbies");
    }

    public function testEnv() 
    {
        $this->view("blade-template.env", [])->assertSeeText("This is test environment");
    }

    public function testSwitchStatement()
    {
        $this->view("blade-template.switch-statement", ["value" => "A"])->assertSeeText("Memuaskan");
        $this->view("blade-template.switch-statement", ["value" => "B"])->assertSeeText("Bagus");
        $this->view("blade-template.switch-statement", ["value" => "C"])->assertSeeText("Cukup");
        $this->view("blade-template.switch-statement", ["value" => "D"])->assertSeeText("Tidak Lulus");
    }

    public function testForLoop()
    {
        $this->view("blade-template.for", ["limit" => 10])
        ->assertSeeText("0")
        ->assertSeeText("1")
        ->assertSeeText("2")
        ->assertSeeText("3")
        ->assertSeeText("4")
        ->assertSeeText("5")
        ->assertSeeText("6") 
        ->assertSeeText("7")
        ->assertSeeText("8")
        ->assertSeeText("9");
    }

    public function testForEach()
    {
        $this->view("blade-template.for-each", ["hobbies" => ["playing game", "coding", "playing guitar"]])
        ->assertSeeText("playing game")
        ->assertSeeText("coding")
        ->assertSeeText("playing guitar");
    }
}
