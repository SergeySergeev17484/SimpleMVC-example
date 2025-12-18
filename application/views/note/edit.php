<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$Url = Config::getObject('core.router.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-notes-nav.php'); ?>

<h2><?= $editNoteTitle ?></h2>

<form id="editNote" method="post" action="<?= $Url::link("admin/notes/edit&id=" . $_GET['id'])?>">
    <div>
        <label for="title">Название статьи</label><br>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($viewNotes->title ?? '') ?>" style="width: 100%; max-width: 600px;">
    </div>
    <br>
    
    <div>
        <label for="briefDescription">Краткое описание</label><br>
        <textarea name="briefDescription" id="briefDescription" rows="3" style="width: 100%; max-width: 600px;"><?= htmlspecialchars($viewNotes->briefDescription ?? '') ?></textarea>
    </div>
    <br>
    
    <div>
        <label for="content">Содержание</label><br>
        <textarea name="content" id="content" rows="15" style="width: 100%; max-width: 800px; min-height: 300px;"><?= htmlspecialchars($viewNotes->content ?? '') ?></textarea>
    </div>
    <br>
    
    <div>
        <label for="categoryId">Категория *</label><br>
        <select name="categoryId" id="categoryId" style="width: 100%; max-width: 300px;">
            <option value="">-- Выберите категорию --</option>
            <?php foreach($categories as $category): ?>
                <option value="<?= $category->id ?>" <?= ($viewNotes->categoryId == $category->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>
    
    <div>
        <label for="subcategoryId">Подкатегория</label><br>
        <select name="subcategoryId" id="subcategoryId" style="width: 100%; max-width: 300px;">
            <option value="">-- Выберите подкатегорию --</option>
            <?php foreach($subcategories as $subcategory): ?>
                <option value="<?= $subcategory->id ?>" <?= ($viewNotes->subcategoryId == $subcategory->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($subcategory->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>
    
    <div>
        <label for="authors">Авторы</label><br>
        <select name="authors[]" id="authors" multiple size="3" style="width: 100%; max-width: 300px;">
            <?php foreach($users as $user): ?>
                <option value="<?= $user->id ?>" <?= in_array($user->id, $authorIds ?? []) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user->login) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small>Удерживайте Ctrl (или Cmd на Mac) для выбора нескольких авторов</small>
    </div>
    <br>
    
    <div>
        <label>
            <input type="checkbox" name="isActive" value="1" <?= ($viewNotes->isActive ?? 1) ? 'checked' : '' ?>>
            Статья активна (отображается на сайте)
        </label>
    </div>
    <br>

    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
    <input type="submit" name="saveChanges" value="Сохранить" style="padding: 5px 15px; margin-right: 10px;">
    <input type="submit" name="cancel" value="Назад" style="padding: 5px 15px;">
</form>