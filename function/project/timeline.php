<br><h2><span class="label label-danger">Biiểu đồ</span></h2><br><br>
<style>
	.date{
		top: 1cm;
		margin-left: -0.7cm;
		-ms-transform: rotate(90deg); /* IE 9 */
		-webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
		transform: rotate(90deg);
	}
</style>
<?php
	function getEarliestOrLatestDateIndex($date, $isLatest = false){
		$time = 0;
		
		if(!$isLatest){
			for($i = 1; $i < sizeof($date); $i++){
				if(calcDuration($date[$i],$date[$time]) > 0){
					$time = $i;
				}
			}		
		}else{
			for($i = 1; $i < sizeof($date); $i++){
				if(calcDuration($date[$i],$date[$time]) < 0)
					$time = $i;
			}		
		}
		return $time;
	}
	
	function calcDuration($ealiest, $latest){
		return (strtotime(reformatDate($latest)) - strtotime(reformatDate($ealiest)));
	}
	
	function calcFinish($left, $right){
		$now = time();
		if(strtotime(reformatDate($left)) - $now > 0){
			return 0;
		}
		
		if(strtotime(reformatDate($right)) - $now < 0){
			return 100;
		}
		
		$value = ($now - strtotime(reformatDate($left))) * 100 / (strtotime(reformatDate($right)) - strtotime(reformatDate($left)));
			return $value;
	}
	
	function getAllGlobalInfo($taskList){
		$startdate = array();
		$enddate = array();
		$name = array();
		$id = array();
		while($task = mysql_fetch_array($taskList)){			
			array_push($startdate, $task["startdate"]);
			array_push($enddate, $task["enddate"]);
			array_push($name, $task["name"]);
			array_push($id, $task["id"]);
		}

		$now = time();		
		$ealiest = getEarliestOrLatestDateIndex($startdate);
		$latest = getEarliestOrLatestDateIndex($enddate, true);
		$duration = calcDuration($startdate[$ealiest], $enddate[$latest]);
		return array($ealiest, $latest, $duration, $startdate, $enddate, $name, $id);
	}
############################################################
	echo'<div>';
	displayTimeLine($_GET["id"]);
	echo'</div><br>';
	
	if(isset($_GET["id"]) && $_GET["id"] != "" && is_numeric($_GET["id"])){
		$parent = getGlobalByID($_GET["id"]);
		$duration = calcDuration($parent["startdate"], $parent["enddate"]);

		$taskList = getGlobalBelongTo($_GET["id"]);
		if(mysql_num_rows($taskList) > 0)
			$info = getAllGlobalInfo($taskList);
		
		$width = 100;		
		
		echo '
	<div class="panel panel-info">
		  <div class="panel-heading">
				<h3 class="panel-title">Biểu đồ công việc</h3>
		  </div>
		  <div class="panel-body">
				<table class="table table-bordered" style="margin: 0cm auto; width: 95%;">';
				echo'
					<tr>
						<td style="width: 1cm;">'.$parent["id"].'
						<td>
							<div class="input-group" style="width: '.$width.'%">
								<div class="title" style="font-weight: bold; margin-left: 0%; font-size: 130%; color: red">'.$parent["name"].'</div>
								<div style="margin-left: 0%; width: 100%" title="'.$parent["name"].'"  data-toggle="popover" role="button" data-trigger="hover" data-placement="top" data-content="'.$parent["startdate"].' - '.$parent["enddate"].'">
									<div class="progress" style="margin-bottom: 0px">
										<div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '.round(calcFinish(($parent["startdate"]), ($parent["enddate"]))).'%"></div>
									</div>
								</div>
							</div>
						</td>
					</tr>';
				if(mysql_num_rows($taskList) > 0){	
					for($i = 0; $i < sizeof($info[3]); $i++){
						echo'
						<tr>
							<td style="width: 1cm;">'.$info[6][$i].'
							<td>
								<div class="input-group" style="width: '.$width.'%">
									<div class="title" style="font-weight: bold; margin-left: '.(calcDuration($info[3][$info[0]],$info[3][$i])*100/$duration).'%;"><a href="?action=timeline&cat=project&id='.$info[6][$i].'">'.$info[5][$i].'</a></div>
									<div style="margin-left: '.(calcDuration($info[3][$info[0]],$info[3][$i])*100/$duration).'%; width: '.(calcDuration($info[3][$i],$info[4][$i])*100/$duration).'%" data-toggle="popover" role="button" title="'.$info[5][$i].'"  data-trigger="hover" data-placement="top" data-content="'.$info[3][$i].' - '.$info[4][$i].'">
										<div class="progress" style="margin-bottom: 0px">
											<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '.round(calcFinish($info[3][$i],$info[4][$i])).'%"></div>
										</div>
									</div>
								</div>
							</td>
						</tr>';
					}
				}
					echo'
					<tr>
						<td>
						<td style="position: relative; height: 3cm;">';
						echo '<div class="date" style="color: blue; position: absolute; left: '.(calcDuration($parent["startdate"], $parent["startdate"])*$width/$duration).'%;">'.reformatDate($parent["startdate"]).'</div>';
						echo '<div class="date" style="color: blue; position: absolute; left: '.(calcDuration($parent["startdate"], $parent["enddate"])*$width/$duration).'%;">'.reformatDate($parent["enddate"]).'</div>';
						
				if(mysql_num_rows($taskList) > 0){
					for($i = 0; $i < sizeof($info[3]); $i++){
						echo '<div class="date" style="position: absolute; color: red; left: '.(calcDuration($info[3][$info[0]],$info[3][$i])*$width/$duration).'%;">'.reformatDate($info[3][$i]).'</div>';
						echo '<div class="date" style="position: absolute; color: blue;left: '.(calcDuration($info[3][$info[0]],$info[4][$i])*$width/$duration).'%;">'.reformatDate($info[4][$i]).'</div>';
					}
				}
		//			echo '<div class="date" style="color: red; position: absolute; left: '.(calcDuration($parent["startdate"],date('Y-m-d'))*100/$duration).'%;">'.date('d-m-Y').'</div>';

				echo '
				</table><br>
				<div class="description">
					<div><span style="width: 10px; background: red; color: red">hel</span> Ngày bắt đầu</div>
					<div><span style="width: 10px; background: blue; color: blue">hel</span> Ngày kết thúc</div>
				</div>
				<a href="?action=project&id='.$_GET["id"].'" class="btn btn-primary">Xem công việc</a>
			</div>
		</div>';
?>

		<?php include "function/project/comment.php";?>

<?php		
	}else{
		header("Location: index.php?action=project");
	}
?>