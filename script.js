// let luckyBox = document.querySelectorAll(".lucky-box-wrapper .lucky-box");
// for ( let count = 0 ; count < luckyBox.length ; count++ ) {
//     luckyBox[count].addEventListener("click",event=>{
//         for ( let i = 0 ; i < luckyBox.length ; i++ ) {
//             luckyBox[i].setAttribute("style","border-color: transparent");
//         }
//         luckyBox[count].setAttribute("style","border-color: black;");
//     });
// }


// Important codes for lottery style changes !! don't delete !!
// let sec = 0;
// let finalSec = Math.floor(Math.random() * 100)+1200;
// let counter = 0;
// let swiperInterval;
// function swiperFunction() {
//     if ( counter === luckyBox.length ) counter = 0;
//     if ( sec > finalSec ) {
//         clearInterval(swiperInterval);
//         return;
//     }
//     for ( let i = 0 ; i < luckyBox.length ; i++ ) {
//         luckyBox[i].setAttribute("style","border-color: transparent");
//     }
//     luckyBox[counter].setAttribute("style","border-color: black;");
//     counter++;
//     if ( sec > 200 ) {
//         sec+=Math.floor(Math.random() * 100)+30;
//     }
//     else if ( sec > 500 ) {
//         sec+=Math.floor(Math.random() * 150)+60;
//     } else if ( sec > 800 ) {
//         sec+=Math.floor(Math.random() * 200)+130;
//     } else sec+=20;
//     clearInterval(swiperInterval);
//     swiperInterval = setInterval(swiperFunction, sec);
//     console.log(sec);
// }
// swiperFunction();