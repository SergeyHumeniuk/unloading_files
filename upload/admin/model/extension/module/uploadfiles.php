<?php

class ModelExtensionModuleUploadfiles extends Model
{

    public function maybeCreateDBTableForUploadFiles()
    {
        return $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "upload_files` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `file` VARCHAR(255) NOT NULL,
              `name` VARCHAR(255),
              `date_created` VARCHAR(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;");
    }

    public function selectAllUploadFiles()
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "upload_files` ORDER BY `id` DESC");
        return $query->rows;
    }
    public function addUploadFiles($file_url, $file_name)
    {
        $date = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO `" . DB_PREFIX . "upload_files` SET `file` = '$file_url', `name` = '$file_name', `date_created`='$date'");
    }
    public function getModuleById($module_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "upload_files WHERE id = '" . (int) $module_id . "'");

        if ($query->row) {
            return json_decode($query->rows);
        } else {
            return array();
        }
    }
    public function deleteFileById($id)
    {
        $query = $this->db->query("DELETE  FROM " . DB_PREFIX . "upload_files WHERE id = '" . (int) $id . "'");
    }
}
