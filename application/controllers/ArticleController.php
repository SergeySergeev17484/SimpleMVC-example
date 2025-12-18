<?php

namespace application\controllers;

use application\models\Note;
use application\models\Category;
use application\models\Subcategory;
use ItForFree\SimpleMVC\Router\WebRouter;

/**
 * Контроллер для публичного просмотра статей
 */
class ArticleController extends \ItForFree\SimpleMVC\MVC\Controller
{
    /**
     * @var string Путь к файлу макета 
     */
    public string $layoutPath = 'main.php';
      
    /**
     * Просмотр отдельной статьи
     */
    public function viewAction()
    {
        $articleId = $_GET['id'] ?? null;
        
        if (!$articleId) {
            $this->redirect(WebRouter::link("homepage/index"));
            return;
        }
        
        $Note = new Note();
        $article = $Note->getById($articleId);
        
        if (!$article || !$article->isActive) {
            $this->redirect(WebRouter::link("homepage/index"));
            return;
        }
        
        // Загружаем категорию и подкатегорию
        $category = null;
        if ($article->categoryId) {
            $Category = new Category();
            $category = $Category->getById($article->categoryId);
        }
        
        $subcategory = null;
        if ($article->subcategoryId) {
            $Subcategory = new Subcategory();
            $subcategory = $Subcategory->getById($article->subcategoryId);
        }
        
        // Загружаем авторов
        $authors = $article->getAuthors();
        
        $this->view->addVar('article', $article);
        $this->view->addVar('category', $category);
        $this->view->addVar('subcategory', $subcategory);
        $this->view->addVar('authors', $authors);
        
        $this->view->render('article/view.php');
    }
}
