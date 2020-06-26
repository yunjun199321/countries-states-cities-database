<?php
/*
    1. load csv file
    2. form associate array
    3. output it to txt file
*/

function main () {

    // load data
    $country_file = fopen("../csv/countries.csv", "r");
    $city_file = fopen("../csv/cities.csv", "r");
    $country_arr = array();
    $city_arr = array();
    $country_city_arr = array();

    $count = 0;
    while (!feof($country_file)) {
        // ignore first line
        $count++;
        if ($count == 1) continue;

        $arr = fgetcsv($country_file);
        $country_arr[$arr[3]] = $arr[1];
    }

    $count2 = 0;
    while (!feof($city_file)) {
        $count2++;
        if ($count2 == 1) continue;

        $arr = fgetcsv($city_file);
        $city_arr[$arr[5]][] = $arr[1];
    }

    fclose($country_file);
    fclose($city_file);

    // combine arr
    foreach ($country_arr as $code => $name) {
        if (array_key_exists($code, $city_arr)) {
            $country_city_arr[$country_arr[$code]] = implode("//", $city_arr[$code]);
        } else {
            $country_city_arr[$country_arr[$code]] = $country_arr[$code];
        }
    }

    file_put_contents("../text/central_list_of_countries_and_cities.php", "<?php" . PHP_EOL, FILE_APPEND);
    file_put_contents("../text/central_list_of_countries_and_cities.php", var_export($country_city_arr, true), FILE_APPEND);
    file_put_contents("../text/central_list_of_countries_and_cities.php", ";", FILE_APPEND);
}

main();