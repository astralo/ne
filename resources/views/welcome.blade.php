<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test case</title>

    <link rel="stylesheet" href="//yastatic.net/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/styles.css">

    <script src="//yastatic.net/jquery/2.2.4/jquery.min.js"></script>
    <script src="//yastatic.net/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-3">

            <div class="filter input-group">
                <input class="form-control" type="text" id="name" name="name" value placeholder="Поиск по наименованию">
                <div class="input-group-btn">
                    <a href class="btn btn-primary" id="btn">Найти</a>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-9">
            <table class="table table-bordered table-responsive table-condensed" id="table">
                <thead>
                <tr>
                    <th data-col="currency.name" class="th">Name</th>
                    <th data-col="price_usd" class="th">Price</th>
                    <th data-col="percent_change_24h" class="th">% Change(24h)</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"></script>
<script src="/js/scripts.js"></script>
</body>
</html>