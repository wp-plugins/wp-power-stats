<div class="wrap">

    <h2>Overview</h2>
    
    <div class="container">
        <div class="metabox-holder">
        
        
            <div class="one-third column">
                <div class="cell">
                    <div class="postbox-container">
                        <div class="postbox micro">
                            <h3>Summary</h3>
    
                            <div class="inside">
                            
                                <table class="summary">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td class="value">Visitors</td>
                                            <td class="value">Pageviews</td>
                                        </tr>
                                    </thead>
    
                                    <tbody>
                                        <tr>
                                            <td>Today</td>
                                            <td class="value"><?php echo $today_visits[0] ?></td>
                                            <td class="value"><?php echo $today_pageviews[0] ?></td>
                                        </tr>
    
                                        <tr>
                                            <td>This Week</td>
                                            <td class="value"><?php echo $this_week_visits[0] ?></td>
                                            <td class="value"><?php echo $this_week_pageviews[0] ?></td>
                                        </tr>
    
                                        <tr>
                                            <td>This Month</td>
                                            <td class="value"><?php echo $this_month_visits[0] ?></td>
                                            <td class="value"><?php echo $this_month_pageviews[0] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div><!-- inside -->
                        </div><!-- postbox -->
    
                        <div class="postbox micro">
                            <h3>Devices</h3>
    
                            <div class="inside">
                            
                                <table class="triple">
                                    <tbody>
                                        <tr>
                                            <td><img src="<?php echo plugins_url('wp-power-stats/images/desktop.png') ?>" alt="Desktop"></td>
                                            <td><img src="<?php echo plugins_url('wp-power-stats/images/tablet.png') ?>" alt="Tablet"></td>
                                            <td><img src="<?php echo plugins_url('wp-power-stats/images/mobile.png') ?>" alt="Mobile"></td>
                                        </tr>
                                        <tr>
                                            <td class="percent"><?php echo $desktop ?><span>%</span></td>
                                            <td class="percent"><?php echo $tablet ?><span>%</span></td>
                                            <td class="percent"><?php echo $mobile ?><span>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>Desktop</td>
                                            <td>Tablet</td>
                                            <td>Mobile</td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div><!-- inside -->
                        </div><!-- postbox -->
                    </div><!-- postbox-container -->
                </div><!-- cell -->
            </div><!-- one-third -->
    
            <div class="two-thirds column">
                <div class="cell">
    
    
        			<div class="postbox-container">
    					<div class="postbox double-height">
    						<h3><span>Visitors & Page Views</span></h3>
    					
    						<div class="inside">
    
    							<?php 
    							
    						    $data_array = "";
    							$visits = array_reverse($visits);
    							
                                if (is_array($visits) && !empty($visits)) : ?>
    
                                    <?php foreach ($visits as $day) {
        									if ($day['hits'] === null) $day['hits'] = 0;
        									if ($day['pageviews'] === null) $day['pageviews'] = 0;
        									$data_array .= "['".$day['date']."', ".$day['pageviews'].", ".$day['hits']."],";
                                          } ?>
    
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
        						          "animation": {"duration": 1000,"easing": 'out',},
        								  "colors": ['#AAAAAA', '#21759B'],
        								  "vAxis": {"title": '',"baselineColor": '#CCCCCC',"textPosition": "in","textStyle": {"bold":false,"color": '#848484',"fontSize": 9}},
        								  "hAxis": {"title": '',"textStyle": {"color": '#777777'},"showTextEvery": '2'},
        								  "legend": {"position": 'none',},
        								  "lineWidth": '2',
        								  "pointSize": '0',
        								  "focusTarget": 'category',
        								  "chartArea": {"width": '94%', "height": '70%'}
        						        };
        
        						
        						        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        						        chart.draw(data, options);
        						      }
        						      
        						      
        							  (function($) {$(document).ready(function() {
        							  	
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
        									
        									$(window).resize(debouncer(function(e) {drawChart();drawMap();}));
                                        
                                        });})(jQuery);
        
        						    </script>
        						    
        							<div id="chart_div" style="width: 100%; height: 260px;"></div>
    						    
    						    <?php endif ?>
    						    
    						</div><!-- inside -->
        				
        				</div><!-- postbox -->
        			</div><!-- postbox-container -->
                </div><!-- cell -->
            </div><!-- two-thirds -->
            
            
            <div class="one-third column">
                <div class="cell">
                    <div class="postbox-container">
    
                        <div class="postbox micro">
                            <h3>Traffic Source</h3>
                            <div class="inside">
                                <table class="triple">
                                    <tbody>
                                        <tr>
                                            <td><img src="<?php echo plugins_url('wp-power-stats/images/search.png') ?>" alt="Search Engine"></td>
                                            <td><img src="<?php echo plugins_url('wp-power-stats/images/link.png') ?>" alt="Link"></td>
                                            <td><img src="<?php echo plugins_url('wp-power-stats/images/direct.png') ?>" alt="Direct"></td>
                                        </tr>
                                        <tr>
                                            <td class="percent"><?php echo $search_engines ?><span>%</span></td>
                                            <td class="percent"><?php echo $links ?><span>%</span></td>
                                            <td class="percent"><?php echo $direct ?><span>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>Search Engine</td>
                                            <td>Links</td>
                                            <td>Direct</td>
                                        </tr>
                                    </tbody>
                                </table>        
                            </div><!-- inside -->
                        </div><!-- postbox -->
                        
                        <div class="postbox micro">
                            <h3>Browsers</h3>
                            <div class="inside dense">
                                <table class="triple">
                                    <tbody>
                                        <tr>
                                            <?php foreach ($browsers as $browser) : ?><td><img src="<?php echo plugins_url('wp-power-stats/images/'.$browser['image'].'.png') ?>" alt="<?php echo $browser['name'] ?>"></td><?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <?php foreach ($browsers as $browser) : ?><td class="percent"><?php echo $browser['percent'] ?><span>%</span></td><?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <?php foreach ($browsers as $browser) : ?><td><?php echo $browser['name'] ?></td><?php endforeach ?>
                                        </tr>
                                    </tbody>
                                </table>        
                            </div><!-- inside -->
                        </div><!-- postbox -->
                        
                        <div class="postbox micro">
                            <h3>Operating Systems</h3>
                            <div class="inside dense">
                                <table class="triple">
                                    <tbody>
                                        <tr>
                                            <?php foreach ($oss as $os) : ?><td><img src="<?php echo plugins_url('wp-power-stats/images/'.$os['image'].'.png') ?>" alt="<?php echo $os['name'] ?>"></td><?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <?php foreach ($oss as $os) : ?><td class="percent"><?php echo $os['percent'] ?><span>%</span></td><?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <?php foreach ($oss as $os) : ?><td><?php echo $os['name'] ?></td><?php endforeach ?>
                                        </tr>
                                    </tbody>
                                </table>        
                            </div><!-- inside -->
                        </div><!-- postbox -->
                        
                        
                    </div><!-- postbox-container -->
                </div><!-- cell -->
            </div><!-- one-third -->
            
            <div class="two-thirds column">
                <div class="cell">
    
    
        			<div class="postbox-container">
    					<div class="postbox triple-height">
    						<h3><span>Visitors & Page Views</span></h3>
    					
    						<div class="inside">
    
								<?php
									
								$country_data_array = "";
								
								if (is_array($country_data) && !empty($country_data)) {
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
    						    
    						</div><!-- inside -->
        				
        				</div><!-- postbox -->
        			</div><!-- postbox-container -->
                </div><!-- cell -->
            </div><!-- two-thirds -->
            
            <div class="one-third column">
                <div class="cell">
                    <div class="postbox-container">
    
                        <div class="postbox">
                            <h3>Top Posts</h3>
                            <div class="inside">
                                <table>
                                    <tbody>

                                        <?php $i=1; foreach ($top_posts as $post): ?>
        								<tr><td class="order"><?php echo $i ?>.</td><td class="link"><a href=""><?php echo substr($post['title'], 0, 50) ?></a></td></tr>
        								<?php $i++; endforeach; ?>

                                    </tbody>
                                </table>        
                            </div><!-- inside -->
                        </div><!-- postbox -->
                        
                    </div><!-- postbox-container -->
                </div><!-- cell -->
            </div><!-- one-third -->
            
            <div class="two-thirds column">
                <div class="cell">
                
                    <div class="half column">
                        <div class="cell">
                        
                			<div class="postbox-container">
            					<div class="postbox">
            						<h3><span>Top Links</span></h3>
            						<div class="inside">
                                        <table>
                                            <tbody>
                								<?php $i=1; foreach ($top_links as $link): ?>
                								<tr><td class="order"><?php echo $i ?>.</td><td class="link"><a href=""><?php echo substr($link['referer'], 0, 50) ?></a></td></tr>
                								<?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
            						</div><!-- inside -->
                				</div><!-- postbox -->
                            </div><!-- postbox-container -->
                            
                        </div><!-- cell -->
                    </div><!-- half -->
                    
                    <div class="half column last">
                        <div class="cell">
                
                            <div class="postbox-container">
            					<div class="postbox">
            						<h3><span>Top Search Terms</span></h3>
            						<div class="inside">
                                        <table>
                                            <tbody>
                								<?php $i=1; foreach ($top_links as $link): ?>
                								<tr><td class="order"><?php echo $i ?>.</td><td class="link"><a href=""><?php echo substr($link['referer'], 0, 50) ?></a></td></tr>
                								<?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
            						</div><!-- inside -->
                				</div><!-- postbox -->
                            </div><!-- postbox-container -->
                        </div><!-- cell -->
                    </div><!-- half -->
        			
                </div><!-- cell -->
            </div><!-- two-thirds -->
            
            <div class="clear"></div>
            
        </div><!-- metabox-holder -->
    </div><!-- container -->
    
</div><!-- wrap -->