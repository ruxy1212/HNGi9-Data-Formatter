<?php 
$team_name = "Team X";
$template_json = file_get_contents('template.json');

//create folders for each json and output
$path = 'all_json'; $out = 'output';
checkDir($path); checkDir($out);
function checkDir($dir){
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

if($_FILES['csv']['error'] == 0){
    $name = $_FILES['csv']['name'];
    $ext = pathinfo($_FILES['csv']['name'], PATHINFO_EXTENSION);
    $type = $_FILES['csv']['type'];
    $csvf = $_FILES['csv']['tmp_name'];
    $csvr = $out.'/'.pathinfo($_FILES['csv']['name'], PATHINFO_FILENAME).'.output.csv';

    // check the file is a csv
    if($ext === 'csv'){    
        //Open input csv and output csv files     
        $csv = fopen($csvf, "r");
        $cvv = fopen($csvr, 'w');
    
        $header = true;
        while (($data = fgetcsv($csv)) !== FALSE) {
            //check if it is heading
            if($header) { $header = false; $data[8] = "Hash"; }
            else{
                if(!empty($data[0])){ 
                    //get team name if column1(index0) is not empty
                    $team_name = $data[0];
                }
                //get other column details
                $decoded_json = json_decode($template_json, true); 
                $decoded_json['minting_tool'] = $team_name;
                $decoded_json['name'] = $data[2];           
                $decoded_json['description'] = $data[4];
                $decoded_json['series_number'] = (int)$data[1];
                $decoded_json['series_total'] = 420;
                $decoded_json['attributes'][0]['value'] = $data[5];

                $attributes = []; //convert string to array
                foreach (preg_split('/[;]/', $data[6]) as $attribute){
                    $parts = explode(':', $attribute);
                    $attributes[trim($parts[0])] = trim($parts[1]); //trim the beginning and trailing whitespaces
                }
                if(!empty($attributes)){ //assign the values
                    array_change_key_case($attributes, CASE_LOWER);
                    $decoded_json['attributes'][1]['value'] = $attributes['hair'];
                    $decoded_json['attributes'][2]['value'] = $attributes['eyes'];
                    $decoded_json['attributes'][3]['value'] = $attributes['teeth']; 
                    $decoded_json['attributes'][4]['value'] = $attributes['clothing'];
                    $decoded_json['attributes'][5]['value'] = $attributes['accessories'];
                    $decoded_json['attributes'][6]['value'] = $attributes['expression'];
                    $decoded_json['attributes'][7]['value'] = $attributes['strength'];
                    $decoded_json['attributes'][8]['value'] = $attributes['weakness'];                     
                }
                $encoded_json = json_encode($decoded_json, JSON_PRETTY_PRINT|JSON_PRESERVE_ZERO_FRACTION);
                $data[8] = $hashed_json = hash('sha256', $encoded_json);               
               
                //create JSON for the row
                $export_file = $decoded_json['name'].".json";
                file_put_contents($path.'/'.$export_file, $encoded_json);
            }
            //insert row into output csv
            fputcsv($cvv, $data);  
        }
        //close both CSVs
        fclose($csv);
        fclose($cvv);
        echo "Done!";
    }else{
        echo "This isn't a CSV!";
    }
}else{
    echo "Error occured!";
}

?>