<div class="card-panel bl-panel text-center hoverable" style="margin-left: 0%;margin-right: 0%;margin-top: 10%;">
    <h5><?=$topic?></h5>
    <hr>
    <ul class="nav nav-tabs tabs-3" style="
                                                position: relative;
                                                height: 48px;
                                                background-color: #fff;
                                                margin: 0 auto;
                                                width: 100%;
                                                white-space: nowrap;
                                                border: none;
                                                border-bottom: 1px solid #ddd;
                                                padding-left: 0;
                                                padding: 0;
                                                list-style: none;
                                                box-shadow: 0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
        <li style="
                        width: 33%;
                        display: block;
                        float: left;
                        text-align: center;
                        line-height: 48px;
                        height: 48px;
                        padding: 0;
                        margin: 0;
                        text-transform: uppercase;
                        letter-spacing: .8px;" class="active">
            <a data-toggle="tab" href="#video-tab">Videos</a>
        </li>
        <li style="
                        width: 33%;
                        display: block;
                        float: left;
                        text-align: center;
                        line-height: 48px;
                        height: 48px;
                        padding: 0;
                        margin: 0;
                        text-transform: uppercase;
                        letter-spacing: .8px;">
            <a data-toggle="tab" href="#pdf-tab">Pdfs</a>
        </li>
        <li style="
                        width: 33%;
                        display: block;
                        float: left;
                        text-align: center;
                        line-height: 48px;
                        height: 48px;
                        padding: 0;
                        margin: 0;
                        text-transform: uppercase;
                        letter-spacing: .8px;">
            <a data-toggle="tab" href="#img-tab">Images</a>
        </li>
    </ul>
    <div class="tab-content" >
        <?= $this->render('//user/profile/_profileContents',['model_videos'=>$model_videos,'model_pdf'=>$model_pdf,'model_img'=>$model_img])?>
    </div>
</div>