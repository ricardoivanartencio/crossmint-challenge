<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Jobs\PolyanetsJob;
use App\Jobs\PolyanetsSoloonsAndComeths;

class HomeController extends Controller
{
    public function index()
    {
        $exercises = [];
        
        //in a real scenario, this data could be brought from the database with a query and the $exercises would be replace by a object eloquent and the code could be shorter

        $exercises[0] = [
            'name' => 'add_planets',
            'action' => 'Create!',
            'image' => 'crossmint_1st_challenge_complete',
            'text' => 'This button will create a X pattern of Planets in the Megaverse!'
        ];

        $exercises[1] = [
            'name' => 'remove_planets',
            'action' => 'Delete!',
            'image' => 'crossmint_1st_challenge_uncomplete',
            'text' => 'This button will delete the X pattern of Planets from the Megaverse!'
        ];

        $exercises[2] = [
            'name' => 'add_planets_moons_and_comets',
            'action' => 'Create!',
            'image' => 'crossmint_2nd_challenge_complete',
            'text' => 'This button will make a Crossmint logo of Planets, Moons and Comets in the Megaverse!'
        ];

        $exercises[3] = [
            'name' => 'remove_planets_moons_and_comets',
            'action' => 'Delete!',
            'image' => 'crossmint_2nd_challenge_uncomplete',
            'text' => 'This button will delete the Crossmint logo of Planets, Moons and Comets from the Megaverse!'
        ];

        return view('home', [
            'exercises' => $exercises
        ]);
    }

    public function images($filename)
    {
        $path = storage_path('app/public/images/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function AddPlanets()
    {
        $response = PolyanetsJob::dispatch('post');

        if($response ){
            return redirect()->route('home')->with('message', ['type' => 'success', 'text' => '¡Planets Added Successfully!', 'dismissible' => true]);
        }else{
            return redirect()->route('home')->with('message', ['type' => 'error', 'text' => 'There was an error :(', 'dismissible' => true]);
        }
        
    }
    
    public function RemovePlanets()
    {
        $response = PolyanetsJob::dispatch('delete');

        if($response ){
            return redirect()->route('home')->with('message', ['type' => 'success', 'text' => '¡Planets Deleted Successfully!', 'dismissible' => true]);
        }else{
            return redirect()->route('home')->with('message', ['type' => 'error', 'text' => 'There was an error :(', 'dismissible' => true]);
        }
    }

    public function AddPlanetsMoonsAndComets()
    {
        $response = PolyanetsSoloonsAndComeths::dispatch('post');

        if($response ){
            return redirect()->route('home')->with('message', ['type' => 'success', 'text' => '¡Planets, Moons and Comets Added Successfully!', 'dismissible' => true]);
        }else{
            return redirect()->route('home')->with('message', ['type' => 'error', 'text' => 'There was an error :(', 'dismissible' => true]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function RemovePlanetsMoonsAndComets()
    {
        $response = PolyanetsSoloonsAndComeths::dispatch('delete');

        if($response ){
            return redirect()->route('home')->with('message', ['type' => 'success', 'text' => '¡Planets, Moons and Comets Deleted Successfully!', 'dismissible' => true]);
        }else{
            return redirect()->route('home')->with('message', ['type' => 'error', 'text' => 'There was an error :(', 'dismissible' => true]);
        }
    }


}
