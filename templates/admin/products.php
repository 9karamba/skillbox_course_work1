<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';
if(getRole() != 'admin'){
    header("Location: /");
}

include dirname(__FILE__) . '/../header.php';
?>

<main class="page-products">
  <h1 class="h h--1">Товары</h1>
  <a class="page-products__button button" href="/admin/add">Добавить товар</a>
  <div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Цена</span>
    <span class="page-products__header-field">Категория</span>
    <span class="page-products__header-field">Новинка</span>
  </div>
  <ul class="page-products__list">
      <?php foreach (getProducts() as $product): ?>
        <li class="product-item page-products__item">
          <b class="product-item__name"><?= $product["name"] ?></b>
          <span class="product-item__field"><?= $product["id"] ?></span>
          <span class="product-item__field"><?= $product["price"] ?> руб.</span>
          <span class="product-item__field"><?= getProductsCategories($product["id"]) ?></span>
          <span class="product-item__field"><?= $product["new"] ? 'Да' : 'Нет' ?></span>
          <a href="add/?product-id=<?= $product["id"] ?>" class="product-item__edit" aria-label="Редактировать"></a>
          <button class="product-item__delete" data-product="<?= $product["id"] ?>"></button>
        </li>
      <?php endforeach; ?>
  </ul>
</main>

<?php
    include dirname(__FILE__) . '/../footer.php';
?>
