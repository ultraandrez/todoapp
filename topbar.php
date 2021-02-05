<nav class="main-header navbar bg-dark">

  <ul class="text-center navbar-nav">
    <li>
      <a class="nav-link text-white"> <large><b>Планирование задач</b></large></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
   <li class="nav-item">
          <a class="nav-link">
            <span>
              <div class="d-felx badge-pill text-white">
                <span class="fa fa-user mr-2"></span>
                <span><b><?php echo ucwords($_SESSION['login_lastname'] . " " .$_SESSION['login_firstname'] . " " . $_SESSION['login_middlename']) ?></b></span>
              </div>
            </span>
          </a>
    </li>
  </ul>

</nav>
