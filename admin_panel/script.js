let lotteryItemButton = document.getElementsByClassName("lottery-item")[0];
let ticketGeneratorButton = document.getElementsByClassName("ticket-generator")[0];

lotteryItemButton.addEventListener("click",event=>{
    window.location = "lottery-item.php";
});
ticketGeneratorButton.addEventListener("click",event=>{
    window.location = "ticket-generator.php";
});

