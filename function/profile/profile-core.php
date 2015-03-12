<?php
	function generateCodeForSkill($memberid = null, $isReadOnly = false){
		$skills = Skill::findSkillOfMember($memberid);
		
		$checked = array(true => "checked", false => "");
		
		echo'
		<div class="row">';
		foreach($skills as $skill){
			$childs = $skill->getChild();
			echo'
			<div class="col-md-6">
				<div class="form-control" style="height: 5cm; overflow-y: scroll; overflow-x: auto">					
					<input type="checkbox" name="skill[]" value="'.$skill->getID().'" '.$checked[$skill->getIsOfMember()].'> '.$skill->getName().'<br>
					<div style="padding-left: 10%">';
						
						foreach($childs as $child){
							echo '<div class="form-control"><input type="checkbox" name="skill[]" value="'.$child->getID().'" '.$checked[$child->getIsOfMember()].'>'.$child->getName().'</div>';
						}
			
		echo'			
					</div>
				</div>
			</div>';
		}									
		echo'
		</div>';
	}
?>