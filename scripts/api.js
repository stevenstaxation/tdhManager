// Globals
var authKey;
var token;
var customerID;
const apiVersion = "v2";

// Global Code
authenticate("Dhinstall@thedatahub.uk", "Tdhmanager27");
// authenticate("support@thedatahub.uk", "Dontforget27");

setTimeout(() => {
  data = JSON.parse(authKey).data;
  token = data.token;
  customerID = data.organizationId;
}, 500);

//##########################################

function authenticate(email, password) {
  const auth = {
    email: email,
    password: password,
  };

  let xhr = new XMLHttpRequest();
  xhr.withCredentials = true;
  xhr.open("POST", `https://api.de.surfsight.net/${apiVersion}/authenticate`);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onload = function () {
    if (xhr.status == 200) {
      authKey = xhr.response;
    } else {
      console.log("INVALID LOG IN");
    }
  };

  xhr.send(JSON.stringify(auth));
}

// GET EVENT LIST
//
async function getEventList(
  imei = "357660103015277",
  startdate = new Date().toISOString(),
  enddate = new Date().toISOString()
  // count = 10
) {
  const query = new URLSearchParams({
    start: `${startdate}`,
    end: `${enddate}`,
    // limit: `${count}`,
  }).toString();

  const resp = await fetch(
    `https://api.de.surfsight.net/${apiVersion}/devices/${imei}/events?${query}`,
    {
      method: "GET",
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
  );

  return await resp.text();
}

async function getAddressByCoords(latitude, longitude, eventArray) {
  const address_url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&sensor=false&key=AIzaSyAVW9tbTr9ILP5uL8RXuBrZ5AOvSGe8LwA`;
  let res = await fetch(address_url);
  ret = await res.text();

  let location = JSON.parse(ret);
  if (location["status"] != "ZERO_RESULTS") {
    eventArray.location = location["results"][0]["formatted_address"];
  } else {
    eventArray.location = "N/A";
  }

  return await eventArray;
}

// async function file_get_contents(uri) {
//   let res = await fetch(uri),
async function file_get_contents(uri) {
  let res = await fetch(uri),
    ret = res.text();
  return await ret;
}
