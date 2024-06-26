<?php
require_once "include/header.php";
require_once "include/dbconn.php";
require_once "include/dashboard_info.php";

?>

<!-- Wrap -->
<div id="wrap">  
	<!-- Container -->
	<main id="container">
		
    <div class="main_content">
    
      <!--Content-->
      <div class="main_graph">
        
        <!--일별 접속자 현황-->
        <div class="line_charts">
          <canvas id="chart" style="height: 500px;"></canvas>
        </div>
        
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
        <script type="text/javascript">
          // 일별접속자 그래프 차트
          // PHP에서 가져온 데이터를 JavaScript로 전달
          var logs = <?php echo json_encode($logs); ?>;

          // 날짜와 접속인원 배열 생성
          var logTimes = logs.map(log => log.log_date);
          var totalLogins = logs.map(log => parseInt(log.total_logins));

          // 접속인원 데이터의 최대 값
          const maxLogins = Math.max(...totalLogins); 
          // 접속인원 최대값을 기준으로 간격 설정
          const stepSize = Math.ceil(maxLogins / 10); 

          // 일별 접속자 현황
          const chart1 = new Chart(
            document.getElementById('chart'),
            {
              plugins: [ChartDataLabels], // chartjs-plugin-datalabels 불러오기
              type: 'line', // 차트 타입 지정
              data: { // 차트 데이터
                labels: logTimes,
                datasets: [{
                  label: '방문수',
                  data: totalLogins,
                  borderWidth: 2,
                  tension: 0.4,
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { // y축 설정
                	y: {
                        ticks: {
                          stepSize: stepSize,
                          // ...
                          callback: function(value, index, values) {
                            if (value % stepSize === 0 || value === maxLogins) {
                              return value; // 접속인원이 설정된 간격 또는 최대값일 때만 라벨 표시
                            }
                            return ''; // 나머지 경우에는 라벨 표시 안 함
                          },
                        },
                      },
               },
                plugins: {
                  title: {
                  display: true,
                  text: '일별 접속자 현황',
                  color: '#000',
                  font: {
                    size: 18,
                    family: 'Pretendard',
                    weight: '600',
                    color:'#000'
                  },
                },
                legend: { // 범례 사용 안 함
                  display: true,
                  position: 'right',
                  labels: {
                    font: {
                      size: 12,
                      family: 'Pretendard',
                    },
                  }
                },
                tooltip: { // 기존 툴팁 사용 안 함
                  enabled: false
                },
                datalabels: { // datalables 플러그인 세팅
                  align: 'top', // 도넛 차트에서 툴팁이 잘리는 경우 사용
                  font: { // font 설정
                    weight: '700',
                    size: '13px',
                  },
                  color: '#000', // font color
                  },
                },
              },
            }
          );


        </script>    
      </div>
      <!--//Content-->
      
    </div>


	</main>
	<!--//Container-->  
</div>

  
</body>
</html>
