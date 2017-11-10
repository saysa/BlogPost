<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Blog Professionnel</title>
    <link href="style.css" rel="stylesheet" />
</head>
<body>
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
                <em><a href="post.php?id=<?= $data['id'] ?>">Voir le post en entier</a></em>
        	</p>
        </div>
    <?php
    }
    $posts->closeCursor();
    ?>
</body>
</html>