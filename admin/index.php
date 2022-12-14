<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Dashboard Page</title>

<?php 
session_start();  
if (!isset($_SESSION['admin'])) {
  header("location:login.php");
}

include "./templates/top.php"; 
include_once 'Database.php';
?>
 
<?php include "./templates/navbar.php"; ?>

<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>


      <canvas class="my-4 w-100" id="boxChart" width="900" height="380"></canvas> 

      <h2>Total Admins</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Status</th>
              
            </tr>
          </thead>
          <?php

$result = mysqli_query($conn,"SELECT * FROM admin");

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_array($result)) {
    ?>
    <tr><td><?php echo $row['id'];?></td>
          <td><?php echo $row['name'];?></td>
          <td><?php echo $row['email'];?></td>
          
          <td><?php echo $row['is_active'];?></td>
          
            </tr>
  <?php
  }
}
?>
           
          
        </table>
      </div>
    </main>
  </div>
</div>

<?php include "./templates/footer.php"; ?>

<?php
//Algorithm for display chart with movies as collection 
$movielist = mysqli_query($conn,"SELECT * FROM add_movie");
foreach($movielist as $movie){
  $recentmovie_name[]= $movie['movie_name'];
  $current_movie= $movie['movie_name'];
  $current_count = mysqli_query($conn,"SELECT SUM(price) as count  FROM customers WHERE movie ='".$current_movie."' ");
  $row = mysqli_fetch_assoc($current_count); 
  $sum = $row['count'];
  $movie_price[]= $sum;

}
?>
<script type="text/javascript" src="./js/admin.js"></script>
<script>
var ctx = document.getElementById('boxChart')
  // eslint-disable-next-line no-unused-vars
  var boxChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($recentmovie_name);?>,
      datasets: [{
        data:<?php echo json_encode($movie_price);?>,
        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: false
          }
        }]
      },
      legend: {
        display: false
      }
    }
  })
  </script>
