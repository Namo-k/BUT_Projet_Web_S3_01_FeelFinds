//changement des images sur le smiley
var i = 0;
var images = new Array();
images.push("../img/stickers/cheerful.png");
images.push("../img/stickers/angel.png");
images.push("../img/stickers/clown.png");
images.push("../img/stickers/crying.png");
images.push("../img/stickers/dead.png");
images.push("../img/stickers/devil.png");
images.push("../img/stickers/famous.png");
images.push("../img/stickers/geek.png");
images.push("../img/stickers/in-love.png");
images.push("../img/stickers/mocking.png");
images.push("../img/stickers/sadness.png");

function ChangerImage(){
    if(i<images.length){
        document.getElementById("stickers").src = images[i];
        ++i;
    }
    else
        i=0

    setTimeout("ChangerImage()", 1700) //boucle
}
 
window.onload = function(){
ChangerImage();
}