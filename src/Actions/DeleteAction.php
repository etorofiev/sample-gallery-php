<?php

namespace SampleGalleryPhp\Actions;

use PDO;

class DeleteAction
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM images WHERE id = :id');
        $stmt->bindValue(':id', $id,  PDO::PARAM_INT);
        $stmt->execute();
        $affected_rows = $stmt->rowCount();
        return $affected_rows;
    }
}
