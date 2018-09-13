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
                <li><a href="<?php echo base_url(); ?>home">Kontrolna ploča</a></li>
                <li class="active"> <a href="<?php echo base_url(); ?>profili">Profili</a> </li>
                <li><a href="<?php echo base_url(); ?>obavijesti">Ocjena uvjeta</a></li>
                <li><a href="<?php echo base_url(); ?>odjava">Odjava</a></li>
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
                            <li><a href="<?php echo base_url(); ?>home">Kontrolna ploča</a></li>
                            <li class="active"> <a href="<?php echo base_url(); ?>profili">Profili</a> </li>
                            <li><a href="<?php echo base_url(); ?>obavijesti">Ocjena uvjeta</a></li>
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

                                    <input type='text' class="form-control" data-provide="datepicker" disabled="true"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Do</label>
                                <div class='input-group date' id='datetimepicker7'>

                                    <input type='text' class="form-control" data-provide="datepicker" disabled="true"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                                </div>
                            </div>
                            <script type="text/javascript">
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
                <div class="col-sm-12">
                    <div class="well"  id="sessions">
                      <div class="table-responsive">
                        <h4>Postojeći profili</h4>
                        <?php echo $tables; ?>
                        <p><span> </span></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="well"  id="sessions">
                      <h4>Obriši postojeći profil.</h4>
                      <form action="/profili" method="POST">
                          <select class="form-control" name="profiledelete" id="profiledelete">
                              <?php if(isset($id) && isset($id_default)){
                                $nmbrof = count($id);
                                echo '<option' . " " . 'value=' . "$id_default[0]" . '>' . $id_default[0] . '</option>';
                                for ($i=0; $i < $nmbrof; $i++) {
                                  echo '<option' . " " . 'value=' . "$id[$i]" . '>' . $id[$i] . '</option>';
                                }
                              } ?>
                          </select>
                          <button type="submit" class="btn btn-primary">Obriši</button>
                      </form>
                      <?php if(isset($notify)){
                        echo '<p><span>' . $notify . '</span></p>';
                      } ?>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well"  id="sessions">
                        <h4>Dodaj novi profil</h4>
                        <form action="/profili/add" method="get">
                          <div class="form-group">
                            <div class="col">
                              <label for="profilename">Ime profila</label>
                              <input type="text" class="form-control" name="profilename" id="profilename" placeholder="Ime profila, jedna riječ.">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col">
                              <label for="temperatureopt">Temperatura</label>
                              <input type="number" class="form-control" name="temperatureopt" id="temperatureopt" placeholder="Optimum za razvoj biljke">
                            </div>
                            <div class="col">
                              <input type="number" class="form-control" name="temperaturemax" id="temperaturemax" placeholder="Maximum">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col">
                              <label for="lighthours">Osvjetljenje</label>
                              <input type="number" class="form-control" name="lighthours" id="lighthours" placeholder="Broj sati dnevnog svijetla potrebnog biljci">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col">
                              <label for="moisture">Vlaga tla</label>
                              <input type="number" class="form-control" name="moisture" id="moisture" placeholder="Optimalna vlaga tla izražena u postotku.">
                            </div>
                          </div
                          <div class="form-group">
                            <div class="col">
                              <label for="phvaluemin">Ph vrijednost</label>
                              <input type="number" class="form-control" name="phvaluemin" id="phvaluemin" placeholder="Minimum">
                            </div>
                            <div class="col">
                              <input type="number" class="form-control" name="phvaluemax" id="phvaluemax" placeholder="Maximum">
                            </div>
                            <button type="submit" class="btn btn-primary">Spremi</button>
                          </form>
                          <p><span>Nakon spremanja dodati će se novi profil.</span></p>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
