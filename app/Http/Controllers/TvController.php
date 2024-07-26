<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ViewModels\TvViewModel;
use App\ViewModels\TvShowViewModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use App\Exceptions\ResourceNotFoundException;

class TvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        try {
            $popularTv = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/tv/popular')
                ->throw()
                ->json()['results'];

            $topRatedTv = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/tv/top_rated')
                ->throw()
                ->json()['results'];

            $genres = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/genre/tv/list')
                ->throw()
                ->json()['genres'];
        } catch (RequestException $e) {
            return response()->view('errors.api', ['message' => $e->getMessage()], $e->getCode());
        }

        $viewModel = new TvViewModel(
            $popularTv,
            $topRatedTv,
            $genres,
        );

        return view('tv.index', $viewModel);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Create logic here
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Store logic here
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        try {
            $tvshow = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/tv/'.$id.'?append_to_response=credits,videos,images')
                ->throw()
                ->json();
        } catch (RequestException $e) {
            throw new ResourceNotFoundException();
        }

        $viewModel = new TvShowViewModel($tvshow);

        return view('tv.show', $viewModel);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Edit logic here
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Update logic here
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Destroy logic here
    }
}
