<?php
require('model.php');
$_GET['id'] = 1;
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $post = getPost($_GET['id']);
    require('postView.php');
}
else {
    echo 'Erreur : aucun identifiant de billet envoyé';
}

