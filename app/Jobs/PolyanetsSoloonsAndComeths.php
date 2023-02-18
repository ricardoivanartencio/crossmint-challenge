<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;

class PolyanetsSoloonsAndComeths implements ShouldQueue
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

            $candidateId = config('app.candidate_id');

            $response = crossmintGoalMap($endpoint, $candidateId)->body();//getting the map so i can scan where i have to put each object

            $response_decoded = json_decode($response, true);

            $complete_data = [];

            foreach ($response_decoded['goal'] as $row => $rows) {//with this logic i split the rows and then the columns and then i read what is inside of each one
                foreach ($rows as $column => $object) {
                    
                    if($object != 'SPACE'){//i eliminate all the space
                        $lower_case_object = strtolower($object);
                        
                        if(str_contains($lower_case_object, "_")){//if contains "_" means that is a moon or a comet
                            $splited_object = explode('_', $lower_case_object);
                            
                            if($splited_object[1] == 'soloon'){
                                $complete_data['soloons'][] = [
                                    'row' => $row,
                                    'column' => $column,
                                    'color' => $splited_object[0]
                                ];
                            }else if($splited_object[1] == 'cometh'){
                                $complete_data['comeths'][] = [
                                    'row' => $row,
                                    'column' => $column,
                                    'direction' => $splited_object[0]
                                ];
                            }
                        }else{//else is a planet
                            $complete_data['polyanets'][] = [
                                'row' => $row,
                                'column' => $column,
                            ];
                        }

                    }
                }
            }

            //now i have 1 variable with 3 arrays with the name in the index, inside of each one there are one by one the coordinates of the object that i have to put in the megaverse

            foreach ($complete_data as $object_name => $objects) {//here i divide the complete data so i can take the object_name and use it as an identificator to send each one of the rows through the http post 
                foreach ($objects as $object) {

                    $response = crossmintConection($this->method, $endpoint, $candidateId, $object, $object_name);
        
                    sleep(1);//pause for caution
        
                    if($response['status'] == 200){
                        Log::info($response['message'] . 'was successful!');
                    }else{
                        Log::error($response['message'] . 'failed.');
                    }

                }
            }
            
            Log::info('Process ended!');

        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }
}
