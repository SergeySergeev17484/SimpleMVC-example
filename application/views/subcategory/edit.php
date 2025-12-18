<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
?>
<?php include(__DIR__ . '/../note/includes/admin-notes-nav.php'); ?>

<h2><?= $pageTitle ?></h2>

<form method="post" action="<?= WebRouter::link('admin/subcategories/' . ($subcategory ? 'edit&id=' . $subcategory->id : 'add')) ?>">
    <div>
        <label for="name">Название подкатегории</label><br>
        <input type="text" name="name" id="name" required style="width: 100%; max-width: 400px;" 
               value="<?= htmlspecialchars($subcategory->name ?? '') ?>">
    </div>
    <br>
    
    <?php if ($subcategory && $subcategory->id): ?>
        <input type="hidden" name="id" value="<?= $subcategory->id ?>">
    <?php endif; ?>
    
    <input type="submit" name="saveChanges" value="Сохранить" style="padding: 5px 15px; margin-right: 10px;">
    <input type="submit" name="cancel" value="Назад" style="padding: 5px 15px;">
</form>

<?php if ($subcategory && $subcategory->id): ?>
    <p><a href="<?= WebRouter::link('admin/subcategories/delete&id=' . $subcategory->id) ?>" 
          onclick="return confirm('Удалить эту подкатегорию?')">Удалить эту подкатегорию</a></p>
<?php endif; ?>
