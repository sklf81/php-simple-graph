<?php
		class Graph{
			public $title;
			public $data;
			public $x_axis_title;
			public $y_unit;
			public $x_lines = 10;
			public $y_lines = 16;
			public $data_render_amount;
		
			public function __construct($id, $title, $data, $y_unit){
				$this->title = $title;
				$this->data = empty($data) ? array("x" => array_fill(0, 100, 0), "y" => array_fill(0, 100, 42)) : $data;
				$this->y_unit = $y_unit;
				$this->id = $id;

				//Can be changed manually
				$this->data_render_amount = sizeof($this->data["y"]);
			}

			public function displayYLines($amount){
				for($i = 0; $i < $amount; $i++){
					$html_y_line = "
						<div class='graph_line_y' 
							style='margin-top: calc(var(--graph_margin) + ".$i." * var(--height_graph)/var(--y_lines));'>
						</div>
					";
					echo($html_y_line);
				}
			}

			public function displayXLines($amount){
				for($i = 0; $i < $amount; $i++){
					$html_x_line = "
						<div class='graph_line_x' 
							style='margin-left: calc(var(--graph_margin) +  ".$i." *var(--width_graph)/var(--x_lines));'>
						</div>
					";
					echo($html_x_line);
				}
			}


			public function displayGraphHTML($map_min_max){
				$data = $this->data;
				$max = max($data["y"]);
				$d_length = sizeof($data["y"]);
				$data_render_amount = $this->data_render_amount;

				if($map_min_max){
					$avg = array_sum($data["y"]) / count($data["y"]);
					$min = min($data["y"]) == $max ? 0 : min($data["y"]);
				}
				else{
					$min = 0;
				}

				$diff = $max - $min;
				$unit = $this->y_unit;
				
				$y_labels = array(number_format($min, 2, ",", "").$unit,
						  number_format($min + $diff/4, 2, ",", "").$unit,
						  number_format($min + $diff/2, 2, ",", "").$unit,
						  number_format($min + 3*$diff/4, 2, ",", "").$unit,
						  number_format($max, 2, ",", "").$unit);

				$graph_wrapper_upper = "
				<div class='graph_wrapper' id='".$this->id."_graph_wrapper'>
					<div class='graph_header'>
						<div class='graph_title' id='".$this->id."_graph_title' active='false'>
							".$this->title." 
						</div>
						<div class='bar_data' id='".$this->id."_bar_data'>
						</div>
					</div>"
				;

				$html_include_js = "
					<script src='/include/tools/js/graph_mouse.js'></script>
				";
			
				$html_labels = "
					<div class='axis_y'> ".$y_labels[4]." </div>
					<div class='axis_y'> ".$y_labels[3]." </div>
					<div class='axis_y'> ".$y_labels[2]." </div>
					<div class='axis_y'> ".$y_labels[1]." </div>
					<div class='graph_origin'> ".$y_labels[0]." </div>	
				";
				
				$html_graph_head = "
					<div class='graph' id='".$this->id."_graph'>
				";

				$graph_wrapper_footer = "
					</div>
					<div class='axis_title_x'>
						<p>".str_replace('"', '', $this->x_axis_title)."</p>
					</div>
				</div>
				";

				
				echo($html_include_js);
				echo($graph_wrapper_upper);
				$this->displayYLines($this->y_lines, "y");
				$this->displayXLines($this->x_lines, "x");
				echo($html_labels);
				echo($html_graph_head);

				for($i = 0; $i < $data_render_amount; $i++){
					if($i >= $data_render_amount){
							$y_data = 0;
							$x_data = 0;
					}
					else{
							$y_data = $data["y"][$i];
							$x_data = $data["x"][$i];
					}
					$percentage = 100*($y_data - $min)/$diff;
					$graph_bar = "
					<div class='graph_bar' id='".$this->id."_bar_".$i."' mouseover='false' 
						y_data='".$y_data.$unit."' 
						x_data='".$x_data."' 
						bar_data_id='".$this->id."_bar_data'
						style='
							grid-column: ".($i + 1)." / ".($i + 2).";
							height=".$percentage."%;
							margin-top: calc(".(1 - ($percentage / 100))." * var(--height_graph)'
						onmouseover='barOnMouseOver(this)'
						onmouseleave='barOnMouseLeave(this)'>
					</div>";

					echo($graph_bar);
				}

                echo($graph_wrapper_footer);
			}
		}
?>
