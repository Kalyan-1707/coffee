function flip_card(){
    document.getElementById('order_summary_card_front').style.transform = "rotateX(-180deg)";
    document.getElementById('order_summary_card_back').style.transform = "rotateX(0deg)";
    }
    function flip_card_back(card_id){
        document.getElementById('order_summary_card_back').style.transform = "rotateX(180deg)";
    document.getElementById('order_summary_card_front').style.transform = "rotateX(0deg)";
   
    }