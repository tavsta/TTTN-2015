<?php
	function getComment($id){
		return mysql_query("SELECT account.name as name, account.id as memberid, global.name as globalname, comment.content as content FROM account, global, comment WHERE comment.globalid = '$id' AND comment.globalid = global.id AND comment.memberid = account.id");
	}
	
	if(isset($_POST["comment"]) && $_POST["comment"] != ""){
		mysql_query("INSERT INTO comment(globalid, memberid, content) VALUES('$_POST[id]', '".getUserIDFromCookie()."', '$_POST[comment]')");
	}
?>

<hr>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Bình luận</h3>
	</div>
	<div class="panel-body">
<?php
	$commentList = getComment($_GET["id"]);
	while($comment =  mysql_fetch_array($commentList)){
		echo'
		<div><a href="?action=profile&id='.$comment["memberid"].'"><strong>'.$comment["name"].'</strong></a>: <i>'.$comment['content'].'</i></div>
		';
	}
?>		
	</div>
	<div class="panel-footer">
		<form role="form" method="post">
			<input type="hidden" name="id" value="<?=$_GET["id"]?>"/>
			<div class="form-group">
				<textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
			</div>
			<button type="submit" class="btn btn-default">Gửi</button>
		</form>
	</div>
	
</div>

