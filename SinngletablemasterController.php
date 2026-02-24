<?php

/**
 * Description of SinngletablemasterController
 *
 * @author deepak
 */
class SinngletablemasterController extends CommonController {

    function addAction($res) {
        $out = array();
        if ($this->isPost()) {
            $this->objModel->add($_POST);
        }
        $out['frm'] = $this->config[$this->objModel->table];
        return $out;
    }

    function updateAction($res) {
        if ($this->isPost()) {
            return $this->objModel->update($res, $res['id']);
        }
    }

    function viewAction() {
        return $this->objModel->feetypeById($res['id']);
    }

    function listAction($res) {
        return $this->objModel->lists();
    }

    function deleteAction($res) {
        return $this->objModel->update($res, $res['id']);
    }

    function editAction($res) {
        return $this->objModel->feetypeById($res['id']);
    }

}
