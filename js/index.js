function index(){
    this.getDatosGrafica = function (){
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta página no existe");
                }
            },
            url: 'servidor.php',
            method: 'POST',
            data: {
                rq: "4"
            }
        }).done(function (datos) {
            if(datos != ''){
                let etiquetas = new Array();
                let tcantidad = new Array();
                var jDatos = JSON.parse(datos);
                
                var ctx = document.getElementById('idGrafica').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                      labels: etiquetas,
                      datasets: [{
                        label: '# of Votes',
                        data: tcantidad,
                        backgroundColor: coloresP
                      }
                    ]
                }
            });
            }
        });
    }
}