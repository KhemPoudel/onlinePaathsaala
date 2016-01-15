<?php $this->beginBlock('suggestion_block');?>
    <div class="card-panel bl-panel text-center hoverable" style="margin-right: -60%;margin-left: -5%;">
        <h3 class="black-text">Suggestions</h3>
        <hr>
        <ul class="nav nav-tabs tabs-5" style="
position: relative;
height: 48px;
background-color: #fff;
margin: 0 auto;
width: 100%;
white-space: nowrap;
border: none;
border-bottom: 1px solid #ddd;
padding-left: 0;
padding: 0
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
                <a data-toggle="tab" href="#home">Posts</a>
            </li>
            <li style="width: 33%;display: block;
float: left;
text-align: center;
line-height: 48px;
height: 48px;
padding: 0;
margin: 0;
text-transform: uppercase;
letter-spacing: .8px;
"><a data-toggle="tab" href="#menu4">Programs</a></li>
            <li style="width: 33%;display: block;
float: left;
text-align: center;
line-height: 48px;
height: 48px;
padding: 0;
margin: 0;
text-transform: uppercase;
letter-spacing: .8px;"><a data-toggle="tab" href="#menu5">Users</a></li>
        </ul>

        <div class="tab-content card-panel blue-grey lighten-5" >
            <div id="home" class="tab-pane fade in active">
                <br>
                <h5>HOME</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div id="menu4" class="tab-pane fade">
                <br>
                <h5>Menu 1</h5>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
            <div id="menu5" class="tab-pane fade">
                <br>
                <h5>Menu 2</h5>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
            </div>
            <div id="menu6" class="tab-pane fade">
                <br>
                <h5>Menu 3</h5>
                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
            <div id="menu7" class="tab-pane fade">
                <br>
                <h5>Menu 3</h5>
                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
        </div>
    </div>
<?php $this->endBlock();?>