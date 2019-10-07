<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>
        Home page
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=Mansalva&display=swap" rel="stylesheet">

    <script src="/js/jquery-3.1.1.js"></script>

</head>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <fieldset>
                <legend>Фермочка для овечек
                    <span class="span">День: <p id="day">0</p></span>

                </legend>




                <?$index = 1?>
                @foreach ($sheepfold as $key => $list)
                    <div class="col-md-6">
                        <h3>Загон №{{ $key  }}</h3>

                        <div id="paddock{{ $key  }}" class="zagon">

                            @foreach ($list as $sheepId)
                                <div id="sheep{{ $sheepId }}" class="name"></div>
                                {{--@endfor--}}
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </fieldset>

            <div class="col-md-6">
                <form>
                    <div class="form-group">
                        <button id="reset" class="btn btn-danger">Reset</button>

                    </div>
                    <div class="form-group">

                        <select name="command" id="command">
                            <option value="add">Add</option>
                            <option value="sleep">Sleep</option>
                        </select>
                        <input type="submit" name="send" value="Do" class="input">
                    </div>
                </form>
            </div>

            <div class="col-md-7 info-block href" >
                <p><a href="/statistics/" class="otchet">Отчет</a></p>

            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        function add() {
            $.ajax({
                url: '/reproduce/',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#paddock' + data.paddock).append(
                        '<div id="sheep' + data.sheep_id + '" class="name"></div>'
                    );
                }
            });
        }

        function sleep() {
            $.ajax({
                url: '/sleep/',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#sheep' + data.sleep.id).hide();

                    $('#sheep' + data.moved.id).appendTo('#paddock' + data.moved.to);
                }
            });
        }

        $('input[type=submit]').on('click', function () {
            var cmd = $('select').val();

            if (cmd == 'add') {
                add();
            } else if (cmd == 'sleep') {
                sleep();
            }

            return false;
        });

        $('#reset').on('click', function () {
            $.ajax({
                url: '/reset',
                success: function () {

                    window.location.reload();
                }
            });

            setDay(0);
            clearInterval(timer);
        });

        var timer = setInterval(function () {
            var day = localStorage.getItem('day') ? localStorage.getItem('day') : 0;
            day = parseInt(day) + 1;
            setDay(day);

            if (day % 10 == 0 && day > 0) {
                add();
            }

            if (day % 20 == 0 && day > 0) {
                sleep();
            }
        }, 1000);

        function setDay(day) {
            localStorage.setItem('day', day);
            $('#day').html(day);
        }
    });
</script>
</body>
</html>
