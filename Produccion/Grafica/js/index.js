function index(){
    this.ini = function (){
        console.log("Iniciando..");
        this.getDatosGrafica();
    }

    this.getDatosGrafica = function (){
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta página no existe");
                }
            },
            url: 'php/servidor.php',
            method: 'POST',
            data: {
                rq: "4"
            }
        }).done(function (datos) {
            console.log("Datos recibidos:", datos);

            if(datos != ''){
                let etiquetas = new Array();
                let tcantidad = new Array();
                let ColoresP = new Array();
                var jDatos = (typeof datos === 'object') ? datos : JSON.parse(datos);

                var tablaDatos = document.createElement('tabla');
                tablaDatos.classList.add('table','table-striped');
                var tr = document.createElement('tr');
                var th = document.createElement('th');
                th.innerText = "Mes";
                tr.appendChild(th);
                th = document.createElement('th');
                th.innerText = "cantidad";
                tr.appendChild(th);
                tablaDatos.appendChild(tr);

                for(let i in jDatos){
                    etiquetas.push(jDatos[i].fechaVenta);
                    tcantidad.push(jDatos[i].totalProduccion);
                    ColoresP.push("#36004D");

                    var tr = document.createElement('tr');
                    var td = document.createElement('td');
                    td.innerText = jDatos[i].fechaVenta;
                    tr.appendChild(td);

                    td = document.createElement('td');
                    td.innerText = parseInt(jDatos[i].totalProduccion).toLocaleString();
                    tr.appendChild(td);

                    tablaDatos.appendChild(tr);
                }

                var idCont = document.getElementById('idContTabla');
                idCont.appendChild(tablaDatos);
                
                var ctx = document.getElementById('idGrafica').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                      labels: etiquetas,
                      datasets: [{
                        label: 'Produccion',
                        data: tcantidad,
                        backgroundColor: ColoresP
                      }
                    ]
                }
            });
            }
        });
    }
}

var oIndex = new index();
setTimeout(function () { oIndex.ini(); }, 100);