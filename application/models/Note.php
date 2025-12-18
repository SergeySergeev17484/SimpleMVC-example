<?php
namespace application\models;
/* 
 * class Note
 * 
 * 
 */

class Note extends BaseExampleModel {
    
    public string $tableName = "notes";
    
    public string $orderBy = 'publicationDate DESC';
    
    public ?int $id = null;
    
    public $title = null;
    
    public $briefDescription = null;
    
    public $content = null;
    
    public $publicationDate = null;
    
    public $categoryId = null;
    
    public $subcategoryId = null;
    
    public $isActive = 1;
    
    public $categoryName = null;
    
    public $subcategoryName = null;
    
    public $authors = [];
    
    /**
     * Получить список авторов статьи
     */
    public function getAuthors()
    {
        if (!$this->id) {
            return [];
        }
        
        $sql = "SELECT u.id, u.login FROM users u 
                INNER JOIN note_authors na ON u.id = na.userId 
                WHERE na.noteId = :noteId";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":noteId", $this->id, \PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Установить авторов статьи
     */
    public function setAuthors(array $authorIds)
    {
        if (!$this->id) {
            return;
        }
        
        // Удаляем старых авторов
        $sql = "DELETE FROM note_authors WHERE noteId = :noteId";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":noteId", $this->id, \PDO::PARAM_INT);
        $st->execute();
        
        // Добавляем новых
        if (!empty($authorIds)) {
            $sql = "INSERT INTO note_authors (noteId, userId) VALUES (:noteId, :userId)";
            $st = $this->pdo->prepare($sql);
            foreach ($authorIds as $userId) {
                $st->bindValue(":noteId", $this->id, \PDO::PARAM_INT);
                $st->bindValue(":userId", $userId, \PDO::PARAM_INT);
                $st->execute();
            }
        }
    }
    
    /**
     * Получить название категории
     */
    public function getCategoryName()
    {
        if (!$this->categoryId) {
            return null;
        }
        $Category = new Category();
        $category = $Category->getById($this->categoryId);
        return $category ? $category->name : null;
    }
    
    /**
     * Получить название подкатегории
     */
    public function getSubcategoryName()
    {
        if (!$this->subcategoryId) {
            return null;
        }
        $Subcategory = new Subcategory();
        $subcategory = $Subcategory->getById($this->subcategoryId);
        return $subcategory ? $subcategory->name : null;
    }
    
    /**
     * Переопределяем getList для включения категорий
     */
    public function getList(int $numRows = 1000000): array
    {
        $sql = "SELECT n.*, c.name as categoryName, sc.name as subcategoryName 
                FROM $this->tableName n
                LEFT JOIN categories c ON n.categoryId = c.id
                LEFT JOIN subcategories sc ON n.subcategoryId = sc.id
                ORDER BY $this->orderBy
                LIMIT :numRows";
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":numRows", $numRows, \PDO::PARAM_INT);
        $st->execute();
        $list = [];
        
        while ($row = $st->fetch(\PDO::FETCH_ASSOC)) {
            $note = $this->loadFromArray($row);
            $note->categoryName = $row['categoryName'] ?? null;
            $note->subcategoryName = $row['subcategoryName'] ?? null;
            $list[] = $note;
        }
        
        return ['results' => $list];
    }
    
    /**
     * Получить список активных статей
     */
    public function getActiveList(int $numRows = 1000000): array
    {
        $sql = "SELECT n.*, c.name as categoryName, sc.name as subcategoryName 
                FROM $this->tableName n
                LEFT JOIN categories c ON n.categoryId = c.id
                LEFT JOIN subcategories sc ON n.subcategoryId = sc.id
                WHERE n.isActive = 1
                ORDER BY $this->orderBy
                LIMIT :numRows";
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":numRows", $numRows, \PDO::PARAM_INT);
        $st->execute();
        $list = [];
        
        while ($row = $st->fetch(\PDO::FETCH_ASSOC)) {
            $note = $this->loadFromArray($row);
            $note->categoryName = $row['categoryName'] ?? null;
            $note->subcategoryName = $row['subcategoryName'] ?? null;
            $list[] = $note;
        }
        
        return ['results' => $list];
    }
    
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (title, briefDescription, content, publicationDate, categoryId, subcategoryId, isActive) 
                VALUES (:title, :briefDescription, :content, :publicationDate, :categoryId, :subcategoryId, :isActive)"; 
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":publicationDate", (new \DateTime('NOW'))->format('Y-m-d'), \PDO::PARAM_STR);
        $st->bindValue( ":title", $this->title, \PDO::PARAM_STR );
        $st->bindValue( ":briefDescription", $this->briefDescription, \PDO::PARAM_STR );
        $st->bindValue( ":content", $this->content, \PDO::PARAM_STR );
        $st->bindValue( ":categoryId", $this->categoryId, $this->categoryId ? \PDO::PARAM_INT : \PDO::PARAM_NULL );
        $st->bindValue( ":subcategoryId", $this->subcategoryId, $this->subcategoryId ? \PDO::PARAM_INT : \PDO::PARAM_NULL );
        $st->bindValue( ":isActive", $this->isActive ? 1 : 0, \PDO::PARAM_INT );
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
    public function update()
    {
        $sql = "UPDATE $this->tableName SET title=:title, briefDescription=:briefDescription, content=:content, 
                categoryId=:categoryId, subcategoryId=:subcategoryId, isActive=:isActive 
                WHERE id = :id";  
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":title", $this->title, \PDO::PARAM_STR );
        $st->bindValue( ":briefDescription", $this->briefDescription, \PDO::PARAM_STR );
        $st->bindValue( ":content", $this->content, \PDO::PARAM_STR );
        $st->bindValue( ":categoryId", $this->categoryId, $this->categoryId ? \PDO::PARAM_INT : \PDO::PARAM_NULL );
        $st->bindValue( ":subcategoryId", $this->subcategoryId, $this->subcategoryId ? \PDO::PARAM_INT : \PDO::PARAM_NULL );
        $st->bindValue( ":isActive", $this->isActive ? 1 : 0, \PDO::PARAM_INT );
        $st->bindValue( ":id", $this->id, \PDO::PARAM_INT );
        $st->execute();
    }
}

