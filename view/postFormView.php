<?php $title = htmlspecialchars($post['title']); ?>

<?php ob_start(); ?>
<h1>Mon blog !</h1>
<p>
	<a href="index.php">Retour à la liste des billets</a><br>
	<a href="index.php?action=post&amp;id=<?= $post['id'] ?>">Retour au billet</a>
</p>

<form action="index.php?action=editPost&amp;id=<?= $post['id'] ?>" method="post">
	<h2>Modifier le billet</h2>
    <div>
        <label for="author">Auteur</label><br />
        <input type="text" id="author" name="author" value="<?= $post['author']; ?>" />
    </div>	    
    <div>
        <label for="title">Titre</label><br />
        <input type="text" id="title" name="title" value="<?= $post['title']; ?>" />
    </div>
    <div>
        <label for="lead_paragraph">Chapô</label><br />
        <textarea id="lead_paragraph" name="lead_paragraph"><?= $post['lead_paragraph']; ?></textarea>
    </div>	    
    <div>
        <label for="content">Contenu</label><br />
        <textarea id="content" name="content"><?= $post['content']; ?></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>