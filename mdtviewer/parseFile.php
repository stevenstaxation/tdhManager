<?php
session_start();
require "endianBinaryReader.php";
require "classes.php";


$fileName =  $_SESSION['filePath'];


$file = fopen($fileName, "rb") or die("Unable to open file");

// PARSE FILE HEADER //
$fileHeader = [];
$fileHeader += ['identifier' => readUINT32($file,false)];
$fileHeader += ['version' => readUByte($file,false)];
fseek($file,8);
$fileHeader += ['dateTime' => date('D j M Y G:i:s',readUINT32($file,false))];

$tZ = readSINT32($file, false);
if ($tZ > 0) {
    $timeZone = 'UTC +' .$tZ/60;
} elseif ($tZ < 0) {
    $timeZone = 'UTC -' .$tZ/60;
} else {
    $timeZone = 'UTC';
}
$fileHeader += ['timeZone' => $timeZone];

$daylightSaving = 'Off';
if (readUByte($file,false)!=0) {
    $daylightSaving = 'On';
}
$fileHeader += ['daylightSaving' => $daylightSaving];

if ($fileHeader['daylightSaving']=='On') {
    $timeZone = str_replace("DST", "UTC", $timeZone);
}

fseek($file,0x16);
$fileHeader += ['extension' => readString($file,false,3)];

// CONFIRM FILE EXTENSION EXPECTED TO BE MDT AND SIGNATURE IS CORRECT - IF NOT EXIT HERE            
if (strtoupper(dechex($fileHeader['identifier'])) != "F2EF00AA" || strtoupper($fileHeader['extension'])!='MDT') {
    echo "<div class='alert alert-danger'>This file is not a valid  MDT file</alert>";
    exit();
}

// PARSE MDT HEADER
fseek($file,0x24);
$MDTHeader = [];
$MDTHeader += ['identifier' => readUINT32($file,false)];
if (strtoupper(dechex($MDTHeader['identifier'])) != "E2EF00AA") {
       echo "<div class='alert alert-danger'>This file is not a valid  MDT file</alert>";
    exit();
}
fseek($file,0x30);
$MDTHeader += ['VRN' => readString($file,false,60)];
$MDTHeader += ['Driver ID' => readString($file,false,60)];
$MDTHeader += ['Channels' => readUByte($file, false)];

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class='container'>
    <div id = 'headerBar' style='background-color: lightgrey; margin-top: 15px;'>
        <div class='row'>
            <div class='col-md-3'><?php echo "<strong>VRN: </strong>" . $MDTHeader['VRN'];?></div> 
            <div class='col-md-6'><?php echo "<strong>FILE TIME: </strong>" . $fileHeader['dateTime'] . " " . $fileHeader['timeZone'];?></div> 
            <div class='col-md-3'><?php echo "<strong>CHANNELS: </strong>" . $MDTHeader['Channels'];?></div> 
        </div>
    </div>
</div>    

<?php
// PARSE CHANNEL PARAMETERS
$channelParameters = [];
fseek($file, 0xAA);
for ($ch = 1; $ch <= $MDTHeader['Channels']; $ch++) {
    $channelParameter = [];
    $channelParameter += ['Width' => readUINT16($file,false)];
    $channelParameter += ['Height' => readUINT16($file,false)];
    $channelParameter += ['Bitrate' => (readUINT32($file,false)/pow(1024,2)) ."Mbps"];
    $channelParameter += ['Recording' => readUByte($file,false)];
    $channelParameter += ['Codec' => readUByte($file,false)];
    $channelParameter += ['FPS' => readUByte($file,false)];
    $throwaway = readUByte($file,false);  // throw away reserved byte
    $channelParameter += ['Position' => ftell($file)];
    $channelParameters[$ch] = $channelParameter;
}
$throwaway = readUINT16($file,false);
$throwaway = readUINT16($file,false);

$throwaway = readString($file,false,0x60 - $MDTHeader['Channels']*12);

// PARSE FIRST FRAMEINFO
$throwaway = readUINT32($file,false);
$throwaway = readUByte($file,false);
$throwaway = readUByte($file,false);
$throwaway = readUINT16($file,false);
$throwaway = readUByte($file,false);
$streamStart = readUINT32($file,false);
$streamSize = readUINT32($file,false);
fseek($file, $streamStart);

