$(document).ready(function(){
	$("a").map(function(a, b){if($(this).attr("href").indexOf("http") == -1) $(this).attr("href", window.location.origin + "/TTTN-2015/trunk" + $(this).attr("href"))});
	$("#member #key").keyup(function(){
		var key = $("#member #key").val();
		$("#searchResult .col-lg-6").css({"display": "none"});
		$("#searchResult .col-lg-6").map(function(a, b){
			if($(this).attr("firstname").indexOf(key) >= 0 || $(this).attr("lastname").indexOf(key) >= 0){
				$(this).css({"display": "block"});
			}
		});
	});
		
	$("#member #addMember").click(function(){
		var obj = $("#searchResult .col-lg-6:has(input:checked)");
		
		obj.map(function(){
			$("#joinedMemberList").append('<div class="col-lg-6" id="' + $(this).attr("id") + '" firstname="' + $(this).attr("firstname") +'" lastname="' + $(this).attr("lastname") +'">' + '<input type="hidden" name="member[' + $(this).attr("id") + ']" value="' + $(this).attr("id") + '" / >' + $(this).html() + '</div>');
		});

		obj.remove();
	});
	
	$("#member #removeMember").click(function(){
		var obj = $("#joinedMemberList .col-lg-6:has(input:checked)");
		
		obj.map(function(){
			$(this).children("input").remove();
			$("#searchResult").append('<div class="col-lg-6" id="' + $(this).attr("id") +'" firstname="' + $(this).attr("firstname") +'" lastname="' + $(this).attr("lastname") +'">' + $(this).html() + '</div>');
		});

		obj.remove();
	});
	
	$("#member #key-button").click(function(){
		$.post("http://localhost/tttnphp/suport-ajax/ajax.php",
		{
		  action: "searchmember",
		  key: $("#member #key").attr("value")
		},
		function(data,status){
			$("#member #searchResult").html(data);
		});
	});
	
	$("#joinrequest .accept-eject").click(function(){
		if($(this).has(".accept-join")){
			$.post("http://localhost/tttnphp/suport-ajax/ajax.php",
			{
			  action: "accept-eject",
			  key: $(this).parent().parent().attr("value"),
			  status: "ACCEPT-JOIN"
			},
			function(data,status){
					console.log(data);
			});			
		}else{
			if($(this).has(".eject-join")){
				$.post("http://localhost/tttnphp/suport-ajax/ajax.php",
				{
				  action: "accept-eject",
				  key: $(this).parent().parent().attr("value"),
				  status: "EJECT-JOIN"
				},
				function(data,status){
					console.log(data);
				});			
			}
		}
		$("#message").html(parseInt($("#message").html()) - 1)
		$(this).parent().parent().remove();			
	});
	
	$(".tab-content .next").click(function(){
		$(".tab-control span").eq($(".tab-control .label-success").size()).removeClass("label-info").addClass("label-success");
	});

	$(".tab-content .prev").click(function(){
		$(".tab-control span").eq($(".tab-control .label-success").size() - 1).removeClass("label-success").addClass("label-info");
	});

	$("input:radio").click(function(){
		$("#parent").attr("value", $(this).parent().parent().attr("id"));
	});
});

function checkMatchPassword(obj, value){
	$(obj).attr("value", value);
	$("input[name='password']").next().text("");
	$("input[name='repassword']").next().text("");
	if($("input[name='password']").attr("value") != $("input[name='repassword']").attr("value"))
		$(obj).next().text("Mật khẩu không trùng nhau");
}

//**************TRUNG****************
$(function () {
  $('[data-toggle="popover"]').popover()
})
$('#myStateButton').on('click', function () {
    $(this).button('complete') // button text will be "finished!"
  })
