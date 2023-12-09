<!DOCTYPE html>
<html>
<head>
    <title>Попов</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$string = file_get_contents("road_and_point.geojson");
if ($string === false) {
    // deal with error...
}

$json_a = json_decode($string, true);
if ($json_a === null) {
    // deal with error...
}//accidents.json
$string1 = file_get_contents("test3.json");
if ($string1 === false) {
    // deal with error...
}

$json_test = json_decode($string1, true);
if ($json_test === null) {
    // deal with error...
}

//var_dump($json_a['features'][0]['geometry']['coordinates'][0][0]);
for ($i = 0; $i < count($json_a['features']); $i++)
{
    if($json_a['features'][$i]['geometry']['type']=="Polygon")
    {
        for ($j = 0; $j < count($json_a['features'][$i]['geometry']['coordinates'][0]); $j++)
        {
            //echo $json_a['features'][$i]['geometry']['coordinates'][0][$j][0]." ";
            //echo $json_a['features'][$i]['geometry']['coordinates'][0][$j][1];
            //echo '<br>';
            
        }
    }
    if($json_a['features'][$i]['geometry']['type']=="Point")
    {
        //echo $json_a['features'][$i]['geometry']['coordinates'][1].";";
        //echo $json_a['features'][$i]['geometry']['coordinates'][0];
        //echo ';<br>';
    }
    //echo '<br>';
    
    //echo $json_test[$i]['lat'].";";
    //echo $json_test[$i]['long'];
    //var_dump($json_test[$i]['severity']);
    //echo ';<br>';

}
$date_tom = strtotime("+1 day");

?>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=<ваш API-ключ>" type="text/javascript"></script>
    <script src="polygon.js" type="text/javascript"></script>
	<style>
        #map {
            width: 90%; height: 75%; margin-left: auto; margin-right: auto; border:0px solid black;
        }
        
        #main{
            width:100%;
            height: 100vh;
            display: flex;
        }
        #header{
            width:100%;
            border-bottom:4px solid rgb(247, 247, 253);
        }
        button{
            background:none;
            border-radius: 8px;
        }
        #del{
            visibility:hidden;
            border:2px solid red;
        }
        #show,#step,#sel{
            visibility:visible;
        }
        #buttons{
            width:100%;
            border:0px solid black;
            text-align: center;
            
        }
        #left{
            width:25%;
            height:100%;
            background-color: rgb(76, 86, 102);
            text-align: center;
            padding:0px;
        }
        #right{
            width:75%;
            height:100%;
            background-color: rgb(247, 247, 253);
        }
        #point{
            font-size: calc(1.325rem + .9vw);
            color:white;
            text-decoration:none;
            display: block;
        }
        #point:hover{
            background-color: rgb(247, 247, 253);
            color:black;
            width:100%;
        }
        #menu_mobile{
            visibility:hidden;
            width:100%;
            background-color: rgb(76, 86, 102);
            text-align: center;
            position:fixed;
            top:95%;
            right:0%;
        }
        @media screen and (max-width: 900px){
            #menu_mobile{
                visibility:visible;
            }
            #left{
                width:0%;
            }
            #right{
                width:100%;
            }
            #point{
                display: inline;
            }
          
        }
    </style>
