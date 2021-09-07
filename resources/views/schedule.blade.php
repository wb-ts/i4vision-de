@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/schedule.css')}}">
@if (array_key_exists("design", $data))
    <link rel="stylesheet" href="{{ asset('css') . '/' . $data['design'] . '.css' }}">
  @endif
@endpush

@section('content')




    <div style="padding: 10px;">
        <!-- Wrapper for slides -->
        <h1 class="schedule-title">Termine</h1>
        <div class="container-fluid  text-center" style="margin-top: 20px;">

            <div class="schedule-content row" cellspacing="10px" style="margin-left:0px; margin-right:0px  ">
              @foreach ($data['schedule_entries'] as $key=>$schedule)
                <div  class="schedule-border col-lg-6">
                  <div>
                      <img src="{{ asset('storage') . '/' . $data['images'][$schedule->id][0]->url }}" class="img-thumbnail @if (($schedule->count() == $loop->index + 1) && (($loop->index + 1) % 2 == 1) && (($loop->index + 1) % 4 == 1)) image-one-item  @elseif ((($schedule->count() == $loop->index + 2) && (($loop->index + 2) % 4 == 2)) || (($schedule->count() == $loop->index + 1) && (($loop->index + 1) % 4 == 2))) image-one-row  @else image-item @endif">
                  </div>
                  <div style="">
                      <strong>
                          <h3
                              style="font-weight: bold; padding-top: 5px; padding-bottom: 5px; margin: 0px;">
                              {{ __('schedule.' . date('l', strtotime($schedule->date))) }},
                              {{ date('d.m', strtotime($schedule->date)) }}
                              <br>
                              {{ __('schedule.time') }}: {{ $schedule->time }}
                          </h3>

                      </strong>
                  </div>
                  <div>
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
              @endforeach

          </div>
        </div>
    </div>
    <script>
    var number = 1;

    showSlider();
    //$(".slide-tr").hide();
    //$(".slide-number-" + number).show();

    function showSlider() {
        $(".slide-tr").hide();
        $(".slide-number-" + number).show();
        number++;

        if (!$(".slide-number-" + number).length) {
            number = 1;
        }

        setTimeout(function() {
            showSlider();
        }, 5000);
    }
    </script>
    @endsection