const express = require("express");
const app = express();
const mysql = require("mysql");

const conn = mysql.createConnection({
    host: "127.0.0.1",
    user: "root",
    password: "root",
    database: "crm",
});

// conn.connect(function (err) {
//     if (err) {
//         console.error('Error connecting to MySQL: ' + err.stack);
//         return;
//     }
// });

const getAllQuery = "select active, name, surname, email, phone, \n" +
    "(select name from subject where id = firms.subject_id) as subject,\n" +
    "source, date_of_contact, date_of_meeting,cv, \n" +
    "(select text from firm_notes where firm_id = firms.id and note_type_id = (select id from note_type where note_type.type = 'result')) as result,\n" +
    "(select text from firm_notes where firm_id = firms.id and note_type_id = (select id from note_type where note_type.type = 'workshop')) as workshop,\n" +
    "(select text from firm_notes where firm_id = firms.id and note_type_id = (select id from note_type where note_type.type = 'brigade')) as brigade,\n" +
    "(select text from firm_notes where firm_id = firms.id and note_type_id = (select id from note_type where note_type.type = 'practice')) as practice\n" +
    "from firms";

const columnQueryMap = {}

columnQueryMap["active"] = "active";
columnQueryMap["name"] = "name";
columnQueryMap["surname"] = "surname";
columnQueryMap["email"] = "email";
columnQueryMap["phone"] = "phone";
columnQueryMap["subject"] = "(select name from subject where id = firms.subject_id) as subject";
columnQueryMap["source"] = "source";
columnQueryMap["date_of_contact"] = "date_of_contact";
columnQueryMap["date_of_meeting"] = "date_of_meeting";
columnQueryMap["result"] = "(select text from firm_notes where firm_id = firms.id and note_type_id = (select id from note_type where note_type.type = 'result')) as result";
columnQueryMap["workshop"] = "(select text from firm_notes where firm_id = firms.id and note_type_id = (select id from note_type where note_type.type = 'workshop')) as workshop";
columnQueryMap["brigade"] = "(select text from firm_notes where firm_id = firms.id and note_type_id = (select id from note_type where note_type.type = 'brigade')) as brigade";
columnQueryMap["practice"] = "(select text from firm_notes where firm_id = firms.id and note_type_id = (select id from note_type where note_type.type = 'practice')) as practice";




function queryBuilder(columnsToIgnore)
{
    let i = 0;
    let query ="select ";
    for (x in columnQueryMap) {

        query += columnQueryMap[x];
        if (i !== Object.keys(columnQueryMap).length -1) {
            query += ",";
        }
        query += "\n";
        i++;
    }

    query += "from firms"
    return query;
}





console.log(queryBuilder());



app.get("/firms/:id", (req, res) => {
    conn.query(getAllQuery + " where id = ?", [req.params.id], (err, results) => {


        res.send(JSON.stringify(results[0]));

    })
})

app.get("/firms/hide-column", (req, res) => {

    conn.query(getAllQuery, (err, results) => {
        let csvData = "active,name,surname,email,phone,subject,source,date_of_contact,date_of_meeting,source,date_of_contact,date_of_meeting,cv,result,workshop,brigade,practice \r\n"

        results.forEach((x) => {
            csvData += [x.active, x.name, x.surname, x.email, x.phone, x.subject, x.source, x.date_of_contact, x.date_of_meeting, x.cv, x.result, x.workshop, x.brigade, x.practice].join(",") + "\r\n"
        })

        res
            .set({
                "Content-Type": "text/csv",
                "Content-Disposition": `attachment; filename="firms.csv"`,
            }).send(csvData);
    })
})

app.post("/firms", (req, res) => {

    let values = [1, req.body.name, req.body.surname, req.body.email, req.body.phone, req.body.subject_id, req.body.source, req.body.date_of_contact, req.body.date_of_meeting, 1];


    conn.query("insert into firms(active, name, surname, email, phone, subject_id, source, date_of_contact, date_of_meeting, cv) values (?, ?, ?, ?, ?,?, ?, ?, ?, ?)", values, (err, results) => {
        if (err) {
            res.status(500).json({msg: "failed to insert firm"})
        } else {
            res.status(200).json({msg: "inserted successfully"})
        }
    })
})

app.get("/firms/:id/contact/:contact_type", (req, res) => {
    let contact_type = req.params.contact_type;
    if (contact_type === "phone" || contact_type === "email") {
        conn.query("select ? from firms where id = ?", [contact_type, req.params.id], (err, result) => {
            res.send(JSON.stringify(result));

        });
    } else {
        res.status(406).json({msg: "Invalid contact type"})
    }
})

app.post("/firms/:id/contact", (req, res) => {

})

app.post("/cards", (req, res) => {

})

app.get("/firms/export", (req, res) => {
    conn.query(getAllQuery, (err, results) => {
        let csvData = "active,name,surname,email,phone,subject,source,date_of_contact,date_of_meeting,source,date_of_contact,date_of_meeting,cv,result,workshop,brigade,practice \r\n"

        results.forEach((x) => {
            csvData += [x.active, x.name, x.surname, x.email, x.phone, x.subject, x.source, x.date_of_contact, x.date_of_meeting, x.cv, x.result, x.workshop, x.brigade, x.practice].join(",") + "\r\n"
        })

        res
            .set({
                "Content-Type": "text/csv",
                "Content-Disposition": `attachment; filename="firms.csv"`,
            }).send(csvData);
    })
})

app.get("/events/:id", (req, res) => {
    conn.query("select ")
})

app.post("/events/", (req, res) => {

})
