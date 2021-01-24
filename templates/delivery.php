<?php
  include 'header.php';

  $delivery = getDelivery();
?>

<main class="page-delivery">
  <h1 class="h h--1">Доставка</h1>
  <p class="page-delivery__desc">
    Способы доставки могут изменяться в зависимости от адреса доставки, времени осуществления покупки и наличия товаров.
  </p>
  <p class="page-delivery__desc page-delivery__desc--strong">
    <b>При оформлении покупки мы проинформируем вас о доступных способах доставки, стоимости и дате доставки вашего заказа.</b>
  </p>
  <section class="page-delivery__info">
    <header class="page-delivery__desc">
      Возможные варианты доставки:
      <b class="page-delivery__variant">Доставка на дом:</b>
    </header>
    <ul class="page-delivery__list">
      <?php foreach ($delivery as $item): ?>
        <li>
          <b class="page-delivery__item-title">
              <?= $item['name'] ?> - <?= $item['price'] ?> РУБ <?= $item['free_price'] ? "/ БЕСПЛАТНО (ДЛЯ ЗАКАЗОВ ОТ {$item['free_price']} РУБ)" : '' ?>
          </b>
          <p class="page-delivery__item-desc">
            <?= $item['description'] ?? '' ?>
          </p>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="page-delivery__desc">
      Мы свяжемся с вами, чтобы подтвердить дату и время доставки. Кроме того, вы будете получать уведомления по электронной почте и SMS с информацией о номере заказа, его стоимости, а также с информацией о том, что заказ готов к выдаче. В день доставки заказа мы отправим вам SMS-уведомлениес номером телефона сотрудника службы доставки.
    </p>
    <a class="page-delivery__button button" href="/">Продолжить покупки</a>
  </section>
</main>

<?php
  include 'footer.php';
?>