<?php


class FrameInfo
{
    public $frameIdentifier;
    public $streamCodec;
    public $streamOffset;
    public $streamSize;
    public $streamDateTime;
    public $streamTimeZone;
    public $streamDaylightSaving;
    public $AVCodec;
    public $AVChannel;
    public $AVFrameType;
    public $AVWidth;
    public $AVHeight;
    public $AVRecordType;
    public $AVRecordAudio;
    public $GPSSignal;
    public $GPSLatitude;
    public $GPSLongitude;
    public $GPSSpeed;
    public $GPSAltitude;
    public $GPSHeading;
    public $GPSYear;
    public $GPSMonth;
    public $GPSDay;
    public $GPSHour;
    public $GPSMin;
    public $GPSSec;
    public $GPSMilliSec;
    public $gSensorX;
    public $gSensorY;
    public $gSensorZ;
    public $frameEventType;
    public $frameMotionChannel;
    public $frameCarSignal;
    public $frameCarPulse;
    public $frameAlarmIn;
    public $frameAlarmOut;
    public $frameExtDataType;
    public $frameGSensorNumber;
    public $frameLossChannels;
    public $frameRPM;
    public $frameEventInfo;
    public $frameDataType;
}

class SpeedFrame 
{
    public $rDate;
    public $rTime;
    public $speedKMH;
    public $speedMPH;
}

class SensorItem {
    public $rDate;
    public $rTime;
    public $X;
    public $Y;
    public $Z;
}

class GPSNode {
    public $Latitude;
    public $Longitude;
    public $Speed;
    public $Altitude;
    public $gDate;
    public $gTime;
}


?>