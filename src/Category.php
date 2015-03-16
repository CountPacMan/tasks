<?php
  class Category {
    private $name;
    private $id;

    function __construct($name, $id = null) {
      $this->name = $name;
      $this->id = $id;
    }

    // setters
    function setName ($name) {
      $this->name = (string) $name;
    }

    function setId ($id) {
      $this->
    }

    // getters
    function getName() {
      return $this->name;
    }

    function getId() {
      return $this->id;
    }

    // dB

    function save() {
      $statement = $GLOBALS['DB']->query("INSERT INTO categories (name) VALUES ('{$this->getName()}') RETURNING id;");
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      $this->setId($result['id']);
    }

    static function getAll() {
      $returned_categories = $GLOBALS['DB']->query("SELECT * FROM categories;");
      $categories = [];
      foreach ($returned_categories as $category) {
        $name = $category['name'];
        $id = $category['id'];
        $new_category = new Category($name, $id);
        array_push($categories, $new_category);
      }
      return $categories;
    }

    static function deleteAll() {
      $GLOBALS['DB']->exec("DELETE FROM categories *;");
    }

    static function find($search_id) {
      $found_category = null;
      $categories = Category::getAll();
      foreach($categories as $category) {
        $category_id = $category->getId();
        if($category_id == $search_id) {
          $found_category = $category;
        }
      }
      return $found_category;
    }
  }
