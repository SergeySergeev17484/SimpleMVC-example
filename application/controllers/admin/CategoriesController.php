<?php
namespace application\controllers\admin;

use application\models\Category;
use ItForFree\SimpleMVC\Config;

class CategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'admin-main.php';
    
    protected array $rules = [
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];
    
    public function indexAction()
    {
        $Category = new Category();
        $categories = $Category->getList()['results'];
        
        $this->view->addVar('categories', $categories);
        $this->view->render('category/index.php');
    }
    
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'])) {
                $Category = new Category();
                $Category->name = $_POST['name'] ?? '';
                $Category->insert();
                $this->redirect($Url::link("admin/categories/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index"));
            }
        }
        else {
            $this->view->addVar('pageTitle', 'Добавление новой категории');
            $this->view->addVar('category', null);
            $this->view->render('category/edit.php');
        }
    }
    
    public function editAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/categories/index"));
            return;
        }
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'])) {
                $Category = new Category();
                $Category->id = $id;
                $Category->name = $_POST['name'] ?? '';
                $Category->update();
                $this->redirect($Url::link("admin/categories/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index"));
            }
        }
        else {
            $Category = new Category();
            $category = $Category->getById($id);
            
            if (!$category) {
                $this->redirect($Url::link("admin/categories/index"));
                return;
            }
            
            $this->view->addVar('pageTitle', 'Редактирование категории');
            $this->view->addVar('category', $category);
            $this->view->render('category/edit.php');
        }
    }
    
    public function deleteAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/categories/index"));
            return;
        }
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteCategory'])) {
                $Category = new Category();
                $Category->id = $id;
                $Category->delete();
                $this->redirect($Url::link("admin/categories/index"));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index"));
            }
        }
        else {
            $Category = new Category();
            $category = $Category->getById($id);
            
            $this->view->addVar('category', $category);
            $this->view->render('category/delete.php');
        }
    }
}
