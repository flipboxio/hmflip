	@extends('template')
	@section('main')
		<div class="margin-top-85">
			<div class="row m-0">
				<!-- sidebar start-->
				@include('users.sidebar')
				<!--sidebar end-->
				<div class="col-md-10">
					<div class="main-panel min-height mt-4">
						<div class="row justify-content-center">
							<div class="col-md-3 pl-4 pr-4">
								@include('listing.sidebar')
							</div>

							<div class="col-md-9 mt-4 mt-sm-0 pl-4 pr-4">
								<form id="img_form" enctype='multipart/form-data' method="post" action="{{ url('listing/' . $result->id . '/' . $step) }}" accept-charset='UTF-8'>
									{{ csrf_field() }}
									<div class="row">
										<div class="col-md-12 border mt-4 pb-5 rounded-3 pl-sm-0 pr-sm-0 ">
											<div class="row">
												<div class="form-group col-md-12 main-panelbg pb-3 pt-3 mt-sm-0 ">
													<h4 class="text-18 font-weight-700 pl-3">{{ __('Photos') }}</h4>
												</div>
                                                <div class="form-group col-md-12">
                                                    <div class="alert alert-danger mt-4 hide" id="notice">
                                                        <span class="text-center"></span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mt-4 p-4 pb-4 pt-4">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    @if (session('success'))
                                                                        <div class="alert alert-success mt-4">
                                                                            <span>{{ session('success') }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <input class="form-control text-16" name="file" id="photo_file"
                                                                           type="file" value="" accept="image/*">
                                                                    <input type="hidden" id="photo" type="text" name="photos">
                                                                    <input type="hidden" name="img_name" id="img_name">
                                                                    <input type="hidden" name="crop" id="type" value="crop">
                                                                    <p class="text-13">(Width 640px and Height 360px)
                                                                    </p>
                                                                    <div id="result" class="hide">
                                                                        <img src="#" alt="">
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button type="submit"
                                                                            class="btn btn-large btn-photo text-16" id="up_button">
                                                                        <i class="spinner fa fa-spinner fa-spin d-none"
                                                                           id="up_spin"></i>
                                                                        <span
                                                                            id="up_button_txt">{{ __('Upload') }}</span>

                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    @if ($errors->any())
                                                                        
                                                                        <span
                                                                             class="text-danger">{{ $errors->first() }}
                                                                        </span>
                                                                        
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div id="photo-list-div" class="col-md-12 p-0">
                                                            <?php
                                                            $serial = 0;
                                                            ?>
                                                            <div class="row">
                                                                @foreach ($photos as $photo)
                                                                    <?php
                                                                    $serial++;
                                                                    ?>

                                                                    <div class="col-md-6 mt-5"
                                                                         id="photo-div-{{ $photo->id }}">
                                                                        <div class="room-image-container200"
                                                                             style="background-image:url('{{ url('public/images/property/' . $photo->property_id . '/' . $photo->photo) }}');">
                                                                            @if ($photo->cover_photo == 0)
                                                                                <a class="photo-delete text-right"
                                                                                   href="javascript:void(0)"
                                                                                   data-rel="{{ $photo->id }}">
                                                                                    <p class="photo-delete-icon"><i
                                                                                            class="fa fa-trash text-danger p-4"></i>
                                                                                    </p>
                                                                                </a>
                                                                            @endif
                                                                        </div>

                                                                        <div class="row mt-5">
                                                                            <div class="col-md-12 pl-4 pr-4 pr-sm-0 pl-sm-0">
                                                                             <textarea data-rel="{{ $photo->id }}"
                                                                                       class="form-control text-16 photo-highlights"
                                                                                       placeholder="{{ __('What are the highlights of this photo?') }}">{{ $photo->message }}</textarea>
                                                                            </div>

                                                                            <div
                                                                                class="col-md-6 pl-4 pr-4 pr-sm-0 pl-sm-0 mt-4">
                                                                                <label
                                                                                    for="sel1">{{ __('Serial') }}</label>
                                                                                <input type="text"
                                                                                       image_id="{{ $photo->id }}"
                                                                                       property_id="{{ $result->id }}"
                                                                                       id="serial-{{ $photo->id }}"
                                                                                       class="form-control text-16 serial"
                                                                                       name="serial"
                                                                                       value="{{ $photo->serial }}">
                                                                            </div>

                                                                            <div class="col-md-6 pl-4 pr-4  pr-sm-0 mt-4">
                                                                                @if ($photo->cover_photo == 0)
                                                                                    <label
                                                                                        for="sel1">{{ __('Cover Photo') }}</label>
                                                                                    <select
                                                                                        class="form-control photoId text-16"
                                                                                        id="photoId">
                                                                                        <option value="Yes"
                                                                                                <?= $photo->cover_photo == 1 ? 'selected' : '' ?>
                                                                                                image_id="{{ $photo->id }}"
                                                                                                property_id="{{ $result->id }}">
                                                                                            {{ __('Yes') }}
                                                                                        </option>
                                                                                        <option value="No"
                                                                                                <?= $photo->cover_photo == 0 ? 'selected' : '' ?>
                                                                                                image_id="{{ $photo->id }}"
                                                                                                property_id="{{ $result->id }}">
                                                                                            {{ __('No') }}
                                                                                        </option>
                                                                                    </select>
                                                                                @endif
                                                                            </div>
                                                                        </div>

                                                                        @if ($serial % 3 == 0)
                                                                            <div style="clear:both;">&nbsp;</div>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                         <span class="text-danger display-off ml-3"
                                                               id='photo'>{{ __('This field is required.') }}
                                                         </span>
                                                        </div>
                                                    </div>

                                                    <div style="clear:both;"></div>
                                                </div>
											</div>
										</div>
									</div>
								</form>

									<div class="col-md-12 p-0 mt-4 mb-5">
										<div class="row m-0 justify-content-between">
											<div class="mt-4">
												<a href="{{ url('listing/' . $result->id . '/amenities') }}" class="btn btn-outline-danger secondary-text-color-hover text-16 font-weight-700  pt-3 pb-3 pl-5 pr-5">
													{{ __('Back') }}
												</a>
											</div>

											<div class="mt-4">

												<a href="{{ url('listing/' . $result->id . '/pricing') }}" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5" id="btnnext"><i class="spinner fa fa-spinner fa-spin d-none" id="btn_spin"></i>
													<span id="btnnext-text">{{ __('Next') }}</span>
												</a>
											</div>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <div class="modal fade crop-modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="background: white">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLongTitle">{{ __('Edit Image') }}</h2>
                        <button type="button" class="close text-28" id="clode-modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="min-height: 70vh">
                            <canvas id="canvas">
                                {{ __('Your browser does not HTML5 canvas element.') }}
                            </canvas>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" id="crop" class="btn btn-primary">{{ __('Crop') }}</button>
                        <button type="button" id="restore" class="btn btn-secondary" data-dismiss="modal">{{ __('Skip') }}</button>
                    </div>
                </div>
            </div>
        </div>
	@endsection

    @push('css')
        <link rel="stylesheet" href="{{ asset('public/css/cropper.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/css/photo-listing.min.css') }}" />
    @endpush

@section('validation_script')
    <script type="text/javascript" src="{{ asset('public/js/bootbox.min.js') }}"></script>
    <script src="{{ asset('public/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/js/cropper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/js/additional-method.min.js') }}"></script>

	<script type="text/javascript">
		'use strict'
        let photoUploadURL = '{{ url("add_photos/" . $result->id) }}';
		var photoRoomURl = '{{ url("images/rooms/" . $result->id) }}';
		var photoMessageURL = '{{ url("listing/" . $result->id . "/photo_message") }}';
        let photoDeleteURL = '{{ url("listing/" . $result->id . "/photo_delete") }}';
        let makeDefaultPhotoURL = '{{ url("listing/photo/make_default_photo") }}';
        var makePhotoSerialURL = '{{ url("listing/photo/make_photo_serial") }}';
        let highlightsPhotoText = "{{ __('What are the highlights of this photo?') }}";
        let networkErrorText = "{{ __('Network error! Please try again.') }}";
        var token = '{{ csrf_token() }}';
		let nextText = "{{ __('Next') }}..";
		let areYouSureText = "{{ __('Are you sure ?') }}";
		let deleteForeverText = "{{ __('If you delete this, it will be gone forever.') }}";
        let cancelText = "{{ __('Cancel') }}";
        let okText = "{{ __('OK') }}";
        let deletedText = "{{ __('Deleted!') }}";
        let uploadText = "{{ __('Upload') }}..";
        let imageMendatoryTypeText = "{{ __('The file must be an image (jpg, jpeg, png or gif)') }}";
        let invalidImagetypeText = "{{ __('Invalid file type! Please select an image file.') }}";
        let noFileSelectedText = "{{ __('No file(s) selected.') }}";
		let page = 'photos';
		let gl_photo_id = 0;

	</script>

	<script type="text/javascript" src="{{ asset('public/js/listings.min.js') }}"></script>

@endsection
	