for ($ch = 1; $ch <= $MDTHeader['Channels']; $ch++) {
    $channelParameters[$ch] += ['CameraName' => readString($file,false,64)];
}

$frames = [];

fseek($file, $streamStart + $streamSize);

while (true) { 
    $frame = new FrameInfo;
    $frame->frameIdentifier = readUINT32($file,false);
 
    if (strtoupper(dechex($frame->frameIdentifier)) != "E1EF00AA")    {
        break;
    }

    $throwaway = readUINT32($file,false); // this is two bytes and a word
    $frame->streamCodec = readUByte($file,false);
    $frame->streamOffset = readUINT32($file,false);
    $frame->streamSize = readUINT32($file,false);
    $frame->streamDateTime = readUINT32($file,false);
    $frame->streamTimeZone = readUINT16($file,false);
    $frame->streamDaylightSaving = readUByte($file,false);
    $throwaway = readString($file,false,11); // 1 byte, 1 word and 2 longs
    $frame->AVCodec = readUByte($file,false);
    $frame->AVChannel = readUByte($file,false);
    $frame->AVFrameType = readUByte($file,false);
    $frame->AVWidth = readUINT16($file,false);
    $frame->AVHeight = readUINT16($file,false);
    $frame->AVRecordType = readUINT16($file,false);
    $frame->AVRecordAudio = readUByte($file,false);
    $frame->GPSSignal = readSByte($file,false);
    $frame->GPSLatitude = readDouble($file,false);
    $frame->GPSLongitude = readDouble($file,false);
    $frame->GPSSpeed = readUINT16($file,false);
    $frame->GPSAltitude = readUINT16($file,false);
    $frame->GPSHeading = readUINT16($file,false);
    $frame->GPSYear = readUINT16($file,false);
    $frame->GPSMonth = readUINT32($file,false);
    $frame->GPSDay = readUINT16($file,false);
    $frame->GPSHour = readUINT16($file,false);
    $frame->GPSMin = readUINT16($file,false);
    $frame->GPSSec = readUINT16($file,false);
    $frame->GPSMilliSec = readUINT16($file,false);
    $frame->gSensorX = readSINT16($file,false)/1000;
    $frame->gSensorY = readSINT16($file,false)/1000;
    $frame->gSensorZ = (readSINT16($file,false)-1000)/1000;
    $frame->frameEventType = readUINT16($file,false);
    $frame->frameMotionChannel = readUINT16($file,false);
    $frame->frameCarSignal = readUByte($file,false);
    $frame->frameCarPulse = readUINT16($file,false);
    $frame->frameAlarmIn = readUINT16($file,false);
    $frame->frameAlarmOut = readUINT16($file,false);
    $frame->frameExtDataType = readUByte($file,false);
    $frame->frameGSensorNumber = readUByte($file,false);
    $frame->frameLossChannels = readUINT16($file,false);
    $frame->frameRPM = readUINT16($file,false);
    $frame->frameEventInfo = readUINT16($file,false);
    $frame->frameDataType = readUByte($file,false);
    $throwaway = readString($file,false,7); // 1 byte + 3 words
    array_push($frames, $frame);
    fseek($file,ftell($file) + $frame->streamSize);
}


file_put_contents('filename.txt', print_r($frames,true));

$speedItems = [];
$sensorItems = [];
$locations = [];
$labelsList = "";
$sensorLabel = "";
$dataList = "";
$dataListK = "";
$sensorListX = "";
$sensorListY = "";
$sensorListZ = "";
$coordinateList = "";

