<?php
    use App\Http\Controllers\PricesController;
    use \App\Http\Controllers\StopyController;
$dataPoints = array(
);
$dataPoints2 = array();
$data2 = json_decode((new PricesController)->in_category('Lublin','Rynek pierwotny(tranzakcja)')->content());
//echo $data2;
$data_rates = json_decode((new StopyController())->all());

foreach ($data_rates as $item){
    array_push($dataPoints2,array('label'=>$item->data,'y'=>$item->ref));
}
foreach ($data2 as $item) {
    array_push($dataPoints,array('label'=>((new StopyController)->kwartalToData($item->kwartal)),'y'=>$item->cena));
};

?>

<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title:{
                    text: "Simple Column Chart with Index Labels"
                },
                axisY:{
                    includeZero: true,
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC"

                },
                axisY2:{
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
                    indexLabelFontColor: "#5A5757",
                    indexLabelPlacement: "outside",
                    dataPoints: <?php echo json_encode($dataPoints);  ?>
                },{
                    type: "line", //change type to bar, line, area, pie, etc
                    //indexLabel: "{y}", //Shows y value on all Data Points
                    axisYType: "secondary",
                    indexLabelFontColor: "#5A5757",
                    indexLabelPlacement: "outside",
                    dataPoints: <?php echo json_encode($dataPoints2);  ?>
                }]
            });
            chart.render();

        }
    </script>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</div>
