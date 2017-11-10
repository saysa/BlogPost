<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Blog Professionnel</title>
    <link href="style.css" rel="stylesheet" />
</head>
<body>

    <h1>Mon blog !</h1>
    <p>Derniers billets du blog :</p>

    <?php
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=blog_post;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    $req = $db->query('SELECT id, author, title, lead_paragraph, content, DATE_FORMAT(last_update, \'%d/%m/%Y à %Hh%imin%ss\') AS last_update FROM post ORDER BY last_update DESC LIMIT 0, 5');

    while ($data = $req->fetch())
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
            	<?= nl2br(htmlspecialchars($data['content'])) ?>
        	</p>
        </div>
    <?php
    }
    $req->closeCursor();
    ?>
</body>
</html>