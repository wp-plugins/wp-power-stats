<div class="wrap">
	<div class="wp-log-page-icon icon32"></div>
	<h2><?php echo get_admin_page_title(); ?></h2>

	<!--<ul class="subsubsub">
		<li><a href="" class="current">Overview</a> |</li>
		<li><a href="">Visitors & Page Views</a> |</li>
		<li><a href="">Visitor Map</a> |</li>
		<li><a href="">Devices</a> |</li>
		<li><a href="">Browsers</a> |</li>
		<li><a href="">Operating Systems</a> |</li>
		<li><a href="">Posts</a> |</li>
		<li><a href="">Links</a> |</li>
		<li><a href="">Search Terms</a></li>
	</ul>

	<p class="help-link">
		<a href="">Help</a>
	</p>-->



	<div id="dashboard-widgets-wrap">

		<div id="dashboard-widgets" class="metabox-holder columns-2">
	
			
			<div class="postbox-container one-column">
			
				<div class="meta-box-sortables">
			
					<div class="">
						<div id="summary" class="postbox micro">
					
							<h3><span>Summary</span></h3>
						
							<div class="inside" id="dashboard_right_now">

                                <table class="summary">
                                    <thead>
                                        <tr><td></td><td class="value">Visitors</td><td class="value">Pageviews</td></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Today</td><td class="value"><?php echo $today_visits[0]; ?></td><td class="value"><?php echo $today_pageviews[0]; ?></td></tr>
                                        <tr><td>This Week</td><td class="value"><?php echo $this_week_visits[0]; ?></td><td class="value"><?php echo $this_week_pageviews[0]; ?></td></tr>
                                        <tr><td>This Month</td><td class="value"><?php echo $this_month_visits[0]; ?></td><td class="value"><?php echo $this_month_pageviews[0]; ?></td></tr>
                                    </tbody>
                                </table>
							    
								<div class="clear"></div>

							</div>
						</div>
					</div>
					
					<div class="">
						<div id="dashboard_incoming_links" class="postbox micro">
					
							<h3><span>Devices</span></h3>
						
							<div class="inside">
							
								<table class="table_devices">
									<tbody>
										<tr>
											<td class="desktop"><?php echo $desktop; ?><span>%</span><div>Desktop</div></td>
											<td class="tablet"><?php echo $tablet; ?><span>%</span><div>Tablet</div></td>
											<td class="mobile"><?php echo $mobile; ?><span>%</span><div>Mobile</div></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

				
				</div>
			</div>
			
			<div class="postbox-container two-columns last">
			
				<div class="meta-box-sortables">
			
					<div class="">
						<div id="visitors_page_views" class="postbox">
					
							<h3><span>Visitors & Page Views</span></h3>
						
							<div class="inside">

								<?php
									
									$data_array = "";
									
									$visits = array_reverse($visits);
									
                                    if (is_array($visits) && !empty($visits)) {

										foreach ($visits as $day) {
											if ($day['hits'] === null) $day['hits'] = 0;
											if ($day['pageviews'] === null) $day['pageviews'] = 0;
											$data_array .= "['".$day['date']."', ".$day['pageviews'].", ".$day['hits']."],";
										}

								?>

								<script type="text/javascript">
							      google.load("visualization", "1", {packages:["corechart"]});
							      google.setOnLoadCallback(drawChart);
							      function drawChart() {
							        var data = google.visualization.arrayToDataTable([
							          ['Year', 'Page Views', 'Visitors'],
							          <?php echo $data_array; ?>
							        ]);
							
							        var options = {
							          "title": '',
							          "backgroundColor": 'transparent',
							          "animation": {
										  "duration": 1000,
										  "easing": 'out',
									  },
									  "colors": ['#AAAAAA', '#21759B'],
									  "vAxis": {
										 "title": '',
										 "baselineColor": '#CCCCCC',
										 "textPosition": "in",
										 "textStyle": {
											 "bold":false,
											 "color": '#848484',
											 "fontSize": 9
										 }

									  },
									  "hAxis": {
										 "title": '',
										 "textStyle": {
										 	"color": '#777777'
										 },
										 "showTextEvery": '2'
									  },
									  "legend": {
										  "position": 'none',
									  },
									  "lineWidth": '2',
									  "pointSize": '0',
									  "focusTarget": 'category',
									  "chartArea": {"width": '94%', "height": '70%'}
							        };

							
							        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
							        chart.draw(data, options);
							      }
							      
							      
								  (function($) {
								  
								  	$(document).ready(function() {
								  		function debouncer(func, timeout) {
											var timeoutID, timeout = timeout || 200;
											return function() {
												var scope = this,
													args = arguments;
												clearTimeout(timeoutID);
												timeoutID = setTimeout(function() {
													func.apply(scope, Array.prototype.slice.call(args));
												}, timeout);
											}
										}
										$(window).resize(debouncer(function(e) {
											drawChart();drawMap();
										}));
									});
								  
								  })(jQuery);

							    </script>
							    
								<div id="chart_div" style="width: 100%; height: 245px;"></div>
							    
							    <?php } ?>
							    
							</div>
						</div>
					</div>
				
				</div>
				
			</div>
			
			<div class="clear"></div>
			
			
			
			<div class="postbox-container one-column">
			
				<div class="meta-box-sortables">
			
					<div class="">
						<div id="dashboard_incoming_links" class="postbox micro">
					
							<h3><span>Traffic Sources</span></h3>
						
							<div class="inside">
							
								<table class="table_sources">
									<tbody>
										<tr>
											<td class="source-search"><?php echo $search_engines; ?><span>%</span><div>Search Engines</div></td>
											<td class="source-links"><?php echo $links; ?><span>%</span><div>Links</div></td>
											<td class="source-direct"><?php echo $direct; ?><span>%</span><div>Direct</div></td>
										</tr>
									</tbody>
								</table>

							</div>
						</div>
					</div>
					
					<div class="">
						<div id="dashboard_incoming_links" class="postbox micro">
					
							<h3><span>Browsers</span></h3>
						
							<div class="inside">
								<table class="table_browsers">
									<tbody>
										<tr>
											<?php echo $browsers ?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="">
						<div id="dashboard_incoming_links" class="postbox micro">
					
							<h3><span>Operating Systems</span></h3>
						
							<div class="inside">
								<table class="table_os">
									<tbody>
										<tr>
											<?php echo $oss ?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				
				</div>
			</div>
			
			<div class="postbox-container two-columns last">
			
				<div class="meta-box-sortables">
			
					<div class="">
						<div id="dashboard_incoming_links" class="postbox double">
					
							<h3><span>Visitor Map</span></h3>
						
							<div class="inside">
							
								<?php
									
									$country_data_array;
									
									if (is_array($country_data)) {
										foreach ($country_data as $country) {
											$country_data_array .= "['".$country['name']."', ".$country['count']."],";
										}
									}

								?>

								<script type="text/javascript">
							       google.load('visualization', '1', {'packages': ['geochart']});
								   google.setOnLoadCallback(drawMap);
								
								    function drawMap() {
								      var data = google.visualization.arrayToDataTable([
								        ['Country', 'Popularity'],
								        <?php echo $country_data_array ?>
								      ]);
								
								      var options = {
										  backgroundColor: 'transparent',
									      dataMode: 'regions',
									      colors: ['#C5D8E0','#00618C']
								      };
								
								      var container = document.getElementById('map_canvas');
								      var geomap = new google.visualization.GeoChart(container);
								      geomap.draw(data, options);
								      
								  };

							    </script><div id="map_canvas" style=" height: 405px; width: 100%; text-align: center; margin: auto;"></div>

							</div>
						</div>
					</div>
				
				</div>
				
			</div>
			
			<div class="clear"></div>
			
			
			<div class="postbox-container one-column">
			
				<div class="meta-box-sortables">
			
					<div class="">
						<div id="dashboard_incoming_links" class="postbox">
					
							<h3><span>Top Posts</span></h3>
						
							<div class="inside">
							
								<table class="top-posts"><tbody>
								
								<?php $i=1; foreach ($top_posts as $post): ?>
								<tr><td class="order"><?php echo $i ?>.</td><td class="link"><a href=""><?php echo substr($post['title'], 0, 50) ?></a></td></tr>
								<?php $i++; endforeach; ?>
	
								</tbody></table>

							</div>
						</div>
					</div>

				
				</div>
			</div>
			
			<div class="postbox-container one-column">
			
				<div class="meta-box-sortables">
			
					<div class="">
						<div id="dashboard_incoming_links" class="postbox">
					
							<h3><span>Top Links</span></h3>
						
							<div class="inside">
							
								<table class="top-posts"><tbody>
								
								<?php $i=1; foreach ($top_links as $link): ?>
								<tr><td class="order"><?php echo $i ?>.</td><td class="link"><a href=""><?php echo substr($link['referer'], 0, 50) ?></a></td></tr>
								<?php $i++; endforeach; ?>
	
								</tbody></table>
	
							</div>
						</div>
					</div>

				
				</div>
			</div>
			
			<div class="postbox-container one-column">
			
				<div class="meta-box-sortables">
			
					<div class="">
						<div id="dashboard_incoming_links" class="postbox">
					
							<h3><span>Top Search Terms</span></h3>
						
							<div class="inside">
							
								<table class="top-posts"><tbody>
								
								<?php $i=1; foreach ($top_searches as $search): ?>
								<tr><td class="order"><?php echo $i ?>.</td><td class="link"><a href=""><?php echo substr($search['terms'], 0, 50) ?></a></td></tr>
								<?php $i++; endforeach; ?>
	
								</tbody></table>
	
							</div>
						</div>
					</div>
					
				
				</div>
			</div>
			
			<div class="clear"></div>
			
		</div>

	</div>

</div>
