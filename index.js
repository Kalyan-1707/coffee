let cart_items=new Map();
let item_list=new Map();

item_list.set('Espresso Italiano',79);
item_list.set('Brrrista',137);
item_list.set('Vanilla Latte',160);

function flip_card(card_id){
                document.getElementById('front'+card_id).style.transform = "rotateX(-180deg)";
                document.getElementById('back'+card_id).style.transform = "rotateX(0deg)";
                }
                function flip_card_back(card_id){
                    document.getElementById('back'+card_id).style.transform = "rotateX(180deg)";
                document.getElementById('front'+card_id).style.transform = "rotateX(0deg)";
               
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

  
       
       document.getElementById('cart_notification_badge').innerHTML=cart_items.size;

       show_cart();
 }


 function show_cart()
 {
     table_row='';
     for (let entry of cart_items) { 
        
        table_row+='<tr>';
        table_row+='<td>'+entry[0]+'</td>';
        table_row+='<td>'+entry[1]+'</td>';
        table_row+='<td>'+item_list.get(entry[0])+'</td>';
        table_row+='<td>'+entry[1]*item_list.get(entry[0])+'</td>';
        table_row+='</tr>';
      }

    document.getElementById('cart_table').innerHTML=table_row;
 }


