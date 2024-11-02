<!-- Start footer -->
    <footer class="main-footer">
        <div class="top-part">
            <nav class="nav">
                <ul>
                    <li><a href="<?=ROOT?>">Home</a></li>
                    <li><a href="<?=ROOT?>/games">Games</a></li>
                    <li><a href="<?=ROOT?>/about">About us</a></li>
                    <li><a href="<?=ROOT?>/contact">Contact us</a></li>
                </ul>
            </nav>
            <form action="<?=ROOT?>/search" class="footer-div">
                <div class="form-group">
                    <input class="form-control" type="search" name="find" placeholder="Search for game">
                    <button class="btn btn-search bg-darkblue" type="submit">
                        Search
                    </button>
                </div>
            </form>
            <nav class="nav">
                <ul>
                    <li>
                        <a href="http://" target="_blank">
                            <i class="social icon-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="http://" target="_blank">
                            <i class="social icon-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="http://" target="_blank">
                            <i class="social icon-youtube"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="bottom-part">
            <span>Fiction Robot &copy all right reserved <?=date("Y");?>.</span>

            <?php if(!empty(user('name'))):?>
                    <?=('<span><a href=" '.ROOT.'/admin">Admin</a></span>');?>
                <?php else:?>
                    <?=('<span><a href=" '.ROOT.'/admin-login">Admin</a></span>');?>
            <?php endif;?>
        </div>
    </footer>
    <!-- End footer -->

    <?php message("only admin can access the admin page");?>

    <script src="<?=ROOT?>/assets/js/main.js"></script>
    <script src="<?=ROOT?>/assets/js/menu-popper.js?10"></script>
</body>
</html>