<nav class="white nav-fixed" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="/evoting/" class="brand-logo"><span class="rodab">E-VOTING</span>
            SYSTEM</a>
        <?php if(isset($_SESSION['isvoter'])) { ?>
        <ul class="right hide-on-med-and-down navbar-list-ul">

            <li><a href="/evoting/admin/logout.php">Logout</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
            <li><a href="/evoting/admin/logout.php">Logout</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">Menu</i></a>
        <?php }?>
    </div>
</nav>