foreach ($frames as $frameItem) {
    if ($frameItem->AVChannel == 1) {
        $speedItem = new SpeedFrame;
        $sensorItem = new SensorItem;
        $location = new GPSNode;
        
        $speedItem->rDate = $frameItem->GPSYear . '-' . $frameItem->GPSMonth . '-' . $frameItem->GPSDay;
        $sensorItem->rDate = $speedItem->rDate;
        $speedItem->rTime = sprintf('%02d', $frameItem->GPSHour) . ':' . sprintf('%02d', $frameItem->GPSMin) . ':' . sprintf('%02d', $frameItem->GPSSec);
        $sensorItem->rTime = $speedItem->rTime;
        $speedItem->speedKMH = $frameItem->GPSSpeed;
        $speedItem->speedMPH = $speedItem->speedKMH/1.609;
        $labelsList .= "'" . $speedItem->rTime . "', ";
        $sensorLabel .= "'" . $sensorItem->rTime . "', ";
        $dataList .= $speedItem->speedMPH . ", ";
        $dataListK .= $speedItem->speedKMH . ", ";
        
        array_push($speedItems, $speedItem);
    
        $sensorItem->X = $frameItem->gSensorX;
        $sensorListX .= $sensorItem->X . ", ";
        $sensorItem->Y = $frameItem->gSensorY;
        $sensorListY .= $sensorItem->Y . ", ";
        $sensorItem->Z = $frameItem->gSensorZ;
        $sensorListZ .= $sensorItem->Z . ", ";
        array_push($sensorItems, $sensorItem);

        $location->Latitude = convertCoord($frameItem->GPSLatitude);
        $location->Longitude = convertCoord($frameItem->GPSLongitude);
        $location->Speed = $frameItem->GPSSpeed;
        $location->Altitude = $frameItem->GPSAltitude;
        $location->gDate = $speedItem->rDate;
        $location->gTime = $speedItem->rTime;
        array_push($locations, $location);
       
        if ($location->Latitude !=0) {
            $coordinateList .= " { lat: " .$location->Latitude . ", lng: " . $location->Longitude ." },";
            $oldLatitude = $location->Latitude;
            $oldLongitude = $location->Longitude;
        } else {
            $coordinateList .= " { lat: " .$oldLatitude . ", lng: " . $oldLongitude ." },";
        }
        

    }
}
$labelsList = substr($labelsList,0,-1);
$dataList = substr ($dataList,0,-1);
$dataListK = substr ($dataListK,0,-1);
$sensorLabel = substr($sensorLabel,0,-1);
$sensorListX = substr($sensorListX,0,-1);
$sensorListY = substr($sensorListY,0,-1);
$sensorListZ = substr($sensorListZ,0,-1);
$coordinateList = substr($coordinateList,0,-1);
$startLatitude = $locations[0]->Latitude;
$startLongitude = $locations[0]->Longitude;
$endLatitude = $locations[array_key_last($locations)]->Latitude;
$endLongitude = $locations[array_key_last($locations)]->Longitude;

