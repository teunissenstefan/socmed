@extends('layouts.app')

@section('pageTitle', 'Edit profile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit profile') }}</div>

                    <div class="card-body">
                        {{ Html::ul($errors->all()) }}

                        {{ Form::model($user, array('route' => array('profileupdate', $user->id), 'method' => 'PUT')) }}
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    {{ Form::text('name', null, array('class' => 'form-control '.($errors->has('name') ? ' is-invalid' : ''),'required','autofocus')) }}

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Last name') }}</label>

                                <div class="col-md-6">
                                    {{ Form::text('lastname', null, array('class' => 'form-control '.($errors->has('lastname') ? ' is-invalid' : ''),'required')) }}

                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('Birthdate') }}</label>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::text('birthdate', null, array('class' => 'form-control '.($errors->has('birthdate') ? ' is-invalid' : ''),'readonly','id' => 'd')) }}

                                        @if ($errors->has('birthdate'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('birthdate') }}</strong>
                                    </span>
                                        @endif

                                        <div id="z"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                                <?php $genderArray = array(); ?>
                                @foreach($genders as $gender)
                                    <?php $genderArray[$gender->id] = $gender->gender; ?>
                                @endforeach
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::select('gender', $genderArray, null, ['id' => 'myselect', 'class' => 'form-control '.($errors->has('gender') ? ' is-invalid' : '')]) }}
                                    </div>

                                    @if ($errors->has('gender'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="github_username" class="col-md-4 col-form-label text-md-right">{{ __('GitHub Username') }}</label>

                                <div class="col-md-6">
                                    {{ Form::text('github_username', null, array('class' => 'form-control '.($errors->has('github_username') ? ' is-invalid' : ''))) }}

                                    @if ($errors->has('github_username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('github_username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    {{ Form::email('email', null, array('class' => 'form-control '.($errors->has('email') ? ' is-invalid' : ''),'required')) }}

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( function() {
            $('#z').datepicker({
                inline: true,
                altField: '#d',
                minDate: "-100Y",
                maxDate: "-1D",
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd"
            });

            $('#d').change(function(){
                $('#z').datepicker('setDate', $(this).val());
            });
            $('#z').datepicker('setDate', "{{ $user->birthdate }}");
        } );
    </script>
@endsection
