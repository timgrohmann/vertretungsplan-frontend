$(document).ready(function(){
    $.get(url, function(data){
        $('#info').html("<p>Plan für: " + data['plan']['forDay'] + "</p><p>Zuletzt aktualisiert: " + data['plan']['lastUpdated'] + "</p>");
        setTimeout(function(){
            $('.loader').addClass('hidden');
            $('#planTable').removeClass('hidden');
        },200);


        if (data['plan']['lessons'][0]['withOData'] == true){
            $('#info').append("<p>Die Angaben in Klammern geben die urspünglichen Werte an.</p>");
        }
        showData(data);

    })


    $('#nextPage').click(function(){
        page_offset += 1;
        $('#prevPage').removeClass('disabled');
        deleteTable();
        loadData();
    });
    $('#prevPage').click(function(){
        page_offset -= 1;
        if (page_offset < 0) {
            page_offset = 0;
            return;
        }
        if (page_offset == 0) $('#prevPage').addClass('disabled');
        deleteTable();
        loadData();
    });
})

var page_offset = 0;

function loadData(){
    $.get(url + "&page="+page_offset, function(data){
        $('#info').html("<p>Plan für: " + data['plan']['forDay'] + "</p><p>Zuletzt aktualisiert: " + data['plan']['lastUpdated'] + "</p>");

        if (data['plan']['lessons'][0] == undefined) {
            $('#info').html("<p>Keine Vertretungsstunden für dich am " + data['plan']['forDay'] + " gefunden</p>");
            return
        }
        if (data['plan']['lessons'][0]['withOData'] == true){
            $('#info').append("<p>Die Angaben in Klammern geben die urspünglichen Werte an.</p>");
        }
        showData(data);

    })
}

function showData(data){


    for (var lesson of data['plan']['lessons']){
        if (!lesson.withOData) {
            $('#planTable').append(`<tr><td>${lesson.lesson}</td><td>${lesson.subject}</td><td>${lesson.teacher}</td><td>${lesson.room}</td><td>${lesson.info}</td>`)
        }else{
            $('#planTable').append(`<tr><td>${lesson.lesson}</td><td>${lesson.subject} (${lesson.oSubject})</td><td>${lesson.teacher} (${lesson.oTeacher})</td><td>${lesson.room} (${lesson.oRoom})</td><td>${lesson.info}</td>`);
        }

    }

    $('.loader').addClass('hidden');
    $('#planTable').removeClass('hidden');
}

function deleteTable(){
    $('#planTable tr').each(function(index){
        if (!$( this ).hasClass('head')){
            $( this ).remove();
        }
    })
    $('.loader').removeClass('hidden');
    $('#planTable').addClass('hidden');
    $('#info').html("<p>Plan lädt…</p><br>");
}
