<?php
//session_start();
// ********************************
// ENDIAN BINARY READER FUNCTIONS *
// ********************************

function readUByte($Handle, $BigEndian = false) {
 
    if ($BigEndian == false) {
            $byte0 = unpack("C*",fread($Handle,1));
    } else {
            $byte0 = unpack("C*",fread($Handle,1));  
    }
    
     return $byte0[1];
}

function readSByte($Handle, $BigEndian = false) {
 
    if ($BigEndian == false) {
            $byte0 = unpack("c*",fread($Handle,1));
    } else {
            $byte0 = unpack("c*",fread($Handle,1));  
    }
    
     return $byte0[1];
}

function readUINT16($Handle, $BigEndian = false) {
 
    if ($BigEndian == false) {
            $byte0 = unpack("v*",fread($Handle,2));
    } else {
            $byte0 = unpack("n*",fread($Handle,2));  
    }
    
     return $byte0[1];
}

function readSINT16($Handle, $BigEndian = false) {
 
    if ($BigEndian == false) {
            $byte0 = unpack("s*",fread($Handle,2));
    } else {
            $byte0 = unpack("s*",fread($Handle,2));  
    }
    
     return $byte0[1];
}

function readUINT32($Handle, $BigEndian = false) {
 
    if ($BigEndian == false) {
            $byte0 = unpack("V*",fread($Handle,4));
    } else {
            $byte0 = unpack("N*",fread($Handle,4));  
    }
    
     return $byte0[1];
}

function readSINT32($Handle, $BigEndian = false) {

    if ($BigEndian == false) {
            $byte1 = unpack("l*",fread($Handle,4));
    } else {
            $byte0 = unpack("l*",fread($Handle,4));  
            $byte1 = switchEndian($byte0[1]);
    }    

        return $byte1[1];
  }

function readDouble($Handle, $BigEndian = false) {
 
    if ($BigEndian == false) {
            $byte0 = unpack("e*",fread($Handle,8));
    } else {
            $byte0 = unpack("E*",fread($Handle,8));  
    }
    
     return $byte0[1];
}


// read string pointed to by $Offset
function readString($Handle, $BigEndian = false, $Length) {
    $byte0 = unpack("A*", fread($Handle,$Length));
    $byte0[1] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $byte0[1]);
    return $byte0[1];    
}

function switchEndian($UINT32, $sFormat='L', $dFormat='N') {
    $UINT32 = intval($UINT32, 16);
    $UINT32 = pack($sFormat, $UINT32);
    $UINT32 = unpack($dFormat, $UINT32);
    return $UINT32;
}



?>
