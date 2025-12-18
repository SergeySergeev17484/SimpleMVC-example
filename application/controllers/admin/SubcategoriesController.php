<?php
namespace application\controllers\admin;

use application\models\Subcategory;
use application\models\Category;
use ItForFree\SimpleMVC\Config;

class SubcategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'admin-main.php';
    
    protected array $rules = [
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];
    
    public function indexAction()
    {
        $Subcategory = new Subcategory();
        $subcategories = $Subcategory->getList()['results'];
        
        $this->view->addVar('subcategories', $subcategories);
        $this->view->render('subcategory/index.php');
    }
    
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'])) {
                $Subcategory = new Subcategory();
                $Subcategory->name = $_POST['name'] ?? '';
                $Subcategory->insert();
                $this->redirect($Url::link("admin/subcategories/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index"));
            }
        }
        else {
            $Category = new Category();
            $categories = $Category->getList()['results'];
            
            $this->view->addVar('pageTitle', 'Добавление новой подкатегории');
            $this->view->addVar('subcategory', null);
            $this->view->addVar('categories', $categories);
            $this->view->render('subcategory/edit.php');
        }
    }
    
    public function editAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/subcategories/index"));
            return;
        }
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'])) {
                $Subcategory = new Subcategory();
                $Subcategory->id = $id;
                $Subcategory->name = $_POST['name'] ?? '';
                $Subcategory->update();
                $this->redirect($Url::link("admin/subcategories/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index"));
            }
        }
        else {
            $Subcategory = new Subcategory();
            $subcategory = $Subcategory->getById($id);
            
            if (!$subcategory) {
                $this->redirect($Url::link("admin/subcategories/index"));
                return;
            }
            
            $Category = new Category();
            $categories = $Category->getList()['results'];
            
            $this->view->addVar('pageTitle', 'Редактирование подкатегории');
            $this->view->addVar('subcategory', $subcategory);
            $this->view->addVar('categories', $categories);
            $this->view->render('subcategory/edit.php');
        }
    }
    
    public function deleteAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/subcategories/index"));
            return;
        }
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteSubcategory'])) {
                $Subcategory = new Subcategory();
                $Subcategory->id = $id;
                $Subcategory->delete();
                $this->redirect($Url::link("admin/subcategories/index"));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index"));
            }
        }
        else {
            $Subcategory = new Subcategory();
            $subcategory = $Subcategory->getById($id);
            
            $this->view->addVar('subcategory', $subcategory);
            $this->view->render('subcategory/delete.php');
        }
    }
}
