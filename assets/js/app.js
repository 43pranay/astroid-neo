$( function() {
  $( "#EndDate" ).datepicker({
    format: "yyyy-mm-dd",
    autoclose: true
  });
  $( "#StartDate" ).datepicker({
    format: "yyyy-mm-dd",
    autoclose: true
  });
  $( "#submitDate" ).click(function(){
    var startDate = $( "#StartDate" ).val();
    var endDate = $( "#EndDate" ).val();
    if ( startDate == '' || endDate == '' ) {
      $( '.error_msg' ).html("date field required").fadeIn(300).fadeOut(5000);
    }else {
      $.ajax({
        url:base_url('get_data'),
        type:"POST",
        data:{startDate:startDate,endDate:endDate},
        dataType:"json",
        beforeSend: function() {$('.img_loader').show();},
        complete:function() {$('.img_loader').hide();},
        success:function(data){
          $('.fastest_astroid').html(parseFloat(data.fastest_astroid).toFixed(2)+" km/hr");
          $('.fastest_astroid_id').html(data.fastest_astroid_id);
          $('.closest_astroid').html(parseFloat(data.closest_astroid).toFixed(2));
          $('.closest_astroid_id').html(data.closest_astroid_id);
          $('.average_size').html(parseFloat(data.average_size).toFixed(2)+" km");
          LoadBarChart(data.alldates,data.astroidcount);
        }
      })
    }
  });
  LoadBarChart([],[])
  function LoadBarChart(alldates,astroidcount) {
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: alldates,
        datasets: [{
          label: '',
          data: astroidcount,
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
          maxBarThickness:50,
          minBarLength:20
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      },
    });
  }
} );
