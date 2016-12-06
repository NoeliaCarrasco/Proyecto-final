<div id="container3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script type="text/javascript">
$(function () {
    // Create the chart
    $('#container3').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
          type: 'category',
          title: {
              text: 'CATEGORIAS'
          }
        },
        yAxis: {
            title: {
                text: 'CANTIDAD EN LA TIENDA'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: ''
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
        },
        series: [{
            name: 'PRODUCTOS POR CATEGORIAS',
            colorByPoint: true,
            data: [<?php
                  include("./db_configuration.php");
                  $consulta="SELECT COUNT(*) AS SUMA, categorias.NOMBRE FROM productos, categorias WHERE productos.IDCATEGORIA = categorias.IDCATEGORIA GROUP BY categorias.NOMBRE;";
                  $result=$connection->query($consulta);
                  echo $connection->error;
                  while ($fila = $result->fetch_object()) {?>
                  {
                      name: "<?php echo $fila->NOMBRE; ?>",
                      y: <?php echo $fila->SUMA; ?>
                  },
                  <?php } ?>
                  ]
        }],
    });
});
</script>