<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed random facilities for existing approved locations
        $locations = DB::table('locations')->where('status', 'approved')->get();

        foreach ($locations as $loc) {
            DB::table('locations')->where('id', $loc->id)->update([
                'has_toilet'   => $loc->has_toilet ?? rand(0, 1),
                'has_musholla' => $loc->has_musholla ?? rand(0, 1),
                'has_wifi'     => $loc->has_wifi ?? rand(0, 1),
                'has_camping'  => $loc->has_camping ?? rand(0, 1),
            ]);
        }
    }
}
