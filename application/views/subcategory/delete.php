<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
?>
<?php include(__DIR__ . '/../note/includes/admin-notes-nav.php'); ?>

<h2>Удалить подкатегорию?</h2>

<?php if ($subcategory): ?>
    <p>Вы уверены, что хотите удалить подкатегорию "<?= htmlspecialchars($subcategory->name) ?>"?</p>
    
    <form method="post" action="<?= WebRouter::link('admin/subcategories/delete&id=' . $subcategory->id) ?>">
        <input type="hidden" name="id" value="<?= $subcategory->id ?>">
        <input type="submit" name="deleteSubcategory" value="Удалить" style="padding: 5px 15px; margin-right: 10px;">
        <input type="submit" name="cancel" value="Отмена" style="padding: 5px 15px;">
    </form>
<?php endif; ?>