</head>
<body>
    <div id="main">
        <div id="left">
            <div id="header">
                <H2 style="color:white;">Прогнозирование тяжести аварии</H2>
            </div>
            <br>
            <a id="point" href="http://e91545x6.beget.tech/diploma/map.php">Главная</a>
            <a id="point" href="http://e91545x6.beget.tech/diploma/analys.php">Аналитика</a>
            <a id="point" href="https://popov-madi.github.io/IETR1/">ИЭТР</a>
        </div>
        <div id='right'>
            <div id="buttons">
                <H2>Главная</H2>
                <p>Дата: <?=date('d-m-y',$date_tom);?></p>
                <text id="step">Степень аварии</text>
                <select id="sel" onchange="getComboA(this)">
                  <option value="1">Все</option>
                  <option value="3">С погибшими</option>
                  <option value="2">Тяжелая</option>
                  <option value="4">Легкая</option>
                </select>
                <button id="show" onclick="ymaps.ready(init);">Показать карту</button><br>
                <button id = "del">Удалить карту</button>
            </div>
            <br>
            <div id="map"></div>
        </div>
    </div>
    <div id="menu_mobile">
        <a id="point" style="margin:0px 10px 0px 10px" href="http://e91545x6.beget.tech/diploma/map.php">Главная</a>
        <a id="point" style="margin:0px 10px 0px 10px" href="http://e91545x6.beget.tech/diploma/analys.php">Аналитика</a>
        <a id="point" style="margin:0px 10px 0px 10px" href="https://popov-madi.github.io/IETR/">ИЭТР</a>
    </div>
    <script>
    var i = 1;
        function getComboA(selectObject) {
          var value = selectObject.value;  
          i = parseInt(value);
        }
    
        function init() {
            //ВСЕ
            if(i==1)
            {
                document.getElementById("del").style.visibility = "visible";
                document.getElementById("sel").style.visibility = "hidden";
                document.getElementById("show").style.visibility = "hidden";
                document.getElementById("step").style.visibility = "hidden";
                var myMap = new ymaps.Map("map", {
                        center: [55.75, 37.61],
                        zoom: 10
                    }, {
                        searchControlProvider: 'yandex#search'
                    });
            
            <?php
            
                for ($i = 0; $i < count($json_a['features']); $i++)
                {
                    if($json_a['features'][$i]['geometry']['type']=="Polygon")
                    {
                        if($json_test[$i]['severity']==1)
                        {
                            $sever[$i]='Легкий';
                        }
                        if($json_test[$i]['severity']==2)
                        {
                            $sever[$i]='Тяжелый';
                        }
                        if($json_test[$i]['severity']==3)
                        {
                            $sever[$i]='С погибшими';
                        }
                        
                        
            ?>
            
                // Создаем многоугольник, используя класс GeoObject.
                var myGeoObject<?=$i?> = new ymaps.GeoObject({
                    // Описываем геометрию геообъекта.
                    geometry: {
                        // Тип геометрии - "Многоугольник".
                        type: "Polygon",
                        // Указываем координаты вершин многоугольника.
                        coordinates: [
                            // Координаты вершин внешнего контура.
                            [
                                <?php
                                    for ($j = 0; $j < count($json_a['features'][$i]['geometry']['coordinates'][0]); $j++)
                                    {
                                        ?>
                                        [<?=$json_a['features'][$i]['geometry']['coordinates'][0][$j][1]?>, <?=$json_a['features'][$i]['geometry']['coordinates'][0][$j][0]?>],
                                        <?php
                                    }
                                        ?>
                            ]
                        ],
                        // Задаем правило заливки внутренних контуров по алгоритму "nonZero".
                        fillRule: "nonZero"
                    },
                    // Описываем свойства геообъекта.
                    properties:{
                        // Содержимое балуна.
                        balloonContent: "Тяжесть аварии: "+'<?=$sever[$i]?>'+"<br>Количество пострадавших: "+<?=$json_test[$i]['inj']?>+"<br>Количество погибших: "+<?=$json_test[$i]['dead']?>+"<br>Облачность: "+<?=$json_test[$i]['cloudcover']?>+"%<br>Температура: "+<?=$json_test[$i]['temp']?>+"<br>Видимость: "+<?=$json_test[$i]['visibility']?>+"<br>Скорость ветра: "+<?=$json_test[$i]['wspd']?>
                    }
                }, {
                    // Описываем опции геообъекта.
                    // Цвет заливки.
                    <?php
                        if ($sever[$i]=='Легкий')
                        {
                    ?>
                    fillColor: '#00FF00',
                    // Цвет обводки.
                    strokeColor: '#00FF00',
                    <?php
                        }
                        if ($sever[$i]=='Тяжелый')
                        {
                    ?>
                    fillColor: '#fb7a74',
                    // Цвет обводки.
                    strokeColor: '#fb7a74',
                    <?php
                        }
                        if ($sever[$i]=='С погибшими')
                        {
                    ?>
                    fillColor: '#ff0000',
                    // Цвет обводки.
                    strokeColor: '#ff0000',
                    <?php
                        }
                    ?>
                    // Общая прозрачность (как для заливки, так и для обводки).
                    opacity: 1,
                    // Ширина обводки.
                    strokeWidth: 5,
                    // Стиль обводки.
                    strokeStyle: 'solid'
                });
            
                // Добавляем многоугольник на карту.
                myMap.geoObjects.add(myGeoObject<?=$i?>);
                <?php
                        }
                    }
                ?>
                //Удаляем элементы карты
                myMap.controls.remove('rulerControl');
                myMap.controls.remove('geolocationControl');
                myMap.controls.remove('searchControl');
                myMap.controls.remove('trafficControl');
                
                document.getElementById('del').onclick = function () {
                    // Для уничтожения используется метод destroy.
                    myMap.destroy();
                    document.getElementById("del").style.visibility = "hidden";
                    document.getElementById("sel").style.visibility = "visible";
                    document.getElementById("show").style.visibility = "visible";
                    document.getElementById("step").style.visibility = "visible";
                };
            }
            //Только тяжелые случаи
            if(i==2)
            {
                document.getElementById("del").style.visibility = "visible";
                document.getElementById("sel").style.visibility = "hidden";
                document.getElementById("show").style.visibility = "hidden";
                document.getElementById("step").style.visibility = "hidden";
                var myMap = new ymaps.Map("map", {
                        center: [55.75, 37.61],
                        zoom: 10
                    }, {
                        searchControlProvider: 'yandex#search'
                    });
            
            <?php
            
                for ($i = 0; $i < count($json_a['features']); $i++)
                {
                    if($json_a['features'][$i]['geometry']['type']=="Polygon")
                    {
                        if($json_test[$i]['severity']==1)
                        {
                            $sever[$i]='Легкий';
                            continue;
                        }
                        if($json_test[$i]['severity']==2)
                        {
                            $sever[$i]='Тяжелый';
                        }
                        if($json_test[$i]['severity']==3)
                        {
                            $sever[$i]='С погибшими';
                            continue;
                        }
                        
                        
            ?>
            
                // Создаем многоугольник, используя класс GeoObject.
                var myGeoObject<?=$i?> = new ymaps.GeoObject({
                    // Описываем геометрию геообъекта.
                    geometry: {
                        // Тип геометрии - "Многоугольник".
                        type: "Polygon",
                        // Указываем координаты вершин многоугольника.
                        coordinates: [
                            // Координаты вершин внешнего контура.
                            [
                                <?php
                                    for ($j = 0; $j < count($json_a['features'][$i]['geometry']['coordinates'][0]); $j++)
                                    {
                                        ?>
                                        [<?=$json_a['features'][$i]['geometry']['coordinates'][0][$j][1]?>, <?=$json_a['features'][$i]['geometry']['coordinates'][0][$j][0]?>],
                                        <?php
                                    }
                                        ?>
                            ]
                        ],
                        // Задаем правило заливки внутренних контуров по алгоритму "nonZero".
                        fillRule: "nonZero"
                    },
                    // Описываем свойства геообъекта.
                    properties:{
                        // Содержимое балуна.
                        balloonContent: "Тяжесть аварии: "+'<?=$sever[$i]?>'+"<br>Количество пострадавших: "+<?=$json_test[$i]['inj']?>+"<br>Количество погибших: "+<?=$json_test[$i]['dead']?>+"<br>Облачность: "+<?=$json_test[$i]['cloudcover']?>+"%<br>Температура: "+<?=$json_test[$i]['temp']?>+"<br>Видимость: "+<?=$json_test[$i]['visibility']?>+"<br>Скорость ветра: "+<?=$json_test[$i]['wspd']?>
                    }
                }, {
                    // Описываем опции геообъекта.
                    // Цвет заливки.
                    <?php
                        if ($sever[$i]=='Легкий')
                        {
                    ?>
                    fillColor: '#00FF00',
                    // Цвет обводки.
                    strokeColor: '#00FF00',
                    <?php
                        }
                        if ($sever[$i]=='Тяжелый')
                        {
                    ?>
                    fillColor: '#fb7a74',
                    // Цвет обводки.
                    strokeColor: '#fb7a74',
                    <?php
                        }
                        if ($sever[$i]=='С погибшими')
                        {
                    ?>
                    fillColor: '#ff0000',
                    // Цвет обводки.
                    strokeColor: '#ff0000',
                    <?php
                        }
                    ?>
                    // Общая прозрачность (как для заливки, так и для обводки).
                    opacity: 1,
                    // Ширина обводки.
                    strokeWidth: 5,
                    // Стиль обводки.
                    strokeStyle: 'solid'
                });
            
                // Добавляем многоугольник на карту.
                myMap.geoObjects.add(myGeoObject<?=$i?>);
                <?php
                        }
                    }
                ?>
                //Удаляем элементы карты
                myMap.controls.remove('rulerControl');
                myMap.controls.remove('geolocationControl');
                myMap.controls.remove('searchControl');
                myMap.controls.remove('trafficControl');
                
                document.getElementById('del').onclick = function () {
                    // Для уничтожения используется метод destroy.
                    myMap.destroy();
                    document.getElementById("del").style.visibility = "hidden";
                    document.getElementById("sel").style.visibility = "visible";
                    document.getElementById("show").style.visibility = "visible";
                    document.getElementById("step").style.visibility = "visible";
                };
            }
            
            // С погибшими
            if(i==3)
            {
                document.getElementById("del").style.visibility = "visible";
                document.getElementById("sel").style.visibility = "hidden";
                document.getElementById("show").style.visibility = "hidden";
                document.getElementById("step").style.visibility = "hidden";
                var myMap = new ymaps.Map("map", {
                        center: [55.75, 37.61],
                        zoom: 10
                    }, {
                        searchControlProvider: 'yandex#search'
                    });
            
            <?php
            
                for ($i = 0; $i < count($json_a['features']); $i++)
                {
                    if($json_a['features'][$i]['geometry']['type']=="Polygon")
                    {
                        if($json_test[$i]['severity']==1)
                        {
                            $sever[$i]='Легкий';
                            continue;
                        }
                        if($json_test[$i]['severity']==2)
                        {
                            $sever[$i]='Тяжелый';
                            continue;
                        }
                        if($json_test[$i]['severity']==3)
                        {
                            $sever[$i]='С погибшими';
                            
                        }
                        
                        
            ?>
            
                // Создаем многоугольник, используя класс GeoObject.
                var myGeoObject<?=$i?> = new ymaps.GeoObject({
                    // Описываем геометрию геообъекта.
                    geometry: {
                        // Тип геометрии - "Многоугольник".
                        type: "Polygon",
                        // Указываем координаты вершин многоугольника.
                        coordinates: [
                            // Координаты вершин внешнего контура.
                            [
                                <?php
                                    for ($j = 0; $j < count($json_a['features'][$i]['geometry']['coordinates'][0]); $j++)
                                    {
                                        ?>
                                        [<?=$json_a['features'][$i]['geometry']['coordinates'][0][$j][1]?>, <?=$json_a['features'][$i]['geometry']['coordinates'][0][$j][0]?>],
                                        <?php
                                    }
                                        ?>
                            ]
                        ],
                        // Задаем правило заливки внутренних контуров по алгоритму "nonZero".
                        fillRule: "nonZero"
                    },
                    // Описываем свойства геообъекта.
                    properties:{
                        // Содержимое балуна.
                        balloonContent: "Тяжесть аварии: "+'<?=$sever[$i]?>'+"<br>Количество пострадавших: "+<?=$json_test[$i]['inj']?>+"<br>Количество погибших: "+<?=$json_test[$i]['dead']?>+"<br>Облачность: "+<?=$json_test[$i]['cloudcover']?>+"%<br>Температура: "+<?=$json_test[$i]['temp']?>+"<br>Видимость: "+<?=$json_test[$i]['visibility']?>+"<br>Скорость ветра: "+<?=$json_test[$i]['wspd']?>
                    }
                }, {
                    // Описываем опции геообъекта.
                    // Цвет заливки.
                    <?php
                        if ($sever[$i]=='Легкий')
                        {
                    ?>
                    fillColor: '#00FF00',
                    // Цвет обводки.
                    strokeColor: '#00FF00',
                    <?php
                        }
                        if ($sever[$i]=='Тяжелый')
                        {
                    ?>
                    fillColor: '#fb7a74',
                    // Цвет обводки.
                    strokeColor: '#fb7a74',
                    <?php
                        }
                        if ($sever[$i]=='С погибшими')
                        {
                    ?>
                    fillColor: '#ff0000',
                    // Цвет обводки.
                    strokeColor: '#ff0000',
                    <?php
                        }
                    ?>
                    // Общая прозрачность (как для заливки, так и для обводки).
                    opacity: 1,
                    // Ширина обводки.
                    strokeWidth: 5,
                    // Стиль обводки.
                    strokeStyle: 'solid'
                });
            
                // Добавляем многоугольник на карту.
                myMap.geoObjects.add(myGeoObject<?=$i?>);
                <?php
                        }
                    }
                ?>
                //Удаляем элементы карты
                myMap.controls.remove('rulerControl');
                myMap.controls.remove('geolocationControl');
                myMap.controls.remove('searchControl');
                myMap.controls.remove('trafficControl');
                
                document.getElementById('del').onclick = function () {
                    // Для уничтожения используется метод destroy.
                    myMap.destroy();
                    document.getElementById("del").style.visibility = "hidden";
                    document.getElementById("sel").style.visibility = "visible";
                    document.getElementById("show").style.visibility = "visible";
                    document.getElementById("step").style.visibility = "visible";
                };
            }
            
            // Легкая
            if(i==4)
            {
                document.getElementById("del").style.visibility = "visible";
                document.getElementById("sel").style.visibility = "hidden";
                document.getElementById("show").style.visibility = "hidden";
                document.getElementById("step").style.visibility = "hidden";
                var myMap = new ymaps.Map("map", {
                        center: [55.75, 37.61],
                        zoom: 10
                    }, {
                        searchControlProvider: 'yandex#search'
                    });
            
            <?php
            
                for ($i = 0; $i < count($json_a['features']); $i++)
                {
                    if($json_a['features'][$i]['geometry']['type']=="Polygon")
                    {
                        if($json_test[$i]['severity']==1)
                        {
                            $sever[$i]='Легкий';
                            
                        }
                        if($json_test[$i]['severity']==2)
                        {
                            $sever[$i]='Тяжелый';
                            continue;
                        }
                        if($json_test[$i]['severity']==3)
                        {
                            $sever[$i]='С погибшими';
                            continue;
                        }
                        
                        
            ?>
            
                // Создаем многоугольник, используя класс GeoObject.
                var myGeoObject<?=$i?> = new ymaps.GeoObject({
                    // Описываем геометрию геообъекта.
                    geometry: {
                        // Тип геометрии - "Многоугольник".
                        type: "Polygon",
                        // Указываем координаты вершин многоугольника.
                        coordinates: [
                            // Координаты вершин внешнего контура.
                            [
                                <?php
                                    for ($j = 0; $j < count($json_a['features'][$i]['geometry']['coordinates'][0]); $j++)
                                    {
                                        ?>
                                        [<?=$json_a['features'][$i]['geometry']['coordinates'][0][$j][1]?>, <?=$json_a['features'][$i]['geometry']['coordinates'][0][$j][0]?>],
                                        <?php
                                    }
                                        ?>
                            ]
                        ],
                        // Задаем правило заливки внутренних контуров по алгоритму "nonZero".
                        fillRule: "nonZero"
                    },
                    // Описываем свойства геообъекта.
                    properties:{
                        // Содержимое балуна.
                        balloonContent: "Тяжесть аварии: "+'<?=$sever[$i]?>'+"<br>Количество пострадавших: "+<?=$json_test[$i]['inj']?>+"<br>Количество погибших: "+<?=$json_test[$i]['dead']?>+"<br>Облачность: "+<?=$json_test[$i]['cloudcover']?>+"%<br>Температура: "+<?=$json_test[$i]['temp']?>+"<br>Видимость: "+<?=$json_test[$i]['visibility']?>+"<br>Скорость ветра: "+<?=$json_test[$i]['wspd']?>
                    }
                }, {
                    // Описываем опции геообъекта.
                    // Цвет заливки.
                    <?php
                        if ($sever[$i]=='Легкий')
                        {
                    ?>
                    fillColor: '#00FF00',
                    // Цвет обводки.
                    strokeColor: '#00FF00',
                    <?php
                        }
                        if ($sever[$i]=='Тяжелый')
                        {
                    ?>
                    fillColor: '#fb7a74',
                    // Цвет обводки.
                    strokeColor: '#fb7a74',
                    <?php
                        }
                        if ($sever[$i]=='С погибшими')
                        {
                    ?>
                    fillColor: '#ff0000',
                    // Цвет обводки.
                    strokeColor: '#ff0000',
                    <?php
                        }
                    ?>
                    // Общая прозрачность (как для заливки, так и для обводки).
                    opacity: 1,
                    // Ширина обводки.
                    strokeWidth: 5,
                    // Стиль обводки.
                    strokeStyle: 'solid'
                });
            
                // Добавляем многоугольник на карту.
                myMap.geoObjects.add(myGeoObject<?=$i?>);
                <?php
                        }
                    }
                ?>
                //Удаляем элементы карты
                myMap.controls.remove('rulerControl');
                myMap.controls.remove('geolocationControl');
                myMap.controls.remove('searchControl');
                myMap.controls.remove('trafficControl');
                
                document.getElementById('del').onclick = function () {
                    // Для уничтожения используется метод destroy.
                    myMap.destroy();
                    document.getElementById("del").style.visibility = "hidden";
                    document.getElementById("sel").style.visibility = "visible";
                    document.getElementById("show").style.visibility = "visible";
                    document.getElementById("step").style.visibility = "visible";
                };
            }
        }
        
    </script>
</body>
</html>