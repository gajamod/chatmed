


<h1>Estadisticas</h1>
<div id="pastelAreas" style="width: calc( 100% - 50px );">
	<!-- Plotly chart will be drawn inside this DIV -->
</div>
<div id="caldr" style=" width: calc( 100% - 50px );">
	<!-- Plotly chart will be drawn inside this DIV -->
</div>

 <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
  <!-- Numeric JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/numeric/1.2.6/numeric.min.js"></script>
    <script>
var data=[<?php echo $this->params['medicos'].",".$this->params['areas']; ?>];
	console.log(data);

var layout = {
  title: 'Cantidad de consultas',
  height: 500,
  
  annotations: [
    {
      font: {
        size: 20
      },
      showarrow: false,
      text: 'Medicos',
      x: 0.17,
      y: 0.5
    },
    {
      font: {
        size: 20
      },
      showarrow: false,
      text: 'Areas',
      x: 0.82,
      y: 0.5
    }
  ],
  showlegend: false,
  grid: {rows: 1, columns: 2}
};
Plotly.newPlot('pastelAreas', data, layout);

var xValue = ['Dr Gama', 'Dr Fran'];

var yValue = [4.9,4.5];

var trace1 = {
  x: xValue,
  y: yValue,
  type: 'bar',
  text: yValue.map(String),
  textposition: 'auto',
  hoverinfo: 'none',
  marker: {
    color: 'rgb(158,202,225)',
    opacity: 0.6,
    line: {
      color: 'rgb(8,48,107)',
      width: 1.5
    }
  }
};

var data = [trace1];

var layout = {
  title: 'Calificaciones por Medico',
  grid: {rows: 1, columns: 2}
};

Plotly.newPlot('caldr', data, layout);
  </script>