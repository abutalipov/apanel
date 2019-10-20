<?php
use yii\widgets\LinkPager;
?><h1>Комментарии</h1>
<?php foreach ($comments as $comment){
    echo "<li><a href='".Yii::$app->urlManager->createUrl(['site/user','name'=>$comment->Name])."'><i>{$comment->Name}</i> </a>{$comment->Value}</li>";
}
echo LinkPager::widget(['pagination'=>$pagination]);
