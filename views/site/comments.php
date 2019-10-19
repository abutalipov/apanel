<h1>Комментарии</h1>
<?php foreach ($comments as $comment){
    echo "<li><i>{$comment->Name}</i> {$comment->Value}</li>";
}
