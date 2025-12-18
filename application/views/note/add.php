<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
?>

<?php include('includes/admin-notes-nav.php'); ?>
<h2><?= $addNoteTitle ?></h2>

<form id="addNote" method="post" action="<?= WebRouter::link("admin/notes/add")?>"> 
    <div>
        <label for="title">Название статьи</label><br>
        <input type="text" name="title" id="title" style="width: 100%; max-width: 600px;">
    </div>
    <br>
    
    <div>
        <label for="briefDescription">Краткое описание</label><br>
        <textarea name="briefDescription" id="briefDescription" rows="3" style="width: 100%; max-width: 600px;"></textarea>
    </div>
    <br>
    
    <div>
        <label for="content">Содержание</label><br>
        <textarea name="content" id="content" rows="15" style="width: 100%; max-width: 800px; min-height: 300px;"></textarea>
    </div>
    <br>
    
    <div>
        <label for="categoryId">Категория *</label><br>
        <select name="categoryId" id="categoryId" style="width: 100%; max-width: 300px;">
            <option value="">-- Выберите категорию --</option>
            <?php foreach($categories as $category): ?>
                <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>
    
    <div>
        <label for="subcategoryId">Подкатегория</label><br>
        <select name="subcategoryId" id="subcategoryId" style="width: 100%; max-width: 300px;">
            <option value="">-- Выберите подкатегорию --</option>
            <?php foreach($subcategories as $subcategory): ?>
                <option value="<?= $subcategory->id ?>"><?= htmlspecialchars($subcategory->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>
    
    <div>
        <label for="authors">Авторы</label><br>
        <select name="authors[]" id="authors" multiple size="3" style="width: 100%; max-width: 300px;">
            <?php foreach($users as $user): ?>
                <option value="<?= $user->id ?>"><?= htmlspecialchars($user->login) ?></option>
            <?php endforeach; ?>
        </select>
        <small>Удерживайте Ctrl (или Cmd на Mac) для выбора нескольких авторов</small>
    </div>
    <br>
    
    <div>
        <label>
            <input type="checkbox" name="isActive" value="1" checked>
            Статья активна (отображается на сайте)
        </label>
    </div>
    <br>
    
    <input type="submit" name="saveNewNote" value="Сохранить" style="padding: 5px 15px; margin-right: 10px;">
    <input type="submit" name="cancel" value="Назад" style="padding: 5px 15px;">
</form>    
