<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ViewModels\ActorViewModel;
use App\ViewModels\ActorsViewModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use App\Exceptions\ResourceNotFoundException;

class ActorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($page = 1)
    {
        abort_if($page > 500, 204);

        try {
            $popularActors = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/person/popular?page='.$page)
                ->throw()
                ->json()['results'];
        } catch (RequestException $e) {
            return response()->view('errors.api', ['message' => $e->getMessage()], $e->getCode());
        }

        $viewModel = new ActorsViewModel($popularActors, $page);

        return view('actors.index', $viewModel);
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
            $actor = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/person/'.$id)
                ->throw()
                ->json();

            $social = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/person/'.$id.'/external_ids')
                ->throw()
                ->json();

            $credits = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/person/'.$id.'/combined_credits')
                ->throw()
                ->json();
        } catch (RequestException $e) {
            throw new ResourceNotFoundException();
        }

        $viewModel = new ActorViewModel($actor, $social, $credits);

        return view('actors.show', $viewModel);
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
