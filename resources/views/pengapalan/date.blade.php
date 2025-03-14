<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>jQuery UI DatePicker</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<style>
		.ui-highlight .ui-state-default{
			background: green !important;
			border-color: green !important;
			color: white !important;
		}
	</style>
	<script type="text/javascript" language="javascript">		
		var dates = ['2025-03-05','2025-03-15','2025-03-25'];
		jQuery(function(){
			jQuery('#dater').datepicker({
				changeMonth : true,
				changeYear : true,
				beforeShowDay : function(date){
					var y = date.getFullYear().toString(); // get full year
					var m = (date.getMonth() + 1).toString(); // get month.
					var d = date.getDate().toString(); // get Day
					if(m.length == 1){ m = '0' + m; } // append zero(0) if single digit
					if(d.length == 1){ d = '0' + d; } // append zero(0) if single digit
					var currDate = y+'-'+m+'-'+d;
					if(dates.indexOf(currDate) >= 0){
						return [true, "ui-highlight"];	
					}else{
						return [true];
					}					
				}
			});
		})
	</script>
</head>
<body>
	<input type="text" id="dater"/>
</body>
</html>