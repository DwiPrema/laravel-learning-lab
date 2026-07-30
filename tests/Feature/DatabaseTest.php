<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseTest extends TestCase 
{
    protected function setUp(): void 
    {
        parent::setUp();
        DB::delete('delete from categories');
    }

    public function testCrud() 
    {
        DB::insert("insert into categories(id_categories, name, description, created_at) values(?, ?, ?, ?)", [
            1, "Gadget", "Gadget Categories", "2020-10-10 10:10:10"
        ]);

        $result = DB::select('select * from categories where id_categories = ?', [1]);

        self::assertCount(1, $result);
        self::assertEquals(1, $result[0]->id_categories);
        self::assertEquals("Gadget", $result[0]->name);
        self::assertEquals("Gadget Categories", $result[0]->description);
        self::assertEquals("2020-10-10 10:10:10", $result[0]->created_at);
    }

    public function testCrudNamedParameter() 
    {
        DB::insert("insert into categories(id_categories, name, description, created_at) values(:id_categories, :name, :description, :created_at)", [
            "id_categories" => 1,
            "name" => "Gadget",
            "description" => "Gadget Categories",
            "created_at" => "2020-10-10 10:10:10",
        ]);

        $result = DB::select('select * from categories where id_categories = ?', [1]);

        self::assertCount(1, $result);
        self::assertEquals(1, $result[0]->id_categories);
        self::assertEquals("Gadget", $result[0]->name);
        self::assertEquals("Gadget Categories", $result[0]->description);
        self::assertEquals("2020-10-10 10:10:10", $result[0]->created_at);
    }
}