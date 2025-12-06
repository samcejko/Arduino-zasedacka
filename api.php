<?php
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Europe/Prague'); // TODO: Change timezone if needed

function ceskyToAscii($text)
{
    $prevodni_tabulka = array(
        'ä' => 'a',
        'Ä' => 'A',
        'á' => 'a',
        'Á' => 'A',
        'à' => 'a',
        'À' => 'A',
        'ã' => 'a',
        'Ã' => 'A',
        'â' => 'a',
        'Â' => 'A',
        'č' => 'c',
        'Č' => 'C',
        'ć' => 'c',
        'Ć' => 'C',
        'ď' => 'd',
        'Ď' => 'D',
        'ě' => 'e',
        'Ě' => 'E',
        'é' => 'e',
        'É' => 'E',
        'ë' => 'e',
        'Ë' => 'E',
        'è' => 'e',
        'È' => 'E',
        'ê' => 'e',
        'Ê' => 'E',
        'í' => 'i',
        'Í' => 'I',
        'ï' => 'i',
        'Ï' => 'I',
        'ì' => 'i',
        'Ì' => 'I',
        'î' => 'i',
        'Î' => 'I',
        'ľ' => 'l',
        'Ľ' => 'L',
        'ĺ' => 'l',
        'Ĺ' => 'L',
        'ń' => 'n',
        'Ń' => 'N',
        'ň' => 'n',
        'Ň' => 'N',
        'ñ' => 'n',
        'Ñ' => 'N',
        'ó' => 'o',
        'Ó' => 'O',
        'ö' => 'o',
        'Ö' => 'O',
        'ô' => 'o',
        'Ô' => 'O',
        'ò' => 'o',
        'Ò' => 'O',
        'õ' => 'o',
        'Õ' => 'O',
        'ő' => 'o',
        'Ő' => 'O',
        'ř' => 'r',
        'Ř' => 'R',
        'ŕ' => 'r',
        'Ŕ' => 'R',
        'š' => 's',
        'Š' => 'S',
        'ś' => 's',
        'Ś' => 'S',
        'ť' => 't',
        'Ť' => 'T',
        'ú' => 'u',
        'Ú' => 'U',
        'ů' => 'u',
        'Ů' => 'U',
        'ü' => 'u',
        'Ü' => 'U',
        'ù' => 'u',
        'Ù' => 'U',
        'ũ' => 'u',
        'Ũ' => 'U',
        'û' => 'u',
        'Û' => 'U',
        'ý' => 'y',
        'Ý' => 'Y',
        'ž' => 'z',
        'Ž' => 'Z',
        'ź' => 'z',
        'Ź' => 'Z'
    );
    return strtr($text, $prevodni_tabulka);
}

$response = [
    "stav" => "VOLNO",
    "kdo" => "",
    "do_kdy" => "",
    "dalsi_kdo" => "",
    "dalsi_start" => "",
    "cas_ted" => date("d.m. H:i") // ZMĚNA ZDE
];

$file = 'events.json';
if (file_exists($file)) {
    $events = json_decode(file_get_contents($file), true);
    $now = time();

    if (is_array($events)) {
        usort($events, function ($a, $b) {
            return strtotime($a['start']) - strtotime($b['start']);
        });

        foreach ($events as $event) {
            $start = strtotime($event['start']);
            $end = strtotime($event['end']);

            if ($now >= $start && $now < $end) {
                $response["stav"] = "OBSAZENO";
                $response["kdo"] = ceskyToAscii($event['title']);
                // Zkusíme najít organizátora, pokud není, necháme prázdné
                $response["organizator"] = isset($event['organizer']) ? ceskyToAscii($event['organizer']) : "";
                $response["do_kdy"] = "do " . date("H:i", $end);
            }

            if ($start > $now && $response["dalsi_start"] == "") {
                $response["dalsi_kdo"] = ceskyToAscii($event['title']);
                $response["dalsi_start"] = date("H:i j.n.", $start);
            }
        }
    }
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>