(function () {
    "use strict";

    // время загрузки данных в минутах
    var timer = 1;

    var items  = [];
    var temp   = [];
    var params = {};

    var sortCol = 'percent_change_24h';
    var sortDir = true;

    loadData();
    var loader = setInterval(loadData, timer * 60 * 1000);

    $('#table th').on('click', function (ev) {
        var $el = $(ev.target);
        var col = $el.data('col');

        if (sortCol === col) sortDir = !sortDir;
        else sortCol = col;

        sort();
        drawTable();
    });

    $('#name').on('keyup', function (ev) {
        if (ev.which === 13) {
            filterTable();
            sort();
            drawTable();
        }
    });

    $('#btn').on('click', function (ev) {
        ev.preventDefault();
        filterTable();
        sort();
        drawTable();
    });

    function thSortArrows() {
        var cols = $('#table .th');
        cols.map(function (index, item) {
            var $item = $(item);
            if ($item.data('col') === sortCol) {
                $item.addClass('active');
                if (sortDir) $item.addClass('desc');
                else $item.removeClass('desc');
            }

            else {
                $item.removeClass('active');
                $item.removeClass('desc');
            }
        })

    }

    function filterTable() {
        var $inp = $('#name');
        var text = $inp.val();

        if (text) {
            temp  = _.clone(items);
            items = _.filter(items, function (o) {
                return o.currency.name.toLowerCase().indexOf(text.toLowerCase()) !== -1;
            });
        } else {
            if (temp.length) {
                items = _.clone(temp);
                temp  = [];
            }
        }

        console.log('elements filtered by name', text);
    }

    function sort() {
        items = _.orderBy(items, sortCol, sortDir ? 'desc' : 'asc');

        thSortArrows();

        console.log('table sorted', sortCol, sortDir);
    }

    function loadData() {
        $.ajax({
            url:    '/data',
            method: 'get',
            data:   params
        }).then(function (response) {

            console.log('loadData response', response);
            items = response.results;

            filterTable();
            sort();
            drawTable();

            console.log('data loaded');

        }, function (response) {
            console.log('error', response);
        });
    }

    function drawTable() {
        var $items = [];

        items.forEach(function (item) {
            var $row, $price, $percent;

            $row = $('<tr/>');
            $row.append($('<td/>').text(item.currency.name));

            $price = $('<td/>').text(item.price_usd);
            if (item.price_dir === 1) $price.addClass('up')
            else if (item.price_dir === -1) $price.addClass('down');
            $row.append($price);

            $percent = $('<td/>').text(item.percent_change_24h);
            if (item.percent_dir === 1) $percent.addClass('up')
            else if (item.percent_dir === -1) $percent.addClass('down');
            $row.append($percent);

            $items.push($row);
        });

        $('#table tbody').html('');
        $('#table tbody').append($items);

        console.log('table redraw');
    }
})();