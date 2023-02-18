<?php

function crossmintGoalMap($endpoint, $candidateId){
    $response = Http::get($endpoint . '/map/' . $candidateId . '/goal');

    return $response;
}

function crossmintConection($method, $endpoint, $candidateId, $data, $object){ 

    $params = [
        'candidateId' => $candidateId,
        'row' => $data['row'],
        'column' => $data['column'],
    ];

    if($object == 'soloons'){
        $params['color'] = $data['color'];
    }else  if($object == 'comeths'){
        $params['direction'] = $data['direction'];
    }

    if($method == 'post'){

        $response = Http::post($endpoint.'/'.$object, $params);

        $message = ucfirst($object).' with coordinates: '. $data['row'].' - '. $data['column'].' addition ';

    }elseif($method == 'delete'){
        
        $response = Http::delete($endpoint.'/'.$object, $params);

        $message = ucfirst($object).' with coordinates: '. $data['row'].' - '. $data['column'].' deletion ';

    }else{
        return [
            'status' => 405, 
            'response' => 'Method Not Allowed'
        ];
    }

    return [
        'status' => $response->status(),
        'message' => $message
    ];
}