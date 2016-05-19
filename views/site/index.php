<?php

/* @var $this yii\web\View */
/* @var $model app\models\ContactForm */
/* @var $form yii\bootstrap\ActiveForm */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Newster';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Это Newster!</h1>

        <p class="lead">Просто введите URL интересующего раздела и новости будут приходить прямо вам на почту. Все оень просто.</p>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->label('Ваш URL')  ?>

    <div class="form-group">
        <?= Html::submitButton('Поехали', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

        
    </div>

  
</div>
