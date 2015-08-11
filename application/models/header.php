<?php 
    $uri = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
?>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">My Blog</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="<?php if($uri == '/') echo 'active'; ?>"><a href="/">Home</a></li>
                <li class="<?php if($uri == '/bloggers') echo 'active'; ?>"><a href="/bloggers">Bloggers</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php if($uri == '/register') echo 'active'; ?>"><a href="/register">Register</a></li>
                <li class="<?php if($uri == '/login') echo 'active'; ?>"><a href="/login">Login</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>