<?php

namespace Tests\Feature;

use App\Data\Person;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class CollectionTest extends TestCase
{
    public function testCreateCollection()
    {
        $collection = collect([1, 2, 3]);
        $this->assertEqualsCanonicalizing([1, 2, 3], $collection->all());
    }

    public function testForEach()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        foreach ($collection as $key => $value) {
            $this->assertEquals($key + 1, $value);
        }
    }

    public function testCrud()
    {
        $collection = collect([]);
        $collection->push(1, 2, 3);
        $this->assertEqualsCanonicalizing([1, 2, 3], $collection->all());

        $result = $collection->pop();
        $this->assertEquals(3, $result);
        $this->assertEqualsCanonicalizing([1, 2], $collection->all());
    }

    public function testMap()
    {
        $collection = collect([1, 2, 3]);
        $result = $collection->map(function ($value) {
            return $value * 2;
        });

        $this->assertEqualsCanonicalizing([2, 4, 6], $result->all());
    }

    public function testMapInto()
    {
        $collection = collect(["Dwi"]);
        $result = $collection->mapInto(Person::class);
        $this->assertEquals([new Person(name: "Dwi")], $result->all());
    }

    public function testMapSpread()
    {
        $collection = collect([["Dwi", "Premayasa"], ["Prema", "Yasa"]]);
        $result = $collection->mapSpread(function ($firstName, $lastName) {
            $fullName = "$firstName $lastName";
            return new Person($fullName);
        });

        $this->assertEquals([
            new Person("Dwi Premayasa"),
            new Person("Prema Yasa"),
        ], $result->all());
    }

    public function testMapToGroups()
    {
        $collection = collect([
            [
                "name" => "Dwi",
                "department" => "IT"
            ],
            [
                "name" => "Prema",
                "department" => "IT"
            ],
            [
                "name" => "Yasa",
                "department" => "HR"
            ],
        ]);

        $result = $collection->mapToGroups(function ($person) {
            return [
                $person["department"] => $person["name"]
            ];
        });

        $this->assertEquals([
            "IT" => collect(["Dwi", "Prema"]),
            "HR" => collect(["Yasa"]),
        ], $result->all());
    }

    public function testZip()
    {
        $collection1 = collect([1, 2, 3]);
        $collection2 = collect([4, 5, 6]);
        $collection3 = $collection1->zip($collection2);

        $this->assertEquals([
            collect([1, 4]),
            collect([2, 5]),
            collect([3, 6]),
        ], $collection3->all());
    }

    public function testConcat()
    {
        $collection1 = collect([1, 2, 3]);
        $collection2 = collect([4, 5, 6]);
        $collection3 = $collection1->concat($collection2);

        $this->assertEquals([1, 2, 3, 4, 5, 6], $collection3->all());
    }

    public function testCombine()
    {
        $collection1 = ["name", "country", "age"];
        $collection2 = ["Dwi", "Texas", "16"];
        $collection3 = ["Prema", "United States", "17"];
        $collection4 = collect([
            collect($collection1)->combine($collection2),
            collect($collection1)->combine($collection3),
        ]);

        $this->assertEqualsCanonicalizing([
            [
                "name" => "Dwi",
                "country" => "Texas",
                "age" => "16",
            ],
            [
                "name" => "Prema",
                "country" => "United States",
                "age" => "17",
            ],
        ], $collection4->toArray());
    }

    public function testCollapse()
    {
        $collection = collect([
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ]);

        $result = $collection->collapse();

        $this->assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
    }

    public function testFlatMap()
    {
        $collection = collect([
            [
                "name" => "Dwi",
                "hobbies" => ["Coding", "Playing Game"]
            ],
            [
                "name" => "Prema",
                "hobbies" => ["Reading", "Playing Guitar"]
            ]
        ]);

        $result = $collection->flatMap(function ($item) {
            $hobbies = $item["hobbies"];
            return $hobbies;
        });

        $this->assertEqualsCanonicalizing(["Coding", "Playing Game", "Reading", "Playing Guitar"], $result->all());
    }

    public function testStringRepresentation()
    {
        $collection = collect(["Dwi", "Prema", "Yasa"]);

        assertEquals("Dwi-Prema-Yasa", $collection->join("-"));
        assertEquals("Dwi, Prema and Yasa", $collection->join(", ", " and "));
    }

    public function testFilter()
    {
        $collection = collect([
            "Dwi" => "100",
            "Prema" => "90",
            "Yasa" => "70",
        ]);

        $result = $collection->filter(function ($value, $key) {
            return $value >= 80;
        });

        $this->assertEquals([
            "Dwi" => "100",
            "Prema" => "90"
        ], $result->all());
    }

    public function testFIlterIndex()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $result = $collection->filter(function ($value, $key) {
            return $value % 2 == 0;
        });

        $this->assertEquals([2, 4, 6, 8, 10], $result->values()->all());
    }

    public function testPartition()
    {
        $collection = collect([
            "Dwi" => "100",
            "Prema" => "90",
            "Yasa" => "70",
        ]);

        [$result1, $result2] = $collection->partition(function ($value, $key) {
            return $value >= 80;
        });

        $this->assertEquals([
            "Dwi" => "100",
            "Prema" => "90"
        ], $result1->all());

        $this->assertEquals([
            "Yasa" => "70",
        ], $result2->all());
    }
}
