<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
?>
<?php include(__DIR__ . '/../note/includes/admin-notes-nav.php'); ?>

<h2>Список категорий</h2>

<?php if (!empty($categories)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">Категория</th>
      <th scope="col"></th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($categories as $category): ?>
    <tr style="cursor: pointer;" onclick="location='<?= WebRouter::link('admin/categories/edit&id=' . $category->id) ?>'">
        <td><?= htmlspecialchars($category->name) ?></td>
        <td><a href="<?= WebRouter::link('admin/categories/edit&id=' . $category->id) ?>">[Редактировать]</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p><?= count($categories) ?> категори<?= (count($categories) != 1) ? 'й' : 'я' ?> всего.</p>
<?php else:?>
    <p>Список категорий пуст</p>
<?php endif; ?>

<p><a href="<?= WebRouter::link('admin/categories/add') ?>">+ Добавить новую категорию</a></p>
