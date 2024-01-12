<?php
    if ($nombreMarqueurs >= 100) {
        $niveauUtilisateur = 'Superstar';
    } elseif ($nombreMarqueurs >= 50) {
        $niveauUtilisateur =  'Tryharder';
    } elseif ($nombreMarqueurs >= 20) {
        $niveauUtilisateur =  'Intermédiaire';
    } elseif ($nombreMarqueurs >= 10) {
        $niveauUtilisateur =  'Novice';
    } else {
        $niveauUtilisateur =  'Débutant';
    }
?>