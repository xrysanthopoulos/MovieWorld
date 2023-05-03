<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h1 class="fs-1">{{env('APP_NAME')}}</h1>
            </div>
            <div class="col text-end">
                @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                        @auth
                            Wellcome Back <a href="{{ url('/profile') }}" class="">{{Auth::user()->name}}</a>
                        @else
                            <a href="{{ route('login') }}" class="text-info">Log in</a>
                            <span>or</span>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="border border-primary bg-info border-2 rounded-5 text-light p-2">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>

        <p>Found {{count($movies)}} movies</p>

        <div class="row">
            <div id="movies-list" class="col-10">
                @include('movies.list')
            </div>
            <div class="col-2">
                @if (Auth::check())
                    <div class="border border-primary bg-success border-2 rounded-4 p-1 mb-2 text-center">
                        <a href="{{ route('movies.create') }}" class="text-light">New Movie</a>
                    </div>
                @endif
                <div class="border border-black border-4 rounded">
                    <span class="d-flex justify-content-center">Sort by:</span>
                    <div class="d-flex justify-content-center">
                        <div class="d-inline">
                            <div class="checkbox border-top border-primary border-4">
                                <label class="text-info"><input type="checkbox" class="sort-checkbox" name="likes"
                                                                value="1">Likes</label>
                            </div>
                            <div class="checkbox border-top border-primary border-4">
                                <label class="text-info"><input type="checkbox" class="sort-checkbox" name="hates"
                                                                value="1">Hates</label>
                            </div>
                            <div class="checkbox border-top border-primary border-4">
                                <label class="text-info"><input type="checkbox" class="sort-checkbox" name="dates"
                                                                value="1">Dates</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
