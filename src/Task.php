<?php
  class Task {
    private $description;
    private $id;

    function __construct($description, $id = null)   {
      $this->description = $description;
      $this->id = $id;
    }

    // getters
    function getDescription()  {
      return $this->description;
    }

    function getId() {
      return $this->id;
    }

    // setters
    function setDescription($new_desc)  {
      $this->description = (string) $new_desc;
    }

    function setId($id) {
      $this->id = (int) $id;
    }

    // DB
    function save() {
      $statement = $GLOBALS['DB']->query("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}') RETURNING id;");
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      $this->setId($result['id']);
    }

    static function find($search_id) {
      $found_task = null;
      $tasks = Task::getAll();
      foreach ($tasks as $task) {
        $task_id = $task->getId();
        if ($task_id == $search_id) {
          $found_task = $task;
        }
      }
      return $found_task;
    }

    static function getAll() {
      $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
      $tasks = array();
      foreach($returned_tasks as $task) {
        $description = $task['description'];
        $id = $task['id'];
        $new_task = new Task($description, $id);
        array_push($tasks, $new_task);
      }
      return $tasks;
    }

    static function deleteAll() {
      $GLOBALS['DB']->exec("DELETE FROM tasks *;");
    }
  }
?>
