//changement des images sur le smiley
var i = 0;
var images = new Array();
images.push("img/sourirebleu.png");
images.push("img/clin2.png");
images.push("img/sourirejaune.png");
images.push("img/clin.png");
images.push("img/visage-souriant.png");

function ChangerImage(){
    if(i<images.length){
        document.getElementById("smiley").src = images[i];
        ++i;
    }
    else
        i=0

    setTimeout("ChangerImage()", 1700) //boucle
}
 
window.onload = function(){
ChangerImage();
}