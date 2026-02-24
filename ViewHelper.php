<?php
/**
 * Description of ViewHelper
 *
 * @author deepak
 */
class ViewHelper {

    function createFormFields($name, $type, $label, $value = '', $selectArray) {
        switch ($type) {
            case 'Text' : return '<input type="text" value="' . $value . '" id="id_' . $name . '" name="' . $name . '" class="form-control"  placeholder="' . $label . '">';
                break;
            case 'Checkbox' : return '<input type="checkbox" ' . $value . ' id="id_' . $name . '" name="' . $name . '" class="form-control"  placeholder="' . $label . '">';
                break;
            case 'select' : return $this->createSelect($name, $selectArray, $value);
                break;
        }
    }

    function createSelect($name, $array, $selected) {
        $s = '<select name="' . $name . '" id="id_' . $name . '" class="form-control">';
        foreach ($array as $key => $val) {
            $sel = '';
            if ($selected == $key) {
                $sel = 'selected';
            }
            $s .= '<option ' . $sel . ' value="' . $key . '">' . $val . '</option>';
        }
        return $s .= '</select>';
    }

}
