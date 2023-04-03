@extends('layouts.user_type.auth')

@section('content')
    <style>
        .badge {
            background-color: royalblue
        }
    </style>
    <div class="container-fluid">
        {{-- <h1>
            this is student page
        </h1> --}}
        @if ($errors->any())
            <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                <span class="alert-text text-white">
                    {{ $errors->first() }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
        @endif
        @if (session('success'))
            <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                <span class="alert-text text-white">
                    {{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
        @endif
        @if (Auth::user()->role == 'Student')
            <button type="button" id="askSponsor" onclick="sponsore()"
                class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Request Sponsorship' }}
            </button>
        @endif


        <div class="card" style="padding: 10px">
            <div class="table-responsive">
                <table class="table table-striped" style="width:100%" id="my-table">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary  font-weight-bolder opacity-7">ID</th>
                            <th class="text-uppercase text-secondary  font-weight-bolder opacity-7 ps-2">Reason</th>
                            <th class=" text-uppercase text-secondary  font-weight-bolder opacity-7">Needs</th>
                            <th class=" text-uppercase text-secondary  font-weight-bolder opacity-7">Status</th>
                            <th class=" text-uppercase text-secondary  font-weight-bolder opacity-7">Sponsor</th>
                            <th class=" text-uppercase text-secondary  font-weight-bolder opacity-7">Created Date</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div>
                              <img src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-xs">John Michael</h6>
                              <p class="text-xs text-secondary mb-0">john@creative-tim.com</p>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">Manager</p>
                          <p class="text-xs text-secondary mb-0">Organization</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="badge badge-sm badge-success">Online</span>
                        </td>
                        <td class="align-middle text-center">
                          <span class="text-secondary text-xs font-weight-normal">23/04/18</span>
                        </td>
                        <td class="align-middle">
                          <a href="javascript:;" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                            Edit
                          </a>
                        </td>
                      </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sponsorship Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/request-sponsor" method="POST" role="form text-left" enctype="multipart/form-data">
                            @csrf

                            <h5>General Imformation</h5>
                            <hr>
                            </hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name" class="form-control-label">{{ __('First Name') }}</label>
                                        <div class="@error('first_name')border border-danger rounded-3 @enderror">
                                            <input class="form-control" value="{{ auth()->user()->first_name }}"
                                                type="text" required placeholder="First Name" id="first_name"
                                                name="first_name">
                                            @error('first_name')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name" class="form-control-label">{{ __('Last Name') }}</label>
                                        <div class="@error('last_name')border border-danger rounded-3 @enderror">
                                            <input class="form-control" required value="{{ auth()->user()->last_name }}"
                                                type="text" placeholder="Last Name" id="last_name" name="last_name">
                                            @error('last_name')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob" class="form-control-label">{{ __('Date Of Birth') }}</label>
                                        <div class="@error('dob')border border-danger rounded-3 @enderror">
                                            <input class="form-control" required value="{{ auth()->user()->dob }}"
                                                type="date" placeholder="Date Of Birth" id="dob" name="dob">
                                            @error('dob')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user-email" class="form-control-label">{{ __('Email') }}</label>
                                        <div class="@error('email')border border-danger rounded-3 @enderror">
                                            <input class="form-control" required value="{{ auth()->user()->email }}"
                                                type="email" placeholder="@example.com" id="user-email"
                                                name="email">
                                            @error('email')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-control-label">{{ __('Phone') }}</label>
                                        <div class="@error('phone')border border-danger rounded-3 @enderror">
                                            <input class="form-control" required type="tel" placeholder="40770888444"
                                                id="number" name="phone" value="{{ auth()->user()->phone }}">
                                            @error('phone')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gs"
                                            class="form-control-label">{{ __('Grama Niladari Division') }}</label>
                                        <div class="@error('gs') border border-danger rounded-3 @enderror">
                                            <input class="form-control" required type="text" placeholder="GS Division"
                                                id="gs" name="gs" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">{{ 'Address' }}</label>
                                <div class="@error('address')border border-danger rounded-3 @enderror">
                                    <textarea class="form-control" id="address" rows="3" required placeholder="Address" name="address">{{ auth()->user()->address }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ds" class="form-control-label">{{ __('DS Division') }}</label>
                                        <div class="@error('ds')border border-danger rounded-3 @enderror">
                                            <input class="form-control" required type="text" placeholder="DS Division"
                                                id="ds" name="ds" value="">
                                            @error('ds')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district" class="form-control-label">{{ __('District') }}</label>
                                        <div class="@error('district') border border-danger rounded-3 @enderror">
                                            <input class="form-control" required type="text" placeholder="District"
                                                id="district" name="district" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="postal" class="form-control-label">{{ __('Postal Code') }}</label>
                                        <div class="@error('postal')border border-danger rounded-3 @enderror">
                                            <input class="form-control" type="text" placeholder="Postal Code"
                                                id="postal" name="postal" value="">
                                            @error('postal')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province" class="form-control-label">{{ __('Province') }}</label>
                                        <div class="@error('province') border border-danger rounded-3 @enderror">
                                            <input class="form-control" required type="text" placeholder="Province"
                                                id="province" name="province" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            </hr>
                            <hr>
                            </hr>
                            <h5>Request Sponsorship Information</h5>
                            <hr>
                            </hr>

                            <div class="form-check form-check-info ">
                                <input class="form-check-input" type="radio" required id="student_level"
                                    name="student_level" value="school">
                                <label class="form-check-label" for="flexCheckDefault">
                                    I'm a School Student.
                                </label>
                            </div>
                            <div class="form-check form-check-info ">
                                <input class="form-check-input" type="radio" required id="student_level"
                                    name="student_level" value="undergraduate">
                                <label class="form-check-label" for="flexCheckDefault">
                                    I'm a Under Graduate.
                                </label>
                            </div>
                            <div class="form-check form-check-info ">
                                <input class="form-check-input" type="radio" required id="student_level"
                                    name="student_level" value="postgraduate">
                                <label class="form-check-label" for="flexCheckDefault">
                                    I'm a Post Graduate.
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="reason">{{ 'Reason for Request' }}</label>
                                <div class="@error('reason')border border-danger rounded-3 @enderror">
                                    <textarea class="form-control" id="reason" required rows="3"
                                        placeholder="Give a brief Reason for the Sponsorship" name="reason">{{ auth()->user()->about_me }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="needs">{{ 'Needs and Essentials' }}</label>
                                <div class="@error('needs')border border-danger rounded-3 @enderror">
                                    <textarea class="form-control" id="needs" rows="3" placeholder="Needs and Essentials" name="needs">{{ auth()->user()->about_me }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group file-upload">
                                        <label for="doc"
                                            class="form-control-label">{{ __('Related Documents') }}</label>
                                        <div class="@error('doc') border border-danger rounded-3 @enderror">
                                            <input class="form-control" type="file" placeholder="Related Documents"
                                                name="doc[]" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    </br><button type="button" name="add" id="add" onclick="addDoc()"
                                        class="btn btn-success"><i class="fa fa-plus"></i> Add Document</button>
                                </div>
                            </div>
                            {{-- <div class="d-flex justify-content-end">
                                <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                            </div> --}}

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary bg-gradient-dark">Save changes</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Sponsorship Request</h5>
                        <button type="button" class="viewclose" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/request-sponsor" method="POST" role="form text-left"
                            enctype="multipart/form-data">
                            @csrf

                            <h5>General Information</h5>
                            <hr>
                            </hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name" class="form-control-label">{{ __('First Name') }}</label>
                                        <div class="@error('first_name')border border-danger rounded-3 @enderror">
                                            <input class="form-control" value="" type="text" required
                                                placeholder="First Name" id="first_name" name="first_name">
                                            @error('first_name')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name" class="form-control-label">{{ __('Last Name') }}</label>
                                        <div class="@error('last_name')border border-danger rounded-3 @enderror">
                                            <input class="form-control" required value="" type="text"
                                                placeholder="Last Name" id="last_name" name="last_name">
                                            @error('last_name')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob"
                                            class="form-control-label">{{ __('Date Of Birth') }}</label>
                                        <div class="@error('dob')border border-danger rounded-3 @enderror">
                                            <input class="form-control" required value="" type="date"
                                                placeholder="Date Of Birth" id="dob" name="dob">
                                            @error('dob')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user-email" class="form-control-label">{{ __('Email') }}</label>
                                        <div class="@error('email')border border-danger rounded-3 @enderror">
                                            <input class="form-control" required value="" type="email"
                                                placeholder="@example.com" id="email" name="email">
                                            @error('email')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-control-label">{{ __('Phone') }}</label>
                                        <div class="@error('phone')border border-danger rounded-3 @enderror">
                                            <input class="form-control" required type="tel" placeholder="40770888444"
                                                id="phone" name="phone" value="">
                                            @error('phone')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gs"
                                            class="form-control-label">{{ __('Grama Niladari Division') }}</label>
                                        <div class="@error('gs') border border-danger rounded-3 @enderror">
                                            <input class="form-control" required type="text" placeholder="GS Division"
                                                id="gs" name="gs" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">{{ 'Address' }}</label>
                                <div class="@error('address')border border-danger rounded-3 @enderror">
                                    <textarea class="form-control" id="address" rows="3" required placeholder="Address" name="address"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ds" class="form-control-label">{{ __('DS Division') }}</label>
                                        <div class="@error('ds')border border-danger rounded-3 @enderror">
                                            <input class="form-control" required type="text" placeholder="DS Division"
                                                id="ds" name="ds" value="">
                                            @error('ds')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district" class="form-control-label">{{ __('District') }}</label>
                                        <div class="@error('district') border border-danger rounded-3 @enderror">
                                            <input class="form-control" required type="text" placeholder="District"
                                                id="district" name="district" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="postal" class="form-control-label">{{ __('Postal Code') }}</label>
                                        <div class="@error('postal')border border-danger rounded-3 @enderror">
                                            <input class="form-control" type="text" placeholder="Postal Code"
                                                id="postal" name="postal" value="">
                                            @error('postal')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province" class="form-control-label">{{ __('Province') }}</label>
                                        <div class="@error('province') border border-danger rounded-3 @enderror">
                                            <input class="form-control" required type="text" placeholder="Province"
                                                id="province" name="province" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            </hr>
                            <hr>
                            </hr>
                            <h5>Request Sponsorship Information</h5>
                            <hr>
                            </hr>

                            <div class="form-check form-check-info ">
                                <input class="form-check-input" type="radio" required id="student_level"
                                    name="student_level" value="school">
                                <label class="form-check-label" for="flexCheckDefault">
                                    I'm a School Student.
                                </label>
                            </div>
                            <div class="form-check form-check-info ">
                                <input class="form-check-input" type="radio" required id="student_level"
                                    name="student_level" value="undergraduate">
                                <label class="form-check-label" for="flexCheckDefault">
                                    I'm a Under Graduate.
                                </label>
                            </div>
                            <div class="form-check form-check-info ">
                                <input class="form-check-input" type="radio" required id="student_level"
                                    name="student_level" value="postgraduate">
                                <label class="form-check-label" for="flexCheckDefault">
                                    I'm a Post Graduate.
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="reason">{{ 'Reason for Request' }}</label>
                                <div class="@error('reason')border border-danger rounded-3 @enderror">
                                    <textarea class="form-control" id="reason" required rows="3"
                                        placeholder="Give a brief Reason for the Sponsorship" name="reason"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="needs">{{ 'Needs and Essentials' }}</label>
                                <div class="@error('needs')border border-danger rounded-3 @enderror">
                                    <textarea class="form-control" id="needs" rows="3" placeholder="Needs and Essentials" name="needs"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group file-upload">
                                        <label for="doc"
                                            class="form-control-label">{{ __('Related Documents') }}</label>
                                        <div class="download-area">
                                            {{-- $formGroup.find('.download-area').removeClass('hide').find('a').attr('href', '{{url('manage/doc/download/')}}?path=' + doc.path); --}}
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{-- <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                        </div> --}}

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="viewclose" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        @if (Auth::user()->role == 'Sponsor')
                            <button id="acceptReq" type="button" onclick="acceptRequest()"
                                class="btn btn-primary bg-gradient-dark">Accept
                                Request</button>
                        @endif
                    </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="exponential.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
    //    $(document).ready(function(){
    // alert("heloo");
    //    });
    function sponsore() {
        $('#exampleModal').modal('show');
        $("#close").click(function() {
            $("#exampleModal").modal('hide');
        });
        $(".close").click(function() {
            $("#exampleModal").modal('hide');
        });
    }

    var student;

    function sponsoreview(e) {
        $.ajax({
            url: "{{ url('request-sponsor') }}" + "/" + e,
            type: 'GET',
            async: false,
            data: {
                id: e,
            },
            success: function(res) {
                student = res;
                // alert(res);
            }
        });
        // $('#viewModal input').val("");
        $('#viewModal .download-area').children().remove();
        $('#viewModal').modal('show');
        $('#viewModal #first_name').val(student.first_name);
        $('#viewModal #last_name').val(student.last_name);
        $('#viewModal #dob').val(student.dob);
        $('#viewModal #ds').val(student.ds);
        $('#viewModal #gs').val(student.gs);
        $('#viewModal #email').val(student.email);
        $('#viewModal #phone').val(student.phone);
        $('#viewModal #address').val(student.address);
        $('#viewModal #district').val(student.district);
        $('#viewModal #province').val(student.province);
        $('#viewModal #postal').val(student.postal);
        $('#viewModal #reason').val(student.reason);
        $('#viewModal #needs').val(student.needs);
        $('#viewModal input:radio[name=student_level]').filter('[value=' + student.student_level + ']').attr('checked',
            true);

        $.each(student.document, function(index, value) {
            $('#viewModal .download-area').append(
                '<p>' + value.name +
                '</p>&nbsp<a class="btn btn-default" href="{{ url('student_doc/') }}?path=' + value.path +
                '" target="_blank"> <i class="fa fa-fw fa-file-pdf-o"></i> View Certificate</a>'
            );
        });

        if (student.sponsor != null) {
            $('#viewModal #acceptReq').hide();
        } else {
            $('#viewModal #acceptReq').show();
        }


        $("#viewclose").click(function() {
            $("#viewModal").modal('hide');
        });
        $(".viewclose").click(function() {
            $("#viewModal").modal('hide');
        });
    }

    function acceptRequest() {
        $.ajax({
            url: "{{ route('accept') }}",
            type: 'POST',
            data: {
                id: student.id,
                _token: "{{ csrf_token() }}",
            },
            success: function(res) {
                // alert("success");
            }
        });
        $('#viewModal').modal('hide');
        $("#my-table").dataTable().fnDestroy();
        mytable();

    }



    var i = 0;

    function addDoc() {
        ++i;
        $(".file-upload").append(
            '<div class="row"><nobr><div class="@error('doc') border border-danger rounded-3 @enderror"><input class="form-control" type="file" placeholder="Related Documents"  name="doc[]" value=""></div><button type="button" class="btn btn-danger remove-tr"><i class="fa fa-minus"></i></button></nobr></div>'
        );
    };
    $(document).on('click', '.remove-tr', function() {
        $(this).closest("div").remove();
    });

    function mytable() {
        $.ajaxSetup({
            header: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#my-table').DataTable({
            // dom: "Bfrtip",
            order: [
                [0, 'desc']
            ],
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: '{{ route('request-sponsor.index') }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'reason',
                    name: 'reason'
                },
                {
                    data: 'needs',
                    name: 'needs'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(status, type, row, meta) {
                        if (status == 'Requested') {
                            status = '<td><span  class="badge badge-primary">' + status + '</span></td>'
                        } else if (status == 'Accepted') {
                            status = '<td><span  class="badge badge-primary"">' + status +
                                '</span></td>'
                        } else {
                            status = '<td><span class="badge badge-secondary">' + status +
                                '</span></td>'
                        }
                        return status;
                    }
                },
                {
                    data: 'sponsor',
                    name: 'sponsor'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },

                {
                    data: 'view',
                    name: 'view',
                    render: function(status, type, row, meta) {
                        action = '<a data-id="' + row.id + '" onclick="sponsoreview(' + row.id +
                            ')" class="btn btn-info viewBtn">View &nbsp<i class="fa fa-eye" aria-hidden="true"></i></a>'
                        return action;
                    }
                },
            ],

        });

    }
    $(document).ready(function() {
        mytable();
    });
</script>
