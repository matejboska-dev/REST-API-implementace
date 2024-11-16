

const form = document.getElementById('eventForm');


form.onsubmit = (e) => {

    e.preventDefault();

    xhttp = new XMLHttpRequest();


    const name = document.getElementById('event-name').value;
    const description = document.getElementById('event-description').value;
    const time_start = document.getElementById('event-time-start').value;

    let firm_ids = [];
    for (const child of document.getElementById('event-firms')) {
        firm_ids.push(child.id);
    }


    xhttp.open("GET", "http://s-jonas-24.dev.spsejecna.net/npi/firms-all/hide-columns", true);
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhttp.send(JSON.stringify({name: name, description: description, time_start: time_start, firm_ids: firm_ids}));
}