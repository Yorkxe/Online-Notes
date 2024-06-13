<?php
  include("Login_check.php");
  include_once("Navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="Breakpoint.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <title>Document</title>
</head>
<body>
  <div class="row justify-content-center" id="content">
    <div class="col-1 d-none d-md-block"></div>
    <div class="col-md text-center" id="Main">
      <h3>Are you coding today?</h3>
      <p>Learn some cool things from the latest notes</p>
    </div>
    <div id="carouselExampleAutoplaying" class="carousel slide col-md" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active text-center">
          <div class="card-body container-fluid">
            <img class="img-fluid" src="img\Car1.jpg">
            <div class="card-body text-center">
              <h5 class="card-title"></h5>
              <p class="card-text"></p>
              <a href="#" class="btn btn-primary">Read</a>
            </div>
          </div>
        </div>
        <div class="carousel-item text-center">
          <div class="card-body">
            <img class="img-fluid" src="img/Car2.jpg" height="30%">
            <div class="card-body text-center">
              <h5 class="card-title"></h5>
              <p class="card-text"></p>
              <a href="#" class="btn btn-primary">Read</a>
            </div>
          </div>
        </div>
        <div class="carousel-item text-center">
          <div class="card-body">
            <img class="img-fluid" src="img/Car3.jpg">
            <div class="card-body text-center">
              <h5 class="card-title"></h5>
              <p class="card-text"></p>
              <a href="#" class="btn btn-primary">Read</a>
            </div>
          </div>
        </div>
        <div class="carousel-item text-center">
          <div class="card-body">
            <img class="img-fluid" src="img/Car4.jpg">
            <div class="card-body text-center">
              <h5 class="card-title"></h5>
              <p class="card-text"></p>
              <a href="#" class="btn btn-primary">Read</a>
            </div>
          </div>
        </div>
        <div class="carousel-item text-center">
          <div class="card-body">
            <img class="img-fluid" src="img/Car5.jpg">
            <div class="card-body text-center">
              <h5 class="card-title"></h5>
              <p class="card-text"></p>
              <a href="#" class="btn btn-primary">Read</a>
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next col-1" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div> 
    <div class="col-1 d-none d-md-block"></div>
  </div>
</body>
</html>