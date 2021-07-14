<?php
/*
    upoadFiles
    Version: 1.0

    All rights reserved.
*/

class ControllerExtensionModuleUpoadfiles extends Controller
{
    const VERSION = '1.0';


    private $error = array();

    private function writeLog($message)
    {
        $this->log->write('Module upoadfiles: ' . $message);
    }

    public function install()
    {
    }

    public function uninstall()
    {
        $this->load->model('extension/module');
        $this->model_extension_module->deleteModulesByCode('upload_files');

        $this->writeLog('upoadfiles uninstalled');
    }

    public function index()
    {

        $this->load->model('extension/module');
        $this->load->model('extension/module/upoadfiles');

        $this->model_extension_module_uploadfiles->maybeCreateDBTableForUploadFiles();
        $all_files = $this->model_extension_module_uploadfiles->selectAllUploadFiles();


        $data['strings'] = $this->load->language('extension/module/upoadfiles');

        $this->document->addStyle('view/stylesheet/upoadfiles-admin.css');
        //получаєм дані з сервера


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $data['all_files'] =  $all_files;
        //зміна сольору

        $htmlOutput = $this->load->view('extension/module/upoadfiles.tpl', $data);
        $this->response->setOutput($htmlOutput);
    }
}
