@extends('layouts.login')

@section('content')
<div class="container d-flex flex-column">
    <div class="row mt-5">
        {{-- <div class="col-md-6">
            <div class="img-card">
                <img src="img/lucky8.png" alt="Admin" class="img-fluid img" />
            </div>
        </div> --}}
        <div class="col-sm-8 col-md-6 col-lg-4 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">
                <div class="card logincard">
                    <div class="card-body">
                        <div class="m-sm-4">
                            <div class="text-center">
                                <img src="img/lucky8.png" alt="Admin" class="img-fluid" width="250" height="250" />
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" type="text" name="name" placeholder="Enter your username" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="Enter your password" />
                                </div>
                                <div>
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
                                        <span class="form-check-label">
                                            Remember me next time
                                        </span>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block w-100 lucky-btn">Let me in</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
