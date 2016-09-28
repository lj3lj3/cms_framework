<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article edit</title>
    <form action="update" method="post">
        <input type="hidden" name="id" value="{$article.id}">
        title:<br />
        <input name="title" type="text" value="{$article.title}"><br />
        content:<br />
        <textarea name="content" >{$article.content}</textarea>

        <input type="submit">

    </form>
</head>
<body>

</body>
</html>