<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Мой аккаунт';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .d-flex {
        display: flex;
        height: 100vh; /* Обеспечивает высоту на всю высоту экрана */
    }

    .categories-section {
        width: 250px;
        border-right: 1px solid #ddd; /* Линия между контентом и категориями */
        height: 100%; /* Устанавливаем высоту на полную высоту родителя */
        overflow-y: auto; /* Добавляем прокрутку, если содержимое выходит за пределы */
    }

    .content-section {
        flex-grow: 1;
        padding: 20px;
        overflow-y: auto; /* Добавляем прокрутку, если содержимое выходит за пределы */
    }

    .nav-link.active {
        background-color: #e9ecef;
        font-weight: bold;
    }
</style>



<?php
$this->registerCssFile('https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
$this->registerJsFile('https://code.jquery.com/jquery-3.5.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', ['position' => \yii\web\View::POS_HEAD]);
?>

<div class="container rounded bg-white mt-5 mb-5">
    <div class="d-flex">
        <div class="content-section" id="content-section">
        </div>
        <div class="categories-section flex-shrink-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <?= Html::a('Профиль', '#', [
                        'class' => 'nav-link',
                        'data-action' => 'profile',
                        'data-url' => Url::to(['/user/profile'])
                    ]) ?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Аватар', '#', [
                        'class' => 'nav-link',
                        'data-action' => 'avatar',
                        'data-url' => Url::to(['/user/avatar'])
                    ]) ?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Безопасность', '#', [
                        'class' => 'nav-link',
                        'data-action' => 'security',
                        'data-url' => Url::to(['/user/security'])
                    ]) ?>
                </li>
            </ul>
        </div>
    </div>
</div>


<script>
   

    document.addEventListener('DOMContentLoaded', function () {
        function loadContent(url) {
            console.log('Загрузка содержимого с URL:', url); 
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('content-section').innerHTML = data;
                })
                .catch(error => {
                    console.error('Ошибка при загрузке содержимого:', error); 
                    alert('Произошла ошибка при загрузке содержимого.');
                });
        }


        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault(); 
                var url = this.dataset.url; 
                history.pushState(null, '', url); 
                loadContent(url); 
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active')); 
                this.classList.add('active');
            });
        });


        var defaultAction = 'security'; 
        var defaultLink = document.querySelector('.nav-link[data-action="' + defaultAction + '"]');
        if (defaultLink) {
            var defaultUrl = defaultLink.dataset.url;
            if (defaultUrl) {
                console.log('Загрузка содержимого по умолчанию с URL:', defaultUrl); 
                loadContent(defaultUrl); 
                defaultLink.classList.add('active'); 
            }
        }

        window.addEventListener('popstate', function () {
            var url = window.location.pathname;
            if (url.includes('/user/')) {
                console.log('Загрузка содержимого при переходе по истории с URL:', url); 
                loadContent(url);
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                document.querySelector('.nav-link[data-url="' + url + '"]').classList.add('active'); 
            }
        });
        
    });
</script>
