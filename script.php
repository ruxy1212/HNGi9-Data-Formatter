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
            if($header) { $header = false; $data[7] = "Hash"; }
            else{
                if(empty($data[0])){ } //row is empty, do nothing
                else if (!is_numeric($data[0]) && $data[1] == "" && $data[2] == "" && $data[3] == "" && $data[4] == "") {
                    //get team name if column1(index0) is not numeric
                    $team_name = $data[0];
                }else{
                    //get other column details
                    $decoded_json = json_decode($template_json, true); 
                    $decoded_json['minting_tool'] = $team_name;
                    $decoded_json['name'] = $data[1];           
                    $decoded_json['description'] = $data[3];
                    $decoded_json['series_number'] = $data[0];
                    $decoded_json['series_total'] = 420;
                    $decoded_json['attributes'][0]['value'] = $data[4];
                    $encoded_json = json_encode($decoded_json, JSON_PRETTY_PRINT|JSON_PRESERVE_ZERO_FRACTION);
                    $data[7] = $hashed_json = hash('sha256', $encoded_json);

                    //create JSON for the row
                    $export_file = $decoded_json['name'].".json";
                    file_put_contents($path.'/'.$export_file, $encoded_json);
                }
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