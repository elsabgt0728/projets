"use strict"

const lettres = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const motsCaches = [ "CHAMBRE" , "TROUVER" , "CLE"  , "COFFRE" , "BUREAU" , "SAUVER" , "MAITRESSE" ]

const btnContinue = document.getElementById("startbtn")
btnContinue.classList.add("hidden")

let compteurMots = 0;
let allwords = document.getElementById("lsmots")

const grille = Array.from({ length: 10 }, () => Array(10).fill("")); 


 function placerMot (mot){

     let placeOK = false;

      while (!placeOK) {

 //la case de depart
 const i = Math.floor(Math.random()*10)
 const j = Math.floor(Math.random()*10)


const directions =[
    {di : 0, dj : 1},
    {di : 0, dj :-1},
    {di : 1, dj :0},
    {di : 1, dj :-1},
    {di : 1, dj :1},
    {di :-1, dj :0},
    {di :-1, dj :1},
    {di :-1, dj :-1},
]
const dir = directions[Math.floor(Math.random()*directions.length)]

 //on verifie si la derniere case du mot est toujours dans la grille
 const lastI = i + dir.di * (mot.length - 1)
 const lastJ = j + dir.dj * (mot.length - 1)

 if ( lastI < 0 || lastI >= 10 || lastJ < 0 || lastJ >= 10 ) continue;


// evite le croisement de lettres diff
  let possible = true;

        for (let k = 0; k < mot.length; k++) {

          const ni = i + dir.di * k;
          const nj = j + dir.dj * k;

          if (grille[ni][nj] !== "" && grille[ni][nj] !== mot[k]) {

            possible = false;
            break;

          }

        }


        if (!possible) continue;

        // Placer le mot
        for (let k = 0; k < mot.length; k++) {

          const ni = i + dir.di * k;
          const nj = j + dir.dj * k;
          grille[ni][nj] = mot[k];

        }

        placeOK = true;

      }

 }

motsCaches.forEach(placerMot);

 //Remplir les cases vides 
for (let i = 0; i < 10; i++) {

      for (let j = 0; j < 10; j++) {

        if (grille[i][j] === "") {

          grille[i][j] = lettres[Math.floor(Math.random() * 26)];

        }

      }

    }






// creation de la grille
const grill = document.getElementById("grille");

for( let i = 0; i < 10; i++ ) {

    for ( let j = 0; j < 10 ; j++ ) {

        document.getElementById("grille").style.display = "grid";


         const carre = document.createElement('div');
         carre.classList.add("cell");

         carre.dataset.i = i;
         carre.dataset.j = j;

        carre.textContent = grille[i][j]

       
       carre.addEventListener("mousedown", cliquer);
        carre.addEventListener("mouseover", glisser);
        document.addEventListener("mouseup", relacher) ;

    
grill.appendChild(carre);

    }
}


 let select = false;
 let selectedLetters = [];
 let selectedPositions = []; // Tableau d'objets {i,j}
 let direction = null



 function cliquer (event) {

       select = true; 
       selectedLetters = [];  
       selectedPositions = [];
       direction = null;
       resetSelection()
       ajouterUnecase(event.target);
       

       }


       function glisser(event) {

        if ( select && event.target.classList.contains("cell") )    {

                 ajouterUnecase(event.target);

        }  

       }

       let motsTrouves = new Set();


function relacher() {
    select = false;

    const motTrouve = selectedLetters.join("");

                                            //le mot n'a pas déja été trouvé
    if (motsCaches.includes(motTrouve) && !motsTrouves.has(motTrouve)) {

        
        for (let k = 0; k < selectedPositions.length; k++) {
            let pos = selectedPositions[k];
            let c = document.querySelector(`[data-i="${pos.i}"][data-j="${pos.j}"]`);
            c.classList.add("trouve");
        }

        
        let motsDiv = document.getElementById("lsmots");
        motsDiv.innerHTML = motsDiv.innerHTML.replace(
            motTrouve,
            `<span class="barre">${motTrouve}</span>`
        );

        
        motsTrouves.add(motTrouve);

        
        compteurMots++;
        document.getElementById("compteur").textContent =
            "Mots trouvés : " + compteurMots + " / " + motsCaches.length;

        // Tous les mots trouvés → bouton Continue
        if (compteurMots === motsCaches.length) {
            btnContinue.classList.remove("hidden");
        }

    } else {
        resetSelection();
    }
}


       function ajouterUnecase(cell){

        const i = parseInt(cell.dataset.i)
        const j = parseInt(cell.dataset.j)

        if ( selectedPositions.length === 0 ){

            selectedPositions.push({i,j})
            selectedLetters.push(cell.textContent)
            cell.classList.add("surligne")
            return;
        } 

        if (selectedPositions.length === 1 && direction === null) {

    // on definit la direction à partir de la 2e case survolée après le clic initial

            direction = {

                di : i - selectedPositions[0].i ,
                dj : j - selectedPositions[0].j 
            }
            
        }

        if (direction) {

            const expectedI = selectedPositions[0].i + direction.di * selectedPositions.length
             const expectedJ = selectedPositions[0].j + direction.dj * selectedPositions.length

        if ( i === expectedI && j === expectedJ ) {

            selectedPositions.push({i,j})
            selectedLetters.push(cell.textContent)
            cell.classList.add("surligne")

        }


       }



    }

    function resetSelection () {

        document.querySelectorAll(".surligne").forEach(cell => {cell.classList.remove("surligne")});
        selectedLetters = [];
        selectedPositions = [];
        direction = null;
    }

   
    btnContinue.addEventListener("click",()=>{
        window.location.href = "porte2"
    })