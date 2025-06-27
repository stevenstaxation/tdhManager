async function loadWebhooks() {
  const res = await fetch(
    "https://tdhwebhook.azurewebsites.net/api/tdhwebhook?code=c1GR8YeMDfYWunnrsHvzcoN-vT7Xmeis1aJqi9A6gGliAzFuty042A=="
  );
  const data = await res.json();
  //   const list = document.querySelector("#cameraList");
  console.log(data);

  // list.innerHTML = "";
  // data.forEach((item) => {
  //   let cameraRow = `
  //     <tr>
  //         <td>DHInstall</td>
  //         <td>Dunno Yet</td>
  //         <td>${JSON.stringify(item.payload.data.serialNumber).replaceAll(
  //           '"',
  //           ""
  //         )}</td>
  //         <td><span class='badge bg-success'>${JSON.stringify(
  //           item.payload.data.eventType
  //         ).replaceAll('"', "")}</span></td>
  //         <td>
  //             ${new Date(
  //               JSON.stringify(item.payload.data.time) * 1000
  //             ).toLocaleDateString()} ${new Date(
  //     JSON.stringify(item.payload.data.time) * 1000
  //   ).toLocaleTimeString()}
  //         </td>
  //          <td>${JSON.stringify(item.payload.data.lat).replace(
  //            '"',
  //            ""
  //          )}</td>
  //          <td>${JSON.stringify(item.payload.data.lon).replace(
  //            '"',
  //            ""
  //          )}</td>

  //     </tr>`;

  //   list.insertAdjacentHTML("beforeend", cameraRow);
  // });
}

async function dismiss(id) {
  await fetch(`../${id}`, { method: "DELETE" });
  loadWebhooks();
}

loadWebhooks();
setInterval(loadWebhooks, 20000); // refresh every 20s

//   ##############################
// event listeners
// document.querySelector("#getEvent").addEventListener("click", showEventList);

// Globals
// var authKey;
// var token;
// var customerID;
// const apiVersion = "v2";

// Global Code
// authenticate("Dhinstall@thedatahub.uk", "Tdhmanager27");
// authenticate("support@thedatahub.uk", "Dontforget27");

// setTimeout(() => {
//   data = JSON.parse(authKey).data;
//   token = data.token;
//   customerID = data.organizationId;
// }, 500);

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
      //   authKey = xhr.response;
      return xhr.response;
    } else {
      console.log("INVALID LOG IN");
    }
  };

  xhr.send(JSON.stringify(auth));
}

// GET EVENT LIST
async function showEventList() {
  let thisDevice = await getEvent();
  //   const infoWindow = document.querySelector("#infoWindow");
  thisDevice = JSON.parse(thisDevice);
  console.log(thisDevice);
}

async function getEvent() {
  const imei = "357660103015277";
  const eventID = "1178066060";

  const resp = await fetch(
    `https://api.de.surfsight.net/${apiVersion}/devices/${imei}/events/${eventID}`,
    {
      method: "GET",
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
  );

  return await resp.text();
}

async function getEventList() {
  const imei = "357660103015277";
  const query = new URLSearchParams({
    start: "2025-05-01T00:00:00.000Z",
    end: "2025-05-28T12:00:00.000Z",
  });

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
// #########################
