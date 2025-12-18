<?php
namespace application\models;

class Category extends BaseExampleModel {
    
    public string $tableName = "categories";
    
    public string $orderBy = 'name ASC';
    
    public ?int $id = null;
    
    public $name = null;
    
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
