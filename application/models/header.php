<?php
$uri = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
$authUser_NameSpace = new Zend_Session_Namespace('Myblog_Auth');
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
                <li class="<?php if ($uri == '/') echo 'active'; ?>"><a href="/">Home</a></li>
                <?php if (isset($authUser_NameSpace->acl) && isset($authUser_NameSpace->user->role) && $authUser_NameSpace->acl->isAllowed($authUser_NameSpace->user->role, 'user', 'list')) { ?>
                    <li class="<?php if ($uri == '/bloggers') echo 'active'; ?>"><a href="/bloggers">Bloggers</a></li>
                <?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (!isset($authUser_NameSpace->user->id)) { ?>
                    <li class="<?php if ($uri == '/register') echo 'active'; ?>"><a href="/register">Register</a></li>
                    <li class="<?php if ($uri == '/login') echo 'active'; ?>"><a href="/login">Login</a></li>
                <?php } else { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome <?php echo $authUser_NameSpace->user->name; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/myprofile">Profile</a></li>
                            <li><a href="javascript:void(0);" id="logout">Log out</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>