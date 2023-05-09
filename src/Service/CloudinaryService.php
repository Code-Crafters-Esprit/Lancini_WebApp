<?php

namespace App\Service;

use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class CloudinaryService
{
    private $cloudinary;

    public function __construct()
    {
        $configuration = Configuration::instance();
        $configuration->cloud->cloudName = 'djqfwdsot';
        $configuration->cloud->apiKey = '368928773594112';
        $configuration->cloud->apiSecret = 'lYVnrqKoHxVWp6rpi7XgfOjX8BY';

        $this->cloudinary = new Cloudinary($configuration);
    }

    public function uploadImage($imagePath)
    {
        $uploadApi = new UploadApi($this->cloudinary);
        $result = $uploadApi->upload($imagePath);

        if ($result['error']) {
            throw new \Exception('Image upload failed: ' . $result['error']['message']);
        }

        return $result['secure_url'];
    }
}
