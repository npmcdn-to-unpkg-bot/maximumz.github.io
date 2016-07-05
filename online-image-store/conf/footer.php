        <footer>
          <div class="container">
               <div class="col-md-2 footer-left">
                   <h6>Looking for something?</h6>
                    <ul class="nav navbar-nav">
                      <li><a href="../index.php">Home</a><span class="underline-color"></span></li>
                      <li><a href="../photos.php">Photos</a><span class="underline-color"></span></li>
                      <li><a href="../faqs.php">FAQs</a><span class="underline-color"></span></li>
                      <li><a href="../contact.php">Contact</a><span class="underline-color"></span></li>
                    </ul>
               </div>
                <div class="col-md-2 footer-left">
                    <ul class="social-list">
                        <li><img src="../img/Entypo_f32d(2)_64.png" alt="Instagram"></li>
                        <li><img src="../img/Entypo_f312(1)_64.png" alt="Pintrest"></li>
                        <li><img src="../img/Entypo_f309(0)_64.png" alt="Twitter"></li>
                    </ul>
               </div>
                <div class="col-md-4 text-center footer-center">
                    <img src="../img/logo.png" alt="MAXXI logo">
                    <span id="footer-line"></span>
               </div>
               <div class="col-md-2 text-center footer-right">
                    <h6>Profile</h6>
                    <img src="../img/Entypo_d83d(0)_128.png" alt="Profile">
               </div>
                <div class="col-md-2 text-right footer-right">
                    <h6 class="text-right">Account</h6>
                    <?php if($logged_in == true){
                    echo "
                    <ul class='nav navbar-nav'>
                      <li><a href='../account.php'>My Account</a><span class='underline-color'></span></li>
                      <li><a href='../account.php'>My Details</a><span class='underline-color'></span></li>
                      <li><a href='../account.php'>Credits: ".$userAccount['balance']."</a><span class='underline-color'></span></li>
                      <li><a href='../conf/logout.php'>Sign Out</a><span class='underline-color'></span></li>
                    </ul>";
                    }else{
                        echo "Looks like you need one!<br><a href='../login.php'>Sign up or Login</a>";
                    }
                    ?>
               </div>
               <div class="col-md-12 text-center">
                <p class="text-center">Maximized Potential Ltd
                    <br> We specialize in web development &amp; website design. We have a passion for using modern technology to reach those who need it most.
                    <br> Copyright <?php echo date("Y") ?>, all rights reserved.
                </p>
               </div>
           </div>
        </footer>