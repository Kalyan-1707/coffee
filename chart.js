var orders_data={};//data fetched from database.
var items_data={};//data fetched from database.
var pending_orders={};//data of pending orders.

function setDate(){
  
var today = new Date();
var dd = today.getDate();

var mm = today.getMonth()+1; 
var yyyy = today.getFullYear();
if(dd<10) 
{
    dd='0'+dd;
} 

if(mm<10) 
{
    mm='0'+mm;
} 
today = yyyy+'-'+mm+'-'+dd;
document.getElementById('date_table').value=today;

fetch_data_date();

}

function fetch_data_date()
{
  
  let date=document.getElementById('date_table').value;
  let orderStatus = document.getElementById("orderStatus");
  orderStatus = orderStatus.options[orderStatus.selectedIndex].value;
  var xhr=new XMLHttpRequest();
  
  var pars="date="+date +"&" +"status="+orderStatus;
  
    xhr.open('POST','chartdata.php',true);
  
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xhr.onload=function(){
       if(this.status == 200)
        {
         console.log("Sending");
    
        var data=JSON.parse(this.responseText);

        orders_data=JSON.stringify(data.orders);

        items_data=JSON.stringify(data.items);

        pending_orders=JSON.stringify(data.pendingOrders);

        if(pending_orders == "[]")
        {
            let orders_chart_labels=Array();

           let orders_chart_data=Array();
           orders_data=orders_data.slice(1,orders_data.length-1); //Removing {}

            let ele_order=orders_data.split(",");//spliting into array of objects

            for(i=0;i<ele_order.length;i++)
            {
              let date_value=ele_order[i].split(":");
                orders_chart_labels.push(formatDate( new Date(date_value[0].slice(1,date_value[0].length-1))));
                orders_chart_data.push(date_value[1]);
            }

          document.getElementById('pending_orders_table').innerHTML="No orders try another date or different status </br> ex:"+orders_chart_labels+",pending";
        }
        else{
       pending_orders_table();
        }
        }
      } 
      console.log(pars);
      xhr.send(pars);
}


function itemDelivered(tokenid,status)
{ 
 
  var xhr=new XMLHttpRequest();
  
  //	enum('Pending', 'Delivered', 'Cancelled', '')

  let date=document.getElementById('date_table').value;  

  var pars="token="+tokenid + "&" +"status="+status +"&"+ "date="+date;

    
  
    xhr.open('POST','updateStatus.php',true);
  
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xhr.onload=function(){
       if(this.status == 200)
        {
         console.log("Sending");
    
         fetch_data_date();
       
        }
      } 
      xhr.send(pars);

}



function fetch_data(e){

    var xhr=new XMLHttpRequest();
  
  
    xhr.open('POST','chartdata.php',true);
  
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xhr.onload=function(){
       if(this.status == 200)
        {
         console.log("Sending");
    
        var data=JSON.parse(this.responseText);

        orders_data=JSON.stringify(data.orders);

        items_data=JSON.stringify(data.items);

        pending_orders=JSON.stringify(data.pendingOrders);

       pending_orders_table();
       
        }
      } 
      xhr.send();

  }


  function orders_chart()
  {
    


    

    orders_data=orders_data.slice(1,orders_data.length-1); //Removing {}

    let ele_order=orders_data.split(",");//spliting into array of objects

    for(i=0;i<ele_order.length;i++)
    {
       let date_value=ele_order[i].split(":");
        orders_chart_labels.push(formatDate( new Date(date_value[0].slice(1,date_value[0].length-1))));
        orders_chart_data.push(date_value[1]);
    }


    var year=[2010,2011,2012,2013,2014];
    var data_values={
        labels:orders_chart_labels,
        datasets:[
            {
                label:'abd',
        data:orders_chart_data,
        backgroundColor:[
            'rgb(255,0,0,0.3)',
            'rgb(255,0,0,0.3)',
            'rgb(255,0,0,0.3)',
            'rgb(255,0,0,0.3)',
            'rgb(255,0,0,0.3)'
        ],
        borderColor:[
        'rgb(0,0,255,1.0)',
        'rgb(0,0,255,1.0)',
        'rgb(0,0,255,1.0)',
        'rgb(0,0,255,1.0)',
        'rgb(0,0,255,1.0)'
        ],
        borderWidth:1
     }
    ]
    };


    var chartid=document.getElementById('bar-chart').getContext('2d');

    var myChart = new Chart(chartid,{
        type:'bar',
        data:data_values,
        responsive:true,
       
    });

  }



function items_chart(){


    items_data=items_data.slice(1,items_data.length-1);

    items_data=items_data.split(",");//name:12 ===> ['name',12]

    let items_temp='';

    var items_chart_labels=[];

    var items_chart_data=[];

    for(i=0;i<items_data.length;i++)
    {
        items_temp=items_data[i].split(":");
        items_chart_labels.push(items_temp[0].slice(1,items_temp[0].length-1));//slicing of ""
        items_chart_data.push(items_temp[1]);
    }

//doughnut
var ctxD = document.getElementById("doughnutChart").getContext('2d');
var myLineChart = new Chart(ctxD, {
type: 'doughnut',
data: {
labels: items_chart_labels,
datasets: [{
data: items_chart_data,
backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
}]
},
options: {
    
responsive: true,
legend:{
    position:'right',
    },
}
}
);

}


  function formatDate(date) {
    var monthNames = [
      "Jan", "Feb", "Mar",
      "Apr", "May", "Jun", "Jul",
      "Aug", "Sep", "Oct",
      "Nov", "Dec"
    ];
  
    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();
  
    return  day+' ' +monthNames[monthIndex];
  }


  function pending_orders_table()
  {

    let orderStatus = document.getElementById("orderStatus");
    orderStatus = orderStatus.options[orderStatus.selectedIndex].value;
    pending_orders=pending_orders.slice(2,pending_orders.length-2);
    pending_orders=pending_orders.split('","');

    let pending_order_temp={};
    let custname='';
    let tokenid='';
    let items='';

    let table='';

    for(i=0;i<pending_orders.length;i++)
    {
      pending_order_temp=pending_orders[i].split('":"');
      custname=pending_order_temp[0].split(' ');
      tokenid=custname[1];
      custname=custname[0];
      items=pending_order_temp[1];
      items=items.split(',');
      color=['primary','warning','success'];
     table+='<tr>';
     table+='<th scope="row">'+ tokenid +'</th>';
    table+='<td>'+ custname +'</td>';
    table+='<td>'; 
    for(j=0;j<items.length;j++)
    {
      items_temp=items[j].split(':');
      table+='<div class="double-val-label"><span class="'+(color[j%2])+' item">'+items_temp[0]+'</span>';
      table+='<span class="qty">'+items_temp[1]+'</span></div>';
    }
    table+='</td>';
    table+='<td>' + orderStatus +'</td>';
    table+='<td>'+'<button class="btn" onclick="itemDelivered('+ tokenid  +',\'Delivered\')"><i class="fas fa-check-circle"></i></button></td>';
    table+='</tr>';

    }

    document.getElementById('pending_orders_table').innerHTML=table;

  }

  