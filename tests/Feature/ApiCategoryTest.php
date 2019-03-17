<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Category;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;
use Tests\TestCase;
use function count;

class ApiCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed('CategoryTableSeeder');
        $this->seed('PetTableSeeder');
    }

    public function testGuestAccess(): void
    {
        $response = $this->get('/api/categories');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function testGuestDelete(): void
    {
        $id = 1;
        $response = $this->delete('/api/categories/' . $id);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function testUserAccess(): void
    {
        Passport::actingAs(factory(User::class)->make());

        $response = $this->get('/api/categories');

        $response->assertStatus(200);
        $response->assertSeeText('Cats');
    }

    public function testUserDelete(): void
    {
        $id = 1;
        $before = count(Category::all()->toArray());
        Passport::actingAs(factory(User::class)->make());

        $response = $this->delete('/api/categories/' . $id);
        $after = count(Category::all()->toArray());

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Category was deleted.']);
        self::assertSame($after, $before - 1);
    }

    public function testUserAdd(): void
    {
        $before = count(Category::all()->toArray());
        Passport::actingAs(factory(User::class)->make());
        Storage::fake('public');
        $file = UploadedFile::fake()->image('image.jpg');
        $this->json('POST', '/api/images', ['file' => $file]);
        Storage::disk('public')->assertExists(
            config('app.image_path') . '/' . $file->hashName()
        );

        $response = $this->post('/api/categories', [
            'name' => 'Rodents',
            'image' => $file->hashName(),
            'description' => 'A mouse',
            'display_order' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $after = count(Category::all()->toArray());

        $response->assertStatus(200);
        self::assertSame($after, $before + 1);
    }

    public function testUserAddAndDelete(): void
    {
        $before = count(Category::all()->toArray());
        Passport::actingAs(factory(User::class)->make());
        Storage::fake('public');
        $file = UploadedFile::fake()->image('image.jpg');
        $this->json('POST', '/api/images', ['file' => $file]);
        Storage::disk('public')->assertExists(
            config('app.image_path') . '/' . $file->hashName()
        );
        $response = $this->post('/api/categories', [
            'name' => 'Rodents',
            'image' => $file->hashName(),
            'description' => 'A mouse',
            'display_order' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $after = count(Category::all()->toArray());
        $response->assertStatus(200);
        self::assertSame($after, $before + 1);

        $this->delete('/api/categories/' . $response->original['id']);

        Storage::disk('public')->assertMissing(
            config('app.image_path') . '/' . $file->hashName()
        );
    }
}
