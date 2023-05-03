<!DOCTYPE html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    <style>
        .checkbox {
            text-align: right;
        }

        .checkbox input {
            float: right;
            position: relative !important;
            margin: 5px !important;
        }
    </style>
    <main>
        {{ $slot }}
    </main>
</div>
</body>
</html>

<script>
    $(document).on('click', '.vote-btn', function () {
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var movieId = this.getAttribute("data-movie-id");
        var userId = this.getAttribute("data-user-id");
        var voteType = this.getAttribute("data-vote-type");

        fetch(`/movie/${movieId}/vote`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                'user_id': userId,
                'vote_type': voteType
            })
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the vote count display
                    const likeCount = $(`#likes-count-${movieId}`);
                    const hateCount = $(`#hates-count-${movieId}`);
                    const likeBtn = document.querySelector(`#like-btn-${movieId}`);
                    const hateBtn = document.querySelector(`#hate-btn-${movieId}`);
                    likeBtn.style.backgroundColor = ""
                    hateBtn.style.backgroundColor = ""
                    this.style.backgroundColor = "#9DD3D6"
                    likeCount.text(data.likes);
                    hateCount.text(data.hates);
                } else {
                    console.error('Error recording vote');
                }
            })
            .catch(error => console.error(error));
    })

    $(function () {
        $('.sort-checkbox').on('change', function () {
            if ($(this).is(':checked')) {
                $('.sort-checkbox').not(this).prop('checked', false);
            }
        });
    });

    $(document).on('click', '.sort-checkbox', function () {
        let sortOption = $(this).attr("name");

        let checkboxes = document.querySelectorAll('input[type="checkbox"]');
        let selected = Array.from(checkboxes).some(checkbox => checkbox.checked);

        if (!selected) {
            sortOption = 'id';
        }

        $.ajax({
            url: "{{ route('movies.sort') }}",
            type: "GET",
            data: {sort_by: sortOption},
            success: function (response) {
                $('#movies-list').html(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr);
            }
        });
    });
</script>
