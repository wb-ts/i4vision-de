<?php 
include("inc/functions.php");
	
?>
<meta name="csrf-token" content="{{ csrf_token() }}" />

<script rel="stylesheet" src="../js/jquery-1.12.4.min.js"></script>
<script rel="stylesheet" src="../js/jquery.googleslides.js"></script>
<script>
<?php
	
	$galleries = dbselect("SELECT id,google_link FROM galleries"); 
	foreach($galleries as $gallery){
		$id = $gallery['id'];
		$google_link = $gallery['google_link'];
		echo "await RetrieveGalleryLinks('$id', '$google_link');
		";
	}

?>

</script>