<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">
      <i class="fa fa-user" aria-hidden="true" id="logo"></i>
      <span class="text-logo">DigiShop</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Product List <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="create.php">Create Products</a>
        </li>
        <li class="nav-item dropdown"></li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Private Area</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="index.php" method="GET">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        <button href="index.php" type="button" class="btn btn-outline-secondary">Reset</button>
      </form>
    </div>
  </div>
</nav>