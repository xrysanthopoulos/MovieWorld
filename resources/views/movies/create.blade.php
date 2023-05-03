<x-app-layout>
    <div class="container">
        <h3 class="fs-2">Add New Movie</h3>
    <form method="POST" action="{{ route('movies.store') }}">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" placeholder="Enter description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Add Movie</button>
    </form>
    </div>
</x-app-layout>
