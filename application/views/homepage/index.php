<?php 
use ItForFree\SimpleMVC\Router\WebRouter;

use application\assets\DemoJavascriptAsset;
DemoJavascriptAsset::add();

function formatArticleDate($date) {
    if (empty($date)) return '';
    $dateObj = \DateTime::createFromFormat('Y-m-d', $date);
    if ($dateObj) {
        $months = [
            1 => 'JANUARY', 2 => 'FEBRUARY', 3 => 'MARCH', 4 => 'APRIL',
            5 => 'MAY', 6 => 'JUNE', 7 => 'JULY', 8 => 'AUGUST',
            9 => 'SEPTEMBER', 10 => 'OCTOBER', 11 => 'NOVEMBER', 12 => 'DECEMBER'
        ];
        $day = (int)$dateObj->format('d');
        $month = $months[(int)$dateObj->format('n')];
        $year = $dateObj->format('Y');
        return "$day $month $year";
    }
    return $date;
}

function formatAuthors($authors) {
    if (empty($authors)) {
        return '';
    }
    $names = array_column($authors, 'login');
    return 'Authors: ' . implode(', ', $names);
}

?>
<style>
    body {
        background-color: #00CED1;
        font-family: sans-serif;
    }
    .content-wrapper {
        background-color: white;
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        min-height: 80vh;
    }
    .logo {
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #00CED1;
        padding-bottom: 20px;
    }
    .logo a {
        text-decoration: none;
    }
    #logo {
        display: block;
        width: 300px;
        margin-right: 10px;
        border: none;
    }
    .article {
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .article:last-child {
        border-bottom: none;
    }
    .article-title {
        color: #FF8C00;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .article-date {
        color: red;
        margin-bottom: 10px;
        font-size: 14px;
    }
    .article-category {
        margin-bottom: 5px;
        font-size: 14px;
    }
    .article-category a {
        color: #007bff;
        text-decoration: underline;
    }
    .article-subcategory {
        margin-bottom: 5px;
        font-size: 14px;
    }
    .article-authors {
        margin-bottom: 10px;
        font-size: 14px;
    }
    .article-excerpt {
        margin-bottom: 15px;
        color: #333;
        line-height: 1.6;
    }
    .read-more {
        color: #007bff;
        text-decoration: underline;
    }
</style>

<div class="content-wrapper">
    <div class="logo">
        <a href="/"><img id="logo" src="/images/logo.jpg" alt="Widget News" /></a>
    </div>

    <?php if (!empty($notes)): ?>
        <?php foreach($notes as $note): ?>
            <div class="article">
                <div class="article-title"><?= htmlspecialchars($note->title) ?></div>
                <div class="article-date"><?= formatArticleDate($note->publicationDate) ?></div>
                
                <?php if ($note->categoryName): ?>
                    <div class="article-category">
                        in <a href="#"><?= htmlspecialchars($note->categoryName) ?></a>
                    </div>
                <?php endif; ?>
                
                <?php if ($note->subcategoryName): ?>
                    <div class="article-subcategory">
                        Подкатегория: Подкатегория: <?= htmlspecialchars($note->subcategoryName) ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($note->authors)): ?>
                    <div class="article-authors"><?= htmlspecialchars(formatAuthors($note->authors)) ?></div>
                <?php endif; ?>
                
                <div class="article-excerpt">
                    <?php 
                    $excerpt = !empty($note->briefDescription) ? $note->briefDescription : mb_substr($note->content, 0, 200);
                    echo htmlspecialchars($excerpt);
                    if (mb_strlen($note->content) > 200 || !empty($note->briefDescription)) {
                        echo '...';
                    }
                    ?>
                </div>
                
                <div>
                    <a href="<?= WebRouter::link('article/view&id=' . $note->id) ?>" class="read-more">Показать полностью</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Статей пока нет.</p>
    <?php endif; ?>
</div>