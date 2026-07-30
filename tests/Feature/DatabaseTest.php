<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use \Illuminate\Database\QueryException;

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
            1,
            "Gadget",
            "Gadget Categories",
            "2020-10-10 10:10:10"
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

    public function testTransactionSuccess()
    {
        DB::transaction(function () {
            DB::insert("insert into categories(id_categories, name, description, created_at) values(?, ?, ?, ?)", [
                1,
                "Gadget",
                "Gadget Categories",
                "2020-10-10 10:10:10"
            ]);

            DB::insert("insert into categories(id_categories, name, description, created_at) values(?, ?, ?, ?)", [
                2,
                "Food",
                "Food Categories",
                "2020-10-10 10:10:10"
            ]);
        });

        $result = DB::select('select * from categories');
        self::assertCount(2, $result);
    }

    public function testTransactionFailed()
    {
        try {
            DB::transaction(function () {
                DB::insert("insert into categories(id_categories, name, description, created_at) values(?, ?, ?, ?)", [
                    1,
                    "Gadget",
                    "Gadget Categories",
                    "2020-10-10 10:10:10"
                ]);

                DB::insert("insert into categories(id_categories, name, description, created_at) values(?, ?, ?, ?)", [
                    1,
                    "Food",
                    "Food Categories",
                    "2020-10-10 10:10:10"
                ]);
            });
        } catch (QueryException $error) {
            //expected 
        }

        $result = DB::select('select * from categories');
        self::assertCount(0, $result);
    }

    public function testManualTransactionSuccess()
    {
        try {
            DB::beginTransaction();
            DB::insert("insert into categories(id_categories, name, description, created_at) values(?, ?, ?, ?)", [
                    1,
                    "Gadget",
                    "Gadget Categories",
                    "2020-10-10 10:10:10"
                ]);

                DB::insert("insert into categories(id_categories, name, description, created_at) values(?, ?, ?, ?)", [
                    2,
                    "Food",
                    "Food Categories",
                    "2020-10-10 10:10:10"
                ]);
                DB::commit();
        } catch (QueryException $error) {
            DB::rollBack();
        }

        $result = DB::select('select * from categories');
        self::assertCount(2, $result);
    }

    public function testManualTransactionFailed()
    {
        try {
            DB::beginTransaction();
            DB::insert("insert into categories(id_categories, name, description, created_at) values(?, ?, ?, ?)", [
                    1,
                    "Gadget",
                    "Gadget Categories",
                    "2020-10-10 10:10:10"
                ]);

                DB::insert("insert into categories(id_categories, name, description, created_at) values(?, ?, ?, ?)", [
                    1,
                    "Food",
                    "Food Categories",
                    "2020-10-10 10:10:10"
                ]);
                DB::commit();
        } catch (QueryException $error) {
            DB::rollBack();
        }

        $result = DB::select('select * from categories');
        self::assertCount(0, $result);
    }
}
