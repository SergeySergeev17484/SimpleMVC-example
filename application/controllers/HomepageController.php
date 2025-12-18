<?php

namespace application\controllers;

use application\models\Note;

/**
 * Контроллер для домашней страницы
 */
class HomepageController extends \ItForFree\SimpleMVC\MVC\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Домашняя страница";
    
    /**
     * @var string Пусть к файлу макета 
     */
    public string $layoutPath = 'main.php';
      
    /**
     * Выводит на экран страницу "Домашняя страница"
     */
    public function indexAction()
    {
        $Note = new Note();
        $notes = $Note->getActiveList(100)['results'];
        
        // Загружаем авторов для каждой заметки
        foreach ($notes as $note) {
            $authors = $note->getAuthors();
            $note->authors = $authors;
        }
        
        $this->view->addVar('homepageTitle', $this->homepageTitle);
        $this->view->addVar('notes', $notes);
        $this->view->render('homepage/index.php');
    }
}

