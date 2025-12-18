<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
?>
<?php include(__DIR__ . '/../note/includes/admin-notes-nav.php'); ?>

<h2>Удалить категорию?</h2>

<?php if ($category): ?>
    <p>Вы уверены, что хотите удалить категорию "<?= htmlspecialchars($category->name) ?>"?</p>
    
    <form method="post" action="<?= WebRouter::link('admin/categories/delete&id=' . $category->id) ?>">
        <input type="hidden" name="id" value="<?= $category->id ?>">
        <input type="submit" name="deleteCategory" value="Удалить" style="padding: 5px 15px; margin-right: 10px;">
        <input type="submit" name="cancel" value="Отмена" style="padding: 5px 15px;">
    </form>
<?php endif; ?>
