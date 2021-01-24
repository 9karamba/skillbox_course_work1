<?php

include 'header.php';

$products = getProducts();
?>


<main class="shop-page">
  <?php include 'parts/banner.php'; ?>

  <section class="shop container">
    <section class="shop__filter filter">
      <form method="get" action="/" class="filter__form">
      <div class="filter__wrapper">
        <b class="filter__title">Категории</b>
        <ul class="filter__list">
            <li>
                <a class="filter__list-item <?= !isset($_GET['category']) || $_GET['category'] == '' ? 'active' : '' ?>"
                   href="<?= getUrl('category', '') ?>">Все</a>
            </li>
            <?php foreach (getCategories() as $category): ?>
              <li>
                <a class="filter__list-item <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'active' : '' ?>"
                   href="<?= getUrl('category', $category['id']) ?>">
                        <?= $category['name'] ?>
                </a>
              </li>
            <?php endforeach; ?>
        </ul>
      </div>
        <div class="filter__wrapper">
          <b class="filter__title">Фильтры</b>
          <div class="filter__range range">
            <span class="range__info">Цена</span>
            <div class="range__line" aria-label="Range Line"></div>
            <div class="range__res">
              <span class="range__res-item min-price"><?= $_GET['min-price'] ?? '350' ?> руб.</span>
              <span class="range__res-item max-price"><?= $_GET['max-price'] ?? '32 000' ?> руб.</span>
            </div>
          </div>
        </div>

        <fieldset class="custom-form__group">
          <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?= isset($_GET['new']) && $_GET['new'] ? 'checked' : '' ?>>
          <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>
          <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?= isset($_GET['sale']) && $_GET['sale'] ? 'checked' : '' ?>>
          <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
        </fieldset>
          <?php if(isset($_GET['sort'])): ?>
              <input type="hidden" name="sort" value="<?= $_GET['sort'] ?>">
          <?php endif; ?>
          <?php if(isset($_GET['order'])): ?>
              <input type="hidden" name="order" value="<?= $_GET['order'] ?>">
          <?php endif; ?>
          <?php if(isset($_GET['category'])): ?>
              <input type="hidden" name="category" value="<?= $_GET['category'] ?>">
          <?php endif; ?>
          <input type="hidden" name="min-price" value="<?= $_GET['min-price'] ?? '0' ?>">
          <input type="hidden" name="max-price" value="<?= $_GET['max-price'] ?? '32000' ?>">
          <input type="hidden" name="page" value="<?= $products['pagination']['current'] ?>">
        <button class="button" type="submit" style="width: 100%">Применить</button>
      </form>
    </section>

    <div class="shop__wrapper">
      <form method="get" action="/" class="shop__sorting">
        <div class="shop__sorting-item custom-form__select-wrapper">
          <select class="custom-form__select" name="sort">
            <option hidden="" value="">Сортировка</option>
            <option value="price" <?= isset($_GET['sort']) && $_GET['sort'] == 'price' ? 'selected' : '' ?>>По цене</option>
            <option value="name" <?= isset($_GET['sort']) && $_GET['sort'] == 'name' ? 'selected' : '' ?>>По названию</option>
          </select>
        </div>
        <div class="shop__sorting-item custom-form__select-wrapper">
          <select class="custom-form__select" name="order">
            <option hidden="" value="">Порядок</option>
            <option value="asc" <?= isset($_GET['order']) && $_GET['order'] == 'asc' ? 'selected' : '' ?>>По возрастанию</option>
            <option value="desc" <?= isset($_GET['order']) && $_GET['order'] == 'desc' ? 'selected' : '' ?>>По убыванию</option>
          </select>
        </div>
          <?php if(isset($_GET['sale'])): ?>
              <input type="hidden" name="sale" value="<?= $_GET['sale'] ?>">
          <?php endif; ?>
          <?php if(isset($_GET['new'])): ?>
              <input type="hidden" name="new" value="<?= $_GET['new'] ?>">
          <?php endif; ?>
          <?php if(isset($_GET['min-price'])): ?>
            <input type="hidden" name="min-price" value="<?= $_GET['min-price'] ?>">
          <?php endif; ?>
          <?php if(isset($_GET['max-price'])): ?>
              <input type="hidden" name="max-price" value="<?= $_GET['max-price'] ?>">
          <?php endif; ?>
          <?php if(isset($_GET['category'])): ?>
              <input type="hidden" name="category" value="<?= $_GET['category'] ?>">
          <?php endif; ?>
          <input type="hidden" name="page" value="<?= $products['pagination']['current'] ?>">
        <p class="shop__sorting-res">Найдено <span class="res-sort"><?= $products["count"] ?? 0 ?></span> моделей</p>
      </form>
        <section class="shop__list">
            <?php foreach ($products['obj'] as $index=>$product): ?>
                <article class="shop__item product" tabindex="<?= $index ?>" data-id="<?= $product["id"] ?>">
                    <div class="product__image">
                        <img src="<?= $product["photo"] ?>" alt="product-name">
                    </div>
                    <p class="product__name"><?= $product["name"] ?></p>
                    <span class="product__price"><?= $product["price"] ?> руб.</span>
                </article>
            <?php endforeach; ?>
        </section>
        <ul class="shop__paginator paginator">
            <?php for ($i = 1; $i <= $products['pagination']['total']; $i++): ?>
                <li>
                    <a class="paginator__item" <?= $products['pagination']['current'] == $i ? '' : 'href="'. getUrl('page', $i) .'"' ?>>
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
  </section>
  
  <?php include 'parts/placing_order.php'; ?>
</main>

<?php
  include 'footer.php';
?>