"use strict"

//generation de la grile
const grill = document.getElementById("grille");

let pomme = null;
let score = 0;

for( let i = 0; i < 20; i++ ) {

    for ( let j = 0; j < 20 ; j++ ) {

         const carre = document.createElement('div');
         carre.dataset.i = i;
         carre.dataset.j = j;
      
grill.appendChild(carre);

    }
}

//les differentes positions du corps du serpent donc la premiere la tete et la derniere la queue
  const snake = [

    { i : 10 , j : 10},
    { i : 10 , j : 9},
    { i : 10 , j : 8}
    
]

function afficherSerpent(){

    //reinitialisation de la grille
    const cases = document.querySelectorAll("#grille div"); 
    cases.forEach(c => c.classList.remove("snake", "head","tail" ));

for (let k = 0; k < snake.length; k++){

        const pos = snake[k];

        //on recherche les cases exacte qui correspond à la position du serpent 

        const serpent = document.querySelector(
            `div[data-i="${pos.i}"][data-j="${pos.j}"]`
        );
    
    serpent.classList.add("snake");

    if(k === 0){
        serpent.classList.add("head");
    }

    if(k === snake.length - 1){
        serpent.classList.add("tail")
    }

}

}

let direction = "right";

document.addEventListener("keydown", function(e){
    if(e.key === "ArrowUp" && direction!== "down"){
        direction = "up"
    }

    else if(e.key === "ArrowDown" && direction!== "up"){
        direction = "down"
    }

    else if(e.key === "ArrowLeft" && direction!== "right"){
        direction = "left"
    }

    else if(e.key === "ArrowRight" && direction!== "left"){
        direction = "right"
    }
})



function afficherPomme (){

    const ancienne = document.querySelector(".cat"); 
    if (ancienne) ancienne.classList.remove("cat");

let positionValide = false;
let chat;

while(!positionValide){

    chat = {
        i: Math.floor(Math.random() * 20), 
        j: Math.floor(Math.random() * 20)
    }
    
    //ici on suppose que la position est valide
    positionValide = true

    for( let k = 0; k < snake.length; k++){

        if( chat.i === snake[k].i && chat.j === snake[k].j ){

    positionValide = false
            break;
        }
    }
}

const caseChat = document.querySelector( `div[data-i="${chat.i}"][data-j="${chat.j}"]` );

    caseChat.classList.add("cat")

    pomme = chat;

}


function avancerSnake(){

    const tete = { ...snake[0]}   //on copie la tete actuelle dans un nouvelle objet

    if (direction === "up") tete.i--; 
    if (direction === "down") tete.i++; 
    if (direction === "left") tete.j--; 
    if (direction === "right") tete.j++;

//si le serpent touche l'extremité de la grille
    if ( tete.i < 0 || tete.i > 19 || tete.j > 19 || tete.j < 0 ){

        clearInterval(interval)
   
    const btn = document.getElementById("pause");
    btn.textContent = "Rejouer";
    btn.onclick = function() {
    location.reload();
};

        document.getElementById("perdu").classList.remove("hidden")
        return;
    }
    
    //si le serpent touche son corps
    for ( let k = 1; k < snake.length; k++ ){

        if ( tete.i === snake[k].i && tete.j === snake[k].j){

            clearInterval(interval)

            const btn = document.getElementById("pause");
        btn.textContent = "Rejouer";
        btn.onclick = function() {
        location.reload();
};
            document.getElementById("perdu").classList.remove("hidden")
            return;
        }

        
    }



    snake.unshift(tete)

    if( pomme.i === snake[0].i && pomme.j === snake[0].j){

        afficherPomme()
        score++
        document.getElementById("score").textContent = "Score : " + score;

        if(score >= 12){

           if (score >= 12) { 

            clearInterval(interval)
            document.getElementById("perdu").textContent = " BRAVO "; 
            document.getElementById("perdu").classList.remove("hidden");
            document.getElementById("continue").classList.remove("hidden");

             document.getElementById("continue").addEventListener("click",() => {
        window.location.href = "cine_fin"
    })

}

}

        } else{

        snake.pop()

    }

    afficherSerpent()

}




let interval = setInterval(avancerSnake, 200);
let enPause = false;

document.getElementById("pause").onclick = function() {

    if (!enPause) {
        clearInterval(interval);
        enPause = true;
        this.textContent = "Reprendre";
    } else {
        interval = setInterval(avancerSnake, 200);
        enPause = false;
        this.textContent = "Pause";
    }
}


afficherSerpent();

afficherPomme()


