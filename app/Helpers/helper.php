<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ImageKit
{
    public $client;
    private $url;
    private $key;
    private $delete_url;
    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
        $this->url = $_ENV['IMAGE_KIT_API_ENDPOINT'];
        $this->key = $_ENV['IMAGE_KIT_API_KEY'];
        $this->delete_url = $_ENV['IMAGE_KIT_DELETE_ENDPOINT'];
    }

    public function saveImage($file, $car, $i)
    {
        $response = $this->client->request('POST', $this->url . 'upload', [
            'multipart' => [
                [
                    'name' => 'file',
                    'filename' => $file->getClientOriginalName(),
                    'contents' => $file->get(),
                    'headers' => [
                        'Content-Type' => $file->getClientMimeType(),
                    ],
                ],
                [
                    'name' => 'fileName',
                    'contents' => time() . $file->getClientOriginalName(),
                ],
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . $this->key,
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            $body = json_decode($response->getBody(), true);
            $car->images()->create([
                'image_path' => $body['url'],
                'position' => $i + 1,
                'image_id' => $body['fileId'],
            ]);
        } else {
            throw new Exception('Image upload failed for position ' . $i);
        }
    }
    public function updateImage($file, $car, $i)
    {
        $response = $this->client->request('POST', $this->url . 'upload', [
            'multipart' => [
                [
                    'name' => 'file',
                    'filename' => $file->getClientOriginalName(),
                    'contents' => $file->get(),
                    'headers' => [
                        'Content-Type' => $file->getClientMimeType(),
                    ],
                ],
                [
                    'name' => 'fileName',
                    'contents' => time() . $file->getClientOriginalName(),
                ],
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . $this->key,
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            $body = json_decode($response->getBody(), true);
            $car->images()->where('position', $i + 1)->update([
                'image_path' => $body['url'],
                'image_id' => $body['fileId'],
            ]);
        } else {
            throw new Exception('Image upload failed for position ' . $i);
        }
    }
    public function deleteImage($image_id)
    {
        try {
            $response = $this->client->request('DELETE', $this->delete_url . $image_id, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . $this->key,
                ],
            ]);

            if ($response->getStatusCode() >= 400) {
                throw new Exception('Image deletion failed for image ID: ' . $image_id);
            }
        } catch (RequestException $e) {
            throw new Exception('Image deletion request failed: ' . $e->getMessage());
        }
    }

    public function uploadFile($file, ?string $fileNamePrefix = null): array
    {
        $safePrefix = $fileNamePrefix ? trim($fileNamePrefix) . '_' : '';
        $response = $this->client->request('POST', $this->url . 'upload', [
            'multipart' => [
                [
                    'name' => 'file',
                    'filename' => $file->getClientOriginalName(),
                    'contents' => $file->get(),
                    'headers' => [
                        'Content-Type' => $file->getClientMimeType(),
                    ],
                ],
                [
                    'name' => 'fileName',
                    'contents' => $safePrefix . time() . '_' . $file->getClientOriginalName(),
                ],
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . $this->key,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Image upload failed.');
        }

        $body = json_decode($response->getBody(), true);

        if (! is_array($body) || ! isset($body['url'], $body['fileId'])) {
            throw new Exception('Image upload response is invalid.');
        }

        return [
            'url' => $body['url'],
            'fileId' => $body['fileId'],
        ];
    }
}
