<?php

use App\Http\Controllers\PricesController;
use \App\Http\Controllers\StopyController;

$miasto = $_GET['city'];
$category = $_GET['category'];
$from = $_GET['from'];
$to = $_GET['to'];

// http://localhost:8000/chart?city=Lublin&category=Rynek%20pierwotny(oferta)&from=2021-01-01&to=2024-01-01

$dataPoints = array();
$dataPoints2 = array();
$dataPrices = json_decode((new PricesController())->inCategoryBetween($miasto, $category, $from, $to)->content());
$dataRates = json_decode((new StopyController())->between($from, $to));


foreach ($dataPrices as $item) {
    array_push($dataPoints, array('x' => strtotime((new StopyController)->kwartalToData($item->kwartal)) * 1000, 'y' => $item->cena));
};
foreach ($dataRates as $item) {
    array_push($dataPoints2, array('x' => strtotime($item->data) * 1000, 'y' => $item->ref));
}

?>

<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: <?php echo "'" . $miasto . " - " . $category . "'" ?>
                },
                axisY: {
                    includeZero: true,
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC"

                },
                axisY2: {
                    title: "stop",
                    titleFontColor: "#C0504E",
                    lineColor: "#C0504E",
                    labelFontColor: "#C0504E",
                    tickColor: "#C0504E"
                }
                ,
                data: [{
                    type: "line", //change type to bar, line, area, pie, etc
                    //indexLabel: "{y}", //Shows y value on all Data Points
                    xValueType: "dateTime",
                    indexLabelFontColor: "#5A5757",
                    indexLabelPlacement: "outside",
                    dataPoints: <?php echo json_encode($dataPoints); ?>
                }, {
                    type: "line", //change type to bar, line, area, pie, etc
                    //indexLabel: "{y}", //Shows y value on all Data Points
                    axisYType: "secondary",
                    xValueType: "dateTime",
                    indexLabelFontColor: "#5A5757",
                    indexLabelPlacement: "outside",
                    dataPoints: <?php echo json_encode($dataPoints2) ?>
}]})
                                chart.render();

                                }
                                </script >
    <div id = "chartContainer" style = "height: 370px; width: 100%;" ></div >
    <script src = "https://cdn.canvasjs.com/canvasjs.min.js" ></script >
</div >
