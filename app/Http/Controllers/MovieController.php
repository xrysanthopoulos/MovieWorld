<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MovieController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $movies = Movie::all();

        $sortBy = $request->input('sort_by', 'id');

        if ($sortBy == 'likes') {
            $movies = $movies->sortByDesc('likes');
        } elseif ($sortBy == 'hates') {
            $movies = $movies->sortByDesc('hates');
        } elseif ($sortBy == 'dates') {
            $movies = $movies->sortByDesc('created_at');
        }

        if ($request->ajax()) {
            return view('movies.list', ['movies' => $movies]);
        }

        return view('main', ['movies' => $movies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $userId = Auth::id();
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required'
        ]);

        $movie = new Movie;
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->user_id = $userId;
        $movie->save();

        return redirect()->route('main')->with('success', 'Movie added successfully.');
    }

    public function vote(Request $request, $id) {

        $user_id = $request->input('user_id');
        $type = $request->input('vote_type');
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $existingVote = Vote::where('movie_id', $movie->id)->where('user_id', $user_id)->first();

        if ($existingVote) {
            if ($existingVote->type == $type) {
                $existingVote->delete();
                $message = 'Your ' . $type . ' has been removed';
            } else {
                $existingVote->type = $type;
                $existingVote->save();
                $message = 'Your vote has been changed to ' . $type;
            }
        } else {
            $vote = new Vote;
            $vote->movie_id = $movie->id;
            $vote->user_id = $user_id;
            $vote->type = $type;
            $vote->save();
            $message = 'You have ' . $type . 'd this movie';
        }

        $likesCount = Vote::where('movie_id', $movie->id)->where('type', 'like')->count();
        $hatesCount = Vote::where('movie_id', $movie->id)->where('type', 'hate')->count();

        return response()->json(['success' => true, 'message' => $message, 'likes' => $likesCount, 'hates' => $hatesCount]);
    }
}
