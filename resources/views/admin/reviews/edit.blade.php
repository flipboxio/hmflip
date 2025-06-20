@extends('admin.template')
@section('main')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-8 offset-sm-2">
          <!-- Horizontal Form -->
          <div class="box box-info box_info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Review Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="rev_form" action="{{ url('admin/edit_review/' . $result->id) }}" method="post">
            {{ csrf_field() }}

              <div class="box-body">
                <div class="form-group row mt-3">
                  <label for="booking_id" class="col-sm-3 col-6 control-label fw-bold">Booking Id</label>
                  <div class="col-sm-6 col-6">
                    <p class="mb-2 f-14">{{ $result->booking_id }}</p>
                  </div>
                </div>
               
                <div class="form-group row mt-3">
                  <label for="property_name" class="col-sm-3 col-6 control-label fw-bold">Property Name</label>
                  <div class="col-sm-6 col-6">
                    <p class="mb-2 f-14">{{ $result->property_name }}</p>
                  </div>
                </div>
              
                <div class="form-group row mt-3">
                  <label for="sender" class="col-sm-3 col-6 control-label fw-bold">Guest</label>
                  <div class="col-sm-6 col-6">
                    <p class="mb-2 f-14">{{ $result->sender }}</p>
                  </div>
                </div>
              
                <div class="form-group row mt-3">
                  <label for="receiver" class="col-sm-3 col-6 control-label fw-bold">Host</label>
                  <div class="col-sm-6 col-6">
                    <p class="f-14">{{ $result->receiver }}</p>
                  </div>
                </div>
               
                <div class="form-group row mt-3">
                  <label for="reviewer" class="col-sm-3 col-6 control-label fw-bold">Reviewed By</label>
                  <div class="col-sm-6 col-6">
                    <p class=" f-14">{{ $result->reviewer }}</p>
                  </div>
                </div>

                @if ($result->reviewer == 'guest')
               
                <div class="form-group row mt-3">
                  <label for="message" class="col-sm-3 control-label fw-bold">Rating</label>
                  <div class="col-sm-6">
                    <input type="number" name="rating" min="1" max="5" class="form-control f-14 " value="{{ $result->rating }}" />
                  </div>
                </div>
                
                <div class="form-group row mt-3">
                  <label for="message" class="col-sm-3 control-label fw-bold">Accuracy</label>
                  <div class="col-sm-6">
                    <input type="number" name="accuracy" min="1" max="5" class="form-control f-14 " value="{{ $result->accuracy }}" />
                  </div>
                </div>
               
                <div class="form-group row mt-3">
                  <label for="message" class="col-sm-3 control-label fw-bold">Location</label>
                  <div class="col-sm-6">
                    <input type="number" name="location" min="1" max="5" class="form-control f-14 " value="{{ $result->location }}" />
                  </div>
                </div>
               
                <div class="form-group row mt-3">
                  <label for="message" class="col-sm-3 control-label fw-bold">Communication</label>
                  <div class="col-sm-6">
                    <input type="number" name="communication" min="1" max="5" class="form-control f-14 " value="{{ $result->communication }}" />
                  </div>
                </div>
               
                <div class="form-group row mt-3">
                  <label for="message" class="col-sm-3 control-label fw-bold">Check In</label>
                  <div class="col-sm-6">
                    <input type="number" name="checkin" min="1" max="5" class="form-control f-14 " value="{{ $result->checkin }}" />
                  </div>
                </div>
              
                <div class="form-group row mt-3">
                  <label for="message" class="col-sm-3 control-label fw-bold">Cleanliness</label>
                  <div class="col-sm-6">
                    <input type="number" name="cleanliness" min="1" max="5" class="form-control f-14 " value="{{ $result->cleanliness }}" />
                  </div>
                </div>
               
                <div class="form-group row mt-3">
                  <label for="message" class="col-sm-3 control-label fw-bold">Value</label>
                  <div class="col-sm-6">
                    <input type="number" name="value" min="1" max="5" class="form-control f-14 " value="{{ $result->value }}" />
                  </div>
                </div>
                @endif

                
                <div class="form-group row mt-3">
                  <label for="message" class="col-sm-3 control-label fw-bold">Message<em class="text-danger">*</em></label>
                  <div class="col-sm-6">
                    <textarea name="message" class="form-control f-14 ">{{ $result->message }}</textarea>
                    <span class="text-danger">{{ $errors->first('message') }}</span>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info btn-space f-14 text-white me-2" name="submit" value="submit">Submit</button>
                <button type="submit" class="btn btn-danger f-14" name="cancel" value="cancel">Cancel</button>

              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@push('scripts')
  <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
@endpush
@stop


