

<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>Заполните следующие поля:</p>
<?php

$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],
]);
?>

<?= $form->field($model,'email')->textInput(['autofocus'=>true])?>
<?= $form->field($model,'password')->label('Пароль')->passwordInput()?>

<div>
    <button type="submit" class="btn btn-primary">Подтверить</button>
</div>
<?php
ActiveForm::end();
?>
