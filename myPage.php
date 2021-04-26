<?php
require('function.php');
$user_id = $_SESSION['id'];
$re_id = $_REQUEST['myPage_id'];
$follow_check = getFollow($user_id, $re_id);
$check = getFavoriteAll($user_id);

if(!empty($re_id)){
    $reUser = getUser($re_id);
    $contents = getUserContents($re_id);
    $goods = getFavoriteComment($re_id);
    $ReMessages = getAllReMessage($re_id);
}
?>

<?php require('header.php'); ?>
<div class="container-fluid">
    <div class="header_img">
    </div>
    <div class="row main_content">
        <div class="col-md-4 left_content">
            <div class="text-center mt-5 mr-5">
                <img src="user_img/<?php echo h($reUser['user_img']); ?>" class="rounded-circle myPage_img ml-5" alt="プロフィール画像">
            </div>
            <div class="user_name mt-4">
                <?php echo h($reUser['name']);?>
            </div>

            <?php if($re_id != $user_id && empty($follow_check)): ?>
                <div class="text-center">
                    <a href="follow.php?id=<?php echo $reUser['id'];?>" class="btn btn-primary mt-4">フォローする</a>
                </div>
            <?php endif; ?>

            <div class="text-center">
                <?php if($re_id != $user_id && !empty($follow_check)): ?>
                    <a href="follow_delete.php?id=<?php echo $reUser['id'];?>" class="btn btn-primary mt-3">フォローをはずす</a>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-around">
                <a href="follow_view.php?id=<?php echo $reUser['id']; ?>" class="btn btn-primary follow mt-4 ml-5">フォロー</a>
                <a href="follower_view.php?id=<?php echo $reUser['id']; ?>" class="btn btn-primary follower mt-4 mr-5">フォロワー</a>
            </div>

            <?php if($reUser['id'] == $user_id): ?>
                <div class="text-center mt-4">
                    <a href="update.php?update_id=<?php echo $user_id; ?>">ユーザー情報を変更する</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="line"></div>

        <div class="col-md-7 right_content">

            <div class="tabs mt-3 ml-md-5">

                <input id="all" type="radio" name="tab_item" checked>
                <label class="tab_item" for="all">ツイート</label>
                <input id="programming" type="radio" name="tab_item">
                <label class="tab_item" for="programming">返信</label>
                <input id="design" type="radio" name="tab_item">
                <label class="tab_item" for="design">いいね</label>

                <div class="tab_content" id="all_content">
                    <div class="tab_content_description">
                        <?php foreach ($contents as $content): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <img src="user_img/<?php echo h($content['user_img']); ?>" class="rounded-circle mt-2 ml-4" alt="プロフィール画像">
                                        <h5 class="card-title ml-3 mt-4 mr-auto">
                                            <a href="myPage.php?myPage_id=<?php echo h($content['user_id']);?>"><?php echo h($content['name']);?></a>
                                        </h5>
                                        <small class="mr-5 mt-3 date"><?php echo h($content['created']);?></small>
                                    </div>
                                    <p class="card-text my_card-text mt-3"><a href="show.php?id=<?php echo h($content['id']); ?>"><?php echo nl2br(h($content['message']));?></a></p>
                                </div>
                                <?php if(isset($content['picture'])): ?>
                                    <img src="picture/<?php echo h($content['picture']);?>" class="main_picture mt-4" alt="投稿画像">
                                <?php endif; ?>
                                <div class="d-flex justify-content-end">
                                    <?php in_array($content['id'], $check) ? print'<a href="favorite_delete.php?id='.$content['id'].'" class="fas fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$content['good'].'</span>'
                                    :print'<a href="favorite.php?id='.$content['id'].'" class="far fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$content['good'].'</span>';?>
                                        <a href="post.php?id=<?php echo $content['id']; ?>" class="btn btn-dark mt-3 ml-3 mb-3 mr-3">返信</a>
                                    <?php if($content['user_id'] == $user_id): ?>
                                        <a href="delete.php?id=<?php echo $content['id']; ?>" class="btn btn-dark mt-3 mb-3 mr-3 delete">削除</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="tab_content" id="programming_content">
                    <div class="tab_content_description">
                        <?php foreach ($ReMessages as $ReMessage): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <img src="user_img/<?php echo h($ReMessage['user_img']); ?>" class="rounded-circle mt-2 ml-4" alt="プロフィール画像">
                                        <h5 class="card-title ml-3 mt-4 mr-auto">
                                            <a href="myPage.php?myPage_id=<?php echo h($ReMessage['user_id']);?>"><?php echo h($ReMessage['name']);?></a>
                                        </h5>
                                        <small class="mr-5 mt-3 date"><?php echo h($ReMessage['created']);?></small>
                                    </div>
                                    <p class="card-text my_card-text mt-3">
                                    <a href="show.php?id=<?php echo h($ReMessage['id']); ?>/#<?php echo h($ReMessage['id']); ?>"><?php echo nl2br(h($ReMessage['message']));?></a>
                                    </p>
                                </div>
                                <?php if(isset($ReMessage['picture'])): ?>
                                    <img src="picture/<?php echo h($ReMessage['picture']);?>" class="main_picture mt-4" alt="投稿画像">
                                <?php endif; ?>
                                <div class="d-flex justify-content-end">
                                    <?php in_array($ReMessage['id'], $check) ? print'<a href="favorite_delete.php?id='.$ReMessage['id'].'" class="fas fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$ReMessage['good'].'</span>'
                                    :print'<a href="favorite.php?id='.$ReMessage['id'].'" class="far fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$ReMessage['good'].'</span>';?>
                                        <a href="post.php?id=<?php echo $ReMessage['id']; ?>" class="btn btn-dark mt-3 ml-3 mb-3 mr-3">返信</a>
                                    <?php if($ReMessage['user_id'] == $user_id): ?>
                                        <a href="delete.php?id=<?php echo $ReMessage['id']; ?>" class="btn btn-dark mt-3 mb-3 mr-3 delete">削除</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="tab_content" id="design_content">
                    <div class="tab_content_description">
                        <?php foreach ($goods as $good): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <img src="user_img/<?php echo h($good['user_img']); ?>" class="rounded-circle mt-2 ml-4" alt="プロフィール画像">
                                        <h5 class="card-title ml-3 mt-4 mr-auto">
                                            <a href="myPage.php?myPage_id=<?php echo h($good['user_id']);?>"><?php echo h($good['name']);?></a>
                                        </h5>
                                        <small class="mr-5 mt-3 date"><?php echo h($good['created']);?></small>
                                    </div>
                                    <p class="card-text my_card-text mt-3"><a href="show.php?id=<?php echo h($good['id']); ?>"><?php echo nl2br(h($good['message']));?></a></p>
                                </div>
                                <?php if(isset($good['picture'])): ?>
                                    <img src="picture/<?php echo h($good['picture']);?>" class="main_picture mt-4" alt="投稿画像">
                                <?php endif; ?>
                                <div class="d-flex justify-content-end">
                                    <?php in_array($good['id'], $check) ? print'<a href="favorite_delete.php?id='.$good['id'].'" class="fas fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$good['good'].'</span>'
                                    :print'<a href="favorite.php?id='.$good['id'].'" class="far fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$good['good'].'</span>';?>
                                        <a href="post.php?id=<?php echo $good['id']; ?>" class="btn btn-dark mt-3 ml-3 mb-3 mr-3">返信</a>
                                    <?php if($good['user_id'] == $user_id): ?>
                                        <a href="delete.php?id=<?php echo $good['id']; ?>" class="btn btn-dark mt-3 mb-3 mr-3 delete">削除</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

            
        </div>
    </div>
</div>
<?php require('footer.php'); ?>