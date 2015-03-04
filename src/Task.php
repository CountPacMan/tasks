<?php
class Task
{
    private $description;

    function __construct($description)
    {
        $this->description = $description;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($new_desc)
    {
        $this->description = (string) $new_desc;
    }

    function save() {
        array_push($_SESSION['taskList'], $this);
    }

    static function getALl() {
        return $_SESSION['taskList'];
    }

    static function deleteAll() {
        $_SESSION['taskList'] = [];
    }
}
