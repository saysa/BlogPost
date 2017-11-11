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
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>