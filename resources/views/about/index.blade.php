@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <h1>About</h1>
                <p>Browse our information center to receive guidance on our projects, documentation or guides.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card text-white bg-primary">
                    <div class="card-header h4">{{ __('Documentation') }}</div>
                    <div class="card-body">
                        <p>Get information about the project, the problem, its actors and the terminology.</p>
                        <a href="/about/documentation" class="btn btn-md btn-light" role="button" aria-pressed="true"><i class="fal fa-book-alt"></i>  Read more</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card text-white bg-secondary">
                    <div class="card-header h4">{{ __('Developer guide') }}</div>
                    <div class="card-body">
                        <p>Obtain information related to the design of the solution, its components and patterns. If you are a developer this section can be quite useful.</p>
                        <a href="/about/developer-guide" class="btn btn-md btn-light" role="button" aria-pressed="true"><i class="fal fa-book-alt"></i> Read more</a>
                        <hr>
                        <a href="https://github.com/demency/alimentalos-backend" class="btn btn-md btn-light" role="button" aria-pressed="true"><i class="fab fa-github"></i> Backend repository</a>
                        <a href="https://github.com/demency/alimentalos-frontend" class="btn btn-md btn-light" role="button" aria-pressed="true"><i class="fab fa-github"></i> Frontend repository</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card text-white bg-success">
                    <div class="card-header h4">{{ __('OpenApi specifications') }}</div>
                    <div class="card-body">
                        <p>We use the OpenApi protocol in version 3, discover all the methods available in this project.</p>
                        <a href="/api/documentation" class="btn btn-md btn-light" role="button" aria-pressed="true"><i class="fal fa-book-open"></i> Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
