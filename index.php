<?php 
    require 'common.php';

    $query="select * from items";

	$res=mysqli_query($con,$query) or die(mysqli_error($con));

 
?>



<!DOCTyPE html>
<html>
    <head>
        <title></title>
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
         <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
         <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        
         <link rel="stylesheet" href="index_style_sheet.css">

         <script src="https://kit.fontawesome.com/9d2de32d23.js" crossorigin="anonymous"></script>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="index.js"> </script>
        
    </head>
    <body>

        <nav class="navbar navbar-inverse navbar-static-top" style="margin:0px;">
            <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mynavbar">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>                        
                                </button>    
                        <a href="index.html" class="navbar-brand">Coffee Shop</a>
                                 </div>
          
                <div class="collapse navbar-collapse" id=mynavbar>      
                <form class="nav navbar-right form-inline form-group" action="login_script" method="post" style="padding-top: 10px;">
                                    
                    <label for="email" style="  color: rgb(0,255,0);" class="nav-item">Email</label>&nbsp;
                    <input type="email" name="email" id="email" class="form-control nav-item" placeholder="email" required="true">
                    <label for="password" style="  color: rgb(0,255,0);" class="nav-item">Password</label>&nbsp;
                    <input type="password" name="password" id="password" class="form-control nav-item" placeholder="password" id="pd" required="true">&nbsp;
                    <button class="btn form-control nav-item" style="background-color: orange; color: black">Login</button>
                    </form>	
                    </div>
                </div>
                </nav>
        
        


            <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xs-10">
                <div class="card-container ">
                    <div class="card card-front" id="front1">
                      <img class="card-img-top" src="coffee2.jpg" alt="Card image cap" >
                      <div class="card-body">
                        
                        <div class="card-text">
                        <h5 class="card-title">Cappuccino</h5>
                        <p class="price">₹ 100.00</p>
                      </div>
                        

                        <div class="btn-group btn-block" role="group" aria-label="">
                          <button type="button" class="btn btn-success"  >Order</button>
                          
                          
                          <button type="button" class="btn btn-info" onclick='flip_card(1)'>Info</button>
                        </div>

                        <div class="card-btn-group">
                          <div class="card-btn">
                            <button type="button" class="btn btn-block"
                              onclick="if(document.getElementById('quantity').value>1)document.getElementById('quantity').value--;">&nbsp;-&nbsp;</button>
                          </div>
                          <div class="card-btn">
                            <input type="number" class="form-control" value="1" min="1" max="10" id="quantity" disabled>
                           
                        </div>
                          <div class="card-btn">
                            <button type="button " class="btn  btn-block" onclick="if(document.getElementById('quantity').value<10)document.getElementById('quantity').value++;"> + </button>
                          </div>
                        </div>
                       
                      </div>
                       </div>
                    <div class="card card-back " id="back1">
                      <div class="card-body" >
                        <p>A cappuccino is an espresso-based coffee drink that originated in Italy, and is traditionally prepared with steamed milk foam. Variations of the drink involve the use of cream instead of milk, and flavoring with cinnamon or chocolate powder.</p>
                        </div>
                        <button class="btn btn-info glyphicon " onclick="flip_card_back(1)">back</button>
                        <div class="card-status">
                          <div class="stat">
                            <div class="value">200ml</div>
                            <div class="type">Quantity</div>
                          </div>
                          <div class="stat">
                            <div class="value">55</div>
                            <div class="type">Calories</div>
                          </div>
                          <div class="stat">
                            <div class="value">500 lt</div>
                            <div class="type">Served</div>
                          </div>
                        </div>
                      </div>

                </div>

            </div>





        <?php 
            $count=6;
           while($row=mysqli_fetch_array($res))
           {
               ?>

            
                <div class="col-lg-4 col-xs-10">
                <div class="card-container ">
                    <div class="card card-front" id="<?php echo "front".$count; ?>">
                      <img class="card-img-top" src="<?php echo $row['image'];?>" alt="Card image cap" >
                      <div class="card-body">
                        
                        <div class="card-text">
                        <h5 class="card-title"><?php echo $row['name'];?></h5>
                        <p class="price">₹ <?php echo $row['price'];?></p>
                      </div>
                        

                        <div class="btn-group btn-block" role="group" aria-label="">
                          <button type="button" class="btn btn-success" onclick="cart('<?php echo $row['name'];?>',document.getElementById(<?php echo $count;?>).value);">Order</button>
                          
                          
                          <button type="button" class="btn btn-info" onclick='flip_card(<?php echo $count; ?>)'>Info</button>
                        </div>

                        <div class="card-btn-group">
                          <div class="card-btn">
                            <button type="button" class="btn btn-block"
                              onclick="if(document.getElementById(<?php echo $count;?>).value>1)document.getElementById(<?php echo $count;?>).value--;">&nbsp;-&nbsp;</button>
                          </div>
                          <div class="card-btn">
                            <input type="number" class="form-control" value="1" min="1" max="10" id="<?php echo $count; ?>" disabled>
                           
                        </div>
                          <div class="card-btn">
                            <button type="button " class="btn  btn-block" onclick="if(document.getElementById(<?php echo $count;?>).value<10)document.getElementById(<?php echo $count;?>).value++;"> + </button>
                          </div>
                        </div>
                       
                      </div>
                       </div>
                    <div class="card card-back " id="<?php echo "back".$count;?>">
                      <div class="card-body" >
                        <p>A cappuccino is an espresso-based coffee drink that originated in Italy, and is traditionally prepared with steamed milk foam. Variations of the drink involve the use of cream instead of milk, and flavoring with cinnamon or chocolate powder.</p>
                        </div>
                        <button class="btn btn-info glyphicon " onclick="flip_card_back(<?php echo $count;?>)">back</button>
                        <div class="card-status">
                          <div class="stat">
                            <div class="value"><?php echo $row['capacity'];?></div>
                            <div class="type">Quantity</div>
                          </div>
                          <div class="stat">
                            <div class="value"><?php echo $row['calories'];?></div>
                            <div class="type">Calories</div>
                          </div>
                          <div class="stat">
                            <div class="value"><?php echo $row['servedcapacity'];?></div>
                            <div class="type">Served</div>
                          </div>
                        </div>
                      </div>

                </div>

            </div>

            <?php
             $count=$count+1;}
           ?>













        </div>

    </div>


            <button class='btn btn-primary cart-btn btn-block notification' data-toggle="modal" data-target="#exampleModalCenter">
              <i class="fas fa-shopping-cart"></i>

              <p class="badge" id="cart_notification_badge"></p>
            </button>






<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Check out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table class="table table-dark">
  <thead>
    <tr>
      
      <th scope="col">Item</th>
      <th scope="col">Quantity</th>
      <th scope="col">Price</th>
      <th scope="col">Total</th>
    </tr>
  </thead>
  <tbody id='cart_table'>
    
  </tbody>
</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" >Place Order</button>
      </div>
    </div>
  </div>
</div>

              


    </body>
</html>