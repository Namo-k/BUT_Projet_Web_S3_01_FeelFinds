const sentiments = [
    { nom: "Epoustouflant", desc: "Fais-toi surprendre ! " },
    { nom: "Triste", desc: "Batterie de tristesse à 99%..." },
    { nom: "Amour", desc: "Un amour partagé inoubliable ?" },
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
        $("." + emojiId).click(function() {
            $("#description_sentiment").html(sentiments[i].desc);
            $(".nom_sentiment").html(sentiments[i].nom);
            $('.inputSentiment').val(sentiments[i].nom);
        });
    }

    document.getElementById("btn_ajouter").addEventListener("click", ajouter);
    $(".btn_retour").click(retour);
}


function init() {
    document.getElementById("ongletContaint").style.display = "block";
    document.getElementById("ongletAjouter").style.display = "none";
    document.getElementById("ongletModifier").style.display = "none";
    document.getElementById("ongletAjouterMarqueur").style.display = "none";
    document.getElementById("btnAnnulerFiltre").style.display = "none";
    document.getElementById("ongletFavori").style.display = "none";

}

function ajouter() {
    document.getElementById("ongletContaint").style.display = "none";
    document.getElementById("ongletAvis").style.display = "none";
    document.getElementById("ongletFavori").style.display = "none";
    document.getElementById("ongletAjouter").style.display = "block";
    $("#ongletAjouter #msgErreurAjoutSentiment").hide();
    $('select[name="nomMarqueur"]').val("");
}

function retour() {
    document.getElementById("ongletContaint").style.display = "block";
    document.getElementById("ongletAjouter").style.display = "none";
    document.getElementById("ongletModifier").style.display = "none";
    document.getElementById("ongletAjouterMarqueur").style.display = "none";
    document.getElementById("ongletFavori").style.display = "none";
    erreurAjout(false);
}

function typeWriter() {
    if (i < txt.length) {
        document.getElementById("typewriter").innerHTML += txt.charAt(i);
        i++;
        setTimeout(typeWriter, speed);
    }
}