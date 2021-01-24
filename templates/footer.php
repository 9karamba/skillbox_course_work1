<footer class="page-footer">
  <div class="container">
    <a class="page-footer__logo" href="#">
      <img src="/templates/img/logo--footer.svg" alt="Fashion">
    </a>
    <nav class="page-footer__menu">
      <ul class="main-menu main-menu--footer">
          <?php
          foreach ($menu as $item) { ?>
              <li>
                  <a class="main-menu__item <?= strripos($uri, $item['href']) === false ? '' : 'active' ?>" href="<?= $item['href'] ?>">
                      <?= $item['name'] ?>
                  </a>
              </li>
          <?php } ?>
      </ul>
    </nav>
    <address class="page-footer__copyright">
      © Все права защищены
    </address>
  </div>
</footer>
</body>
</html>