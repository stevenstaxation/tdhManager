// import express from "express";
// import bodyParser from "body-parser";
// import cors from "cors";
// const app = express();
// const port = process.env.PORT || 3000;

// app.use(cors());
// app.use(bodyParser.json());
// app.use(express.static("public"));

// let webhooks = [];
// let idCounter = 1;

// app.post("/data", (req, res) => {
//   const newWebhook = {
//     id: idCounter++,
//     timestamp: new Date(),
//     payload: req.body,
//   };
//   webhooks.push(newWebhook);
//   res.sendStatus(200);
// });

// app.get("/data", (req, res) => {
//   res.json(webhooks);
// });

// app.delete("/data/:id", (req, res) => {
//   const id = parseInt(req.params.id);
//   webhooks = webhooks.filter((item) => item.id !== id);
//   res.sendStatus(200);
// });

// app.listen(port, () => {
//   console.log(`Server listening on port ${port}`);
// });
