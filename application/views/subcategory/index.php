<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
?>
<?php include(__DIR__ . '/../note/includes/admin-notes-nav.php'); ?>

<h2>Список подкатегорий</h2>

<?php if (!empty($subcategories)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">Название подкатегории</th>
      <th scope="col"></th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($subcategories as $subcategory): ?>
    <tr style="cursor: pointer;" onclick="location='<?= WebRouter::link('admin/subcategories/edit&id=' . $subcategory->id) ?>'">
        <td><?= htmlspecialchars($subcategory->name) ?></td>
        <td><a href="<?= WebRouter::link('admin/subcategories/edit&id=' . $subcategory->id) ?>">[Редактировать]</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p><?= count($subcategories) ?> подкатегори<?= (count($subcategories) != 1) ? 'й' : 'я' ?> всего.</p>
<?php else:?>
    <p>Список подкатегорий пуст</p>
<?php endif; ?>

<p><a href="<?= WebRouter::link('admin/subcategories/add') ?>">+ Добавить новую подкатегорию</a></p>