if ($MDTHeader['Channels']==1) {
  
    echo "
    <div class=container-fluid'>
        <div class='row'>
            <div class='col-12 border bg-light'>" .
            $channelParameters[1]['CameraName'] ." [". $channelParameters[1]['Width'] . " x " . $channelParameters[1]['Height'] ."]
            </div>
        </div>
        <div class='row'>
            <div id='showMap' class='col-4 border'>
            MAPS
            </div>
            <div class='col-4 border'>
            SPEED GRAPH
            </div>
            <div class='col-4 border'>
            G SENSOR
            </div>
        </div>        
    </div>       
    ";
} elseif ($MDTHeader['Channels']==4) {  
      
    echo "
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-lg-12 border'>
                <div class='row'>
                    <div class='col-lg-6 border'>" .
                    $channelParameters[1]['CameraName'] ." [". $channelParameters[1]['Width'] . " x " . $channelParameters[1]['Height'] ."]
                    </div>
                    <div class='col-lg-6 border'>" .
                    $channelParameters[4]['CameraName'] ." [". $channelParameters[4]['Width'] . " x " . $channelParameters[4]['Height'] ."]
                    </div>
                </div>
                <div class='row'>
                    <div class='col-lg-6 border'>" .
                    $channelParameters[3]['CameraName'] ." [". $channelParameters[3]['Width'] . " x " . $channelParameters[3]['Height'] ."]
                    </div>
                    <div class='col-lg-6 border'>" .
                    $channelParameters[2]['CameraName'] ." [". $channelParameters[2]['Width'] . " x " . $channelParameters[2]['Height'] ."]
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div id='showMap' class='col-lg-12 border' style='width: 100%; height: 600px;'>
           
            </div>
            <div class='col-lg-12 border'>
                <div class='card'>
                    <div class='card-body'>
                        <canvas id='speedLine'></canvas>
                    </div>
                </div>
            </div>
            <div class='col-lg-12 border'>
                <div class='card'>
                    <div class='card-body'>
                        <canvas id='sensorLine'></canvas>
                    </div>
                </div>
            </div>
        </div>        
    </div> 
    
    <script>
    var ctx = document.getElementById('speedLine').getContext('2d');
    var chart = new Chart(ctx, {

    type: 'line',

    // The data for our dataset
    data: {
        labels: [" . $labelsList . "],
        datasets: [{
            label: 'mph',
            backgroundColor: 'rgba(255,255,255,0)',
            borderColor: 'rgb(255, 51, 255)',
            borderWidth: 1,
            spanGaps: true,
            pointRadius: 0,
            data: [" . $dataList ."]
        }, {
            label: 'kph',
            backgroundColor: 'rgba(255,255,255,0)',
            borderColor: 'rgb(255, 192, 0)',
            borderWidth: 1,
            spanGaps: true,
            pointRadius: 0,
            data: [" . $dataListK ."]
        }]
    },

    // Configuration options go here
    options: {
        title: {
            display: true,
            text: 'Speed'
        }, 
        legend: {
            display: true,
            labels: {
                boxWidth: 1
            }
        }
    }
});
    
    
    
     var ctx = document.getElementById('sensorLine').getContext('2d');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: [" . $sensorLabel . "],
        datasets: [{
            label: 'G Sensor X Axis',
            backgroundColor: 'rgba(255,255,255,0)',
            borderColor: 'rgb(255, 0, 0)',
            borderWidth: 1,
            spanGaps: true,
            pointRadius: 0,
            data: [" . $sensorListX ."]
        }, {
            label: 'G Sensor Y Axis',
            backgroundColor: 'rgba(255,255,255,0)',
            borderColor: 'rgb(0, 255, 0)',
            borderWidth: 1,
            spanGaps: true,
            pointRadius: 0,
            data: [" . $sensorListY ."]
        }, {
            label: 'G Sensor Z Axis',
            backgroundColor: 'rgba(255,255,255,0)',
            borderColor: 'rgb(0,0,255)',
            borderWidth: 1,
            spanGaps: true,
            pointRadius: 0,
            data: [" . $sensorListZ ."]
        }]
    },

    // Configuration options go here
    options: {
        title: {
            display: true,
            text: 'Sensor (G)'
        },
        legend: {
            display: true,
            labels: {
                boxWidth: 1
            }
        }
    }
});
    
  
    </script>

<script>
 
      function initMap() {
 
        const startPosition = { lat: " . $startLatitude .", lng: " . $startLongitude . " };
        const endPosition = { lat: " . $endLatitude .", lng: " . $endLongitude . " };
        
        const map = new google.maps.Map(document.getElementById('showMap'), {
          zoom:17,
          center: startPosition,
          mapTypeId: 'terrain',
        });
 
        const markerList = [" . $coordinateList ."];
        
        const drivePath =  new google.maps.Polyline({
                path: markerList,
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 2,
        });
        
        const starter = new google.maps.Marker ({
            position: startPosition,
            label: 'A',
            title: 'Start Position',
        });

        const ending = new google.maps.Marker ({
            position: endPosition,
            label: 'B',
            title: 'End Position',
        });

        drivePath.setMap(map);  
        starter.setMap(map);
        ending.setMap(map);
        collapseUploadPanel();
    }

</script>
<script
    src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCQlUacjtHeF3VVfxNlk4A1Vk6msHooHFo&callback=initMap&libraries=&v=weekly' async>
    </script>


    ";
}


function convertCoord($MDTCoordinate) {
    $deg = intval($MDTCoordinate/100);
    $frac = $MDTCoordinate - ($deg * 100);
    $frac = $frac/60;

    return $deg + $frac;
}

?>