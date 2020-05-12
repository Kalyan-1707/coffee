<?php
session_start();

if (!isset($_SESSION['uname']))
{
    header('location:https://thunder1707.000webhostapp.com/');
}

?>




<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
         <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
         <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
         <script src="https://kit.fontawesome.com/9d2de32d23.js" crossorigin="anonymous"></script>
    
         <script src="chart.js"></script>

        <link rel="stylesheet" href="chart.css">
    </head>

    <body onload="setDate()">


    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a class="navbar-brand" href="#">Coffee</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
              <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link" href="logout.php">Logout</a>
                </li>    
              </ul>
            </div>
          </nav>

        <div class="vertical-center">
        <div class="container">
            <div class="row mx-auto justify-content-center">
            
            <div class="mx-auto"><p><i class="fas fa-info-circle"></i>Click on done if order is Delivered.</p></div>
            <div>
            <input type="date" id="date_table"  onchange="fetch_data_date()">
            <select id="orderStatus" onchange="fetch_data_date()">
            <option value="Pending" selected>Pending</option>
            <option value="Delivered">Delivered</option>
            <option value="Cancelled">Cancelled</option>
            </select>
            </div>
                <div class="col-xs-12">
                    <div class="card">
                        
                <table class="table table-hover"  >

                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Items</th>
                        <th scope="col">Status</th>
                        <th scope="col">Done</th>
                        
                      </tr>
                    </thead>
                    <tbody id="pending_orders_table">
                     
                    </tbody>
                  </table>
                </div>
            </div>
                
            </div>
            
        </div>
    </div>
    </body>
</html>

