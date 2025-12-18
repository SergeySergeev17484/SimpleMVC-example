<?php
namespace application\controllers\admin;
use application\models\Note;
use application\models\Category;
use application\models\Subcategory;
use application\models\UserModel;
use ItForFree\SimpleMVC\Config;

/* 
 *   Class-controller notes
 * 
 * 
 */

class NotesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    
    public string $layoutPath = 'admin-main.php';
    
    protected array $rules = [
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];
    
    public function indexAction()
    {
        $Note = new Note();

        $noteId = $_GET['id'] ?? null;
        
        if ($noteId) { // если указан конкретный пользователь
            $viewNotes = $Note->getById($_GET['id']);
            $authors = $viewNotes->getAuthors();
            $this->view->addVar('viewNotes', $viewNotes);
            $this->view->addVar('authors', $authors);
            $this->view->render('note/view-item.php');
        } else { // выводим полный список
            $notes = $Note->getList()['results'];
            // Загружаем авторов для каждой заметки
            foreach ($notes as $note) {
                $authors = $note->getAuthors();
                $note->authors = $authors;
            }
            $this->view->addVar('notes', $notes);
            $this->view->render('note/index.php');
        }
    }
    
    /**
     * Выводит на экран форму для создания новой статьи (только для Администратора)
     */
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewNote'])) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                
                // Обработка isActive checkbox
                $newNotes->isActive = isset($_POST['isActive']) ? 1 : 0;
                
                // Обработка даты публикации
                if (empty($newNotes->publicationDate)) {
                    $newNotes->publicationDate = (new \DateTime('NOW'))->format('Y-m-d');
                }
                
                $newNotes->insert();
                
                // Обработка авторов
                if (isset($_POST['authors']) && is_array($_POST['authors'])) {
                    $newNotes->setAuthors($_POST['authors']);
                }
                
                $this->redirect($Url::link("admin/notes/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/index"));
            }
        }
        else {
            $addNoteTitle = "Добавление новой статьи";
            
            // Загружаем категории, подкатегории и пользователей для формы
            $Category = new Category();
            $categories = $Category->getList()['results'];
            
            $Subcategory = new Subcategory();
            $subcategories = $Subcategory->getList()['results'];
            
            $UserModel = new UserModel();
            $users = $UserModel->getList()['results'];
            
            $this->view->addVar('addNoteTitle', $addNoteTitle);
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategories', $subcategories);
            $this->view->addVar('users', $users);
            
            $this->view->render('note/add.php');
        }
    }
    
    /**
     * Выводит на экран форму для редактирования статьи (только для Администратора)
     */
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            
            if (!empty($_POST['saveChanges'])) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->id = $id;
                
                // Обработка isActive checkbox
                $newNotes->isActive = isset($_POST['isActive']) ? 1 : 0;
                
                // Обработка categoryId - может быть пустым
                if (empty($_POST['categoryId'])) {
                    $newNotes->categoryId = null;
                }
                
                // Обработка subcategoryId - может быть пустым
                if (empty($_POST['subcategoryId'])) {
                    $newNotes->subcategoryId = null;
                }
                
                $newNotes->update();
                
                // Обработка авторов
                if (isset($_POST['authors']) && is_array($_POST['authors'])) {
                    $newNotes->setAuthors($_POST['authors']);
                } else {
                    $newNotes->setAuthors([]);
                }
                
                $this->redirect($Url::link("admin/notes/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/index"));
            }
        }
        else {
            $Note = new Note();
            $viewNotes = $Note->getById($id);
            
            // Загружаем авторов
            $authors = $viewNotes->getAuthors();
            $authorIds = array_column($authors, 'id');
            
            // Загружаем категории, подкатегории и пользователей для формы
            $Category = new Category();
            $categories = $Category->getList()['results'];
            
            $Subcategory = new Subcategory();
            $subcategories = $Subcategory->getList()['results'];
            
            $UserModel = new UserModel();
            $users = $UserModel->getList()['results'];
            
            $editNoteTitle = "Редактирование статьи";
            
            $this->view->addVar('viewNotes', $viewNotes);
            $this->view->addVar('editNoteTitle', $editNoteTitle);
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategories', $subcategories);
            $this->view->addVar('users', $users);
            $this->view->addVar('authorIds', $authorIds);
            
            $this->view->render('note/edit.php');   
        }
        
    }
    
    /**
     * Выводит на экран предупреждение об удалении данных (только для Администратора)
     */
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteNote'])) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->delete();
                
                $this->redirect($Url::link("admin/notes/index"));
              
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/edit&id=$id"));
            }
        }
        else {
            
            $Note = new Note();
            $deletedNote = $Note->getById($id);
            $deleteNoteTitle = "Удалить заметку?";
            
            $this->view->addVar('deleteNoteTitle', $deleteNoteTitle);
            $this->view->addVar('deletedNote', $deletedNote);
            
            $this->view->render('note/delete.php');
        }
    }
    
    
}