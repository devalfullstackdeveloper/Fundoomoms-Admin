
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<style>
   .carousel-inner img {
    width: 100%;
    height: 100%;
  }
  .carousel-indicators li {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}
</style>
</head>
<body>
    <!-- slider -->
    <?php
      $count = 0;
    ?>
    <div id="demo" class="carousel slide" data-ride="carousel">
      <ul class="carousel-indicators">
        <?php foreach($bannerList as $j => $bannerData){
          if($count==0){
        ?>
          <li data-target="#demo" data-slide-to="<?php echo $count; ?>" class="active"></li>
        <?php   
          }else{
        ?>
          <li data-target="#demo" data-slide-to="<?php echo $count; ?>">
        <?php  
         
          }
           $count++;
        }
        ?>
        <!-- <li data-target="#demo" data-slide-to="0" class="active"></li> -->
        <!-- <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2"></li> -->
      </ul>
      <div class="carousel-inner">
        
        <?php
          $count1 = 0;
          foreach ($bannerList as $i => $bannerData) {
           if($count==0){
        ?>
        <div class="carousel-item active">
        <?php }else{ ?>
        <div class="carousel-item">
        <?php
        }
        ?>  
          <img src="<?= base_url() .'uploads/banner/'. $bannerData['mb_img'] ?>" alt="Los Angeles" width="1100" height="500">
          <div class="carousel-caption">
            <p class="mb-1">Chicago</p>
            <p class="mb-1">We had such a great time in LA!</p>
          </div>   
        </div>
        <?php $count1 = $count1+1; } ?>
        <!-- <div class="carousel-item">
          <img src="image/2.jpg" alt="Chicago" width="1100" height="500">
          <div class="carousel-caption">
            <p class="mb-1">Chicago</p>
            <p class="mb-1">We had such a great time in LA!</p>
          </div>   
        </div>
        <div class="carousel-item">
          <img src="image/1.jpg" alt="New York" width="1100" height="500">
          <div class="carousel-caption">
            <p class="mb-1">Chicago</p>
            <p class="mb-1">We had such a great time in LA!</p>
          </div>   
        </div> -->

      </div>
      <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>

    <!-- slider -->
</body>
</html>