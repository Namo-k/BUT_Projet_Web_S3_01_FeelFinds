var nom_surprise = "Etonné";
var desc_surprise = "...";

var nom_joyeux = "Joyeux";
var desc_joyeux = "allô";

var nom_amour = "Amour";
var desc_amour = "Un moment mémorable avec votre âme soeur ?";

var i = 0;
var txt = 'artages tes sentiments avec tes amis !'; /* The text */
var speed = 50; /* The speed/duration of the effect in milliseconds */

window.onload = function() { 
    init();
    document.getElementById("emoji1").addEventListener("click", function() { modifier(nom_surprise, desc_surprise); });
    document.getElementById("emoji2").addEventListener("click", function() { modifier(nom_joyeux, desc_joyeux); });
    document.getElementById("emoji3").addEventListener("click", function() { modifier(nom_amour, desc_amour); });
    document.getElementById("emoji4").addEventListener("click", function() { modifier(nom_surprise, desc_surprise); });
    document.getElementById("emoji5").addEventListener("click", function() { modifier(nom_surprise, desc_surprise); });
    document.getElementById("emoji6").addEventListener("click", function() { modifier(nom_surprise, desc_surprise); });

    typeWriter();

    document.getElementById("ajouter").addEventListener("click", ajouter);
} 

function init() {
    document.getElementById("ongletContaint").style.display = "block";
    document.getElementById("ongletAjouter").style.display = "none";
}

function modifier(nom,desc) {
    document.getElementById("nom_sentiment").innerHTML = nom;
    document.getElementById("description_sentiment").innerHTML = desc;
    document.getElementById("nom_sentiment2").innerHTML = nom;
}

function typeWriter() {
    if (i < txt.length) {
      document.getElementById("typewriter").innerHTML += txt.charAt(i);
      i++;
      setTimeout(typeWriter, speed);
    }
}

function ajouter() {
    document.getElementById("ongletContaint").style.display = "none";
    document.getElementById("ongletAjouter").style.display = "block";
}