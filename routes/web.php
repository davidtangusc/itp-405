<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\URL;
use App\Models\Artist;
use App\Models\Track;
use App\Models\Genre;
use App\Models\Album;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/mail', function () {
    Mail::raw('What is your favorite framework?', function ($message) {
        $message->to('dtang@usc.edu')->subject('Hello David');
    });
});

Route::get('/itunes', function (Request $request) {
    $term = $request->query('term');
    $cacheKey = "itunes-api-$term";
    $response = Cache::remember($cacheKey, 60, function () use ($term) {
        return Http::get("https://itunes.apple.com/search?term=$term")->object();
    });

    return view('api.itunes', [
        'response' => $response,
    ]);
});

Route::get('/reddit/{subreddit}', function ($subreddit) {
    $response = Cache::remember("reddit-$subreddit", 60, function () use ($subreddit) {
        return Http::get("https://www.reddit.com/r/$subreddit.json")->object();
    });

    return view('api.reddit', [
        'response' => $response,
    ]);
});

Route::get('/yelp', function () {
    return Http::withToken(env('YELP_API_KEY'))
        ->get('https://api.yelp.com/v3/businesses/search?term=vegan&location=Los Angeles')
        ->json();
});

Route::middleware(['auth'])->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::middleware(['prevent-blocked-users'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

        Route::view('/blocked', 'blocked')->name('blocked');
    });
});


Route::get('/register', [RegisterController::class, 'index'])->name('registration.index');
Route::post('/register', [RegisterController::class, 'register'])->name('registration.create');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login'); // goes with the auth middleware
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');


Route::get('/eloquent', function () {
    // SELECT * FROM artists
    // return Artist::all();

    // SELECT * FROM tracks LIMIT 5
    // $tracks = Track::where('unit_price', '>', 0.99)->orderBy('name', 'desc')->get();

    // SELECT * FROM artists WHERE id = 3
    // Artist::find(3);

    // INSERT INTO genres ...
    // $genre = new Genre();
    // $genre->name = 'Hip Hop';
    // var_dump($genre->id);
    // $genre->save(); // trigger the INSERT INTO SQL
    // var_dump($genre->id);

    // Updating records
    // $genre->name = 'Alternative';
    // $genre->save(); // trigger an UPDATE SQL

    // DELETING a record
    // Genre::find(27)->delete();

    // RELATIONSHIPS
    // $metallica = Artist::find(50);
    // return $metallica->albums;

    // $masterOfPuppets = Album::find(152);
    // return $masterOfPuppets->artist;

    // EXERCISE 1
    // set up a relationship between Track and Genre so that we can get
    // the genre from a track record of 1837
    // $track = Track::find(1837);
    // return $track->genre;

    // EXERCISE 2
    // set up a relationship between Track and Genre so that we can get
    // all the tracks for a given genre
    // $metal = Genre::find(3);
    // return $metal->tracks;

    // N + 1 problem (lazy loading)
    // $tracks = Track::orderBy('name')->take(20)->get();

    // return view('eloquent', [
    //     'tracks' => $tracks,
    // ]);

    // Eager loading
    $tracks = Track::with(['genre'])
        ->orderBy('name')
        ->take(20)
        ->get();

    return view('eloquent', [
        'tracks' => $tracks,
    ]);
});


Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
Route::get('/albums/new', [AlbumController::class, 'create'])->name('album.create');
Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');
Route::get('/albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');



if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
} 