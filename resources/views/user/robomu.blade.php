@extends('layout.user')

@push('header')
    <style>
        .RangeSlider_ParticipantName {
            padding-bottom: 20px;
            display: block;
        }

        .RangeSlider {}

        .RangeSlider_ClickArea {
            position: relative;
            padding: 20px 0 15px 0;
            margin-top: -20px;
            outline: 1px dashed #fff;
            /* to show clickarea */
            user-select: none;
        }

        .RangeSlider_ParticipantName {
            font-size: 24px;
            color: #000000;
            text-align: center;
            height: 49px;
            line-height: 49px;
            width: 100%;
            /* white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis; */
        }

        .RangeSlider_Track {
            border: 1px solid #5e5e5e;
            background-color: #757575;
            position: relative;
            transition: all .3s;
        }

        .RangeSlider_TrackFill {
            position: relative;
            width: 0%;
            height: 5px;
            background-color: #6658DC;
            /* transition: width .4s cubic-bezier(0,1,.5,1.25); */
            transition: width .1s ease-in;
        }

        /* when thumb is being dragged, remove the transition */
        .RangeSlider_TrackFill.RangeSlider_TrackFill-stopAnimation {
            transition: none;
        }

        .RangeSlider_Thumb {
            position: absolute;
            top: 0;
            right: 0;
            width: 15px;
            height: 15px;
            background: #ddd;
            border-radius: 50%;
            cursor: pointer;
            transform: translate(50%, -33.33%);
        }

        /* when thumb is being dragged, increase the size so the cursor can come outside of it slightly */
        .RangeSlider_TrackFill-stopAnimation .RangeSlider_Thumb:before {
            content: "";
            display: block;
            width: 1000px;
            height: 1000px;
            position: absolute;
            top: -500px;
            left: -500px;
            border-radius: 50%;
            /* background: rgba(255,255,255,0.1); */
        }

        .RangeSlider_Points {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding-top: 4px;
            margin: 0 -8px 0 -8px;
        }

        .RangeSlider_Point {
            font-size: 11px;
            color: #ddd;
            cursor: pointer;
            width: 20px;
            text-align: center;
        }

        .RangeSlider_Point:hover {
            color: #fff;
        }

        .RangeSlider_Point:before {
            content: "";
            display: block;
            height: 5px;
            width: 1px;
            background-color: #666;
            margin: 0 auto;
        }

        .RangeSlider_Point.RangeSlider_PointActive {
            color: #6658DC;
        }

        .RangeSlider_Labels {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            width: 100%;
        }

        .RangeSlider_LabelLeft {
            text-align: left;
            margin-left: 0;
            width: 150px;
        }

        .RangeSlider_LabelRight {
            text-align: right;
            margin-right: 0;
            width: 150px;
        }

        .RangeSlider_LabelLeft p,
        .RangeSlider_LabelRight p {
            margin: 0;
        }
    </style>
@endpush

