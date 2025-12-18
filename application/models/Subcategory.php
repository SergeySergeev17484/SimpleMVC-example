<?php
namespace application\models;

class Subcategory extends BaseExampleModel {
    
    public string $tableName = "subcategories";
    
    public string $orderBy = 'name ASC';
    
    public ?int $id = null;
    
    public $name = null;
    
    public $categoryId = null;
    
    public $categoryName = null;
    
    public function getList(int $numRows = 1000000): array
    {
        return parent::getList($numRows);
    }
    
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (name) VALUES (:name)"; 
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
    public function update()
    {
        $sql = "UPDATE $this->tableName SET name=:name WHERE id = :id";  
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);
        $st->execute();
    }
}
