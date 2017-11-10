<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Blog Professionnel</title>
    <link href="style.css" rel="stylesheet" />
</head>
<body>
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
    	</p>
    </div>
</body>
</html>