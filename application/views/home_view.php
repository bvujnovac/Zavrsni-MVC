<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 hidden" id="loader">
    <center>
        <img src="<?php echo base_url(); ?>assets/imgs/ajax-loader.gif">
    </center>
</div>

<nav class="navbar navbar-default visible-xs">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <button type="button" class="navbar-toggle user-info" data-toggle="collapse" data-target="#useInfo">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="useInfo">
            <ul class="nav navbar-nav">
                <li class="text-center">
                    <h2 class="small text-uppercase">Dobro došao</h2>
                    <img src="<?php echo base_url(); ?>assets/imgs/beni.JPG" alt="" width="70" height="70" style="border-radius:50px">
                    <div class="text-uppercase">Benjamin Vujnovac</div>
                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo base_url(); ?>home">Kontrolna ploča</a></li>
                <li> <a href="<?php echo base_url(); ?>profili">Profili</a> </li>
                <li><a href="<?php echo base_url(); ?>obavijesti">Obavijesti</a></li>
                <li><a href="<?php echo base_url(); ?>logout">Odjava</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 col-md-3 col-lg-2  sidenav hidden-xs clearfix" id="nav">

            <div data-spy="affix" data-offset-top="0" class="sidenav-container">
                <div class="row">
                    <div class="col-sm-12">
                        <p></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-5">
                        <img src="<?php echo base_url(); ?>assets/imgs/beni.JPG" alt="" width="70" height="70" style="border-radius:50px">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-7" style="margin-top:20px">
                        <div class="small">Dobro došao,</div>
                        <div class="text-uppercase">Benjamin Vujnovac</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="<?php echo base_url(); ?>home">Kontrolna ploča</a></li>
                            <li> <a href="<?php echo base_url(); ?>profili">Profili</a> </li>
                            <li><a href="<?php echo base_url(); ?>obavijesti">Obavijesti</a></li>
                            <li><a href="<?php echo base_url(); ?>odjava">Odjava</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <br>

        </div>
        <br>

        <div class="col-sm-9 col-md-9 col-lg-10" id="contemt-main">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" id="dashboard">
                    <span class="small text-uppercase text-muted">kontrolna ploča</span>
                    <h1>Sustav nadzora i ocjene kakvoće tla i uvjeta za uzgoj bilja</h1>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
                    <div class="row">
                        <div class='col-sm-12 form-inline datetimepickerwrapper'>
                            <div class="form-group">
                                <label>Od</label>
                                <div class='input-group date' id='datetimepicker6'>

                                    <input type='text' class="form-control" data-provide="datepicker"  />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Do</label>
                                <div class='input-group date' id='datetimepicker7'>

                                    <input type='text' class="form-control" data-provide="datepicker" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                                </div>
                            </div>
                            <script type="text/javascript">
                                var min_date = new Date("<?php echo $min ?>");
                                var max_date = new Date("<?php echo $max ?>");
                                var min_datetoshow = new Date(new Date(max_date).setDate(max_date.getDate()-1));
                                var min_datefinal = min_datetoshow.format("yyyy-mm-dd");
                                var max_datetoshow = new Date(new Date(max_date).setDate(max_date.getDate()+1));
                                var max_datefinal = max_datetoshow.format("yyyy-mm-dd");
                                var from_date = min_datefinal;
                                var to_date = max_datefinal;
                            </script>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="well">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">

                                <h5>Trenutna temperatura</h5>
                                <h3>23</h3>

                            </div>
                            <div class="col-md-12 col-lg-6">
                                <span id="temperature-realtime-chart-container">Ovdje će se crtat grafovi</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="well">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">

                                <h5>Trenutno osvjetljenje</h5>
                                <h3>70%</h3>
                            </div>

                            <div class="col-md-12 col-lg-6">
                                <span id="light-realtime-chart-container">Ovdje će se crtat grafovi</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="well">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">

                                <h5>Trenutna vlaga   </h5>
                                <h3>15%</h3>
                            </div>

                            <div class="col-md-12 col-lg-6">
                                <span id="moist-realtime-chart-container">Ovdje će se crtat grafovi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">


                    <div class="well">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">

                                <h5>Ph faktor   </h5>
                                <h3>neutralno</h3>
                            </div>

                            <div class="col-md-12 col-lg-6">
                                <span id="bounce-rate-chart-container">Ovdje će se crtat grafovi</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well"  id="sessions">
                        <h4>Temperatura</h4>
                        <p><span id="temperature-chart-container">Ovdje će se crtat grafovi</span></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well"  id="sessions">
                        <h4>Osvjetljenje</h4>
                        <p><span id="light-chart-container">Ovdje će se crtat grafovi</span></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well"  id="sessions">
                        <h4>Vlaga</h4>
                        <p><span id="moist-chart-container">Ovdje će se crtat grafovi</span></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well"  id="sessions">
                        <h4>Ph faktor</h4>
                        <p><span id="phvalue-chart-container">Ovdje će se crtat grafovi</span></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>