<?php $title = htmlspecialchars($post['title']); ?>

<?php ob_start(); ?>
<h1>Mon blog !</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
    	<?= htmlspecialchars($post['title']) ?><br>
    	Par <?= htmlspecialchars($post['author']) ?> - 
    	<em>dernière modification <?= $post['last_update'] ?></em>
    </h3>
        
    <p>
    	<strong><?= nl2br(htmlspecialchars($post['lead_paragraph'])) ?></strong>
    	<?= nl2br(htmlspecialchars($post['content'])) ?>
    	<br>
    	<em><a href="index.php?action=postForm&amp;id=<?= $post['id'] ?>">Modifier le billet</a></em>
	</p>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>