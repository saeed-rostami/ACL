<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UploadImage extends TestCase
{
    /**
     * A basic test example.
     *
//     * @return void
     */
    /**
    /** @test */

    public function image_upload_and_resize()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post(route('upload'), [
            'image' => $file
        ]);
        $response->assertResponseOk();
    }
}
