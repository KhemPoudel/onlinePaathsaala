        <div class="detailBox">
    <div class="actionBox">
        <?php
        foreach($models as $model)
        {?>

        <ul class="commentList">
            <li>
                <div class="commenterImage">
                    <?php echo \dektrium\user\models\User::findOne(['id'=>$model->commentedBy])->username;?>
                </div>
                <div class="commentText">
                    <p class="">Hello this is a test comment.</p> <span class="date sub-text">on March 5th, 2014</span>

                </div>
            </li>

        </ul>
        <?php }?>
        <form class="form-inline" role="form">
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Your comments" />
            </div>
            <div class="form-group">
                <button class="btn btn-default">Add</button>
            </div>
        </form>
    </div>
</div>



