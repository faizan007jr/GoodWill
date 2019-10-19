<?php
$page_title = 'Home';
$cart_items = 0;
include('./master-header.php');
?>

<div>

    <div class="jumbotron">
        <h1 class="display-4">Goodwill Electronics</h1>
        <p class="lead">A Simple way to find the best electronics you desire.</p>
    </div>

    <div id="carouselOffers" class="carousel slide my-4" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselOffers" data-slide-to="0" class="active" style="filter: invert(100%);"></li>
            <li data-target="#carouselOffers" data-slide-to="1" class="" style="filter: invert(100%);"></li>
            <li data-target="#carouselOffers" data-slide-to="2" class="" style="filter: invert(100%);"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img class="d-block img-fluid m-auto" width="100%" src="images/carousel/offers1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block img-fluid m-auto" width="100%" src="./images/carousel/offers2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block img-fluid m-auto" width="100%" src="images/carousel/offers3.png" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselOffers" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" style="filter: invert(100%);" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselOffers" role="button" data-slide="next">
            <span class="carousel-control-next-icon" style="filter: invert(100%);" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

</div>

<script type="text/javascript" src="./scripts/carousel-fix.js"></script>

<?php
include ('./master-footer.html');
?>
