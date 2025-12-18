<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');

function formatDate($date) {
    if (empty($date)) return '';
    $dateObj = \DateTime::createFromFormat('Y-m-d', $date);
    if ($dateObj) {
        return $dateObj->format('d.m.Y');
    }
    return $date;
}

function formatAuthors($authors) {
    if (empty($authors)) {
        return '-';
    }
    $names = array_column($authors, 'login');
    return implode(', ', $names);
}
?>
<?php include('includes/admin-notes-nav.php'); ?>

<h2>Список статей</h2>

<?php if (!empty($notes)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Название</th>
      <th scope="col">Краткое описание</th>
      <th scope="col">Содержание</th>
      <th scope="col">Дата публикации</th>
      <th scope="col">Категория</th>
      <th scope="col">Подкатегория</th>
      <th scope="col">Авторы</th>
      <th scope="col">Активна</th>
      <th scope="col"></th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($notes as $note): ?>
    <tr>
        <td><?= $note->id ?></td>
        <td><a href="<?= WebRouter::link('admin/notes/index&id=' . $note->id) ?>"><?= htmlspecialchars($note->title) ?></a></td>
        <td><?= htmlspecialchars($note->briefDescription ?? '') ?></td>
        <td><?= htmlspecialchars(mb_substr($note->content, 0, 100) . (mb_strlen($note->content) > 100 ? '...' : '')) ?></td>
        <td><?= formatDate($note->publicationDate) ?></td>
        <td><?= htmlspecialchars($note->categoryName ?? '') ?></td>
        <td><?= htmlspecialchars($note->subcategoryName ?? '') ?></td>
        <td><?= htmlspecialchars(formatAuthors($note->authors ?? [])) ?></td>
        <td><?= $note->isActive ? 'Да' : 'Нет' ?></td>
        <td><a href="<?= WebRouter::link('admin/notes/edit&id=' . $note->id) ?>">[Редактировать]</a></td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php else:?>
    <p>Список статей пуст</p>
<?php endif; ?>

