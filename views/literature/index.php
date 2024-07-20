<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->title = 'Каталог литературы';
$this->registerCssFile('@web/css/styles.css');

$this->registerJs(<<<JS
    $(document).ready(function () {
        $('#search-input').on('input', function () {
            var searchText = $(this).val().toLowerCase();
            $.pjax.reload({
                container: '#pjax-container',
                url: '<?= Url::to(['literature/search']) ?>',
                data: { search: searchText },
                type: 'GET',
                timeout: 3000,
                dataType: 'json',
                success: function(data) {
                    if (data && data.noResults) {
                        $('#no-results-message').show();
                    } else {
                        $('#no-results-message').hide();
                    }
                }
            });
        });
    });
JS
);
?>

<div class="row">
    <div id="search-container" class="mb-3">
        <input type="text" id="search-input" class="form-control" placeholder="Поиск по заголовкам...">
    </div>
    
    <div id="no-results-message" class="alert alert-info" style="display: none;">
        Нет результатов для вашего поиска.
    </div>
    
    <?php Pjax::begin(['id' => 'pjax-container']); ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_card',
        'summary' => false,
        'options' => ['class' => 'list-view row'],
        'itemOptions' => ['class' => 'col-md-4 mb-3'],
    ]); ?>
    
    <div class="text-center">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]); ?>
    </div>
    
    <?php Pjax::end(); ?>
</div>
