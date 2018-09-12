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
                <li><a href="<?php echo base_url(); ?>obavijesti">Ocjena i obavijesti</a></li>
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
                            <li class="active"><a href="<?php echo base_url(); ?>home">Kontrolna ploča</a></li>
                            <li> <a href="<?php echo base_url(); ?>profili">Profili</a> </li>
                            <li><a href="<?php echo base_url(); ?>obavijesti">Ocjena i obavijesti</a></li>
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
                  <h5>Odabir profila za prikaz</h5>
                  <form action="/home" method="POST">
                      <select class="form-control" name="profileselect" id="profileselect" onchange="this.form.submit()">
                          <?php if(isset($id) && isset($id_default)){
                            $nmbrof = count($id);
                            echo '<option' . " " . 'value=' . "$id_default[0]" . '>' . $id_default[0] . '</option>';
                            for ($i=0; $i < $nmbrof; $i++) {
                              echo '<option' . " " . 'value=' . "$id[$i]" . '>' . $id[$i] . '</option>';
                            }
                          } ?>
                      </select>
                  </form>
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
                                function foo() {
                                  getDataTemerature();
                                  setTimeout(foo, 10000);
                                }
                                //foo();
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

                          <div id="temp-container"></div>
                          <script>

                          const tempSource = {
                            "chart": {
                              "caption": "Temperatura zraka",
                              "subcaption": "(Trenutna)",
                              "lowerlimit": "0",
                              "upperlimit": "40",
                              "numbersuffix": "°C",
                              "thmfillcolor": "#008ee4",
                              "showgaugeborder": "1",
                              "gaugebordercolor": "#008ee4",
                              "gaugeborderthickness": "2",
                              "plottooltext": "Temperature: <b>$datavalue</b> ",
                              "theme": "zune",
                              "showvalue": "1"
                            },
                            "value": "<?php echo $temp ?>"
                          };

                          FusionCharts.ready(function() {
                            var myChart = new FusionCharts({
                              type: "thermometer",
                              renderAt: "temp-container",
                              width: "100%",
                              height: "200%",
                              dataFormat: "json",
                              dataSource: tempSource
                            }).render();
                          });
                          </script>

                        </div>
                    </div>

                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="well">
                        <div class="row">
                          <div id="light-container"></div>
                          <script>
                          FusionCharts.ready(function() {
                            var myChart = new FusionCharts({
                              type: "angulargauge",
                              renderAt: "light-container",
                              width: "100%",
                              height: "200%",
                              dataFormat: "json",
                              dataSource: {
                                chart: {
                                  caption: "Trenutno osvjetljenje(%)",
                                  lowerlimit: "0",
                                  upperlimit: "100",
                                  showvalue: "1",
                                  numbersuffix: "%",
                                  theme: "zune",
                                  showtooltip: "0"
                                },
                                colorrange: {
                                  color: [
                                    {
                                      minvalue: "0",
                                      maxvalue: "50",
                                      code: "#F2726F"
                                    },
                                    {
                                      minvalue: "50",
                                      maxvalue: "75",
                                      code: "#FFC533"
                                    },
                                    {
                                      minvalue: "75",
                                      maxvalue: "100",
                                      code: "#62B58F"
                                    }
                                  ]
                                },
                                dials: {
                                  dial: [
                                    {
                                      value: "<?php echo $light ?>"
                                    }
                                  ]
                                }
                              }
                            }).render();
                          });
                          </script>

                        </div>

                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="well">
                        <div class="row">
                          <div id="moist-container"></div>
                          <script>
                          FusionCharts.ready(function() {
                            var myChart = new FusionCharts({
                              type: "cylinder",
                              renderAt: "moist-container",
                              width: "100%",
                              height: "200%",
                              dataFormat: "json",
                              dataSource: {
                                chart: {
                                  caption: "Vlaga tla (%)",
                                  lowerlimit: "0",
                                  upperlimit: "50",
                                  lowerlimitdisplay: "Niska",
                                  upperlimitdisplay: "Visoka",
                                  numbersuffix: " %",
                                  cylfillcolor: "#5D62B5",
                                  plottooltext: "Trenutna vlaga: <b><?php echo $moist ?>%</b>",
                                  cylfillhoveralpha: "85",
                                  theme: "zune"
                                },
                                value: "<?php echo $moist ?>"
                              }
                            }).render();
                          });

                          </script>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="well">
                        <div class="row">
                          <div id="ph-container"></div>
                          <script>
                          const phSource = {
                            "chart": {
                              "caption": "Ph vrijednost tla",
                              "theme": "zune",
                              "showvalue": "1",
                              "pointerbghovercolor": "#ffffff",
                              "pointerbghoveralpha": "80",
                              "pointerhoverradius": "12",
                              "showborderonhover": "1",
                              "pointerborderhovercolor": "#333333",
                              "pointerborderhoverthickness": "2",
                              "showtickmarks": "0",
                              "numbersuffix": " "
                            },
                            "colorrange": {
                              "color": [
                                {
                                  "minvalue": "4",
                                  "maxvalue": "5",
                                  "label": "nagrizajuće kiselo",
                                  "code": "#e44a00"
                                },
                                {
                                  "minvalue": "5",
                                  "maxvalue": "6",
                                  "label": "kiselo",
                                  "code": "#f8bd19"
                                },
                                {
                                  "minvalue": "6",
                                  "maxvalue": "7",
                                  "label": "neutralno",
                                  "code": "#6baa01"
                                }
                              ]
                            },
                            "pointers": {
                              "pointer": [
                                {
                                  "value": "<?php echo $phvalue ?>",
                                  "tooltext": "Ph vrijednost tla  "
                                }
                              ]
                            }
                          };

                          FusionCharts.ready(function() {
                            var myChart = new FusionCharts({
                              type: "hlineargauge",
                              renderAt: "ph-container",
                              width: "100%",
                              height: "200%",
                              dataFormat: "json",
                              dataSource: phSource
                            }).render();
                          });
                          </script>

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
