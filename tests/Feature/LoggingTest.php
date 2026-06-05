<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LoggingTest extends TestCase
{
    public function testLogging() {
        Log::info("Hello Info");
        Log::warning("Hello Warning");
        Log::error("Hello error");
        Log::critical("Hello critical");
        

        self::assertTrue(true);
    }

    public function testContext()
    {
        Log::info("Hello Info", ["user" => "Dwi Premayasa"]);

        self::assertTrue(true);
    }

    public function testWithContext()
    {
        Log::withContext(["user" => "Dwi Premayasa"]);

        Log::info("Hello Info");
        Log::info("Hello Info");
        Log::info("Hello Info");

        self::assertTrue(true);
    }

    public function testSelectedChannel()
    {
        $slackLogger = Log::channel('slack');
        $slackLogger->error("Hello Slack Error"); //send to slack channel

        Log::info("Hello Info"); //send to default channel
        Log::info("Hello Info"); //send to default channel

        self::assertTrue(true);
    }
}
