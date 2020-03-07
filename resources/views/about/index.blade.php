@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Class') }}</div>

                    <div class="card-body">
                        {{ __('Class is everything that groups elements with similar properties. One class of our system is the Pet. It belongs to a type of animal, it has colors, size and a name. The animal has a location and in practice it has a history where it has traveled.') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">{{ __('Resource') }}</div>

                    <div class="card-body">
                        {{ __('Resource is a type of class that groups the classes that have a general and common behavior in our system specifically related to that it can be listed, created, edited or deleted.') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">{{ __('Relationship') }}</div>

                    <div class="card-body">
                        {{ __('Relationship is any link between two classes of the system, we have common interfaces such as HasComments or Photoable in case our class can be photoable. In each case, it relates one element to another, such as the Photo and the Pet.') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">{{ __('System') }}</div>

                    <div class="card-body">
                        {{ __('System is any ordered set of classes that orchestrated and implemented make up an operational flow that gives solution to a specific problem. Our system allows to have a conscious control of natural or artificial resources.') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">{{ __('Authenticated') }}</div>

                    <div class="card-body">
                        {{ __('Authenticated is a globally available function that allows access to the authenticated user in the system in the context of executing an HTTP request.') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">{{ __('Repository') }}</div>

                    <div class="card-body">
                        {{ __('Repository is a type of class that contains specific methods of a class to handle behavior of one or more classes. An example of this is the user repository, it allows you, among others, to create a user, check if another belongs to a user, etc.') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">{{ __('Finder') }}</div>

                    <div class="card-body">
                        {{ __('Finder is a repository dedicated to solving classes with standardized parameters. For example, we have a class in charge of handling all resource listings, that class requires Finder to specifically find the type of resource that should be listed by the system.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
