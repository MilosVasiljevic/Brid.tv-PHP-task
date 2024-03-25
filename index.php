<?php
	$json = file_get_contents('https://services.brid.tv/services/mrss/latest/1/0/1/25/0.json');
	$data = json_decode($json);

	$content ="<table class='table'>";
 	$content .="<tr><th>Naziv</th><th>Slika</th><th>Thumbnail</th><th>Trajanje</th><th>Datum</th>";

 	$length = count($data->Video);

 	for ($i = 0; $i < $length; $i++) {

	  	$content .="<tr class='";

	  	if ($data->Video[$i]->duration < 60) {
	  		$content .= "short tr";
	  	} else if ($data->Video[$i]->duration < 120) {
	  		$content .= "medium tr";
	  	} else {
	  		$content .= "long tr";
	  	}

	  	$content .="'> ";


	    $content .= "<td>" . $data->Video[$i]->name . "</td>";
	    $content .= "<td><img src= 'http://" . $data->Video[$i]->image  . " '></td>";
	    
	    $content .= "<td><img src= 'http://" . $data->Video[$i]->thumbnail   . " '></td>";
	    $content .= "<td data-duration='" . $data->Video[$i]->duration . "' >" . gmdate("i:s", $data->Video[$i]->duration) . "</td>";
	    $content .= "<td>" . $data->Video[$i]->publish . "</td>";

	   	$content .="<td><button class='hide-button'>Exclude</button></td></tr>";

	}

	$content .="</table>"



?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Miloš Vasiljević</title>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<style type="text/css">

	  	img , video {
	    	max-width: 100%;
		}

		.short  {
	    	background-color: #e7e9f3;
		}

		.medium  {
	    	background-color: #c7cce6;
		}

		.long  {
	    	background-color: #a2abde;
		}
		.checkbox {
			width: 34px;
    	}

    	.btn {
		    font-size: 20px;
		    margin-bottom: 10px;
		}

		#search {
		    font-size: 20px;
		    padding: 16px;
		    height: 50px;
		}

		th {
		    border: 0px!important;
		    font-size: 18px;
		}

		.container {
		    margin-top: 50px;
		}

		.red {
		    background-color: red;
		}

		.hidden {
		    display: none;
		}


  	</style>
</head>

<body>

<div class="container"> 

	<div class="row">

		<div class="col-md-3"> 
			<h3>Sortiraj po</h3>
			<div><button class="btn" onclick="naziv()"> Nazivu </button></div>
			<div><button class="btn" onclick="trajanje()"> Trajanju </button></div>
			<div><button class="btn" onclick="datum()"> Datumu objavljivanja </button></div>

			<h3>Prikaži samo klipove kraće od minut</h3>
			<input type="checkbox"  class="form-control checkbox" onchange="samoKratkiKlipovi()">

			<h3>Traži klipove po nazivu</h3>
			<input type="text"  class="form-control" onkeyup="traziPoNazivu()" id="search">

		</div>

		<div id="videos" class="col-md-9"> 

			<?php
				echo $content;
			?>

		</div>

	</div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

function naziv() {

	var contacts = $('.table');
	var cont = contacts.find('.tr');

	cont.detach().sort(function(a, b) {
	            var astts =  $(a).children(":first").text();
	            var bstts =  $(b).children(":first").text();
	            return (astts > bstts) ? (astts > bstts) ? 1 : 0 : -1;
	});

	contacts.append(cont);

}


function trajanje() {

	var contacts = $('.table');
	var cont = contacts.find('.tr');

	cont.detach().sort(function(a, b) {
	            var astts =  parseInt( $(a).children().eq(3).data("duration") ) ;
	            var bstts =  parseInt( $(b).children().eq(3).data("duration") ) ;
	            
	            return (astts > bstts) ? (astts > bstts) ? 1 : 0 : -1;
	});

	contacts.append(cont);

}


function datum() {

	var contacts = $('.table');
	var cont = contacts.find('.tr');

	cont.detach().sort(function(a, b) {
	            var astts =  $(a).children().eq(4).text();
	            var bstts =  $(b).children().eq(4).text();
	            console.log(astts);
	            return (astts > bstts) ? (astts > bstts) ? 1 : 0 : -1;
	 });

	contacts.append(cont);

}

function samoKratkiKlipovi()  {
	$(".medium , .long").toggle();
}

$(".hide-button").click(function() {
   $(this).parent().hide();
});


$('#videos').on('click', '.hide-button', function(){ 
	$(this).closest("tr").remove();
});



function traziPoNazivu() { 
 	var query = $("#search").val().toLowerCase();
 	var length = query.length;

 	if (length > 2) {
 		$(".tr").each(function(){

	    	var firstLeteers = $(this).children(":first").text().substring(0, length).toLowerCase();

	    	if (query != firstLeteers )  {
	    		$(this).addClass("hidden");
	    	} else {
	    		$(this).removeClass("hidden");
	    	}

	  	});
 	} else {
		   $("*").removeClass("hidden");
	}
 	
};


</script>

</body>
</html>