// googleslides v1.1 - jQuery Google Slides plugin
// (c) 2012 Brady Holt - www.geekytidbits.com
// License: http://www.opensource.org/licenses/mit-license.php



function RetrieveGalleryLinks(gallery_id, google_link) {
	var albumURI = "https://photos.app.goo.gl/" + google_link;
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});	
	$.ajax({
		type: 'POST',
		url: '/admin/sync_google_image',
		dataType: 'text',
		data: {
			// '_token': $('meta[name="csrf-token"]').attr('content'),
			"gallery_id": gallery_id,
			"albumURI": albumURI
		},
		success: function (data) {
			return data;
		}
	})

}