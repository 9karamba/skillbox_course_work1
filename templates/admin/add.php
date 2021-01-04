<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';
if(getRole() != 'admin'){
    header("Location: /");
}
include $_SERVER['DOCUMENT_ROOT'].'/include/add_product.php';
include dirname(__FILE__) . '/../header.php';
?>

<main class="page-add">
  <h1 class="h h--1">Добавление товара</h1>
    <?php if ( isset($error) ) : ?>
        <p class="alert alert-error">
            <?= $error ?>
        </p>
    <?php endif; ?>
  <form class="custom-form" action="/admin/add/<?= isset($_GET["product-id"]) ? '?product-id=' . $_GET["product-id"] : '' ?>" enctype="multipart/form-data" method="post" <?= !isset($error) && isset($_POST["add-product"]) ? 'hidden' : '' ?>>
      <?php if(isset($product) && $product ): ?>
        <input type="hidden" name="product-id" value="<?= $product[0]['id'] ?>">
        <input type="hidden" name="product-image" value="<?= $product[0]['photo'] ?>">
      <?php endif; ?>
      <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" id="product-name" value="<?= isset($product) && $product ? $product[0]["name"] : '' ?>">
        <p class="custom-form__input-label" <?= isset($product) && $product ? 'hidden' : '' ?>>
          Название товара
        </p>
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" id="product-price" value="<?= isset($product) && $product ? $product[0]["price"] : '' ?>">
        <p class="custom-form__input-label" <?= isset($product) && $product ? 'hidden' : '' ?>>
          Цена товара
        </p>
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
      <ul class="add-list">
        <li class="add-list__item add-list__item--add">
          <input type="file" name="product-photo" id="product-photo" hidden="" value="<?= isset($product) && $product ? $product[0]["photo"] : '' ?>">
          <label for="product-photo">Добавить фотографию</label>
        </li>
          <?php if( isset($product) && $product ): ?>
              <li class="add-list__item add-list__item--active">
                  <img src="<?= $product[0]["photo"] ?>">
              </li>
          <?php endif; ?>
      </ul>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category[]" class="custom-form__select" multiple="multiple">
          <option hidden="">Название раздела</option>
            <?php foreach (getCategories() as $category): ?>
                <option value="<?= $category['id'] ?>" <?= isset($product_categories) && in_array($category['id'], $product_categories) ? 'selected' : '' ?>><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
      </div>
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?= isset($product) && $product && $product[0]["new"] ? 'checked' : '' ?>>
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?= isset($product) && $product && $product[0]["sale"] ? 'checked' : '' ?>>
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <button class="button" name="add-product" type="submit">Добавить товар</button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" <?= isset($error) || !isset($_POST["add-product"]) ? 'hidden' : '' ?>>
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
    </div>
  </section>
</main>

<?php
    include dirname(__FILE__) . '/../footer.php';
?>
