<?php

function __autoload($class) {
    if (file_exists('app/model/' . $class . '.php')) {
        include 'model/' . $class . '.php';
    } elseif ((file_exists('app/controller/' . $class . '.php'))) {
        include 'controller/' . $class . '.php';
        include_once("app/PFBC/Form.php");
        include_once 'PFBC/Element/Button.php';
        include_once 'PFBC/Element/Captcha.php';
        include_once 'PFBC/Element/Checkbox.php';
        include_once 'PFBC/Element/Checksort.php';
        include_once 'PFBC/Element/CKEditor.php';
        include_once 'PFBC/Element/Color.php';
        include_once 'PFBC/Element/Country.php';
        include_once 'PFBC/Element/Date.php';
        include_once 'PFBC/Element/DateTimeLocal.php';
        include_once 'PFBC/Element/DateTime.php';
        include_once 'PFBC/Element/Email.php';
        include_once 'PFBC/Element/File.php';
        include_once 'PFBC/Element/Hidden.php';
        include_once 'PFBC/Element/HTML.php';
        include_once 'PFBC/Element/jQueryUIDate.php';
        include_once 'PFBC/Element/Month.php';
        include_once 'PFBC/Element/Number.php';
        include_once 'PFBC/Element/Password.php';
        include_once 'PFBC/Element/Phone.php';
        include_once 'PFBC/Element/Radio.php';
        include_once 'PFBC/Element/Range.php';
        include_once 'PFBC/Element/Search.php';
        include_once 'PFBC/Element/Select.php';
        include_once 'PFBC/Element/Sort.php';
        include_once 'PFBC/Element/State.php';
        include_once 'PFBC/Element/Textarea.php';
        include_once 'PFBC/Element/Textbox.php';
        include_once 'PFBC/Element/Time.php';
        include_once 'PFBC/Element/TinyMCE.php';
        include_once 'PFBC/Element/Url.php';
        include_once 'PFBC/Element/Week.php';
        include_once 'PFBC/Element/YesNo.php';
        include_once 'PFBC/Validation/AlphaNumeric.php';
        include_once 'PFBC/Validation/Captcha.php';
        include_once 'PFBC/Validation/Date.php';
        include_once 'PFBC/Validation/Email.php';
        include_once 'PFBC/Validation/Numeric.php';
        include_once 'PFBC/Validation/RegExp.php';
        include_once 'PFBC/Validation/Required.php';
        include_once 'PFBC/Validation/Url.php';
    } else {
        throw new Exception('Class not found (' . $class . ')');
    }
}
