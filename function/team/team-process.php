<?php
	$sendJoinOrInvitationRequest = NONE;
	if(checkAuthenticated() && !$handledPost && isset($_POST["sendJoinRequest"])){
		$sendJoinOrInvitationRequest = sendJoinOrInvitationRequest($_POST["team"], JOIN);
	}
?>