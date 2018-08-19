<style>
.account-wall {
    margin-top: 20px;
    padding: 40px 0px 20px 0px;
    background-color: #f7f7f7;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    margin-bottom: 10%;
    padding-bottom: 15%;
}
.profile-img {
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}
.row {
    margin-top: 8%;
}
body {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 1.42857143;
    color: #333;
    background-color: #fff !important;
}
.login-title {
    color: #555;
    font-size: 18px;
    font-weight: 400;
    display: block;
}
.text-center {
    text-align: center;
}
div[style] {
   background-color: #fff !important;
}
</style>
<div class="container-fluid text-center">
  <div class="container">
<div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-lg-4 ">
            <h1 class="text-center login-title">Za nastavak je potrebna prijava</h1>
            <div class="account-wall">
                <img class="profile-img" src="<?php echo base_url(); ?>assets/imgs/not_loggedin.png"
                    alt="">
                <div class="form-group">
                <form method="post" class="form-signin">
                <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Prijava</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
