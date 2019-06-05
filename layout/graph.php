<div class="present">
		 <h2>Trend over tid</h2>       
		 <canvas id="chart" style="width: auto; height: auto; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
<!-- javascriptkode for å generere grafer  -->
			<script>
			  var ctx = document.getElementById("chart").getContext('2d');
  var myChart = new Chart(ctx, {
  type: 'line',
          fill: 'false',
  data: {
      labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
      datasets: 
      [{
          label: 'Klor',
          data: [<?php echo $klor; ?>],
          backgroundColor: 'transparent',
          borderColor:'#808000',
          borderWidth: 3
      },
     {
          label: 'DPD1',
          data: [<?php echo $dpd1; ?>],
          backgroundColor: 'transparent',
          borderColor:'#008000',
          borderWidth: 3
      },
     {
          label: 'DPD3',
          data: [<?php echo $dpd3; ?>],
                          backgroundColor: 'transparent',
          borderColor:'#7CFC00',
          borderWidth: 3	
      },

                  {
          label: 'DPD3-DPD1',
					data: [<?php echo $bundet_klor; ?>],
					 backgroundColor: 'transparent',
          borderColor:'#2E8B57',
          borderWidth: 3	
			},
			{
          label: 'phenol',
          data: [<?php echo $phenol; ?>],
                          backgroundColor: 'transparent',
          borderColor:'#DC143C',
          borderWidth: 3	
      },
      {
          label: 'ph',
          data: [<?php echo $ph; ?>],
          backgroundColor:  'transparent',
          borderColor:'#B22222',
          borderWidth: 3	
      }]
  },

  options: {
      scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
      tooltips:{mode: 'index'},
      legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
  }
});		
			</script>		
	</div>