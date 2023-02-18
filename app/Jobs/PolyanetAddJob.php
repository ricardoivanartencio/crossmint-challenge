<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

use App\Helpers\CrossmintConnectionHelper;

class PolyanetAddJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $method;

    public function __construct($method)
    {
        $this->method = $method;
    }

    public function handle(): void
    {
        require_once app_path('Helpers/CrossmintConnectionHelper.php');

        try {
            $endpoint = config('app.crossmint_endpoint');

            $candidateId = '57b79d58-a3cc-47fd-86eb-0ac7ea00c3dc';
            $initial = 2;
            $final = 8;

            $planets_coordinates = [];
            
            while($initial <= 8){

                $planets_coordinates[] = [
                    'row' => $initial,
                    'column' => $initial,
                ];

                $planets_coordinates[] = [
                    'row' => $final,
                    'column' => $initial,
                ];

                $initial++;
                $final--;
            }

            //since the api does support a post with an array as row or/and column value i had to make indivitual requests per planet

            foreach ($planets_coordinates as $planet) {
                $response = crossmintConection($this->method, $endpoint, $candidateId, $planet);

                sleep(1);//pause for caution 

                if($response->status() == 200){
                    Log::info('Planet with coordinates: '. $planet['row'].' - '. $planet['column'].' added succesfully!');
                }else{
                    Log::error('Planet with coordinates: '. $planet['row'].' - '. $planet['column'].' could not be added.');
                }
            }

            dd('Final');

        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }
}
