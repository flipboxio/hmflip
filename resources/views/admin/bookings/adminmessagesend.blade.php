 @extends('admin.template')

 @section('main')
     <div class="content-wrapper">
        <section class="content-header">
            <h1>Update message form<small>Update message</small></h1>
            @include('admin.common.breadcrumb')
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Update message form</h3>
                        </div>
                        <form class="form-horizontal" action="{{ url('admin/send-message-email/' . $messages->id) }}" id="send_email" method="post" name="add_customer" accept-charset='UTF-8'>
                            {{ csrf_field() }}
                            <input type="hidden" name="message_id" value="{{ $messages->id }}">
                            <div class="box-body">
                                <div class="form-group row mt-3">
                                    <div class="col-sm-6">
                                        <input type="hidden" class="form-control f-14"
                                        value="{{ $messages->receiver_id }}" name="receiver_id" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Message
                                        <span  class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <textarea id="content" name="content" placeholder="" class="form-control f-14 col-md-12"> {{ $messages->message }} </textarea>
                                        <span id="content-validation-error"></span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <input type="hidden" class="form-control f-14" value="{{ $messages->type_id }}" name="admin_email" placeholder="">
                                    <div class="col-sm-6">
                                        <input type="hidden" class="form-control f-14"
                                        value="{{ $messages->sender->email }}" name="admin_email" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info btn-sm text-white f-14 me-2" id="submitBtn">Update</button>
                                <a href="{{ url('admin/messages') }}" class="btn btn-danger btn-sm f-14"> Cancel </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
     </div>
 @endsection

 @push('scripts')
     <script src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
 @endpush
