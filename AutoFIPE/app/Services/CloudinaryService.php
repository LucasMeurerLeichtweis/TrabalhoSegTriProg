<?php

namespace App\Services;

use Cloudinary\Cloudinary;

class CloudinaryService
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);
    }

    public function upload($arquivo): array
    {
        $resultado = $this->cloudinary
            ->uploadApi()
            ->upload($arquivo->getRealPath(), [
                'folder' => 'autofipe'
            ]);

        return [
            'url' => $resultado['secure_url'],
            'public_id' => $resultado['public_id'],
        ];
    }

    public function excluir(string $publicId): void
    {
        $this->cloudinary
            ->uploadApi()
            ->destroy($publicId);
    }
}
