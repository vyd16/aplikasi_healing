<?php

use Illuminate\Support\Facades\DB;

// Seed random facilities for existing approved locations
$locations = DB::table('locations')->where('status', 'approved')->get();

foreach ($locations as $loc) {
    DB::table('locations')->where('id', $loc->id)->update([
        'has_toilet'   => rand(0, 1),
        'has_musholla' => rand(0, 1),
        'has_wifi'     => rand(0, 1),
        'has_camping'  => rand(0, 1),
    ]);
}

echo "Done. Updated " . count($locations) . " locations with random facilities.\n";
