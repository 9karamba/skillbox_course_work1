<?php
  include $_SERVER['DOCUMENT_ROOT'].'/include/auth.php';
  include dirname(__FILE__) . '/../header.php';
?>

<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
  <form class="custom-form" action="/admin" method="post">
    <?php if ( isset($error) ) : ?>
      <p class="alert alert-error">
        <?= $error ?>
      </p>
    <?php endif; ?>
    <input type="email" name="email" value="<?= isset($_COOKIE["email"]) ? $_COOKIE["email"] : '' ?>" class="custom-form__input" required="" placeholder="Email">
    <input type="password" name="password" class="custom-form__input" required="" placeholder="Пароль">
    <button class="button" name="login" type="submit">Войти в личный кабинет</button>
  </form>
</main>

<?php
  include dirname(__FILE__) . '/../footer.php';
?>
