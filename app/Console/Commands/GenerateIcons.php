<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateIcons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:icons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate SVG Icons for Map';

    /**
     * Create a new command.
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
     */
    public function handle()
    {
        foreach (['navigation', 'circle', 'origin'] as $icon) {
            $this->createIconColors($icon);
        }
    }

    /**
     * Create icon colors loop.
     *
     * @param $icon
     */
    public function createIconColors($icon)
    {
        foreach (['000000', '137547', 'F2C037', 'd63e33'] as $color) {
            $this->createIconColorUsingHeading($icon, $color);
        }
    }

    /**
     * Create icon color loop using heading.
     *
     * @param $icon
     * @param $color
     */
    public function createIconColorUsingHeading($icon, $color)
    {
        for ($i = 0; $i <= 360; $i++) {
            $path = public_path() . '/icons/' . $icon . '-' . $color . '-' . $i . '.svg';
            file_put_contents($path, view('svg.' . $icon, [
                'rotation' => $i,
                'color' => $color,
            ])->toHtml());
        }
    }
}
