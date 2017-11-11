<?php $title = 'Blog professionnel'; ?>

<?php ob_start(); ?>
<h1>Mon blog !</h1>
<p>Derniers billets du blog :</p>

<?php
while ($data = $posts->fetch())
{
?>
    <div class="news">
        <h3>
        	<?= htmlspecialchars($data['title']) ?><br>
        	Par <?= htmlspecialchars($data['author']) ?> - 
        	<em>dernière modification <?= $data['last_update'] ?></em>
        </h3>
            
        <p>
        	<strong><?= nl2br(htmlspecialchars($data['lead_paragraph'])) ?></strong>
            <br>
            <em><a href="index.php?action=post&amp;id=<?= $data['id'] ?>">Voir le billet</a></em>
    	</p>
    </div>
<?php
}
$posts->closeCursor();
?>

<form action="index.php?action=newPost" method="post">
    <h2>Ajouter un billet</h2>
    <div>
        <label for="author">Auteur</label><br />
        <input type="text" id="author" name="author" />
    </div>      
    <div>
        <label for="title">Titre</label><br />
        <input type="text" id="title" name="title" />
    </div>
    <div>
        <label for="lead_paragraph">Chapô</label><br />
        <textarea id="lead_paragraph" name="lead_paragraph"></textarea>
    </div>      
    <div>
        <label for="content">Contenu</label><br />
        <textarea id="content" name="content"></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>