@section('main')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                <li class="breadcrumb-item active">Basic Elements</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Basic Elements</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="RangeSlider" id="RangeSlider">
                                        <h2 class="RangeSlider_ParticipantName mb-3">Akurasi Pencarian RoboMu</h2>
                                        <div class="RangeSlider_ClickArea">
                                            <div class="RangeSlider_Track">
                                                <div class="RangeSlider_TrackFill">
                                                    <div class="RangeSlider_Thumb"></div>
                                                </div>
                                            </div><!-- /.RangeSlider_Track -->
                                            <div class="RangeSlider_Points">
                                                <div class="RangeSlider_Point RangeSlider_PointActive">0</div>
                                                <div class="RangeSlider_Point">1</div>
                                                <div class="RangeSlider_Point">2</div>
                                                <div class="RangeSlider_Point">3</div>
                                                <div class="RangeSlider_Point">4</div>
                                                <div class="RangeSlider_Point">5</div>
                                                <div class="RangeSlider_Point">6</div>
                                                <div class="RangeSlider_Point">7</div>
                                                <div class="RangeSlider_Point">8</div>
                                                <div class="RangeSlider_Point">9</div>
                                                <div class="RangeSlider_Point">10</div>
                                            </div><!-- /.RangeSlider_Points -->
                                        </div><!-- /.RangeSlider_ClickArea -->

                                        <!-- Add this section for labels below the slider -->
                                        <div class="RangeSlider_Labels">
                                            <div class="RangeSlider_LabelLeft">
                                                <p class="fw-bold">Konten lebih banyak</p>
                                                <p>Sedang</p>
                                            </div>
                                            <div class="RangeSlider_LabelRight">
                                                <p class="fw-bold">Konten lebih sedikit</p>
                                                <p>Tinggi</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <a href="{{ route('user.retake') }}" class="btn btn-outline-primary rounded-pill waves-effect waves-light w-100">
                                            <span class="btn-label"><i class="mdi mdi-camera-retake-outline"></i></span> Tambah Selfie
                                        </a>
                                    </div>
                                   
                                </div>

                                <div class="col-lg-6">
                                    <br><br><br>
                                    <div class="roboyu-activation d-flex align-items-center p-3" style="background-color: #6658DC; border-radius: 15px; color: white;">
                                        <div>
                                            <img src="{{ asset('iconrobot/ROBOT LOOKING SOMETHING.png') }}" alt="RoboMu" style="width: 120px; margin-right: 20px;"> <!-- Adjust width and ensure image is correct -->
                                        </div>
                                        <div>
                                            <h4 class="fw-bold mb-3 text-white">RoboMu Diaktifkan</h4>
                                            <p>RoboMu mulai mencari segera dan akan mengirimimu DM jika menemukan sesuatu. Untuk pencarian pertama kali, RoboMu membutuhkan waktu verifikasi. Kontenmu akan ditampilkan pada tab "FotoMu".</p>
                                        </div>
                                    </div>
                                </div>
                                                             

                                <div class="mt-4">
                                    <h2 class="fw-bold">Temuan RoboMu kamu</h2>
                                    <p><strong>Perlu diketahui bahwa FotoMu tidak pernah mencarikan foto untuk user. Userlah yang mengendalikan RoboMu masing-masing untuk mencari foto mereka sendiri.</strong></p>
                                
                                    <p>RoboMu adalah Robo yang cerdas dan rajin. Bagaimanapun, <strong>kamu adalah pengontrolnya</strong>. Jadi, untuk setiap foto yang ditemukan, RoboMu akan meminta konfirmasi kamu, <strong>apakah ini kamu?</strong> Kamu hanya butuh menjawab: <strong>Ya</strong> atau <strong>Bukan</strong>.</p>
                                
                                    <p>Dari jutaan foto di server, RoboMu hanya akan menawarkan user, foto yang dianggap cocok dengan <strong>algoritma wajah dan lokasi</strong>. Ini akan secara drastis mengurangi kemungkinan foto orang lain muncul di pencarian kamu.</p>
                                
                                    <p>Terkadang RoboMu akan menawarkan foto yang dianggap mirip <strong>secara algoritma</strong>, tapi mungkin bukan kamu. Secara etis, kamu hanya mengonfirmasi jika foto itu benar-benar kamu, dan menolak foto yang bukan kamu. Dengan menjawab <strong>Ya</strong> atau <strong>Bukan</strong> dengan benar, kamu melatih RoboMu untuk menjadi <strong>lebih pintar dan lebih efisien</strong> dalam menemukan foto kamu.</p>
                                </div>
                            </div>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div><!-- end col -->
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script>
        var RangeSlider = function(containerID) {
            var self = this,
                $RangeSlider = $('#' + containerID),
                $SliderThumnb = $RangeSlider.find('.RangeSlider_Thumb'),
                $SliderTrack = $RangeSlider.find('.RangeSlider_Track'),
                $SliderTrackFill = $RangeSlider.find('.RangeSlider_TrackFill'),
                $ClickArea = $RangeSlider.find('.RangeSlider_ClickArea'),
                $SliderPoints = $RangeSlider.find('.RangeSlider_Point');

            // Retrieve the stored value from localStorage (if available), otherwise default to 10
            var storedValue = localStorage.getItem('userSliderValue') || 10;
            this.value = parseInt(storedValue, 10); // Ensure it's an integer

            /* helper to find slider value based on filled track width */
            var findValueFromTrackFill = function(trackFillWidth) {
                var totalWidth = $SliderTrack.width(),
                    onePercentWidth = totalWidth / 100,
                    value = Math.round((trackFillWidth / onePercentWidth) / 10);
                return value;
            }

            /* change highlighted number based on new value */
            var updateSelectedValue = function(newValue) {
                $SliderPoints.removeClass('RangeSlider_PointActive');
                $SliderPoints.eq(newValue).addClass('RangeSlider_PointActive');
            }

            /* highlight track based on new value (and move thumb) */
            var updateHighlightedTrack = function(newPosition) {
                newPosition = newPosition + '0%';
                $SliderTrackFill.css('width', newPosition);
            }

            /* set up drag functionality for thumbnail */
            var setupDrag = function($element, initialXPosition) {
                $SliderTrackFill.addClass('RangeSlider_TrackFill-stopAnimation');
                var trackWidth = $SliderTrackFill.width();

                var newValue = findValueFromTrackFill(trackWidth);
                updateSelectedValue(newValue);

                $element.on('mousemove', function(e) {
                    var newPosition = trackWidth + e.clientX - initialXPosition;
                    self.imitateNewValue(newPosition);

                    newValue = findValueFromTrackFill($SliderTrackFill.width());
                    updateSelectedValue(newValue);
                });
            }

            /* remove drag functionality for thumbnail */
            var finishDrag = function($element) {
                $SliderTrackFill.removeClass('RangeSlider_TrackFill-stopAnimation');
                $element.off('mousemove');
                var newValue = findValueFromTrackFill($SliderTrackFill.width());
                self.updateSliderValue(newValue);
            }

            /* method to update all things required when slider value updates */
            this.updateSliderValue = function(newValue) {
                updateSelectedValue(newValue);
                updateHighlightedTrack(newValue);
                self.value = newValue;

                // Store the new value in localStorage for future use
                localStorage.setItem('userSliderValue', newValue);

                console.log('this.value = ', self.value);
            }

            /* method to imitate new value without animation */
            this.imitateNewValue = function(XPosition) {
                $SliderTrackFill.addClass('RangeSlider_TrackFill-stopAnimation');
                if (XPosition > $SliderTrack.width()) {
                    XPosition = $SliderTrack.width();
                }
                $SliderTrackFill.css('width', XPosition + 'px');
            }

            /*
             * bind events when instance created
             */
            $ClickArea.on('mousedown', function(e) {
                /* if a number or thumbnail has been clicked, use their event instead */
                var $target = $(e.target);
                if ($target.hasClass('RangeSlider_Thumb')) {
                    return false;
                }
                /* now we can continue based on where the clickable area was clicked */
                self.imitateNewValue(e.offsetX);
                setupDrag($(this), e.clientX);
            });

            $ClickArea.on('mouseup', function(e) {
                console.log('"$ClickArea" calling "finishDrag"');
                finishDrag($(this));
            });

            // update value when markers are clicked
            $SliderPoints.on('mousedown', function(e) {
                e.stopPropagation();
                var XPos = $(this).position().left + ($(this).width() / 2);
                self.imitateNewValue(XPos);
                setupDrag($ClickArea, e.clientX);
            });

            // when thumbnail is clicked down, init the drag stuff
            $SliderThumnb.on('mousedown', function(e) {
                e.stopPropagation();
                setupDrag($(this), e.clientX);
            });

            // when the thumbnail is released, remove the drag stuff
            $SliderThumnb.on('mouseup', function(e) {
                console.log('"$SliderThumnb" calling "finishDrag"');
                finishDrag($(this));
            });

            // Set the initial value based on stored value
            this.updateSliderValue(this.value); // Use the stored value
        }

        var rangeSlider = new RangeSlider('RangeSlider');
        var rangeSlider2 = new RangeSlider('RangeSlider2');
    </script>
@endpush
