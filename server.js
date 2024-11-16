const express = require("express");
const app = express();
const mysql = require("mysql");
const result = require("mysql/lib/protocol/ResultSet");

app.use(express.json())
app.use(express.urlencoded({extended: false}));

const conn = mysql.createConnection({
    host: "127.0.0.1",
    user: "root",
    password: "root",
    database: "crm",
});

conn.connect(function (err) {
    if (err) {
        console.error('Error connecting to MySQL: ' + err.stack);
        return;
    }
});





firmQueryColumns = []

conn.query("SHOW COLUMNS FROM firm",(err,results) =>
{
    firmQueryColumns = results.map(x=> x.Field);

    console.log(firmQueryColumns);

    getAllQuery = queryBuilder();


    //console.log(getAllQuery);
})

const columnQueryMap = {}
columnQueryMap["subject_id"] = "(select name from subject where id = firm.subject_id) as subject";

let getAllQuery = "";

function queryBuilder(columnsToIgnore) {

    let query = "select ";
    for (x of firmQueryColumns) {

        if (columnsToIgnore && columnsToIgnore.includes(x) ) {
            continue;
        }
        query += columnQueryMap[x] ?? x;
        query += ",\n";

    }
    query = query.replace(/,\s*$/, "");
    query += " from firm"
    return query;
}





app.get("/npi/firms/:id", (req, res) => {
    conn.query(getAllQuery + " where id = ?", [req.params.id], (err, results) => {

        res.send(JSON.stringify(results[0]));

    })
})

app.get("/npi/firms-all/hide-columns", (req, res) => {

   // res.send(JSON.stringify(req.body.hide_columns));


    conn.query(queryBuilder(req.body.hide_columns), (err, results) => {

        res.send(JSON.stringify(results));

    })
})

app.post("/npi/firms", (req, res) => {

    let values = [1, req.body.name, req.body.surname, req.body.email, req.body.phone, req.body.subject_id, req.body.source, req.body.date_of_contact, req.body.date_of_meeting, 1];


    conn.query("insert into firms(active, name, surname, email, phone, subject_id, source, date_of_contact, date_of_meeting, cv) values (?, ?, ?, ?, ?,?, ?, ?, ?, ?)", values, (err, results) => {
        if (err) {
            res.status(500).json({msg: "failed to insert firm"})
        } else {
            res.status(200).json({msg: "inserted successfully"})
        }
    })
})

app.get("/npi/firms/:id/contact/:contact_type", (req, res) => {
    let contact_type = req.params.contact_type;
    if (contact_type === "phone" || contact_type === "email") {
        conn.query("select ? from firms where id = ?", [contact_type, req.params.id], (err, result) => {
            res.send(JSON.stringify(result));

        });
    } else {
        res.status(406).json({msg: "Invalid contact type"})
    }
})

app.put("/npi/firms/:id/contact/:contact_type", (req, res) => {
    let contact_type = req.params.contact_type;
    if (contact_type === "phone" || contact_type === "email") {
        conn.query("update firms set ? = ? where id = ?", [contact_type,req.body.new_value, req.params.id], (err, result) => {
            if(err)
            {
                res.status(402).json({msg: "failed to update contact"});
            } else
            {
                res.status(201).send();
            }

        });
    } else {
        res.status(406).json({msg: "Invalid contact type"})
    }
})

app.delete("/npi/firms/:id/contact/:contact_type", (req, res) =>
{
    let contact_type = req.params.contact_type;
    if (contact_type === "phone" || contact_type === "email") {
        conn.query("update firms set ? = null where id = ?", [contact_type, req.params.id], (err, result) => {
            if(err)
            {
                res.status(402).json({msg: "failed to update contact"});
            } else
            {
                res.status(201).send();
            }
        });
    } else {
        res.status(406).json({msg: "Invalid contact type"})
    }
})


app.post("/npi/cards", (req, res) => {

    let image = req.body.img;
    let firm_id = req.body.firm_id;

    conn.query("insert into cards(firm_id) values (?)",[firm_id], (err, result) =>
    {
        if(err)
        {
           res.status(500).json({msg: "failed to insert card, card is already stored"})
        }

        conn.query("select name from firm where id = ?", [firm_id], (err, result) => {
            require("fs").writeFile(`/cards/${result[0]}.png`, image, 'base64', function (err) {
                console.log(err);
            });

            res.status(200).json({msg: "card saved"})
        })
    })
})

app.get("/npi/firms-all/export", (req, res) => {

    console.log(getAllQuery);
    conn.query(queryBuilder(["id"]), (err, results) => {
        let csvData = firmQueryColumns.join(",");

        results.forEach(x => {
            console.log(x);
            csvData += Object.values(x).join(",") + "\r\n"
        })

        res
            .set({
                "Content-Type": "text/csv",
                "Content-Disposition": `attachment; filename="firms.csv"`,
            }).send(csvData);
    })
})

app.get("/npi/events/:id", (req, res) => {
    conn.query("select  events.name  as event_name ,firm.name as firm_name, events.description as event_description, events.time_start, events.time_end from firms_in_event" +
        "\n" +
        " inner join firm on firm.id = firms_in_event.firm_id \n" +
        " inner join events on events.id = firms_in_event.event_id\n" +
        " group by  event_name, firm.name, event_description, events.time_start, events.time_end;", (err, results) => {

        let events = {};
        for (event_name of [...new Set(results.map(a => a.event_name))]) {
            // drinks.push({username: username, drinkData: []})

          //  console.log(event_name);
            events[event_name] = {event_name: event_name, firm_names: ""}


            console.log(events[event_name]);


            //console.log(username)
            //responseData.terminal.drinks[username] = []
        }

        for (data of results) {
            // responseData.terminal.drinks[data.username].push({drinkName: data.drink_name, amount: data.amount})
            let name = data.event_name;

            events[name].firm_names +=  data.firm_name;
            events[name].event_description ??= data.event_description;
            events[name].time_start ??= data.time_start;
            events[name].time_end ??= data.time_end


           // console.log(events[name]);
        }


        let eventResults = [];
        for(x in events)
        {
            eventResults.push(events[x]);
        }


       // console.log(JSON.stringify(eventResults));
        res.json(eventResults);
    })
})

app.post("/npi/events/", (req, res) => {
    {
        let firm_ids = req.body.firm_ids;

        conn.query("insert into events(name,description, time_start, time_end) values (?,?,?,?)",
            [req.body.name, req.body.description, req.body.time_start, req.body.time_end], (err, results) => {
                let id = results.insertId;

                let query = "insert into firms_in_events(firm_id, event_id) values ";

                for (firm_id of firm_ids) {
                    query += (`(${firm_id}, ${id}),`)
                }
                query = query.replace(/,\s*$/, "");

                conn.query(query, (err, results) => {
                })

            })
    }
})


const PORT = 9009;
app.listen(PORT, "0.0.0.0", function (err) {
    if (err) console.log("Error in server setup")

    console.log("Server listening on Port", PORT);

});