<?php

namespace Tests\Feature;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\assertEquals;

class DatabaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("delete from categories");
    }

    public function testCrud()
    {
        DB::insert("insert into categories(id_categories, name, description, created_at) values(?, ?, ?, ?)", [
            1,
            "Gadget",
            "Gadget Categories",
            "2020-10-10 10:10:10"
        ]);

        $result = DB::select("select * from categories where id_categories = ?", [1]);

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

        $result = DB::select("select * from categories where id_categories = ?", [1]);

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

        $result = DB::select("select * from categories");
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

        $result = DB::select("select * from categories");
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

        $result = DB::select("select * from categories");
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

        $result = DB::select("select * from categories");
        self::assertCount(0, $result);
    }

    public function testInsert()
    {
        DB::table("categories")->insert([
            "id_categories" => 1,
            "name" => "Gadget",
        ]);

        DB::table("categories")->insert([
            "id_categories" => 2,
            "name" => "Food",
        ]);

        $result = DB::select("select count(id_categories) as total from categories");
        self::assertEquals(2, $result[0]->total);
    }

    public function testSelect()
    {
        $this->testInsert();

        $collection = DB::table("categories")->select(["id_categories", "name"])->get();
        self::assertNotNull($collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function insertCategories()
    {
        DB::table("categories")->insert([
            "id_categories" => 1,
            "name" => "smartphone",
            "description" => "smartphone category",
            "created_at" => "2020-10-10 10:10:10",

        ]);
        DB::table("categories")->insert([
            "id_categories" => 2,
            "name" => "food",
            "description" => "food category",
            "created_at" => "2020-10-10 10:10:10",

        ]);
        DB::table("categories")->insert([
            "id_categories" => 3,
            "name" => "laptop",
            "description" => "laptop category",
            "created_at" => "2020-10-10 10:10:10",

        ]);
        DB::table("categories")->insert([
            "id_categories" => 4,
            "name" => "fashion",
            "description" => "fashion category",
            "created_at" => "2020-10-10 10:10:10",

        ]);
    }

    public function testWhere()
    {
        $this->insertCategories();

        $collection = DB::table("categories")->where(function (Builder $builder) {
            $builder->where("id_categories", "=", 1);
            $builder->orWhere("id_categories", "=", 2);
        })->get();

        self::assertCount(2, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereBetween()
    {
        $this->insertCategories();

        $collection = DB::table("categories")
            ->whereBetween("created_at", ["2020-09-10 10:10:10", "2020-11-10 10:10:10"])
            ->get();

        self::assertCount(4, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereIn()
    {
        $this->insertCategories();

        $collection = DB::table("categories")->whereIn("id_categories", [1, 2])->get();

        self::assertCount(2, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereNotNull()
    {
        $this->insertCategories();

        $collection = DB::table("categories")
            ->whereNotNull("description")->get();

        self::assertCount(4, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereDate()
    {
        $this->insertCategories();

        $collection = DB::table("categories")
            ->whereDate("created_at", "2020-10-10")
            ->get();

        self::assertCount(4, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testUpdate()
    {
        $this->insertCategories();

        DB::table("categories")->where("name", "=", "smartphone")->update([
            "name" => "handphone"
        ]);

        $collection = DB::table("categories")->where("name", "=", "handphone")->get();
        self::assertCount(1, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testUpsert()
    {
        DB::table("categories")->updateOrInsert([
            "id_categories" => 5
        ], [
            "name" => "voucher",
            "description" => "tiket and voucher",
            "created_at" => "2020-10-10 10:10:10",
        ]);

        $collection = DB::table("categories")->where("name", "=", "voucher")->get();
        self::assertCount(1, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testIncrement()
    {
        DB::table("counters")->where('id', '=', 'sample')->increment("counter", 1);

        $collection = DB::table("counters")->where('id', '=', 'sample')->get();
        self::assertCount(1, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }
}
