$(document).ready(function () {

    var cookies = document.cookie.split(";");
    var cookie = "";
    for (const c of cookies) {
        if (c.includes("search=")) {
            cookie = c.split("=")[1];
            break;
        }
    }



    $('#basic').DataTable({
        stateSave: true,
        dom: 'lBftrip',
        buttons: [
            'colvis',
            'excel',
            'print'
        ],
        scrollX: "auto",
        lengthMenu: [
            [-1, 10,20,30,40,50],
            ['vše', 10,20,30,40,50,100],
        ],
        scrollY: '700px',
        scrollCollapse: true,
        search: { 
            search: cookie
        },
        columnDefs: [{
            targets: 0,
            orderable: false
        }],
        language: {
            search: "",
            searchPlaceholder: "Vyhledávání"
        },
        initComplete: function (settings, json) {
            $('.dataTables_scrollBody').height($(window).innerHeight() - 180);

        }
    });

    $(".dataTables_length").append(
        $('<div id ="hamburger" class="topnav">' +
            '' +
            '<div class="table-filter">' +
            '<button class="bn49" id="edit-btn">Upravit vybrané</button>' +
            '<a class="bn49" href="#" id="link">Přidání Firmy</a>' +
			' <div id="myLinks"><label>Aktivní:<input type="checkbox" id="check-active" checked></label>' +
            
            
            '<button class="bn49" id="delete-btn">Vymazat vybrané</button>' +
            '<button class="bn49" id="export-btn">Exportovat vybrané</button>' +
            
			'<a class="bn49 " href="/columns/columnForm.php">Úpravy sloupců</a>' +
            '<a class="bn49 " href="/events/tableEvents.php">Události</a>' +
            '<button class="bn49" id="edit-rows">Hromadná změna sloupce</button>' +
            '<input id="email-btn" class="bn49" type="submit" value="Poslat email vybranym"></div>' +
			'<a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars"></i></a></div></div>'
        )
    );
    // iframe 
    $('.myframe').hide();
    document.getElementById('frame').src = 'firms/insertFirmForm.php';
    $('#link').click(function () {
        $('.myframe').show();
        var iframe = document.getElementById("frame");
        iframe.onload = function () {
            $('.myframe').hide();
            location.reload();
        };
    })

    $("#closeIframe").click(function () {
        $(".myframe").hide();
        $(".myframe2").hide();
        
    });

    $('.myframe2').hide();
    document.getElementById('frame2').src = 'editFirm/editFirmForm.php';
    $("#closeIframe2").click(function () {
        $(".myframe2").hide();
        $(".myframe").hide();
    });

    $('#basic').DataTable().on('search.dt', function () {
        var serachInput = $("#basic_filter label input");
        var value = serachInput.val();
        if (value == "") {
            Setcookie("");
			//window.history.replaceState("", "CRM", window.location.origin + "table.php?search=" + value);
        } else {
            Setcookie(value);
            if (window.history.replaceState) {
              //  window.history.replaceState("", "CRM", window.location.origin + "table.php?search=" + value);
            }
        }
    });

    var checkActive = $("#check-active");
    $('#basic').DataTable().column(4).search("1", true, false, true).draw();
    checkActive.on('change', function () {
        if (checkActive.prop("checked") == true) {
            $('#basic').DataTable().column(4).search("1", true, false, true).draw();
        } else {
            $('#basic').DataTable().column(4).search("0", true, false, true).draw();
        }

    });

    $("#delete-btn").click(function () {
        var selected = $(".check:checked");
        if (selected.length > 0) {
            $.confirm({
                title: 'Opravdu chcete smazat tyto firmy ?',
                content: 'Smazat ' + selected.length + ' firem?',
                buttons: {
                    yes: {
                        text: 'Ano',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function () {
                            var array = [];
                            for (const tr of selected) {
                                array.push($(tr).attr('id'));
                            }
                            console.log(array);
                            $.ajax({
                                url: "/firms/deleteFirms.php",
                                method: "POST",
                                data: { "ids": array },
                                success: function (response) {
                                    console.log(response);
                                    location.reload();
                                },
                                error: function () {
                                    alert("error");
                                }

                            });
                        }
                    },
                    no: {
                        text: 'Ne',
                        btnClass: 'btn-gray',
                        keys: ['enter', 'shift'],
                        action: function () {

                        }
                    }
                }
            });
        }
    });

    $("#export-btn").click(function () {
        var selected = $(".selected");
        if (selected.length > 0) {
            var array = [];
            for (const tr of selected) {
                array.push($(tr).attr('id'));
            }
            console.log(array);
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "/firms/exportFirms.php";

            var data = document.createElement("input");

            var json = { "ids": array };
            data.value = JSON.stringify(json);
            data.name = "ids";
            data.type = 'hidden';

            form.appendChild(data);

            document.body.appendChild(form);

            form.submit();
        }
    })

    $("#email-btn").click(function (event) {
        var selected = $(".selected");
        if (selected.length > 0) {
            var mailtoStr = "mailto:?bcc=";
            for (var x = 0; x < selected.length; x++) {
                var item = selected[x]
                var email = $(item).find(".email").attr("title");
                if (email != "") {
                    mailtoStr += email;
                    if (x != selected.length - 1) {
                        mailtoStr += ",";
                    }
                }
            }
            window.location = mailtoStr;
        }
    });

    $("#edit-rows").click(function(){
        var selected = $(".selected");
        if (selected.length > 0) {
            ids_str = "";
            for (var x = 0; x < selected.length; x++) {
                ids_str += $(selected[x]).attr("id")+";";
            }
            sessionStorage.setItem('ids', ids_str)
            window.location = "./firms/editRowsForm.php";
        }
    });


    function Setcookie(value) {
        const d = new Date();
        d.setTime(d.getTime() + (0.5 * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = "search=" + value + ";" + expires;
    }


});



$(window).resize(function () {
    $('.dataTables_scrollBody').height($(window).innerHeight() - 180);
});

function closeIFrame2(){
    $(".myframe2").hide();
    location.reload();
}

