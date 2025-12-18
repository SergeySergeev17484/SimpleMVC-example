<?php 
use ItForFree\SimpleMVC\Router\WebRouter;

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
    .article-title {
        color: #FF8C00;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 15px;
        width: 75%;
    }
    .article-summary {
        width: 75%;
        font-style: italic;
        margin-bottom: 15px;
        color: #333;
    }
    .article-content {
        width: 75%;
        margin-bottom: 20px;
        color: #333;
        line-height: 1.6;
    }
    .article-meta {
        width: 75%;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .pubDate {
        color: #eb6841;
        text-transform: uppercase;
    }
    .article-meta a {
        color: #007bff;
        text-decoration: underline;
    }
    .back-link {
        margin-top: 30px;
    }
    .back-link a {
        color: #007bff;
        text-decoration: underline;
    }
</style>

<div class="content-wrapper">
    <h1 class="article-title"><?= htmlspecialchars($article->title) ?></h1>
    
    <?php if (!empty($article->briefDescription)): ?>
        <div class="article-summary"><?= htmlspecialchars($article->briefDescription) ?></div>
    <?php endif; ?>
    
    <div class="article-content"><?= nl2br(htmlspecialchars($article->content)) ?></div>
    
    <p class="article-meta">
        <span class="pubDate">Published on <?= formatArticleDate($article->publicationDate) ?></span>
        
        <?php if ($category): ?>
            in 
            <a href="#"><?= htmlspecialchars($category->name) ?></a>
        <?php endif; ?>
        
        <?php if ($subcategory): ?>
            &gt;
            <a href="#"><?= htmlspecialchars($subcategory->name) ?></a>
        <?php endif; ?>
    </p>
    
    <?php if (!empty($authors)): ?>
        <p class="article-meta">
            <strong>Авторы:</strong> 
            <?php 
            $authorNames = [];
            foreach ($authors as $author) {
                $authorNames[] = htmlspecialchars($author['login']);
            }
            echo htmlspecialchars(implode(', ', $authorNames));
            ?>
        </p>
    <?php endif; ?>
    
    <p class="back-link"><a href="<?= WebRouter::link('homepage/index') ?>">Вернуться на главную страницу</a></p>
</div>
