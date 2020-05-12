let cart_items=new Map();
let item_list=new Map();

document.getElementById('admin_login_btn').addEventListener('click',backend_validate_admin);

item_list.set('Espresso Italiano',79);
item_list.set('Brrrista',137);
item_list.set('Vanilla Latte',160);
item_list.set('Cappuccino',100);

function adminFormHide(){
  document.getElementById('admin').style.display="none";
}

function adminFormShow(){
  document.getElementById('admin').style.display="inline-flex";
  document.getElementById('navbar-toggler-btn').click();
}

function error_log_pop_up()
{
  if(document.getElementById('place_order_form_error_log').innerHTML!='')
   document.getElementById('open_cart_btn').click();
}

function validate_place_order()
{
    var cust_num=document.getElementById('customer_num').value;
        
  if(cart_items.size==0)
  {
    document.getElementById('place_order_form_error_log').style.display='block';
    document.getElementById('place_order_form_error_log').innerHTML='Add items to cart';
  }
          
    else if(document.getElementById('customer_name').value=="")
    {
      document.getElementById('place_order_form_error_log').style.display='block';
    document.getElementById('place_order_form_error_log').innerHTML='Enter your Name';
    }
    else if(document.getElementById('customer_num').value=="")
    {
      document.getElementById('place_order_form_error_log').style.display='block';
    document.getElementById('place_order_form_error_log').innerHTML='Enter your number';
    }
    
    else if(!(/^[a-zA-Z0-9]+$/.test(document.getElementById('customer_name').value)))
    {
      document.getElementById('place_order_form_error_log').style.display='block';
      document.getElementById('place_order_form_error_log').innerHTML='Name should contain only a-z,0-9';
    }
    
    else if(cust_num.length!=10)
    {
      document.getElementById('place_order_form_error_log').style.display='block';
    document.getElementById('place_order_form_error_log').innerHTML='Number should be 10 digits';
    }
  
    else
  {
    document.getElementById('form_place_order').submit();
  }
}

function placeOrder()
{
  submitPlaceOrder();
}

function flip_card(card_id){
                document.getElementById('front'+card_id).style.transform = "rotateX(-180deg)";
                document.getElementById('back'+card_id).style.transform = "rotateX(0deg)";
                }
                function flip_card_back(card_id){
                    document.getElementById('back'+card_id).style.transform = "rotateX(180deg)";
                document.getElementById('front'+card_id).style.transform = "rotateX(0deg)";
               
                }


  function update_cart_notifier()
  {
    document.getElementById('cart_notification_badge').innerHTML=cart_items.size;
  }

 function cart(item_name,quantity)
   {
      
        
       if(cart_items.has(item_name))
       {
        cart_items.set(item_name,parseInt(cart_items.get(item_name))+parseInt(quantity));
       }
       else
       {
        cart_items.set(item_name,quantity);
       }

      

       
       update_cart_notifier();

       show_cart();
 }

 function remove_item(item_name)
 {
   if((parseInt(cart_items.get(item_name))-1)<=0)
   {
     cart_items.delete(item_name);
   }
   else
   {
      cart_items.set(item_name,(parseInt(cart_items.get(item_name))-1));
   }
      update_cart_notifier();
      show_cart();
 }



 function show_cart()
 {
     table_row='';
     items='';
     total_amt=0;
     for (let entry of cart_items) { 
        
        table_row+='<tr>';
        table_row+='<td>'+entry[0]+'</td>';
        table_row+='<td>'+entry[1]+'</td>';
        
        table_row+='<td>'+entry[1]*item_list.get(entry[0])+'</td>';
        table_row+='<td>'+'<i class="fas fa-minus-circle btn" onclick="remove_item(\''+entry[0]+'\')"></i>'+'</td>';
        table_row+='</tr>';
        items+=entry[0]+':'+entry[1]+',';
        total_amt+=entry[1]*item_list.get(entry[0]);
      }

    document.getElementById('items_input_box').innerHTML=' <input type="text" name="items" value="' + items+ '">';
    document.getElementById('items_input_box').style.display='none';
    document.getElementById('cart_table').innerHTML=table_row;
    document.getElementById('total_amt').innerHTML='₹ '+total_amt;
    
 }
function backend_validate_admin(e){
  

  e.preventDefault();

  var xhr=new XMLHttpRequest();

  var uname=document.getElementById('admin_uname').value;

  var pwd=document.getElementById('admin_pwd').value;

  var pars="uname="+uname +"&" +"pwd="+pwd;

  xhr.open('POST','admin_auth.php',true);

  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  xhr.onload=function(){
     if(this.status == 200)
      {
       console.log("Sending");
  
       if(this.responseText=="success")
       {
        window.location.href='https://thunder1707.000webhostapp.com/admin.php';
       }
       else
        alert(this.responseText);
       
      }
    }
  
    xhr.send(pars);




 }

 function submitPlaceOrder(e){

  

  var xhr=new XMLHttpRequest();

  var uname=document.getElementById('customer_name').value;

  

  var pars="name="+uname;

  xhr.open('POST','orders.php',true);

  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  xhr.onload=function(){
     if(this.status == 200)
      {
       console.log("Sending");
  
       console.log(this.responseText);
       
      }
    }
    console.log(pars);
    xhr.send(pars);
}