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

    public function testForElse()
    {
        $this->view("blade-template.forelse", ["hobbies" => ["Coding", "Playing Guitar"]])
            ->assertSeeText("Coding")
            ->assertSeeText("Playing Guitar")
            ->assertDontSeeText("Tidak Punya Hobby");
    }

    public function testRaw()
    {
        $this->view("blade-template.raw", [])
            ->assertSeeText("Dwi")
            ->assertSeeText("Texas");
    }

    public function testWhile()
    {
        $this->view("blade-template.while", ["i" => 0])
            ->assertSeeText("The current value is 0")
            ->assertSeeText("The current value is 1")
            ->assertSeeText("The current value is 2")
            ->assertSeeText("The current value is 3")
            ->assertSeeText("The current value is 4")
            ->assertSeeText("The current value is 5")
            ->assertSeeText("The current value is 6")
            ->assertSeeText("The current value is 7")
            ->assertSeeText("The current value is 8")
            ->assertSeeText("The current value is 9");
    }

    public function testLoopVariable()
    {
        $this->view("blade-template.loop-variable", ["hobbies" => ["Coding", "Playing Guitar"]])
            ->assertSeeText("Coding")
            ->assertSeeText("Playing Guitar");
    }

    public function testClass()
    {
        $this->view("blade-template.css-class", ["hobbies" => [
            [
                "name" => "Coding",
                "love" => true
            ],
            [
                "name" => "Playing Guitar",
                "love" => false
            ],
        ]])
            ->assertSee('<li class="red bold">Coding</li>', false)
            ->assertSee('<li class="red">Playing Guitar</li>', false);
    }

    public function testInclude()
    {
        $this->view("blade-template.include", [])
            ->assertSeeText("Dwi Premayasa")
            ->assertSeeText("Selamat Datang Di Website Kami")
            ->assertSeeText("Selamat Datang Ya!");

        $this->view("blade-template.include", ["title" => "Premayasa"])
            ->assertSeeText("Premayasa")
            ->assertSeeText("Selamat Datang Di Website Kami")
            ->assertSeeText("Selamat Datang Ya!");
    }

    public function testIncludeCondition()
    {
        $this->view("blade-template.include-condition", [
            "user" => [
                "name" => "Dwi",
                "owner" => true,
            ],
            [
                "name" => "Premayasa",
                "owner" => false,
            ]
        ])
            ->assertSeeText("Selamat Datang Owner")
            ->assertSeeText("Selamat Datang Dwi");
    }

    public function testEach()
    {
        $this->view("blade-template.each", ["users" => [
            [
                "name" => "Dwi",
                "hobbies" => ["Coding", "Playing Guitar"]
            ],
            [
                "name" => "Premayasa",
                "hobbies" => ["Coding", "Gaming"]
            ]
        ]])
            ->assertSeeInOrder([".red", "Dwi", "Coding", "Playing Guitar", "Premayasa", "Coding", "Gaming"]);
    }

    public function testForm()
    {
        $this->view("blade-template.form", ["user" => [
            "premium" => false,
            "name" => "Dwi",
            "admin" => false
        ]])
            ->assertDontSee('checked')
            ->assertSee("Dwi")
            ->assertSee("readonly");
    }

    public function testCsrf()
    {
        $this->view("blade-template.csrf", [])
        ->assertSee("hidden")
        ->assertSee("_token");
    }

    public function testError()
    {
        $errors = [
            "name" => "name is required",
            "password" => "password is required"
        ];

        $this->withViewErrors($errors)
        ->view("blade-template.error", [])
        ->assertSeeText("name is required")
        ->assertSeeText("password is required");
    }
}
