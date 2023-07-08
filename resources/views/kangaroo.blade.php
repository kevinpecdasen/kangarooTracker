@extends('layout')

@section('bodyContent')
    <h3 class="mb-3"><i class="bi {{ $action === 'edit' ? 'bi-pencil-fill' : 'bi-save-fill' }}"></i> {{ $title ?? "Add Kangaroo" }}</h3>
    <div id="msgs"></div>
    <form id="kangaroo_form">
        <div class="row">
            <div class="col-6">
                 <div class="input-group mb-3">
                    <span class="input-group-text" id="name_label">Kangaroo Name:</span>
                    <input autocomplete="off" name="name" required type="text" class="form-control"
                           value="{{ $data['name'] ?? "" }}"
                           placeholder="Name" aria-label="Kangaroo Name" aria-describedby="name_label">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="nickname_label">Nickname:</span>
                    <input autocomplete="off" name="nickname" type="text" class="form-control"
                           value="{{ $data['nickname'] ?? "" }}"
                           placeholder="Nickname" aria-label="Nickname" aria-describedby="nickname_label">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="weight_label">Weight (kg):</span>
                    <input autocomplete="off" name="weight" required type="number" class="form-control"
                           value="{{ $data['weight'] ?? "" }}"
                           placeholder="0.00" aria-label="Weight" aria-describedby="weight_label">
                </div>
            </div>

            <div class="col-4">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="height_label">Height (cm):</span>
                    <input autocomplete="off" name="height" required type="number" class="form-control"
                           value="{{ $data['height'] ?? "" }}"
                           placeholder="0.00" aria-label="Height" aria-describedby="height_label">
                </div>
            </div>

            <div class="col-4">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="gender_label">Gender:</span>
                    <select name="gender" required class="form-control" aria-label="Gender" aria-describedby="gender_label">
                        <option></option>
                        <option
                            {{ isset($data['gender']) && $data['gender'] == "Male" ? "selected" : "" }}
                            value="Male">Male</option>
                        <option
                            {{ isset($data['gender']) && $data['gender'] == "Female" ? "selected" : "" }}
                            value="Female">Female</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="color_label">Color:</span>
                    <input autocomplete="off" name="color" type="text" class="form-control"
                           value="{{ $data['color'] ?? "" }}"
                           placeholder="Color" aria-label="Color" aria-describedby="color_label">
                </div>
            </div>

            <div class="col-4">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="friendliness_label">Friendliness:</span>
                    <select name="friendliness" class="form-control" aria-label="Friendliness" aria-describedby="friendliness_label">
                        <option></option>
                        <option
                            {{ isset($data['friendliness']) && $data['friendliness'] == "Friendly" ? "selected" : "" }}
                             >Friendly</option>
                        <option
                            {{ isset($data['friendliness']) && $data['friendliness'] == "Not Friendly" ? "selected" : "" }}
                            value="Not Friendly" >Not Friendly</option>
                    </select>
                </div>
            </div>

            <div class="col-4">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="birthday_label">Birthday:</span>
                    <input autocomplete="off" type="date" name="birthday"
                           value="{{ $data['birthday'] ?? "" }}"
                           class="form-control" aria-label="Birthday" aria-describedby="birthday_label">
                </div>
            </div>
        </div>

        <div class="row mt-5">
            @csrf
            @method( $action == "add" ? "POST" : "PUT" )
            <input type="hidden" name="id" value="{{ $data['id'] ?? "" }}">
            <input type="hidden" name="action" value="{{ $action ?? "add" }}">


            <input type="submit" name="save" value="{{ isset($data['id']) ? 'Update' : 'Save' }}" class="btn btn-outline-primary">
            &emsp;
            <input type="reset" class="btn btn-outline-secondary"/>
        </div>
    </form>
@endsection

@section('customScripts')
    <script>
        $(function(){
            const kangaroo = {
                action: $('input[name="action"]').val(),
                url: '<?=env('APP_URL')?>',
                init: function() {
                    this.url += (this.action === 'edit')
                        ? "api/edit_record"
                        : "api/add_record";
                    this.handleFormSubmit();
                },
                handleFormSubmit: function()  {
                    $('input[name="save"]').on('click', (e) => {
                        e.preventDefault();
                        $.ajax({
                            url: kangaroo.url,
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                            dataType: 'json',
                            data: $('form').serialize(),
                            success: function (data) {
                                const successMsg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>" +
                                        "<h3 class='alert-heading'>Success!</h3>" +
                                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
                                        "<span aria-hidden='true'>&times;</span> </button><hr/>" +
                                        "<span>Data saved.</span>";
                                    $('#msgs').html(successMsg);
                                    kangaroo.handleResetForm();
                                    kangaroo.fadeAlertMsg();
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                //for field validations failures
                                if (xhr.status === 422 || xhr.responseJSON.errors !== undefined) {
                                    const errors = xhr.responseJSON.errors;
                                    let errorMsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" +
                                        "<h4 class='alert-heading'>Error/s found!</h4>" +
                                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
                                        "<span aria-hidden='true'>&times;</span> </button><hr/>";
                                    Object.keys(errors).forEach((key) => {
                                        if ( typeof errors[key] === "string") {
                                            errorMsg +=  "<span>" + errors[key] + "</span><br/>";
                                        } else {
                                            errorMsg +=  "<span>" + errors[key][0] + "</span><br/>";
                                        }

                                    });
                                    errorMsg += "</div>";
                                    $('#msgs').html(errorMsg);
                                }

                                else {
                                    console.log(xhr);
                                    console.log(textStatus);
                                    console.log(errorThrown);
                                }

                            }
                        })
                    });
                },
                handleResetForm: function () {
                    if (kangaroo.action === 'add') {
                        $('form')[0].reset();
                    }
                },
                fadeAlertMsg: function () {
                    setTimeout(function (){
                        $('.alert').fadeOut();
                    }, 3000);
                }
            }


            kangaroo.init();
        });
    </script>
@endsection
