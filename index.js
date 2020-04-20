function flip_card(card_id){
                document.getElementById('front'+card_id).style.transform = "rotateX(-180deg)";
                document.getElementById('back'+card_id).style.transform = "rotateX(0deg)";
                }
                function flip_card_back(card_id){
                    document.getElementById('back'+card_id).style.transform = "rotateX(180deg)";
                document.getElementById('front'+card_id).style.transform = "rotateX(0deg)";
               
                }