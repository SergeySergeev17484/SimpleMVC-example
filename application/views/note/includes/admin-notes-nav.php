<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');


//vpre($User->explainAccess("admin/adminusers/index"));
?>

<ul class="nav">
    
    <?php  if ($User->isAllowed("admin/notes/index")): ?>
    <li class="nav-item ">
        <a class="nav-link" href="<?= WebRouter::link("admin/notes/index") ?>" style="color: #007bff; text-decoration: underline;">Список</a>
    </li>
    <?php endif; ?>
    
    <?php  if ($User->isAllowed("admin/notes/add")): ?>
    <li class="nav-item ">
        <a class="nav-link" href="<?= WebRouter::link("admin/notes/add") ?>" style="color: #007bff; text-decoration: underline;">+ Добавить статью</a>
    </li>
    <?php endif; ?>  
</ul>
<br>