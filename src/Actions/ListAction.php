<?php

namespace SampleGalleryPhp\Actions;

use PDO;
use SampleGalleryPhp\Models\Image;

class ListAction
{
    protected $db;
    protected $fetch_mode;
    protected $fetch_class_name;

    public function __construct($db)
    {
        $this->db = $db;
        $this->fetch_mode = PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE;
        $this->fetch_class_name = Image::class;
    }

    public function search($term)
    {
        $stmt = $this->db->prepare('SELECT * FROM images WHERE name LIKE :like_term OR MATCH (description) AGAINST (:term IN NATURAL LANGUAGE MODE)');
        $stmt->bindValue(':like_term', "$term%", PDO::PARAM_STR);
        $stmt->bindValue(':term', $term, PDO::PARAM_STR);
        $stmt->execute();
        $images = $stmt->fetchAll($this->fetch_mode, $this->fetch_class_name);

        return $images;
    }

    public function get($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM images WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $image = $stmt->fetchObject($this->fetch_class_name);
        return $image;
    }

    public function getAll($page = null, $limit = null)
    {
        if (!empty($page) and !empty($limit)) {
            $result = $this->db->prepare('SELECT * FROM images ORDER BY created_at DESC LIMIT :limit OFFSET :offset');
            $result->bindValue(':limit', $limit, PDO::PARAM_INT);
            $result->bindValue(':offset', ($page - 1) * $limit, PDO::PARAM_INT);
            $result->execute();
        } else {
            $result = $this->db->query('SELECT * FROM images ORDER BY created_at DESC');
        }
        $images = $result->fetchAll($this->fetch_mode, $this->fetch_class_name);
        return $images;
    }

    public function getLatest()
    {
        $result = $this->db->query('SELECT * FROM images ORDER BY created_at DESC LIMIT 3');
        $latest = $result->fetchAll($this->fetch_mode, $this->fetch_class_name);
        return $latest;
    }

    public function getTotal()
    {
        $result = $this->db->query('SELECT COUNT(*) FROM images');
        $row_count = (int) $result->fetchColumn();
        return $row_count;
    }
}
