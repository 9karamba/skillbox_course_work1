<?php
  include 'header.php';
?>


<main class="shop-page">
  <?php include 'parts/banner.php'; ?>

  <section class="shop container">
    <section class="shop__filter filter">
      <form>
      <div class="filter__wrapper">
        <b class="filter__title">Категории</b>
        <ul class="filter__list">
          <li>
            <a class="filter__list-item active" href="#">Все</a>
          </li>
          <li>
            <a class="filter__list-item" href="#">Женщины</a>
          </li>
          <li>
            <a class="filter__list-item" href="#">Мужчины</a>
          </li>
          <li>
            <a class="filter__list-item" href="#">Дети</a>
          </li>
          <li>
            <a class="filter__list-item" href="#">Аксессуары</a>
          </li>
        </ul>
      </div>
        <div class="filter__wrapper">
          <b class="filter__title">Фильтры</b>
          <div class="filter__range range">
            <span class="range__info">Цена</span>
            <div class="range__line" aria-label="Range Line"></div>
            <div class="range__res">
              <span class="range__res-item min-price">350 руб.</span>
              <span class="range__res-item max-price">32 000 руб.</span>
            </div>
          </div>
        </div>

        <fieldset class="custom-form__group">
          <input type="checkbox" name="new" id="new" class="custom-form__checkbox">
          <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>
          <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox">
          <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
        </fieldset>
        <button class="button" type="submit" style="width: 100%">Применить</button>
      </form>
    </section>

    <div class="shop__wrapper">
      <section class="shop__sorting">
        <div class="shop__sorting-item custom-form__select-wrapper">
          <select class="custom-form__select" name="category">
            <option hidden="">Сортировка</option>
            <option value="price">По цене</option>
            <option value="name">По названию</option>
          </select>
        </div>
        <div class="shop__sorting-item custom-form__select-wrapper">
          <select class="custom-form__select" name="prices">
            <option hidden="">Порядок</option>
            <option value="all">По возрастанию</option>
            <option value="woman">По убыванию</option>
          </select>
        </div>
        <p class="shop__sorting-res">Найдено <span class="res-sort">858</span> моделей</p>
      </section>
      <section class="shop__list">
        <article class="shop__item product" tabindex="0">
          <div class="product__image">
            <img src="/templates/img/products/product-1.jpg" alt="product-name">
          </div>
          <p class="product__name">Платье со складками</p>
          <span class="product__price">2 999 руб.</span>
        </article>
        <article class="shop__item product" tabindex="0">
          <div class="product__image">
            <img src="/templates/img/products/product-2.jpg" alt="product-name">
          </div>
          <p class="product__name">Платье со складками</p>
          <span class="product__price">2 999 руб.</span>
        </article>
        <article class="shop__item product" tabindex="0">
          <div class="product__image">
            <img src="/templates/img/products/product-3.jpg" alt="product-name">
          </div>
          <p class="product__name">Платье со складками</p>
          <span class="product__price">2 999 руб.</span>
        </article>
        <article class="shop__item product" tabindex="0">
          <div class="product__image">
            <img src="/templates/img/products/product-4.jpg" alt="product-name">
          </div>
          <p class="product__name">Платье со складками</p>
          <span class="product__price">2 999 руб.</span>
        </article>
        <article class="shop__item product" tabindex="0">
          <div class="product__image">
            <img src="/templates/img/products/product-5.jpg" alt="product-name">
          </div>
          <p class="product__name">Платье со складками</p>
          <span class="product__price">2 999 руб.</span>
        </article>
        <article class="shop__item product" tabindex="0">
          <div class="product__image">
            <img src="/templates/img/products/product-6.jpg" alt="product-name">
          </div>
          <p class="product__name">Платье со складками</p>
          <span class="product__price">2 999 руб.</span>
        </article>
        <article class="shop__item product" tabindex="0">
          <div class="product__image">
            <img src="/templates/img/products/product-7.jpg" alt="product-name">
          </div>
          <p class="product__name">Платье со складками</p>
          <span class="product__price">2 999 руб.</span>
        </article>
        <article class="shop__item product" tabindex="0">
          <div class="product__image">
            <img src="/templates/img/products/product-8.jpg" alt="product-name">
          </div>
          <p class="product__name">Платье со складками</p>
          <span class="product__price">2 999 руб.</span>
        </article>
        <article class="shop__item product" tabindex="0">
          <div class="product__image">
            <img src="/templates/img/products/product-9.jpg" alt="product-name">
          </div>
          <p class="product__name">Платье со складками</p>
          <span class="product__price">2 999 руб.</span>
        </article>
      </section>
      <ul class="shop__paginator paginator">
        <li>
          <a class="paginator__item">1</a>
        </li>
        <li>
          <a class="paginator__item" href="">2</a>
        </li>
      </ul>
    </div>
  </section>
  
  <?php include 'parts/placing_order.php'; ?>
</main>

<?php
  include 'footer.php';
?>