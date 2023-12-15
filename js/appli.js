var nom_surprise = "Surprise";
var desc_surprise = "rien pour le moment";

var nom_joyeux = "Joyeux";
var desc_joyeux = "allô";

var nom_amour = "Amour";
var desc_amour = "Un moment mémorable avec votre âme soeur ?";

window.onload = function() { 
    //.addEventListener("click", function() { modifier(nom_surprise, desc_surprise); });
    document.getElementById("emoji2").addEventListener("click", function() { modifier(nom_joyeux, desc_joyeux); });
    document.getElementById("emoji3").addEventListener("click", function() { modifier(nom_amour, desc_amour); });
    document.getElementById("emoji4").addEventListener("click", function() { modifier(nom_surprise, desc_surprise); });
    document.getElementById("emoji5").addEventListener("click", function() { modifier(nom_surprise, desc_surprise); });
    document.getElementById("emoji6").addEventListener("click", function() { modifier(nom_surprise, desc_surprise); });
} 

function modifier(nom,desc) {
    document.getElementById("nom_sentiment").innerHTML = nom;
    document.getElementById("description_sentiment").innerHTML = desc;
}