<?php

namespace SampleGalleryPhp\Actions;

use finfo;
use Imagick;
use SampleGalleryPhp\Models\Image;

class UploadAction
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function save($files, $params)
    {
        if (count($files) > 1) {
            throw new \LengthException('Too many files in this request');
        }

        $file = reset($files);

        $path = $this->upload($file);
        $thumbnail_path = $this->generateThumbnail($path);
        $image = $this->constructImageModel($path, $thumbnail_path, $params);
        $this->record($image);
    }

    public function upload($file)
    {
        if(getimagesize($file->file) === false) {
            throw new \InvalidArgumentException('The uploaded file is not an image');
        }

        if ($file->getSize() > 1024*1024*8) {
            throw new \LengthException('The uploaded file is too big');
        }

        if (!in_array(exif_imagetype($file->file), [1, 2, 3, 6])) {
            throw new \InvalidArgumentException('Image format not supported');
        }

        $filename = sprintf(
            '%s.%s',
            uniqid('upload'),
            pathinfo($file->getClientFilename(), PATHINFO_EXTENSION)
        );

        $new_path = './public/images/' . $filename;
        $file->moveTo($new_path);

        return $new_path;
    }

    public function record(Image $image)
    {
        $stmt = $this->db->prepare("
            INSERT INTO images (name, description, path, thumbnail, mime, created_at) VALUES (:name, :description, :path, :thumbnail, :mime, :created_at)
        ");
        $stmt->execute([
            ':name' => $image->name,
            ':description' => $image->description,
            ':path' => $image->path,
            ':thumbnail' => $image->thumbnail,
            ':mime' => $image->mime,
            ':created_at' => $image->created_at
        ]);
    }

    public function generateThumbnail($path)
    {
        $thumb = new Imagick($path);

        $thumb->resizeImage(320, 200, Imagick::FILTER_CATROM, 1);
        $thumb_path = dirname($path) . '/thumbs/thumb_' . basename($path);
        $thumb->writeImage($thumb_path);

        $thumb->clear();

        return $thumb_path;
    }

    private function constructImageModel($path, $thumbnail_path, $params)
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($path);

        $attrs = [
            'name' => $params['image_name'],
            'description' => $params['image_description'],
            'path' => str_replace('./public', '', $path),
            'thumbnail' => str_replace('./public', '', $thumbnail_path),
            'mime' => $mime,
            'created_at' => date("Y-m-d H:i:s")
        ];

        $image = new Image($attrs);
        return $image;
    }
}
