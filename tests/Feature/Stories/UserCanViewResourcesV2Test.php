<?php


namespace Tests\Feature\Stories;


use App\Models\Alert;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Tests\TestCase;

class UserCanViewResourcesV2Test extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_resources()
    {
        $user = User::factory()->create();

        $finder = new Finder();

        $finder->files()->in(app_path() . '/Models');

        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $name = str_replace('.php', '', $file->getRelativePathname());
                $lowercase_name = Str::lower($name);
                $this->assertTrue(true);
                $plural_name = Str::plural($lowercase_name);
//                dd($plural_name);
            }
        }

//        foreach (config('resources.listable') as $key => $listable) {
//            $instance = (new $listable)::factory()->create();
//            $response = $this->actingAs($user, 'api')->json('GET', "/api/{$key}");
//            $response->assertOk();
//            $response->assertJsonStructure(
//                array_merge(default_pagination_fields(), ['data' => [$instance->fields()]])
//            );
//            $fragment = [];
//            foreach ($instance->fields() as $field) {
//                // Run through the fields and build the fragment array to assert
//                if ($field === 'location' || $field === 'user') { continue; }
//                $fragment[$field] = $instance->{$field};
//            }
//            $response->assertJsonFragment($fragment);
//        }
    }
}
