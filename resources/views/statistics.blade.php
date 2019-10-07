<html>
<head>
<title>Home page</title>
    <link rel="stylesheet" href="/css/bootstrap.css" >
</head>

<body>

<p class="bg-info" style="padding-left:470px ">
    Всего овечек: {{ $all  }}
</p>
<ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Живых овечек:
        <span class="badge badge-primary badge-pill">{{$live}}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Усыпленных овечек:
        <span class="badge badge-primary badge-pill">{{$sleep}}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Самый населеный загон №: {{ $max->sheepfold }}.Количество овец в загоне:
        <span class="badge badge-primary badge-pill"> {{ $max->total }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Самый малонаселенный загон №: {{ $min->sheepfold }}.Количество овец в загоне:
        <span class="badge badge-primary badge-pill"> {{ $min->total }}</span>
    </li>
</ul>


</body>
</body>
</html>
