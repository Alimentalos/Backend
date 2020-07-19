<?php

namespace App\Console\Commands;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use Igaster\LaravelCities\Geo;
use Illuminate\Console\Command;

class SeedGeoTableWithLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geo:reverse:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed geo table using location spatial column';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function handle()
    {
	    Geo::query()->orderBy('id')->chunk(100, function ($geos) {
		    foreach ($geos as $geo) {
			    $geo->location = new Point($geo->lat, $geo->long);
			    $geo->save();
		    }
	    });
    }
}
