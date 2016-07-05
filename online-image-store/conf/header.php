<header>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
              <li><a href="../index.php">Home</a><span class="underline-color"></span></li>
              <li><a href="../photos.php">Photos</a><span class="underline-color"></span></li>
              <li><a href="../faqs.php">FAQs</a><span class="underline-color"></span></li>
              <li><a href="../contact.php">Contact</a><span class="underline-color"></span></li>
          </ul>
          <a href="../index.php"><div id='header-logo'></div></a>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../account.php">Account</a><span class="underline-color"></span></li>
               <li><?php if($logged_in == true){echo "<a href='conf/logout.php'>Logout</a><span class='underline-color'></span>"; } else {echo "<a href='login.php'>Login/Sign up</a><span class='underline-color'></span>"; }  ?>
               </li>
               
<!--
               <li class="form-group search">
                   <input type="text" name="maxxi-search" class="form-control" placeholder="Search">
               </li>
-->
                <form class="navbar-form navbar-right">
                   <input type="text" name="maxxi-search" class="form-control maxxi-search" id="ls_query" placeholder="Search">
                </form>
            </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
</header>