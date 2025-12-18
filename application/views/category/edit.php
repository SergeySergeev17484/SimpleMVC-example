<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
?>
<?php include(__DIR__ . '/../note/includes/admin-notes-nav.php'); ?>

<h2><?= $pageTitle ?></h2>

<form method="post" action="<?= WebRouter::link('admin/categories/' . ($category ? 'edit&id=' . $category->id : 'add')) ?>">
    <div>
        <label for="name">Название категории</label><br>
        <input type="text" name="name" id="name" required style="width: 100%; max-width: 400px;" 
               value="<?= htmlspecialchars($category->name ?? '') ?>">
    </div>
    <br>
    
    <?php if ($category && $category->id): ?>
        <input type="hidden" name="id" value="<?= $category->id ?>">
    <?php endif; ?>
    
    <input type="submit" name="saveChanges" value="Сохранить" style="padding: 5px 15px; margin-right: 10px;">
    <input type="submit" name="cancel" value="Назад" style="padding: 5px 15px;">
</form>

<?php if ($category && $category->id): ?>
    <p><a href="<?= WebRouter::link('admin/categories/delete&id=' . $category->id) ?>" 
          onclick="return confirm('Удалить эту категорию?')">Удалить эту категорию</a></p>
<?php endif; ?>
