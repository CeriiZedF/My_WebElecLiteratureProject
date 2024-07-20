<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $chapter->title;
$this->params['breadcrumbs'][] = ['label' => 'Література', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $chapter->literature->title, 'url' => ['view', 'id' => $chapter->literature_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="chapter-view container mt-4 mb-5">
    <div class="mb-3">
        <?= Html::a('Вернуться назад', ['view', 'id' => $chapter->literature_id], ['class' => 'btn btn-secondary']) ?>
    </div>
    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>
    <div class="chapter-content">
        <?= nl2br(Html::encode($chapter->content)) ?>
    </div>
</div>

<div class="container mt-4">
    <div class="d-flex justify-content-between">
        <?php if ($prevChapter): ?>
            <?= Html::a('← Предыдущая глава', ['view-chapter', 'id' => $prevChapter->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if ($nextChapter): ?>
            <?= Html::a('Следующая глава →', ['view-chapter', 'id' => $nextChapter->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .chapter-view {
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .chapter-content {
        font-size: 1.1rem;
        line-height: 1.8;
        margin-top: 20px;
        white-space: pre-wrap;
    }

    .btn {
        border-radius: 20px;
        padding: 10px 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    @media (max-width: 768px) {
        .chapter-content {
            font-size: 1rem;
        }

        .btn {
            padding: 8px 16px;
        }
    }
</style>
