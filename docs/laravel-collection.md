# Laravel Collection Guide

**Laravel Collection** adalah pembungkus (*wrapper*) *fluent* dan berorientasi objek untuk bekerja dengan array data di PHP. Collection menyediakan puluhan method bawaan yang memungkinkan manipulasi data secara berantai (*method chaining*).

---

## 1. Konsep Dasar & Cara Membuat Collection

Collection membungkus array biasa menjadi sebuah objek Collection.

```php
use Illuminate\Support\Collection;

// Menggunakan helper collect()
$collection = collect([1, 2, 3, 4, 5]);

// Menggunakan kelas Collection langsung
$collection = new Collection([1, 2, 3, 4, 5]);

```

> **Catatan:** Hasil dari Query Builder / Eloquent ORM di Laravel (seperti `User::all()`) secara otomatis mengembalikan sebuah instance **Eloquent Collection** (turunan dari Base Collection).

---

## 2. Method Manipulasi & Transformasi Data

### `map()`

Mengubah setiap elemen dalam collection dan mengembalikan collection baru.

```php
$numbers = collect([1, 2, 3, 4]);

$multiplied = $numbers->map(function ($item) {
    return $item * 2;
});

// Hasil: [2, 4, 6, 8]

```

---

### `filter()`

Saringan data berdasarkan kondisi tertentu.

```php
$numbers = collect([1, 2, 3, 4, 5, 6]);

$even = $numbers->filter(function ($value) {
    return $value % 2 === 0;
});

// Hasil: [2, 4, 6]

```

---

### `pluck()`

Mengambil seluruh nilai dari *key* tertentu (sangat berguna untuk array multidimensi atau data Eloquent).

```php
$users = collect([
    ['id' => 1, 'name' => 'Budi'],
    ['id' => 2, 'name' => 'Siti'],
]);

$names = $users->pluck('name');

// Hasil: ['Budi', 'Siti']

```

---

### `sortBy()` / `sortByDesc()`

Mengurutkan collection berdasarkan *key* atau fungsi callback.

```php
$products = collect([
    ['name' => 'Laptop', 'price' => 1000],
    ['name' => 'Mouse', 'price' => 20],
]);

$sorted = $products->sortBy('price');

```

---

## 3. Method Pencarian & Validasi

| Method | Deskripsi | Example |
| --- | --- | --- |
| `first()` | Mengambil elemen pertama (atau elemen pertama yang memenuhi kondisi). | `$users->first(fn($u) => $u->active);` |
| `last()` | Mengambil elemen terakhir. | `$numbers->last();` |
| `contains()` | Mengecek apakah suatu nilai/kondisi ada di dalam collection (mengembalikan `true`/`false`). | `$collection->contains('admin');` |
| `where()` | Filter berdasarkan kriteria key-value secara langsung. | `$users->where('role', 'admin');` |

---

## 4. Method Agregasi (Perhitungan)

Collection menyediakan method cepat untuk menghitung data numeric:

```php
$orders = collect([
    ['price' => 100],
    ['price' => 200],
    ['price' => 150],
]);

$total = $orders->sum('price');   // Hasil: 450
$avg   = $orders->avg('price');   // Hasil: 150
$max   = $orders->max('price');   // Hasil: 200
$count = $orders->count();        // Hasil: 3

```

---

## 5. Contoh Rantai Method (*Method Chaining*)

Kekuatan utama Collection terletak pada kemampuannya menyambung beberapa operasi sekaligus secara elegan:

```php
$data = collect([
    ['product' => 'Laptop', 'price' => 1200, 'in_stock' => true],
    ['product' => 'Mouse',  'price' => 25,   'in_stock' => false],
    ['product' => 'Monitor','price' => 300,  'in_stock' => true],
]);

// Ambil nama produk yang ready stock dengan harga > $100
$result = $data->where('in_stock', true)
               ->filter(fn($item) => $item['price'] > 100)
               ->pluck('product');

// Hasil: ['Laptop', 'Monitor']

```