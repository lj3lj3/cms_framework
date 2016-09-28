<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
</head>
<body>
<ul>
    {foreach $articles as $article}
        <li>"标题: {$article.title} </li>
        内容": {$article.content}
    {/foreach}
</ul>
</body>
</html>