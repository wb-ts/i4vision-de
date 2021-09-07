// googleslides v1.1 - jQuery Google Slides plugin
// (c) 2012 Brady Holt - www.geekytidbits.com
// License: http://www.opensource.org/licenses/mit-license.php



 function method(gallery_id, albumURI) {	
	 	$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		// with fetch
		//console.log(google_link);
		fetch('https://api-allorigins.herokuapp.com/get?url=' + albumURI)
		// fetch('https://photoslibrary.googleapis.com/v1/albums/' + albumURI)
		.then(response => {
			console.log(response);
			if (response.ok) return response.json()
			throw new Error('Network response was not ok.')
		})
		.then(json => {
			console.log(json);
			if (json.status.http_code == 200) {
				var htmlString = json.contents;
				var searchStr = 'src="https://lh3.googleusercontent.com';
				var count = htmlString.split(searchStr).length - 1;
				var number = 0;
				for (var j = 0; j < count; j++) {
					var startInt = htmlString.indexOf(searchStr);

					var metadata = htmlString.substring(startInt + 5, htmlString.indexOf('"', startInt + 10));
					htmlString = htmlString.replace(metadata, "redacted");
					
					var title = htmlString.substring(htmlString.indexOf('<title>') + 7, htmlString.indexOf(' - Google Photos</title>'));
					
					if (metadata.startsWith('https://lh3.googleusercontent.com/a/')) {
						continue;
					}

					metadata = metadata.substring(0, metadata.indexOf('=w')) + '=w1920-h1080-no';
					
					number ++;
					$.ajax({
			            type: 'POST',
									url: '/admin/sync_google_image',
			            dataType: 'text',
			            data: {
							"gallery_id": gallery_id,
							"url": metadata,
							"title": title,
							"number": number
				        },
			            success: function(data) {
			                
			            }
			        });
				}
			}

			location.href = "/admin/galleries/" + gallery_id + "/edit";
		});
}