<?php
/*
    upoadFiles
    Version: 1.0

    All rights reserved.
*/

class ControllerExtensionModuleUploadfiles extends Controller
{
    const VERSION = '1.0';


    private $error = array();

    private function writeLog($message)
    {
        $this->log->write('Module uploadfiles: ' . $message);
    }

    public function install()
    {
        $this->load->model('extension/module');
        $this->model_extension_module->getModulesByCode('uploadfiles');
    }

    public function uninstall()
    {
        $this->load->model('extension/module');
        $this->model_extension_module->deleteModulesByCode('upload_files');

        $this->writeLog('uploadfiles uninstalled');
    }

    public function index()
    {

        $this->load->model('extension/module');
        $this->load->model('extension/module/uploadfiles');

        $this->model_extension_module_uploadfiles->maybeCreateDBTableForUploadFiles();

        $all_files = $this->model_extension_module_uploadfiles->selectAllUploadFiles();


        $data['strings'] = $this->load->language('extension/module/uploadfiles');

        $this->document->addStyle('view/stylesheet/uploadfiles-admin.css');
        //получаєм дані з сервера


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $data['all_files'] =  $all_files;
        //зміна сольору

        $htmlOutput = $this->load->view('extension/module/uploadfiles.tpl', $data);
        $this->response->setOutput($htmlOutput);
        if ($this->request->server['REQUEST_METHOD'] == "POST") {
            if (isset($this->request->post['delete_file']) && $this->request->post['delete_file'] != '') {
                $delete_file = $this->request->post['delete_file'];
                if (file_exists($this->request->post['file_url'])) {
                    unlink($this->request->post['file_url']);
                }

                $this->model_extension_module_uploadfiles->deleteFileById($delete_file);
            } else if (isset($this->request->post['filename'])) {
                $json = array();
                $name_file = $this->request->post['filename'];
                if (!empty($this->request->files['file']['name'])) {
                    $filename = $this->transform($this->request->files['file']['name']);
                    if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 1000)) {
                        $json['error'] = $this->language->get('error_filename');
                    }
                    if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
                        $json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
                    }
                } else {
                    $json['error'] = $this->language->get('error_upload');
                }

                if (!isset($json['error'])) {
                    move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $filename);
                    $file_url = DIR_DOWNLOAD . $filename;
                    $this->model_extension_module_uploadfiles->addUploadFiles($file_url, $name_file);
                    $json['jan'] = $filename;
                    $json['success'] = "Файл загружен успешно!";
                }

                $this->response->setOutput($htmlOutput);
            }
        }
    }

    public function transform($string)
    {
        $arr = array('А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'JO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I', 'Й' => 'JJ', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'KH', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '"', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'EH', 'Ю' => 'JU', 'Я' => 'JA', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'jo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'jj', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shh', 'ъ' => '"', 'ы' => 'y', 'ь' => '_', 'э' => 'eh', 'ю' => 'ju', 'я' => 'ja', ' ' => '_', 'і' => 'i');
        $key = array_keys($arr);
        $val = array_values($arr);
        $translate = str_replace($key, $val, $string);
        return $translate;
    }
}
