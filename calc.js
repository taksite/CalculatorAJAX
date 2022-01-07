function showError(message){

    $( "#result" ).html( "" );
	$( "#error" ).html( message );
}

function setResult(result){

	$( "#result" ).html( result );
	$( "#error" ).html("");
}

function isNumericField(id,success){
	
	var x = $("#"+id).val();
	if( $.isNumeric(x)){
		return success();
	}
	showError('Field: '+id+' must be a number');
	return false;
}

$(document).ready(function(){

    $("#multiply").click(
		function() {
			getResult("multiply");
		}	
	);

    $("#add").click(
		function() {
			getResult("add");
		}	
	);

    $("#sub").click(
		function() {
			getResult("sub");
		}	
	);

	$("#divide").click(
		function() {
			getResult("divide");
		}
		);

	function getResult (operator) {
		
		var x = document.getElementById("x").value;		
		var y = document.getElementById("y").value;

		isNumericField("x", function(){
			isNumericField("y",function(){
				  $.ajax({
					url: file + "/"+operator+"/" + x + "/" + y + "/" + token,
					  success: function(result){
						 setResult( result );
						 return result;
					  },
					  error: () => {
						showError ("Connection error!");
						return false;
					 }
					});
			  })
		  });
	};


});
