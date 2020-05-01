var orders_data={};//data fetched from database.
var items_data={};//data fetched from database.

let orders_chart_labels=Array();

let orders_chart_data=Array();

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


        orders_chart();
        items_chart();
        second();
  
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
        items_chart_labels.push(items_temp[0]);
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


  