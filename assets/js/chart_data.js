$(function () {
    $('#datetimepicker6').datetimepicker({
        format: 'YYYY-MM-DD',
        //minDate : min_date,
        useCurrent: false
    });
    $('#datetimepicker7').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false //Important! See issue #1075
    });
    $("#datetimepicker6").on("dp.change", function (e) {
        $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker7").on("dp.change", function (e) {
        $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    });
    $('#datetimepicker6').data("DateTimePicker").date(from_date);
    $('#datetimepicker7').data("DateTimePicker").date(to_date);

    $("#datetimepicker6").on("dp.change", function(e) {
        $("#loader").removeClass("hidden");
        from_date = e.date.format('YYYY-MM-DD');
        getDataTemerature();
    });

    $("#datetimepicker7").on("dp.change", function(e) {
        $("#loader").removeClass("hidden");
        to_date = e.date.format('YYYY-MM-DD');
        getDataTemerature();
    });
});
setTimeout(
    function()
    {
        getDataTemerature();
    }, 1000);


function getDataTemerature () {
    $.ajax({
        url: 'https://zavrsniradferit.tk/home/data',
        type: 'GET',
        data: "time_from=" + from_date + "&time_to=" + to_date,
        success : function(data) {
            chartData = data;
            var chartTemperatureProperties = {
                "caption": "Temperatura zraka °C",
                "xAxisName": "Vrijeme",
                "yAxisName": "Temperatura",
                "rotatevalues": "0",
                "lineThickness": "2",
                "paletteColors" : "#ff0000",
                "plotToolText": "<div><b>$label, <br/>Temperatura: $datavalue °C</b></div>",
                "theme": "zune"
            };
            var chartLightProperties = {
                "caption": "Osvjetljenje %",
                "xAxisName": "Vrijeme",
                "yAxisName": "Osvjetljenje",
                "rotatevalues": "0",
                "lineThickness": "2",
                "paletteColors" : "#ffb90a",
                "plotToolText": "<div><b>$label, <br/>Osvjetljenje: $datavalue %</b></div>",
                "theme": "zune"
            };
            var chartMoistProperties = {
                "caption": "Vlaga %",
                "xAxisName": "Vrijeme",
                "yAxisName": "Vlaga",
                "rotatevalues": "0",
                "lineThickness": "2",
                "paletteColors" : "#0075C2",
                "plotToolText": "<div><b>$label, <br/>Vlaga: $datavalue %</b></div>",
                "theme": "zune"
            };
            var chartPhvalueProperties = {
                "caption": "Ph faktor",
                "xAxisName": "Vrijeme",
                "yAxisName": "Ph faktor",
                "rotatevalues": "0",
                "lineThickness": "2",
                "paletteColors" : "#c20671",
                "plotToolText": "<div><b>$label, <br/>Ph faktor: $datavalue %</b></div>",
                "theme": "zune"
            };
            apiTempChart = new FusionCharts({
                type: 'line',
                renderAt: 'temperature-chart-container',
                width: '100%',
                height: '250',
                dataFormat: 'json',
                dataSource: {
                    "chart": chartTemperatureProperties,
                    "data": temperature
                }
            });
            apiLightChart = new FusionCharts({
                type: 'line',
                renderAt: 'light-chart-container',
                width: '100%',
                height: '250',
                dataFormat: 'json',
                dataSource: {
                    "chart": chartLightProperties,
                    "data": light
                }
            });
            apiMoistChart = new FusionCharts({
                type: 'line',
                renderAt: 'moist-chart-container',
                width: '100%',
                height: '250',
                dataFormat: 'json',
                dataSource: {
                    "chart": chartMoistProperties,
                    "data": moist
                }
            });
            apiPhvalueChart = new FusionCharts({
                type: 'line',
                renderAt: 'phvalue-chart-container',
                width: '100%',
                height: '250',
                dataFormat: 'json',
                dataSource: {
                    "chart": chartPhvalueProperties,
                    "data": phvalue
                }
            });
            apiTempChart.render();
            apiLightChart.render();
            apiMoistChart.render();
            apiPhvalueChart.render();
        }
    });
    setTimeout(
        function()
        {
            sidenavHeight();
            $("#loader").addClass("hidden");
        }, 1000);
}
