<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Airport;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $string = \file_get_contents(__DIR__ . "/airports.csv");

        $array = [];

        $rows = explode("\n", $string);
        foreach ($rows as $key => $row) {
            if (count($rows) - 1 == $key) {
                continue;
            }

            $columns = explode(",", $row);
            $array[] = [
                "id" => $this->clearString($columns[0] ?? ''),
                "shortcode" => $this->clearString($columns[1] ?? ''),
                "name" => $this->clearString($columns[2] ?? ''),
                "city" => $this->clearString($columns[3] ?? ''),
                "country" => $this->clearString($columns[4] ?? ''),
                "location" => $this->clearString($columns[5] ?? ''),
            ];
        }

        Airport::insert($array);
    }

    public function clearString(string $str): string
    {
        return \preg_replace(["/\"/is", "/\"/is"], ["", ""], $str);
    }
}
