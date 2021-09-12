@extends('layouts.app')


@push('styles')
  <link rel="stylesheet" href="{{ asset('css/pages/flow.css')}}">
  @if (array_key_exists("design", $data))
    <link rel="stylesheet" href="{{ asset('css') . '/' . $data['design'] . '.css' }}">
  @endif
@endpush
@section('content')

  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="1000">
    <!-- Wrapper for slides -->
	  <!-- <h3 class="google-image-title">Erstkommunion am 04.Juli 9:30 Uhr (Fotos: Annette Göring)</h3> -->
	  <h3 id="flow_title" style="text-align: center; font-weight: bold;"></h3>
    <div class="carousel-inner" role="listbox">
    @foreach ($data as $each_data)
    @if (gettype($each_data) != 'string' )

      @if (array_key_exists('google_images', $each_data))
        @foreach ($each_data['google_images'] as $key=>$google_images)
          @foreach ($google_images as $google_image)
            <div style="padding: 20px; height: 87vh; padding-bottom: 0px;" class="item google-image-item" data-time="5" data-title="{{ $each_data['title']['google_images'][$key] }}">
			  <!--<h3 class="google-image-title">{{ $each_data['title']['google_images'][$key] }}</h3>-->
              <img src="{{ $google_image->url }}" class="google-image" style="min-height: 100%;">
            </div>
          @endforeach
        @endforeach
      @endif

      @if (array_key_exists('sites', $each_data))
        @foreach ($each_data['sites'] as $key=>$site)
          <div style="padding: 20px; @if (!(array_key_exists('title', $each_data) && $each_data['title'] == 'off')) height: 90vh; @else height: 100vh; @endif" class="item" data-time="{{ $each_data['time']['sites'][$key] }}" data-title="{{ $site->description }}">
              <!-- <div> -->
                <iframe class="site-iframe" src="{{ $site->url }}"></iframe>
            <!-- </div> -->
          </div>
        @endforeach
      @endif
      @if (array_key_exists('images', $each_data))
        @foreach ($each_data['images'] as $key=>$image)
          <div style="padding: 20px; @if (!(array_key_exists('title', $each_data) && $each_data['title'] == 'off')) height: 90vh; @else height: 100vh; @endif" class="item" data-time="{{ $each_data['time']['images'][$key] }}"  data-title="{{ $image->description }}">
              <!-- <div> -->
              <img class="img-thumbnail" src="{{ asset('storage') . '/' . $image->url }}">
            <!-- </div> -->
          </div>
        @endforeach
      @endif
      @if (array_key_exists('schedule_entries', $each_data))
        @foreach ($each_data['schedule_entries'] as $key=>$schedules)
          @for ($i = 1; $i <= ceil($schedules->count() / 4); $i ++)
            <div class="item" data-time="{{ $each_data['time']['schedule_entries'][$key] }}">
                <!-- <div> -->
                  <div class="" style="padding: 10px;">
                    <!-- Wrapper for slides -->
                    <h1 class="schedule-title">Termine</h1>

                    <div class="text-center" style="margin-top: 10px; width: 100%; border: 0px;">

                      <div class="schedule-content container row" cellspacing="10px">
                          @foreach ($schedules as $key_s=>$schedule)
                            @if ( $loop->index < (($i * 4) - 4) || $loop->index + 1 > ($i * 4)   )
                              @continue
                            @endif
                            @if (date('Y.m.d' , strtotime(date($schedule->date))) < date('Y.m.d'))
                              @continue
                            @endif
                            @if (($loop->index + 2) % 2 == 0)
                              <div class="slide-tr slide-number-{{ ceil(($loop->index + 1) / 4) }} @if (($schedules->count() == $loop->index + 1) && (($loop->index + 1) % 2 == 1) && (($loop->index + 1) % 4 == 1)) one-row @elseif ((($schedules->count() == $loop->index + 2) && (($loop->index + 2) % 4 == 2)) || (($schedules->count() == $loop->index + 1) && (($loop->index + 1) % 4 == 2))) one-row @else two-row @endif">
                            @endif
                                <div class="schedule-border col-lg-6 col-md-6 @if (($loop->index + 2) % 2 == 0) left-background-color @else right-background-color @endif">
                                  <div>
									  @if ($each_data['schedule']['images'][$schedule->image_id])
                                    <img class="img-thumbnail @if (($schedules->count() == $loop->index + 1) && (($loop->index + 1) % 2 == 1) && (($loop->index + 1) % 4 == 1)) image-one-item image-one-row @elseif ((($schedules->count() == $loop->index + 2) && (($loop->index + 2) % 4 == 2)) || (($schedules->count() == $loop->index + 1) && (($loop->index + 1) % 4 == 2))) image-one-row @else schedule-image @endif" src="{{ asset('storage') . '/' . $each_data['schedule']['images'][$schedule->image_id]->url }}">@endif
                                  </div>
									
                                  <div style="">
                                    <strong>
                                      <h3 style="font-weight: bold; padding-top: 5px; padding-bottom: 5px; margin: 0px;">
                            {{ __('schedule.' . date('l', strtotime($schedule->date))) }}, {{ date('d.m', strtotime($schedule->date)) }}
                            <br>
                            {{ __('schedule.time') }}: {{ $schedule->time }}
                            </h3>

                                    </strong>
                                  </div>
                                  <div style="height:84px">
                                    <strong>
                                      <div>
                              {{ $schedule->line1 }}
                            </div>
                            <div>
                                        {{ $schedule->line2 }}
                            </div>
                            <div>
                                        {{ $schedule->line3 }}
                            </div>
                                    </strong>
                                  </div>
                                </div>
                            @if (($loop->index + 2) % 2 != 0)
                              </div>
                            @endif
                          @endforeach

                        </div>
                    </div>
                  </div>
               </div>
            </div>

          @endfor
        @endforeach
      @endif

    @endif
    @endforeach
    </div>
    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev" style="background-image: none;">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next" style="background-image: none;">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <script>

    var items = $("#myCarousel").find(".item");

    items.each(function(index){
      if (index == 0) {
        $(items[index]).addClass("active");
      }
    });

    //
    //   var items = $(this).find(".item.active").data('time');
    //   console.log(index.toElement);

    // });
    var totalItems = $('.item').length;
    var index = $('div.active').index() + 1;


    var time = 5000;

    if ($($(".item")[0]).data('time')) {
      time = $($(".item")[0]).data('time') * 1000;
    }

	if ($($(".item")[0]).data('title')) {
      $("#flow_title").html($($(".item")[0]).data('title'));
    } else {
	  $("#flow_title").html('');
	}

    $('#myCarousel').carousel({
      //pause: false,
      interval: time
    });


    $('#myCarousel').on('slide.bs.carousel', function(event) {
      var c = $('#myCarousel');

	  if (event.direction == "left") {
	  	index = $('div.active').index() + 1;
	  } else {
	  	index = $('div.active').index() - 1;
	  }

      if (index == totalItems) {
        index = 0;
      }

	  if (index < 0) {
		  index = totalItems - 1;
	  }

	  if ($($(".item")[index]).data('title')) {
		  $("#flow_title").html($($(".item")[index]).data('title'));
		} else {
		  $("#flow_title").html('');
		}
      if ($($(".item")[index]).data('time')) {
        time = $($(".item")[index]).data('time') * 1000;
      }

      opt = c.data()['bs.carousel'].options;
      opt.interval= time;
      c.data({options: opt});
      time = $($(".item")[0]).data('time') * 1000;
    });

	var one_row_height = window.innerHeight - 350;
	var schedule_row_height = window.innerHeight - 650;
    $(".schedule-image").css("max-height", schedule_row_height + "px");
	$(".image-one-row").css("max-height", one_row_height + "px");
  </script>
@endsection