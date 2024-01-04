const sentiments = [
    { nom: "Epoustouflant", desc: "Fais-toi surprendre ! " },
    { nom: "Triste", desc: "Batterie de ... à 1%" },
    { nom: "Amour", desc: "Un moment mémorable avec votre âme soeur ?" },
    { nom: "Joyeux", desc: "Croques la vie à pleine dent !" },
    { nom: "Emouvant", desc: "Pleurer de joie !" },
    { nom: "Festif", desc: "Un endroit amusant et convivial !" }
];

var i = 0;
var txt = 'artages tes sentiments avec tes amis !';
var speed = 50;

window.onload = function () {
    init();
    typeWriter();

    for (let i = 0; i < sentiments.length; i++) {
        const emojiId = "emoji_" + sentiments[i].nom.toLowerCase();
        document.getElementById(emojiId).addEventListener("click", function () {
            modifier(sentiments[i].nom, sentiments[i].desc);
        });
    }

    for (let j = 0; j < sentiments.length; j++) {
        const emojiId2 = "emoji_2" + sentiments[j].nom.toLowerCase();
        document.getElementById(emojiId2).addEventListener("click", function () {
            console.log(sentiments[j].nom);
            modifier2(sentiments[j].nom);
        });
    }


    document.getElementById("btn_ajouter").addEventListener("click", ajouter);
    document.getElementById("btn_retour").addEventListener("click", retour);
}

function modifier(nom, desc) {
    document.getElementById("nom_sentiment").innerHTML = nom;
    document.getElementById("description_sentiment").innerHTML = desc;
}

function modifier2(nom) {
    document.getElementById("nom_sentiment2").innerHTML = nom;
    document.getElementById("inputSentiment").value = nom;
}


function init() {
    document.getElementById("ongletContaint").style.display = "block";
    document.getElementById("ongletAjouter").style.display = "none";

    // document.getElementById("ongletContaint").style.display = "none";
    // document.getElementById("ongletAjouter").style.display = "block";
}

function ajouter() {
    document.getElementById("ongletContaint").style.display = "none";
    document.getElementById("ongletAjouter").style.display = "block";
}

function retour() {
    document.getElementById("ongletContaint").style.display = "block";
    document.getElementById("ongletAjouter").style.display = "none";
}

function typeWriter() {
    if (i < txt.length) {
        document.getElementById("typewriter").innerHTML += txt.charAt(i);
        i++;
        setTimeout(typeWriter, speed);
    }
}