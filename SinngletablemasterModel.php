<?php

/**
 * Description of SinngletablemasterModel
 *
 * @author deepak
 */
class SinngletablemasterModel extends CommonModel {

    public $table = '';

    public function setTable($table) {
        $this->table = $table;
    }

    public function lists() {
        $query = $this->objDb->from($this->table)
                ->where('status = ?', 1)
                ->where('deleted = ?', 0);
        return $query->fetchAll();
    }

    public function feetypeById($id) {
        $query = $this->objDb->from($this->table)
                ->where('status = ?', 1)
                ->where('deleted = ?', 0)
                ->where('id = ?', $id);
        return $query->fetchAll();
    }

    public function add($res) {
        $values = $this->createInsertUpdateArray($this->table, $res, 1);
        $query = $this->objDb->insertInto($this->table)->values($values);
        return $query->execute();
    }

    public function update($res, $id) {
        $values = $this->createInsertUpdateArray($this->table, $res, 0);
        $query = $this->objDb->update($this->table)->set($values)->where('id', $id);
        return $query->execute();
    }

}
