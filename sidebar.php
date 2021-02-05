<aside class="main-sidebar sidebar-dark-secondary elevation-4">
  <div class="dropdown">
  <a href="./" class="brand-link">
      <?php if($_SESSION['login_type'] == 1): ?>
      <h3 class="text-center p-0 m-0"><b>Руководитель</b></h3>
      <?php else: ?>
      <h3 class="text-center p-0 m-0"><b>Пользователь</b></h3>
      <?php endif; ?>

  </a>

  </div>
  <div class="sidebar pb-4 mb-4">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item dropdown">
          <a href="./index.php?page=tasks" class="nav-link nav-home">
            <i class="fas fa-tasks nav-icon"></i>
            <p>
              Задачи
            </p>
          </a>
        </li>

        <?php if($_SESSION['login_type'] == 1): ?>
        <li class="nav-item">
          <a href="./index.php?page=manageusers" class="nav-link nav-edit_user">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Пользователи
            </p>
          </a>
        </li>
      <?php endif; ?>

      <li class="nav-item dropdown">
        <a href="logout.php" class="nav-link nav-home">
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>
            Выход
          </p>
        </a>
      </li>

      </ul>
    </nav>
  </div>
</aside>
