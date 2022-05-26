@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <center>
                <a href="javascript:;" id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()"
                   class="btn btn-danger btn-xs btn-flat">Allow for Notification
                </a>
            </center>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        <posts :posts="{{ $posts }}" :user="{{ auth()->user() }}"
                               :user_notifications="{{ auth()->user()->notifications }}"/>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyCSxzVlRUiwuFm5WGfyFdNW1jsJkmKc_JM",
            authDomain: "laravelnotificationfcm.firebaseapp.com",
            projectId: "laravelnotificationfcm",
            storageBucket: "laravelnotificationfcm.appspot.com",
            messagingSenderId: "817845056777",
            appId: "1:817845056777:web:faae8224030fc1cb4ccfd8",
            measurementId: "G-7S8ZDVCEML",
            databaseURL: "https://itdemo-push-notification.firebaseio.com",
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function (token) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '{{ route("save-token") }}',
                        type: 'POST',
                        data: {
                            _token: '{{csrf_token()}}',
                            token: token
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            alert('Token saved successfully.');
                        },
                        error: function (err) {
                            console.log('User Chat Token Error' + err);
                        },
                    });

                }).catch(function (err) {
                alert('User Chat Token Error' + err);
            });
        }

        messaging.onMessage(function (payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });

    </script>
@endsection
<script src="{{asset('js/app.js')}}"></script>
